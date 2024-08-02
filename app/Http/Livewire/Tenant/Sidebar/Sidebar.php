<?php

namespace App\Http\Livewire\Tenant\Sidebar;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Tenant\Customers;
use App\Models\Tenant\Encomendas;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant\RececaoObservacoes;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Models\Tenant\MovimentosStock;
use ZipArchive;

class Sidebar extends Component
{
    use WithPagination;
    use WithFileUploads;

    public int $perPage;

    public string $searchString = '';

    private ?object $saidas = null;

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


    public function render()
    {
        // **  Numero de encomendas de fornecedor abertos  **/

        $saidas = $this->encomendaRepository->menusaidas();

        return view('tenant.livewire.sidebar.sidebar', [
            'saidas' => $saidas,
        ]);
    }
}

