<?php

namespace App\Http\Livewire\Tenant\Analises;

use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Models\Tenant\AnalisesPicking;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Picking extends Component
{
    use WithPagination;
    use WithFileUploads;

    public int $perPage;
    public string $designacao = '';
    public string $ordenation = 'desc';
    public string $searchNumeroEncomenda = '';
    public string $searchReferencia = '';
    public string $OrigemEstado = '';
    public string $selectedDate = '';

    private ?object $encomendas = null;

    public $image;

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

        $this->encomendas = $this->encomendaRepository->entradasCodBarras($this->perPage);
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
        $this->reset(['searchNumeroEncomenda', 'searchReferencia', 'ordenation', 'designacao', 'OrigemEstado', 'selectedDate']);
    }

    public function render()
    {
        // Obtenha os estados da sua fonte de dados, como um array ou coleção
        $estados = AnalisesPicking::pluck('estado')->unique()->toArray(); // Obter estados únicos da tabela AnalisesPicking

        // Filtrar os dados da tabela AnalisesPicking
        $analises_picking = AnalisesPicking::query()
            ->when($this->searchNumeroEncomenda, function ($query) {
                $query->where('document', 'like', '%' . $this->searchNumeroEncomenda . '%');
            })
            ->when($this->searchReferencia, function ($query) {
                $query->where('referencia', 'like', '%' . $this->searchReferencia . '%');
            })
            ->when($this->OrigemEstado, function ($query) { // Filtro para o estado
                $query->where('estado', $this->OrigemEstado);
            })
            ->when($this->designacao, function ($query) {
                $query->where('descricao', 'like', '%' . $this->designacao . '%');
            })
            ->when($this->selectedDate, function ($query) {
                $query->whereDate('created_at', '=', date('Y-m-d', strtotime($this->selectedDate)));
            })
            ->orderBy('id', $this->ordenation)
            ->paginate($this->perPage);

        return view('tenant.livewire.analises.picking', [
            "analises_picking" => $analises_picking,
            "estados" => $estados, // Passa os estados únicos para a view
        ]);
    }

}
