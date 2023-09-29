<?php

namespace App\Http\Livewire\Tenant\Encomendas;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;

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
