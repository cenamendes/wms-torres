<?php

namespace App\Http\Livewire\Tenant\Encomendas;

use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Rececao extends Component
{
    use WithPagination;
    use WithFileUploads;

    public int $perPage;
    public string $searchString = '';
    public string $designacao = '';
    public string $OrigemZona = '';
    private ?object $encomendas = null;
    private ?object $encomendaSpecific = null;
    public $encomendasSpecificInfo = [];
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

        $user = auth()->user();

        $this->encomendas = $this->encomendaRepository->entradasCodBarras($this->perPage);

        foreach ($this->encomendas as $encomenda) {
            $encomendaSpecific = $this->encomendaRepository->verificarEncomendasarmazem($encomenda->id, $this->perPage);

           // Itera sobre os itens dentro de $encomendaSpecific->items() e verifica o atributo "warehouse" em cada item
            foreach ($encomendaSpecific->items() as $item) {

                // Verifica se o valor do campo "warehouse" em $item é igual ao valor do campo "loginarmazem" do usuário autenticado
                if ($item->warehouse == $user->loginarmazem) {

                    $this->encomendasSpecificInfo[$encomenda->id] = $encomendaSpecific;

                    break; // Saímos do loop interno pois já encontramos uma correspondência
                }
            }
        }
    }

    public function paginationView()
    {
        return 'tenant.livewire.setup.pagination';
    }

    public function clearFilter()
    {
        $this->reset(['searchString', 'ordenation', 'OrigemZona', 'designacao']);
    }

    public function render()
    {
        if (isset($this->searchString) && $this->ordenation) {
            $this->encomendas = $this->encomendaRepository->getEncomendasSearch($this->searchString, $this->ordenation, $this->perPage, $this->OrigemZona, $this->designacao);
        }

        $zonas = collect($this->encomendas->items())->pluck('zone')->unique();

        return view('tenant.livewire.encomendas.rececao', [
            "encomendas" => $this->encomendas,
            "zonas" => $zonas,
        ]);
    }
}
