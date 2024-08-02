<?php

namespace App\Http\Livewire\Tenant\DevolucoesClientes;

use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Models\Tenant\Encomendas;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DevolucoesClientes extends Component
{
    use WithPagination;
    use WithFileUploads;

    public int $perPage;
    public string $searchString = '';
    public string $designacao = '';
    public string $OrigemZona = '';
    private ?object $encomendas = null;
    public $image;
    public string $ordenation = 'desc';
    protected object $encomendaRepository;

    public function boot(EncomendasInterface $interfaceEncomenda)
    {
        $this->encomendaRepository = $interfaceEncomenda;
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

        $this->encomendas = $this->encomendaRepository->devolucoesClientesCodBarras($this->perPage);
    }

    public function downloadFileRececao($id)
    {
        $enc = Encomendas::where('id', $id)->first();

        foreach (json_decode($enc->imagem) as $img) {
            $this->dispatchBrowserEvent("downloadImage", ["img" => $img]);
        }

        // return response()->download(public_path().'/cl/'.$enc->imagem);
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = substr(str_shuffle($characters), 0, $length);

        return $randomString;
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

    public function abrirPopUpInfo($name)
    {
        $this->dispatchBrowserEvent('swalFire', [
            'title' => 'Informação',
            'message' => 'Nota: ' . $name,
            'status' => 'info',
        ]);
    }

    public function clearFilter()
    {
        $this->reset(['searchString', 'ordenation', 'OrigemZona', 'designacao']);
    }

    public function render()
    {

        // **  Numero de encomendas de fornecedor abertos  **/

        if (isset($this->searchString) && $this->ordenation) {
            $this->encomendas = $this->encomendaRepository->getDevolucoesclientesSearch($this->searchString, $this->ordenation, $this->perPage, $this->OrigemZona, $this->designacao);
        } else {
            $this->encomendas = $this->encomendaRepository->devolucoesClientesCodBarras($this->perPage);
        }

        $zonas = collect($this->encomendas->items())->pluck('zone')->unique();

        return view('tenant.livewire.devolucoesclientes.devolucoesclientes', ["encomendas" => $this->encomendas, "zonas" => $zonas]);
    }
}
