<?php

namespace App\Http\Livewire\Tenant\Devolucoes;


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
use App\Interfaces\Tenant\Devolucoes\DevolucoesInterface;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Interfaces\Tenant\Transferencias\TransferenciasInterface;

class ShowDevolucoesDetail extends Component
{
    use WithPagination;
    use WithFileUploads;

    //protected $listeners = ["removeDosTemporarios" => "removeDosTemporarios", "EnviarMovimentosPrincipal" => "EnviarMovimentosPrincipal"];
    
    public int $perPage;
    
    private ?object $referencias = NULL;


    /**Reduz stock **/
    public ?string $codbarras = '';
    public ?string $descricao = '';
    public ?string $qtd = '';

    public ?string $selectOrigin;
    public ?string $transferir;

    /************ */
    
    protected object $devolucoesRepository;
    
    public function boot(DevolucoesInterface $interfaceDevolucoes)
    {
        $this->devolucoesRepository = $interfaceDevolucoes;
    }

    public function mount()
    {
       
        $this->qtd = 1;

        $this->transferir = '3';

    }

    

    public function updatedCodbarras()
    {
        $refs = $this->devolucoesRepository->getCodBarrasCollection();
    
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
            $locsTranfer = Localizacoes::where('id',$this->transferir)->get();

            $locsOrigin = Localizacoes::where('cod_barras',$this->selectOrigin)->get();
            

            if($locsOrigin->count() == 0 || $locsTranfer->count() == 0)
            {
                return to_route('tenant.devolucoes.index')
                ->with('message', 'Essa localização não existe!')
                ->with('status', 'error');
            }
        


            if($this->codbarras != "" && $this->descricao != "")
            {
                $refs = $this->devolucoesRepository->getDevolucoesCollection();
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
                                return to_route('tenant.devolucoes.index')
                                ->with('message', 'Essa quantidade ultrapassa o valor existente ou encontra-se a zero!')
                                ->with('status', 'error');
                            }

                            $localizacao_original = Localizacoes::where('cod_barras',$this->selectOrigin)->first();

                            if($localizacao_original->cod_barras != $rf["local"])
                            {
                                return to_route('tenant.devolucoes.index')
                                ->with('message', 'Esse local não contem esse produto!')
                                ->with('status', 'error');
                            }
                            else 
                            {
                                $id_localizacao_original = $localizacao_original->id;
                            }

                            //$id_localizacao = Localizacoes::where('cod_barras',$this->transferir)->first();

                            $number = $this->generateRandomString(8);


                            MovimentosStock::create([
                                "id_movimento" => $number,
                                "nr_encomenda" => $rf["nr_encomenda"],
                                "cod_barras" => $rf["cod_barras"],
                                "reference" => $rf["reference"],
                                "qtd" => "-".$this->qtd,
                                "tipo" => "Transferencia",
                                "localizacao" => $id_localizacao_original
                            ]);
                
                            MovimentosStock::create([
                                "id_movimento" => $number,
                                "nr_encomenda" => $rf["nr_encomenda"],
                                "cod_barras" => $rf["cod_barras"],
                                "reference" => $rf["reference"],
                                "qtd" => $this->qtd,
                                "tipo" => "Transferencia",
                                "localizacao" => "3"
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
                                    return to_route('tenant.devolucoes.index')
                                    ->with('message', 'Essa quantidade ultrapassa o valor existente ou encontra-se a zero!')
                                    ->with('status', 'error');
                                }

                                $localizacao_original = Localizacoes::where('cod_barras',$this->selectOrigin)->first();

                                if($localizacao_original->cod_barras != $rf["local"])
                                {
                                    return to_route('tenant.devolucoes.index')
                                    ->with('message', 'Esse local não contem esse produto!')
                                    ->with('status', 'error');
                                }
                                else 
                                {
                                    $id_localizacao_original = $localizacao_original->id;
                                }

                                $id_localizacao = Localizacoes::where('cod_barras',$this->transferir)->first();

                                $number = $this->generateRandomString(8);


                                MovimentosStock::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd" => "-".$this->qtd,
                                    "tipo" => "Transferencia",
                                    "localizacao" => $id_localizacao_original
                                ]);
                    
