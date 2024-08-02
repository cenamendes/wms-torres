<?php

namespace App\Http\Livewire\Tenant\GestaoStock;

use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Models\Tenant\ReportadosStock;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Reportados extends Component
{
    use WithPagination;
    use WithFileUploads;

    public int $perPage;
    public string $designacao = '';
    public string $observacao = '';
    public string $ordenation = 'desc';
    public string $searchNumeroEncomenda = '';
    public string $searchReferencia = '';
    public string $OrigemEstado = '';
    public string $selectedDate = '';
    public $referencias_reportadas;
    public $selectoptions = [];

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

        $this->referencias_reportadas = ReportadosStock::pluck('referencia')->toArray();
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

    public function updatedOrdenation()
    {
        $this->resetPage(); // Reseta a páginação para a primeira página quando a ordenação é alterada
    }

    public function clearFilter()
    {
        $this->reset(['searchNumeroEncomenda', 'searchReferencia', 'ordenation', 'designacao', 'OrigemEstado', 'selectedDate']);
    }



    public function render()
    {
        // Filtrar os dados da tabela AnalisesReportados
        $reportados_stock = ReportadosStock::query()
            ->when($this->searchReferencia, function ($query) {
                $query->where('referencia', 'like', '%' . $this->searchReferencia . '%');
            })
            ->when($this->designacao, function ($query) {
                $query->where('observacao', 'like', '%' . $this->designacao . '%');
            })
            ->when($this->selectedDate, function ($query) {
                $query->whereDate('created_at', '=', date('Y-m-d', strtotime($this->selectedDate)));
            })
            ->orderBy('id', $this->ordenation)
            ->paginate($this->perPage);

       return view('tenant.livewire.gestaostock.reportados', [
            "reportados_stock" => $reportados_stock,
        ]);
    }
}
