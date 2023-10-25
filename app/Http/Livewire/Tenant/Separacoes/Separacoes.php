<?php

namespace App\Http\Livewire\Tenant\Separacoes;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Tenant\Customers;
use App\Models\Tenant\Encomendas;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant\RececaoObservacoes;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Interfaces\Tenant\Separacoes\SeparacoesInterface;

class Separacoes extends Component
{
    use WithPagination;
    use WithFileUploads;
    
    public int $perPage;
    
    public string $searchString = '';

    private ?object $encomendas = NULL;

    public $image;

    protected object $separacoesRepository;
    
    public function boot(SeparacoesInterface $interfaceSeparacoes)
    {
        $this->separacoesRepository = $interfaceSeparacoes;
    }

    public function mount()
    {
        if (isset($this->perPage)) {
            session()->put('perPage', $this->perPage);
        } elseif (session('perPage')) {
            $this->perPage = session('perPage');
        } else {
            $this->perPage = 10;
        }

        $this->encomendas = $this->separacoesRepository->getEncomendasSeparacoes($this->perPage);
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

        if(isset($this->searchString) && $this->searchString) {
            $this->encomendas = $this->separacoesRepository->getEncomendasSeparacoesSearch($this->searchString,$this->perPage);
        } else {
            $this->encomendas = $this->separacoesRepository->getEncomendasSeparacoes($this->perPage);
        }

        
        return view('tenant.livewire.separacoes.separacoes',["encomendas" => $this->encomendas]);
    }
}
