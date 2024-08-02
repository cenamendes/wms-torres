<?php

namespace App\Http\Livewire\Tenant\Analises;

use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Models\Tenant\AnalisesReportadosAtualizados;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ReportadosAtualizados extends Component
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

        // Filtrar os dados da tabela AnalisesReportadosAtualizados
        $reportados_atualizados = AnalisesReportadosAtualizados::query()
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

        return view('tenant.livewire.analises.reportadosatualizados', [
            "reportados_atualizados" => $reportados_atualizados,
        ]);
    }

}
