<?php

namespace App\Http\Livewire\Tenant\Separacoes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tenant\Config;
use Livewire\WithFileUploads;
use App\Models\Tenant\Encomendas;
use App\Models\Tenant\Localizacoes;
use Illuminate\Support\Facades\View;
use App\Models\Tenant\MovimentosStock;
use App\Models\Tenant\MovimentosStockTemporary;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Interfaces\Tenant\Separacoes\SeparacoesInterface;

class ShowSeparacoesDetail extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $listeners = ["removeDosTemporariosSeparacao" => "removeDosTemporariosSeparacao", "EnviarMovimentosPrincipalSeparacao" => "EnviarMovimentosPrincipalSeparacao"];
    
    public int $perPage;
    
    private ?object $encomendaSpecific = NULL;

    /**Detail */
    public string $encomenda = '';
    public string $stringEncomenda = '';
    public string $orderNumber = '';
    public string $nifNumber = '';
    /*** */

    /**Reduz stock **/
    public ?string $codbarras = '';
    public ?string $descricao = '';
    public ?string $qtd = '';
    /************ */
    
    protected object $separacoesRepository;
    
    public function boot(SeparacoesInterface $interfaceEncomenda)
    {
        $this->separacoesRepository = $interfaceEncomenda;
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

        $encomenda = $this->separacoesRepository->encomendaDetailAll($this->encomenda);

        //FAZ ESTA SITUAÇÃO PARA VERIFICAR QUANTAS LINHAS EXISTEM NESTA ENCOMENDA
        $countHowManyInThisEncomenda = 0;

        foreach($encomenda->lines as $enc)
        {
           
            $countHowManyInThisEncomenda++;
          
            $this->stringEncomenda = $enc->order_number;
            $this->orderNumber = $enc->order_number;
            $this->nifNumber = $enc->nif;
        }


        //COMPARA COM O QUE TENHO EM STOCK TEMPORARIO DESTA ENCOMENDA
        $checkIfExist = MovimentosStockTemporary::where('nr_encomenda',$enc->order_number)->get();

        

        if(count($checkIfExist) < $countHowManyInThisEncomenda)
        {
            foreach($encomenda->lines as $enc)
            {
                $this->orderNumber = $enc->order_number;
                $this->nifNumber = $enc->nif;
                $this->stringEncomenda = $enc->order_number;
    
                MovimentosStockTemporary::create([
                    "id_movimento" => $this->generateRandomString(8),
                    "nr_encomenda" => $enc->order_number,
                    "cod_barras" => $enc->barcode,
                    "reference" => $enc->reference,
                    "qtd_inicial" => $enc->quantity,
                    "qtd_separada" => 0,
                    "tipo" => "Saida",
                    "localizacao" => "0"
                ]);
                    
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
       

        //$encomendas = Encomendas::where('id',$this->encomenda)->first();
      
        //$encomendas = $this->separacoesRepository->getEncomendaSeparacaoByStamp($this->encomenda);

        $getStamp = $this->separacoesRepository->encomendaDetailAll($this->encomenda);

       
        if(!isset($response->cod_barras))
        {
            $this->descricao = "";
            return false;
        }

        foreach($getStamp->lines as $lin)
        {
            if($lin->barcode == $response->cod_barras)
            {
                $this->descricao = $lin->description;
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
                $checkQtd = MovimentosStockTemporary::Where('reference',$this->codbarras)->where('tipo','Saida')->get();
            }
            else if($config->cod_barras_accept == 1 && $config->reference_accept == 0)
            {
                $checkQtd = MovimentosStockTemporary::where('cod_barras',$this->codbarras)->where('tipo','Saida')->get();

                if(count($checkQtd) == 0)
                {
                    $checkQtd = MovimentosStockTemporary::Where('reference',$this->codbarras)->where('tipo','Saida')->get();
                }
            }
            else 
            {
                $checkQtd = MovimentosStockTemporary::where('cod_barras',$this->codbarras)->orWhere('reference',$this->codbarras)->get();
            }

            $soma = 0;

            foreach($checkQtd as $mov)
            {
               
                $soma += $mov->qtd_separada;
             
            }

            foreach($checkQtd as $mov)
            {
                $qtdInicial = $mov->qtd_inicial;
            }

           // $response = Encomendas::where('id',$this->encomenda)->first();

            // $qtdInicial = 0;
            // foreach(json_decode($response->linhas_encomenda) as $line)
            // {
            //     if($this->codbarras == $line->cod_barras || $this->codbarras == $line->referencias)
            //     {
            //         $qtdInicial = $line->qtdrececionada;
            //     }
                
            // }

             
            if($this->qtd + $soma > $qtdInicial)
            {
                return to_route('tenant.separacoes.encomenda.detail', $this->encomenda)
                ->with('message', 'Essa referência já ultrapassou o número!')
                ->with('status', 'error');
            }

            $qtd_somada = $this->qtd + $soma;
        
          
            MovimentosStockTemporary::where('cod_barras',$this->codbarras)->orWhere('reference',$this->codbarras)->update([
            
                "qtd_separada" => $qtd_somada,
                "qtd_separada_recente" => $this->qtd,
                "concluded_movement" => 0
            
            ]);
            
                      
            

          

        }
        else 
        {
            return to_route('tenant.separacoes.encomenda.detail', $this->encomenda)
            ->with('message', 'Tem de adicionar uma referência existente!')
            ->with('status', 'error');
        }


         return to_route('tenant.separacoes.encomenda.detail', $this->encomenda)
         ->with('message', 'Quantidade alterada com sucesso')
         ->with('status', 'success');

    }

    public function terminarStock($orderNumber)
    {
        $mov_temp = MovimentosStockTemporary::where('tipo','Saida')->where('qtd_separada','!=','0')->where('nr_encomenda',trim($orderNumber))->get();

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

                                    //$response = Localizacoes::where('id',1)->first();
                                    $message .= "<td style='font-size:15px;'><span>Saída</span></td>";
                                    // $message .= "<td style='font-size:15px;'><button type='button' id='btnLoc' style='border:none;background:none;' data-mov=".$mov->id."><i class='fa fa-xmark' style='color:red;'></i></button></td>";
                                    
                                $message .= "</tr>";
                            }
                        $message .="</tbody>";
                    $message .= "</table>";
                $message .= "</div>";
           
            
        $message .= "</div>";

        $this->dispatchBrowserEvent('terminarStock', ['title' => "Verificar Movimentos", 'message' => $message, 'orderNumber' => $orderNumber, 'status'=>'info']);
    }

    public function cancelarStock($orderNumber)
    {
        MovimentosStockTemporary::where('tipo','Saida')->where('nr_encomenda',trim($orderNumber))->delete();

        return to_route('tenant.separacoes.encomenda.detail', $this->encomenda)
         ->with('message', 'Cancelar')
         ->with('status', 'success');
    }

    public function EnviarMovimentosPrincipalSeparacao($orderNumber)
    {
        $response = MovimentosStockTemporary::where('tipo','Saida')->where('qtd_separada','!=','0')->where('concluded_movement','!=','1')->where('nr_encomenda',$orderNumber)->get();


        dd($response);

        $array = [];

        if($response == null)
        {
            return to_route('tenant.separacoes.encomenda.detail')
            ->with('message', 'Não contem movimentos!')
            ->with('status', 'error');
        }

        if($response->count() > 0)
        {
            foreach($response as $resp)
            {
                $mov = $this->generateRandomString(8);

                //Vou ter de passa o NIF para o Sergio

                MovimentosStock::create([
                    "id_movimento" => $mov,
                    "nr_encomenda" => $resp->nr_encomenda,
                    "cod_barras" => $resp->cod_barras,
                    "reference" => $resp->reference,
                    "qtd" => $resp->qtd_separada_recente,
                    "tipo" => "Saida",
                    "localizacao" => $resp->localizacao,
                ]);

                //ENVIO O POST PARA O SERGIO COM O MOVIMENTO

                $checkIfConcluded = MovimentosStock::where('nr_encomenda', $resp->nr_encomenda)->where('reference', $resp->reference)->where('tipo','Entrada')->sum('qtd');

             
               
                if($resp->qtd_inicial == $checkIfConcluded)
                {
                    MovimentosStockTemporary::where('nr_encomenda', $resp->nr_encomenda)->where('reference', $resp->reference)->update(["concluded_movement" => 1]);
                    MovimentosStockTemporary::where('Tipo','Saida')->delete();
                }
                else if($resp->qtd_inicial < $checkIfConcluded)
                {
                    MovimentosStock::where('id_movimento',$mov)->delete();

                     return to_route('tenant.separacoes.encomenda.detail', $this->encomenda)
                    ->with('message', 'Essa referência já ultrapassou o número!')
                    ->with('status', 'error');
                }
               

               
                
            }     
            
            // MovimentosStockTemporary::where('Tipo','Entrada')->delete();
         
        }

        return to_route('tenant.separacoes.encomenda.detail', $this->encomenda)
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

        $this->encomendaSpecific = $this->separacoesRepository->encomendaSeparacoesMovimentos($this->encomenda,$this->perPage);
        
        
        return view('tenant.livewire.separacoes.separacaodetail',["encomendaDetail" => $this->encomendaSpecific, "idEncomenda" => $this->encomenda, "orderNumber" => $this->orderNumber, "nif" => $this->nifNumber ]);
    }
}
