<?php

namespace App\Http\Livewire\Tenant\Encomendas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tenant\Config;
use Livewire\WithFileUploads;
use App\Models\Tenant\Encomendas;
use App\Models\Tenant\Localizacoes;
use Illuminate\Support\Facades\View;
use App\Models\Tenant\MovimentosStock;
use App\Models\Tenant\MovimentosStockTemporary;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;

class ShowRececaoDetail extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $listeners = ["removeDosTemporariosRececao" => "removeDosTemporariosRececao", "EnviarMovimentosPrincipalRececao" => "EnviarMovimentosPrincipalRececao"];
    
    public int $perPage;
    
    private ?object $encomendaSpecific = NULL;

    /**Detail */
    public string $encomenda = '';
    public string $stringEncomenda = '';
    /*** */

    /**Reduz stock **/
    public ?string $codbarras = '';
    public ?string $descricao = '';
    public ?string $qtd = '';
    /************ */
    
    protected object $encomendaRepository;
    
    public function boot(EncomendasInterface $interfaceEncomenda)
    {
        $this->encomendaRepository = $interfaceEncomenda;
    }

    public function mount($encomenda)
    {
        if (isset($this->perPage)) {
            session()->put('perPage', $this->perPage);
        } elseif (session('perPage')) {
            $this->perPage = session('perPage');
        } else {
            $this->perPage = 10;
        }

        $this->encomenda = $encomenda;

        $this->qtd = 1;

        $encomenda = $this->encomendaRepository->encomendaDetailAll($this->encomenda);


        //FAZ ESTA SITUAÇÃO PARA VERIFICAR QUANTAS LINHAS EXISTEM NESTA ENCOMENDA
        $countHowManyInThisEncomenda = 0;

        foreach($encomenda as $enc)
        {
            foreach(json_decode($enc->linhas_encomenda) as $line)
            {
                $countHowManyInThisEncomenda++;
            }
            $this->stringEncomenda = $enc->numero_encomenda."|".$enc->nif_fornecedor;
        }

        //COMPARA COM O QUE TENHO EM STOCK TEMPORARIO DESTA ENCOMENDA
        $checkIfExist = MovimentosStockTemporary::where('nr_encomenda',$enc->numero_encomenda."|".$enc->nif_fornecedor)->get();

        


        if(count($checkIfExist) < $countHowManyInThisEncomenda)
        {
            foreach($encomenda as $enc)
            {
                foreach(json_decode($enc->linhas_encomenda) as $line)
                {
                    $enc = Encomendas::where('id',$this->encomenda)->first();
                    // $checkIfExist = MovimentosStockTemporary::where('nr_encomenda',$enc->numero_encomenda."|".$enc->nif_fornecedor)->first();
    
                    $this->stringEncomenda = $enc->numero_encomenda."|".$enc->nif_fornecedor;
    
                   
                        MovimentosStockTemporary::create([
                            "id_movimento" => $this->generateRandomString(8),
                            "nr_encomenda" => $enc->numero_encomenda."|".$enc->nif_fornecedor,
                            "cod_barras" => $line->cod_barras,
                            "reference" => $line->referencias,
                            "qtd_inicial" => $line->qtd,
                            "qtd_separada" => 0,
                            "tipo" => "Entrada",
                            "localizacao" => 1
                        ]);
                    
                }
            }
        }

        
    }


    public function updatedPerPage(): void
    {
        $this->resetPage();
        session()->put('perPage', $this->perPage);
    }

    public function updatedSearchString(): void
    {
        $this->resetPage();
    }

    public function updatedCodbarras()
    {
        $config = Config::first();

        if($config->cod_barras_accept == 0 && $config->reference_accept == 1)
        {
            $response = MovimentosStockTemporary::Where('reference',$this->codbarras)->first();
        }
        else if($config->cod_barras_accept == 1 && $config->reference_accept == 0)
        {
            $response = MovimentosStockTemporary::where('cod_barras',$this->codbarras)->first();

            if($response == null)
            {
                $response = MovimentosStockTemporary::where('reference',$this->codbarras)->first();
            }
        }
        else 
        {
            $response = MovimentosStockTemporary::where('cod_barras',$this->codbarras)->orWhere('reference',$this->codbarras)->first();
        }
       

        $encomendas = Encomendas::where('id',$this->encomenda)->first();

        if(!isset($response->cod_barras) && !isset($response->reference))
        {
            $this->descricao = "";
            return false;
        }

        foreach(json_decode($encomendas->linhas_encomenda) as $lin)
        {
            if($lin->cod_barras != "" && $response->cod_barras != "" )
            {
                
                if($lin->cod_barras == $response->cod_barras)
                {
                    $this->descricao = $lin->designacoes;
                }
            }
            else
            {
                if($lin->referencias == $response->reference)
                {
                    $this->descricao = $lin->designacoes;
                }
            }
           
        }


        if($this->codbarras == "")
        {
            $this->descricao = "";
        }

        
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = substr(str_shuffle($characters), 0, $length);
     
        return $randomString;
     }
     

    public function guardaStock()
    {
        $array = [];

        if($this->codbarras != "" && $this->descricao != "")
        {
                     
            $config = Config::first();

            if($config->cod_barras_accept == 0 && $config->reference_accept == 1)
            {
                $checkQtd = MovimentosStock::Where('reference',$this->codbarras)->where('tipo','Entrada')->get();
            }
            else if($config->cod_barras_accept == 1 && $config->reference_accept == 0)
            {
                $checkQtd = MovimentosStock::where('cod_barras',$this->codbarras)->where('tipo','Entrada')->get();

                
                if(count($checkQtd) == 0)
                {
                    $checkQtd = MovimentosStock::Where('reference',$this->codbarras)->where('tipo','Entrada')->get();
                }
            }
            else 
            {
                $checkQtd = MovimentosStock::where('cod_barras',$this->codbarras)->orWhere('reference',$this->codbarras)->get();
            }

            $soma = 0;

            foreach($checkQtd as $mov)
            {
               
                $soma += $mov->qtd;
             
            }

            $response = Encomendas::where('id',$this->encomenda)->first();

            $qtdInicial = 0;
            foreach(json_decode($response->linhas_encomenda) as $line)
            {
                if($this->codbarras == $line->cod_barras || $this->codbarras == $line->referencias)
                {
                    $qtdInicial = $line->qtdrececionada;
                }
                
            }
             
            if($this->qtd + $soma > $qtdInicial)
            {
                return to_route('tenant.encomendas.rececao.detail', $this->encomenda)
                ->with('message', 'Essa referência já ultrapassou o número!')
                ->with('status', 'error');
            }
        
                      
            MovimentosStockTemporary::where('cod_barras',$this->codbarras)->orWhere('reference',$this->codbarras)->update([
                
                "qtd_separada" => $this->qtd,
                "qtd_separada_recente" => $this->qtd,
                "concluded_movement" => 1
            
            ]);

          

        }
        else 
        {
            return to_route('tenant.encomendas.rececao.detail', $this->encomenda)
            ->with('message', 'Tem de adicionar uma referência existente!')
            ->with('status', 'error');
        }


         return to_route('tenant.encomendas.rececao.detail', $this->encomenda)
         ->with('message', 'Quantidade alterada com sucesso')
         ->with('status', 'success');

    }

    public function terminarStock()
    {
        $mov_temp = MovimentosStockTemporary::where('tipo','Entrada')->where('qtd_separada','!=','0')->get();

        $message = '';

        $message = "<div class='swalBox'>";
            $message .= "<label>Transferências</label>";
            
           
                $message .= "<br><div class='row mt-4' id='divDate' style='justify-content:center;padding-left:15px;padding-right:15px;'>";
                    $message .=" <table class='table-striped' style='width:100%;table-layout:fixed;'>";
                        $message .= "<thead>";
                            $message .= "<th style='padding-bottom: 10px;font-size:15px;'>Referencia</th>";
                            $message .= "<th style='padding-bottom: 10px;font-size:15px;'>QTD separada</th>";
                            $message .= "<th style='padding-bottom: 10px;font-size:15px;'>Passagem</th>";
                            $message .= "<th style='padding-bottom: 10px;font-size:15px;'>Local</th>";
                        $message .= "</thead>";
                        $message .= "<tbody>"; 
                            foreach($mov_temp as $mov)
                            {
                                $message .= "<tr style='text-align:center;'>";
                                    $message .= "<td style='font-size:15px;'><span>".$mov->reference."</span></td>";
                                    $message .= "<td style='font-size:15px;'><span>".$mov->qtd_separada."</span></td>";
                                    $message .= "<td style='font-size:15px;'><span><i class='fa fa-arrow-right' style='color:green;'></i></span></td>";

                                    $response = Localizacoes::where('id',1)->first();
                                    $message .= "<td style='font-size:15px;'><span>".$response->abreviatura."</span></td>";
                                    // $message .= "<td style='font-size:15px;'><button type='button' id='btnLoc' style='border:none;background:none;' data-mov=".$mov->id."><i class='fa fa-xmark' style='color:red;'></i></button></td>";
                                    
                                $message .= "</tr>";
                            }
                        $message .="</tbody>";
                    $message .= "</table>";
                $message .= "</div>";
           
            
        $message .= "</div>";

        $this->dispatchBrowserEvent('terminarStock', ['title' => "Verificar Movimentos", 'message' => $message, 'status'=>'info']);
    }

    public function cancelarStock()
    {
        $enc = Encomendas::where('id',$this->encomenda)->first();
        MovimentosStockTemporary::where('tipo','Entrada')->where('nr_encomenda',$enc->numero_encomenda)->delete();

        return to_route('tenant.encomendas.rececao.detail', $this->encomenda)
         ->with('message', 'Cancelar')
         ->with('status', 'success');
    }

    public function EnviarMovimentosPrincipalRececao()
    {
        $response = MovimentosStockTemporary::where('tipo','Entrada')->where('qtd_separada','!=','0')->where('concluded_movement','!=','0')->get();

        $array = [];

        if($response == null)
        {
            return to_route('tenant.arrumacoes.encomenda.detail')
            ->with('message', 'Não contem movimentos!')
            ->with('status', 'error');
        }

        if($response->count() > 0)
        {
            foreach($response as $resp)
            {
                $mov = $this->generateRandomString(8);

                MovimentosStock::create([
                    "id_movimento" => $mov,
                    "nr_encomenda" => $resp->nr_encomenda,
                    "cod_barras" => $resp->cod_barras,
                    "reference" => $resp->reference,
                    "qtd" => $resp->qtd_separada_recente,
                    "tipo" => $resp->tipo,
                    "localizacao" => $resp->localizacao,
                ]);

                //ENVIO O POST PARA O SERGIO COM O MOVIMENTO

                $checkIfConcluded = MovimentosStock::where('nr_encomenda', $resp->nr_encomenda)->where('reference', $resp->reference)->where('tipo','Entrada')->sum('qtd');

             
               
                // if($resp->qtd_inicial == $checkIfConcluded)
                // {
                    MovimentosStockTemporary::where('nr_encomenda', $resp->nr_encomenda)->where('reference', $resp->reference)->update(["concluded_movement" => 1]);
                    MovimentosStockTemporary::where('Tipo','Entrada')->delete();
               // }
                if($resp->qtd_inicial < $checkIfConcluded)
                {
                    MovimentosStock::where('id_movimento',$mov)->delete();

                     return to_route('tenant.encomendas.rececao.detail', $this->encomenda)
                    ->with('message', 'Essa referência já ultrapassou o número!')
                    ->with('status', 'error');
                }
               

               
                
            }     
            
            // MovimentosStockTemporary::where('Tipo','Entrada')->delete();
         
        }

        return to_route('tenant.encomendas.rececao.detail', $this->encomenda)
         ->with('message', 'Arrumado com sucesso')
         ->with('status', 'success');
    }


   
    public function paginationView()
    {
        return 'tenant.livewire.setup.pagination';
    }


    public function render()
    {

        // **  Numero de encomendas de fornecedor abertos  **/

        //$this->encomendaSpecific = $this->encomendaRepository->encomendaMovimentos($this->stringEncomenda,$this->perPage);

        $this->encomendaSpecific = $this->encomendaRepository->encomendaMovimentos($this->encomenda,$this->perPage);
        
        
        return view('tenant.livewire.encomendas.encomendadetail',["encomendaDetail" => $this->encomendaSpecific, "idEncomenda" => $this->encomenda]);
    }
}
