<?php

namespace App\Http\Livewire\Tenant\Encomendas;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Tenant\Encomendas;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use Illuminate\Support\Facades\View;

class ShowRececaoDetail extends Component
{
    use WithPagination;
    use WithFileUploads;

    //protected $listeners = ["ReceiveImage" => "ReceiveImage"];
    
    public int $perPage;
    
    private ?object $encomendaSpecific = NULL;

    /**Detail */
    public string $encomenda = '';
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
        $response = Encomendas::where('id',$this->encomenda)->first();

        foreach(json_decode($response->linhas_encomenda) as $lin)
        {
            if($lin->referencias == $this->codbarras)
            {
                $this->descricao = $lin->designacoes;
            }
        }

        if($this->codbarras == "")
        {
            $this->descricao = "";
        }
        
    }

    public function guardaStock()
    {
        $array = [];

        if($this->codbarras != "" && $this->descricao != "")
        {
            $response = Encomendas::where('id',$this->encomenda)->first();

            foreach(json_decode($response->linhas_encomenda) as $i => $lin)
            {
                $array[$i] = [
                    "referencias" => $lin->referencias,
                    "designacoes" => $lin->designacoes,
                    "qtd" => $lin->qtd,
                    "qtdrececionada" =>  $lin->qtdrececionada,
                    "preco" => $lin->preco
                ];

                if($lin->referencias == $this->codbarras)
                {
                    if($this->qtd > $lin->qtd || $lin->qtd == 0 )
                    {
                        return to_route('tenant.encomendas.rececao.detail', $this->encomenda)
                        ->with('message', 'Essa quantidade ultrapassa o valor existente!')
                        ->with('status', 'error');
                    }
                    
                    $subtracao = $lin->qtd - $this->qtd;

                    unset($array[$i]);

                    $array[$i] = [
                    "referencias" => $lin->referencias,
                    "designacoes" => $lin->designacoes,
                    "qtd" => $subtracao,
                    "qtdrececionada" =>  $lin->qtdrececionada,
                    "preco" => $lin->preco
                    ];
                }
            }

            Encomendas::where('id',$this->encomenda)->update([
                "linhas_encomenda" => json_encode($array)
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

   
    public function paginationView()
    {
        return 'tenant.livewire.setup.pagination';
    }


    public function render()
    {

        // **  Numero de encomendas de fornecedor abertos  **/

        $this->encomendaSpecific = $this->encomendaRepository->encomendaDetail($this->encomenda,$this->perPage);
        
        
        return view('tenant.livewire.encomendas.encomendadetail',["encomendaDetail" => $this->encomendaSpecific]);
    }
}
