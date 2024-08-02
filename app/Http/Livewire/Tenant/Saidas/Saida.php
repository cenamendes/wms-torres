<?php

namespace App\Http\Livewire\Tenant\Saidas;

use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Models\Tenant\AssociarEncomenda;
use App\Models\Tenant\SaidasStock;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Saida extends Component
{
    use WithPagination;
    use WithFileUploads;

    public int $perPage;
    public int $saida;
    private ?object $saidasstock = null;
    public string $refsaida = '';
    public string $searchString = '';
    public string $designacao = '';
    public string $ordenation = 'desc';
    private ?object $saidas = null;
    public $saidasGuardadas;
    public $encomendasNaoAssociadas = [];

    public $image;

    protected object $encomendaRepository;

    public function boot(EncomendasInterface $interfaceEncomenda)
    {
        $this->encomendaRepository = $interfaceEncomenda;
    }

    public function mount($saida)
    {

        if (isset($this->perPage)) {
            session()->put('perPage', $this->perPage);
        } elseif (session('perPage')) {
            $this->perPage = session('perPage');
        } else {
            $this->perPage = 10;
        }

        $this->saida = $saida;

        session(['tipo_saida' => $saida]);

        $this->saidas = $this->encomendaRepository->entradarefsaidas($saida, $this->perPage);

        $userId = auth()->id();
        $user = auth()->user();

        if ($saida == 1) {
            $this->refsaida = "Grande Porte";
        } elseif ($saida == 2) {
            $this->refsaida = "Pequeno Porte";
        } elseif ($saida == 3) {
            $this->refsaida = "Encomendas com Pendentes";
        } elseif ($saida == 4) {
            $this->refsaida = "Sem Expedição";
        } elseif ($saida == 5) {
            $this->refsaida = "Levantamento em Loja";
        } elseif ($saida == 6) {
            $this->refsaida = "Marketplaces";
        }

        $userIdsAllowed = [1, 16];
        $typeUsersAllowed = [2];
        $isUserAllowed = in_array($userId, $userIdsAllowed) || $user->type_user == 2;

        // Consultar a tabela `associarencomenda` para encontrar as encomendas NÃO associadas ao usuário logado
        $encomendasNaoAssociadas = $isUserAllowed ? collect([]) : AssociarEncomenda::whereNotIn('user_id', [$userId])->pluck('numero_encomenda');

        // Atribuir a lista de encomendas NÃO associadas à variável $encomendasNaoAssociadas
        $this->encomendasNaoAssociadas = $encomendasNaoAssociadas;

        // Filtrar os dados em `$this->saidas`
        $this->saidas = $this->saidas->filter(function ($encomenda) use ($encomendasNaoAssociadas, $isUserAllowed) {
            // Se o usuário logado tiver ID 1 ou 16 ou for do type_user 2, todas as encomendas devem ser visíveis
            if ($isUserAllowed) {
                return true;
            }

            // Verificar se a encomenda está associada a algum usuário diferente do usuário logado
            return $encomendasNaoAssociadas->contains($encomenda->document);
        });
    }

    public function paginationView()
    {
        return 'tenant.livewire.setup.pagination';
    }

    public function abrirPopUpInfo($internal_notes)
    {
        $this->dispatchBrowserEvent('swalFire', [
            'title' => 'Informação',
            'message' => 'Nota: ' . $internal_notes,
            'status' => 'info',
        ]);
    }

    public function toggleRowFontAndSubmit($id, $document, $name, $route)
    {
        // Verifica se a encomenda já existe na tabela saidasstock
        $existingEncomenda = SaidasStock::where('numero_encomenda', $id)->first();

        // Se a encomenda já existir, não faz nada e redireciona para a rota
        if ($existingEncomenda) {
            return redirect()->to($route);
        }
        // Se a encomenda não existir, adiciona-a ao banco de dados
        SaidasStock::create([
            "numero_encomenda" => $id,
            "document" => $document,
            "nome" => $name,
            "user_name" => Auth::user()->name,
            "user_id" => Auth::user()->id,
        ]);

        // Exibe uma mensagem de sucesso
        session()->flash('message', 'Encomenda gravada com sucesso!');

        // Redireciona para a rota específica
        return redirect()->to($route);
    }

    public function clearFilter()
    {
        $this->reset(['searchString', 'ordenation', 'designacao']);
    }

    public function render()
    {

        if (isset($this->searchString) && $this->ordenation) {
            $this->saidas = $this->encomendaRepository->getSaidasSearch($this->saida, $this->searchString, $this->ordenation, $this->perPage, $this->designacao);
        } else {

            $this->saidas = $this->encomendaRepository->entradarefsaidas($this->saida, $this->perPage);
        }
        $this->saidasGuardadas = SaidasStock::pluck('numero_encomenda')->toArray();

        return view('tenant.livewire.saidas.saida', ["saidas" => $this->saidas]);
    }
}
