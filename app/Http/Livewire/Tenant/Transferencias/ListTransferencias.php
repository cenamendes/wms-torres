<?php

namespace App\Http\Livewire\Tenant\Transferencias;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Tenant\Customers;
use App\Models\Tenant\Encomendas;
use App\Models\Tenant\Localizacoes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant\RececaoObservacoes;
use App\Models\Tenant\MovimentosStockTemporary;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Interfaces\Tenant\Localizacoes\LocalizacoesInterface;
use App\Interfaces\Tenant\Transferencias\TransferenciasInterface;

class ListTransferencias extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $listeners = ["getLocal" => "getLocal"];
    
    public int $perPage;
    
    public string $searchString = '';

    public string $resultLocal = '';

    private ?object $transferencias = NULL;
    private ?object $transferenciasLeft = NULL;

    protected object $transferenciasRepository;
    
    public function boot(TransferenciasInterface $interfaceTransferencias)
    {
        $this->transferenciasRepository = $interfaceTransferencias;
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

        $this->transferenciasLeft = $this->transferenciasRepository->getListagem($this->perPage);

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

    public function getLocal($id)
    {
        $this->transferencias = $this->transferenciasRepository->getListagemSearch($id,$this->perPage);
        $this->transferenciasLeft = $this->transferenciasRepository->getListagem($this->perPage);

        $this->resultLocal = "tem";
    }


    public function render()
    {   
        
        // **  Numero de encomendas de fornecedor abertos  **/

        // if(isset($this->searchString) && $this->searchString) {
        //     $this->transferencias = $this->transferenciasRepository->getListagemSearch($this->searchString,$this->perPage);
        // } else {
            //$this->transferencias = $this->transferenciasRepository->getListagem($this->perPage);
       // }

        
        return view('tenant.livewire.transferencias.listagem',["transferencias" => $this->transferencias, "transferenciasLeft" => $this->transferenciasLeft, "resultLocal" => $this->resultLocal]);
    }
}