                                MovimentosStock::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd" => $this->qtd,
                                    "tipo" => "Transferencia",
                                    "localizacao" => "3"
                                ]);
                            }
                        }
                        else
                        {
                            if($rf["cod_barras"] == $this->codbarras)
                            {
                                if($this->qtd > $rf["qtd"] || $rf["qtd"]  == 0 )
                                {
                                    return to_route('tenant.devolucoes.index')
                                    ->with('message', 'Essa quantidade ultrapassa o valor existente ou encontra-se a zero!')
                                    ->with('status', 'error');
                                }

                                $localizacao_original = Localizacoes::where('cod_barras',$this->selectOrigin)->first();

                                if($localizacao_original->cod_barras != $rf["local"])
                                {
                                    return to_route('tenant.devolucoes.index')
                                    ->with('message', 'Esse local não contem esse produto!')
                                    ->with('status', 'error');
                                }
                                else 
                                {
                                    $id_localizacao_original = $localizacao_original->id;
                                }

                                $id_localizacao = Localizacoes::where('cod_barras',$this->transferir)->first();

                                $number = $this->generateRandomString(8);


                                MovimentosStock::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd" => "-".$this->qtd,
                                    "tipo" => "Transferencia",
                                    "localizacao" => $id_localizacao_original
                                ]);
                    
                                MovimentosStock::create([
                                    "id_movimento" => $number,
                                    "nr_encomenda" => $rf["nr_encomenda"],
                                    "cod_barras" => $rf["cod_barras"],
                                    "reference" => $rf["reference"],
                                    "qtd" => $this->qtd,
                                    "tipo" => "Transferencia",
                                    "localizacao" => "3"
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
                                return to_route('tenant.devolucoes.index')
                                ->with('message', 'Essa quantidade ultrapassa o valor existente ou encontra-se a zero!')
                                ->with('status', 'error');
                            }

                            $localizacao_original = Localizacoes::where('cod_barras',$this->selectOrigin)->first();

                            if($localizacao_original->cod_barras != $rf["local"])
                            {
                                return to_route('tenant.devolucoes.index')
                                ->with('message', 'Esse local não contem esse produto!')
                                ->with('status', 'error');
                            }
                            else 
                            {
                                $id_localizacao_original = $localizacao_original->id;
                            }

                            $id_localizacao = Localizacoes::where('cod_barras',$this->transferir)->first();

                            $number = $this->generateRandomString(8);


                            MovimentosStock::create([
                                "id_movimento" => $number,
                                "nr_encomenda" => $rf["nr_encomenda"],
                                "cod_barras" => $rf["cod_barras"],
                                "reference" => $rf["reference"],
                                "qtd" => "-".$this->qtd,
                                "tipo" => "Transferencia",
                                "localizacao" => $id_localizacao_original
                            ]);
                
                            MovimentosStock::create([
                                "id_movimento" => $number,
                                "nr_encomenda" => $rf["nr_encomenda"],
                                "cod_barras" => $rf["cod_barras"],
                                "reference" => $rf["reference"],
                                "qtd" => $this->qtd,
                                "tipo" => "Transferencia",
                                "localizacao" => "3"
                            ]);
                        }
                    }
                    
                    

                }
                }

            }
            else 
            {
                return to_route('tenant.devolucoes.index')
                ->with('message', 'Tem de adicionar uma referência existente!')
                ->with('status', 'error');
            }
        }

         return to_route('tenant.devolucoes.index')
         ->with('message', 'Quantidade alterada com sucesso')
         ->with('status', 'success');

    }


    public function render()
    {
        
        return view('tenant.livewire.devolucoes.devolucaodetail');
    }
}
