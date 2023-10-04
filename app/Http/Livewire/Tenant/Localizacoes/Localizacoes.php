<?php

namespace App\Http\Livewire\Tenant\Localizacoes;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Tenant\Customers;
use App\Models\Tenant\Encomendas;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant\RececaoObservacoes;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Interfaces\Tenant\Localizacoes\LocalizacoesInterface;

class Localizacoes extends Component
{
    use WithPagination;
    use WithFileUploads;

    // protected $listeners = ["ReceiveImage" => "ReceiveImage"];
    
    public int $perPage;
    
    public string $searchString = '';

    private ?object $localizacoes = NULL;

    protected object $localizacoesRepository;
    
    public function boot(LocalizacoesInterface $interfaceLocalizacoes)
    {
        $this->localizacoesRepository = $interfaceLocalizacoes;
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

        $this->localizacoes = $this->localizacoesRepository->getLocalizacoes($this->perPage);

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
            $this->localizacoes = $this->localizacoesRepository->getLocalizacoesSearch($this->searchString,$this->perPage);
        } else {
            $this->localizacoes = $this->localizacoesRepository->getLocalizacoes($this->perPage);
        }


        
        return view('tenant.livewire.localizacoes.localizacoes',["localizacoes" => $this->localizacoes]);
    }
}
