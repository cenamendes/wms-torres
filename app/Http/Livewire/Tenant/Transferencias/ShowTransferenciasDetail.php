<?php

namespace App\Http\Livewire\Tenant\Transferencias;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tenant\Config;
use Livewire\WithFileUploads;
use App\Models\Tenant\Encomendas;
use App\Models\Tenant\Localizacoes;
use Illuminate\Support\Facades\View;
use App\Models\Tenant\MovimentosStock;
use App\Models\Tenant\MovimentosStockTemporary;
use App\Interfaces\Tenant\Arrumacoes\ArrumacoesInterface;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Interfaces\Tenant\Transferencias\TransferenciasInterface;

class ShowTransferenciasDetail extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $listeners = ["EnviarMovimentosPrincipalTransferencias" => "EnviarMovimentosPrincipalTransferencias"];
    
    public int $perPage;
    
    private ?object $referencias = NULL;


    /**Reduz stock **/
    public ?string $codbarras = '';
    public ?string $descricao = '';
    public ?string $qtd = '';

    public ?string $selectOrigin;
    public ?string $transferir;

    /************ */
    
    protected object $transferenciasRepository;
    
    public function boot(TransferenciasInterface $interfaceTransferencias)
    {
        $this->transferenciasRepository = $interfaceTransferencias;
    }

    public function mount()
    {
       
        $this->qtd = 1;

        $this->transferir = '';

    }

    

    public function updatedCodbarras()
    {
        $refs = $this->transferenciasRepository->getCodBarrasCollection();
    
        foreach($refs as $ref)
        {
            if($ref["reference"] == $this->codbarras || $ref["cod_barras"] == $this->codbarras)
            {
                $this->descricao = $ref["designacao"];
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

        if($this->transferir != "" && $this->selectOrigin != "")
        {
            $locsTranfer = Localizacoes::where('cod_barras',$this->transferir)->get();

            $locsOrigin = Localizacoes::where('cod_barras',$this->selectOrigin)->get();
            

            if($locsOrigin->count() == 0 || $locsTranfer->count() == 0)
            {
                return to_route('tenant.transferencia.index')
                ->with('message', 'Essa localização não existe!')
                ->with('status', 'error');
            }
        


            if($this->codbarras != "" && $this->descricao != "")
            {
                $refs = $this->transferenciasRepository->getTransferenciasCollection();
                // DD($refs);
              if(count($refs[$this->selectOrigin]) > 0)
              {
                foreach($refs[$this->selectOrigin] as $i => $rf)
                {
                    $config = Config::first();

                    if($config->cod_barras_accept == 0 && $config->reference_accept == 1)
                    {
                        if($rf["reference"] == $this->codbarras)
                        {
                            if($this->qtd > $rf["qtd"] || $rf["qtd"]  == 0 )
                            {
                                return to_route('tenant.transferencia.index')
                                ->with('message', 'Essa quantidade ultrapassa o valor existente ou encontra-se a zero!')
                                ->with('status', 'error');
                            }

                            $localizacao_original = Localizacoes::where('cod_barras',$this->selectOrigin)->first();

                            if($localizacao_original->cod_barras != $rf["local"])
                            {
                                return to_route('tenant.transferencia.index')
                                ->with('message', 'Esse local não contem esse produto!')
                                ->with('status', 'error');
                            }
                            else 
                            {
                                $id_localizacao_original = $localizacao_original->id;
                            }

                            $id_localizacao = Localizacoes::where('cod_barras',$this->transferir)->first();

                            $number = $this->generateRandomString(8);


                            MovimentosStockTemporary::create([
                                "id_movimento" => $number,
                                "nr_encomenda" => $rf["nr_encomenda"],
                                "cod_barras" => $rf["cod_barras"],
                                "reference" => $rf["reference"],
                                "qtd_separada" => "-".$this->qtd,
                                "tipo" => "stockTransfer",
                                "localizacao" => $id_localizacao_original
                            ]);
                
                            MovimentosStockTemporary::create([
                                "id_movimento" => $number,
                                "nr_encomenda" => $rf["nr_encomenda"],
                                "cod_barras" => $rf["cod_barras"],
                                "reference" => $rf["reference"],
                                "qtd_separada" => $this->qtd,
                                "tipo" => "stockTransfer",
                                "localizacao" => $id_localizacao->id
                            ]);
                            
                        }
                    }
                    else if($config->cod_barras_accept == 1 && $config->reference_accept == 0)
                    {
                        if($rf["cod_barras"] == "")
                        {
                            if($rf["reference"] == $this->codbarras)
                            {
                                if($this->qtd > $rf["qtd"] || $rf["qtd"]  == 0 )
                                {
                                    return to_route('tenant.transferencia.index')
                                    ->with('message', 'Essa quantidade ultrapassa o valor existente ou encontra-se a zero!')
                                    ->with('status', 'error');
                                }

                                $localizacao_original = Localizacoes::where('cod_barras',$this->selectOrigin)->first();

                                if($localizacao_original->cod_barras != $rf["local"])
                                {
                                    return to_route('tenant.transferencia.index')
                                    ->with('message', 'Esse local não contem esse produto!')
                                    ->with('status', 'error');
                                }
                                else 
                                {
                                    $id_localizacao_original = $localizacao_original->id;
                                }

                                $id_localizacao = Localizacoes::where('cod_barras',$this->transferir)->first();

                                $number = $this->generateRandomString(8);


                                MovimentosStockTemporary::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd_separada" => "-".$this->qtd,
                                    "tipo" => "stockTransfer",
                                    "localizacao" => $id_localizacao_original
                                ]);
                    
                                MovimentosStockTemporary::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd_separada" => $this->qtd,
                                    "tipo" => "stockTransfer",
                                    "localizacao" => $id_localizacao->id
                                ]);
                            }
                        }
                        else
                        {
                            if($rf["cod_barras"] == $this->codbarras)
                            {
                                if($this->qtd > $rf["qtd"] || $rf["qtd"]  == 0 )
                                {
                                    return to_route('tenant.transferencia.index')
                                    ->with('message', 'Essa quantidade ultrapassa o valor existente ou encontra-se a zero!')
                                    ->with('status', 'error');
                                }

                                $localizacao_original = Localizacoes::where('cod_barras',$this->selectOrigin)->first();

                                if($localizacao_original->cod_barras != $rf["local"])
                                {
                                    return to_route('tenant.transferencia.index')
                                    ->with('message', 'Esse local não contem esse produto!')
                                    ->with('status', 'error');
                                }
                                else 
                                {
                                    $id_localizacao_original = $localizacao_original->id;
                                }

                                $id_localizacao = Localizacoes::where('cod_barras',$this->transferir)->first();

                                $number = $this->generateRandomString(8);


                                MovimentosStockTemporary::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd_separada" => "-".$this->qtd,
                                    "tipo" => "stockTransfer",
                                    "localizacao" => $id_localizacao_original
                                ]);
                    
                                MovimentosStockTemporary::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd_separada" => $this->qtd,
                                    "tipo" => "stockTransfer",
                                    "localizacao" => $id_localizacao->id
                                ]);
                            }
                        }
                        
                    }
                    else 
                    {
                        if($rf["reference"] == $this->codbarras)
                        {
                            if($this->qtd > $rf["qtd"] || $rf["qtd"]  == 0 )
                            {
                                return to_route('tenant.transferencia.index')
                                ->with('message', 'Essa quantidade ultrapassa o valor existente ou encontra-se a zero!')
                                ->with('status', 'error');
                            }

                            $localizacao_original = Localizacoes::where('cod_barras',$this->selectOrigin)->first();

                            if($localizacao_original->cod_barras != $rf["local"])
                            {
                                return to_route('tenant.transferencia.index')
                                ->with('message', 'Esse local não contem esse produto!')
                                ->with('status', 'error');
                            }
                            else 
                            {
                                $id_localizacao_original = $localizacao_original->id;
                            }

                            $id_localizacao = Localizacoes::where('cod_barras',$this->transferir)->first();

                            $number = $this->generateRandomString(8);


                            MovimentosStockTemporary::create([
                                "id_movimento" => $number,
                                "nr_encomenda" => $rf["nr_encomenda"],
                                "cod_barras" => $rf["cod_barras"],
                                "reference" => $rf["reference"],
                                "qtd_separada" => "-".$this->qtd,
                                "tipo" => "stockTransfer",
                                "localizacao" => $id_localizacao_original
                            ]);
                
                            MovimentosStockTemporary::create([
                                "id_movimento" => $number,
                                "nr_encomenda" => $rf["nr_encomenda"],
                                "cod_barras" => $rf["cod_barras"],
                                "reference" => $rf["reference"],
                                "qtd_separada" => $this->qtd,
                                "tipo" => "stockTransfer",
                                "localizacao" => $id_localizacao->id
                            ]);
                        }
                    }
                    
                    

                }
                }

            }
            else 
            {
                return to_route('tenant.transferencia.index')
                ->with('message', 'Tem de adicionar uma referência existente!')
                ->with('status', 'error');
            }
        }

         return to_route('tenant.transferencia.index')
         ->with('message', 'Quantidade alterada com sucesso')
         ->with('status', 'success');

    }

    public function terminarStock()
    {
        $mov_temp = MovimentosStockTemporary::where('tipo','stockTransfer')
        ->where('qtd_separada','>','0')
        ->where('qtd_separada','!=','0')
        ->get();

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

                                    $response = Localizacoes::where('id',$mov->localizacao)->first();
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

    public function EnviarMovimentosPrincipalTransferencias()
    {
        $response = MovimentosStockTemporary::where('tipo','stockTransfer')->where('qtd_separada','!=','0')->get();


        $array = [];

        if($response == null)
        {
            return to_route('tenant.transferencia.index')
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
                    "qtd" => $resp->qtd_separada,
                    "tipo" => "Transferencia",
                    "localizacao" => $resp->localizacao,
                ]);

                //ENVIO O POST PARA O SERGIO COM O MOVIMENTO

                // $checkIfConcluded = MovimentosStock::where('nr_encomenda', $resp->nr_encomenda)->where('reference', $resp->reference)->where('tipo','Entrada')->sum('qtd');

             
               
                // if($resp->qtd_inicial == $checkIfConcluded)
                // {
                //     MovimentosStockTemporary::where('nr_encomenda', $resp->nr_encomenda)->where('reference', $resp->reference)->update(["concluded_movement" => 1]);
                    MovimentosStockTemporary::where('Tipo','stockTransfer')->delete();
               // }
                // else if($resp->qtd_inicial < $checkIfConcluded)
                // {
                //     MovimentosStock::where('id_movimento',$mov)->delete();

                //      return to_route('tenant.transferencia.index')
                //     ->with('message', 'Essa referência já ultrapassou o número!')
                //     ->with('status', 'error');
                // }
               

               
                
            }     
            
            // MovimentosStockTemporary::where('Tipo','Entrada')->delete();
         
        }

        return to_route('tenant.transferencia.index')
         ->with('message', 'Transferido com sucesso')
         ->with('status', 'success');
    }

    public function cancelarStock()
    {
        
        MovimentosStockTemporary::where('tipo','stockTransfer')->delete();

        return to_route('tenant.transferencia.index')
         ->with('message', 'Cancelar')
         ->with('status', 'success');
    }



    public function render()
    {
        
        return view('tenant.livewire.transferencias.transferenciadetail');
    }
}
