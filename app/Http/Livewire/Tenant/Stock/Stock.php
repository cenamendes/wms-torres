<?php

namespace App\Http\Livewire\Tenant\Stock;

use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Tenant\Config;

class Stock extends Component
{
    use WithPagination;
    use WithFileUploads;

    public int $perPage;
    public string $searchString = '';
    public string $designacao = '';
    public string $OrigemZona = '';
    public ?string $descricao = '';
    public ?string $qtdstock = '';
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

    public function clearFilter()
    {
        $this->reset(['searchString', 'ordenation', 'OrigemZona', 'designacao']);
    }

    public function updatedCodbarras()
    {

        $encspe = $this->encomendaRepository->conferecod($this->encomenda);

        $config = Config::first();

        if ($config->cod_barras_accept == 0 && $config->reference_accept == 1) {
            foreach ($encspe->lines as $line) {
                if ($this->codbarras == $line->referense) {
                    $this->descricao = $line->design;
                    $this->qtdstock = $this->encomendaRepository->entradaQtdStock($line->referense);
                }

            }

        } else if ($config->cod_barras_accept == 1 && $config->reference_accept == 0) {
            foreach ($encspe->lines as $line) {
                if ($this->codbarras == $line->barcode) {
                    $this->descricao = $line->design;
                    $this->qtdstock = $this->encomendaRepository->entradaQtdStock($line->referense);
                }

            }

        } else {
            foreach ($encspe->lines as $line) {
                if ($this->codbarras == $line->barcode || $this->codbarras == $line->referense) {
                    $this->descricao = $line->design;
                    $this->qtdstock = $this->encomendaRepository->entradaQtdStock($line->referense);
                }

            }
        }

        if ($this->codbarras == "") {
            $this->descricao = "";
        }

    }

    public function render()
    {

        if (isset($this->searchString) && $this->ordenation) {
            $this->encomendas = $this->encomendaRepository->getEncomendasSearch($this->searchString, $this->ordenation, $this->perPage, $this->OrigemZona, $this->designacao);
        } else {
            $this->encomendas = $this->encomendaRepository->entradasCodBarras($this->perPage);
        }

        $zonas = collect($this->encomendas->items())->pluck('zone')->unique();

        return view('tenant.livewire.stock.stock', [
            "encomendas" => $this->encomendas,
            "zonas" => $zonas
        ]);
    }
}

