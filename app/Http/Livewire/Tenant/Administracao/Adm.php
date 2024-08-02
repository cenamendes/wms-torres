<?php

namespace App\Http\Livewire\Tenant\Administracao;

use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Models\Tenant\AssociarEncomenda;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Adm extends Component
{
    use WithPagination;
    use WithFileUploads;

    public string $homePanel = 'show active';
    // public string $emailPanel = '';
    public string $pickPanel = '';
    public string $reportPanel = '';
    public string $cancelButton = '';
    public string $actionButton = '';

    public ?object $config = null;

    public string $company_name = '';
    public string $vat = '';
    public string $contact = '';
    public string $email = '';
    public string $address = '';
    public ?string $logotipo = '';
    public string $sender_email = '';
    public string $sender_name = '';
    public string $sender_cc_email = '';
    public string $sender_cc_name = '';
    public string $sender_bcc_email = '';
    public string $sender_bcc_name = '';
    public ?string $signature = '';
    public string $alert_email = '';
    public ?string $report_email = null;

    public $uploadFile;
    public $perPage = 10;
    public string $baseUrl = '';

    public $emailsRequest;

    public int $count = 0;

    public ?array $emailsStored = [];

    public ?object $users = null;
    public ?array $user = null;
    public ?array $usersSelect = [];

    protected ?object $optionsSaidas = null;
    protected ?object $saidas = null;
    private ?object $stoqueSelect = null;

    public ?string $options = null;
    public $selectedUsers = [];
    public $associacoes;

    protected object $encomendaRepository;

    //Parte da pickagem
    public ?int $cod_barras_pick;
    public ?int $reference_pick;

    public ?int $scan_pick;
    public EncomendasInterface $encomendasRepository;
    public function boot(EncomendasInterface $interfaceEncomenda)
    {
        $this->encomendaRepository = $interfaceEncomenda;
    }
    public function mount(EncomendasInterface $interfaceEncomenda)
    {

        if (isset($this->perPage)) {
            session()->put('perPage', $this->perPage);
        } elseif (session('perPage')) {
            $this->perPage = session('perPage');
        } else {
            $this->perPage = 10;
        }
        $this->encomendaRepository = $interfaceEncomenda;

        $this->optionsSaidas = $this->encomendaRepository->menusaidas();
        // vinicius
        $this->stoqueSelect = $this->encomendaRepository->selectStock();
        // vinicius

        $this->users = User::whereIn('type_user', [1, 2])->get();

        $usersStock = User::where('type_user', '!=', 0)->get();

        $this->usersSelect = $usersStock->mapWithKeys(function ($user) {
            return [$user->id => [
                'username' => $user->username,
                'id' => $user->id,
                'authstock' => $user->authstock
            ]];
        })->toArray();
        $this->associacoes = AssociarEncomenda::get()->pluck('user_id', 'numero_encomenda')->toArray();
        $this->saidas = $this->encomendaRepository->entradarefsaidas($this->options, $this->perPage);
        $this->selectedUsers = session('selectedUsers', []);

    }

    public function paginationView()
    {
        return 'tenant.livewire.setup.pagination';
    }


    public function atualizarEstoqueUsuario($userclick, $warehouseId, $checked)
    {
        $user = User::find($userclick);

        if ($user) {
            $authStoque = json_decode($user->authstock, true);

            if ($checked) {
                $authStoque[] = ['id' => $warehouseId];
            } else {
                foreach ($authStoque as $key => $item) {
                    if ($item['id'] == $warehouseId) {
                        unset($authStoque[$key]);
                    }
                }
            }

            $authStoqueNew = array_values($authStoque);

            $user->authstock = json_encode($authStoqueNew);
            $user->save();
            $this->pickPanel = 'show active';
            $this->homePanel = '';

            $this->user = $user->toArray();
        }
    }

    public function updatedOptions()
    {
        $this->saidas = $this->encomendaRepository->entradarefsaidas($this->options, $this->perPage);
    }
    public function userSelected($imprId, $userId, $userType)
    {
        $imprId = trim($imprId);
        $username = '';

        if ($userId != 0) {
            // Obtenha o nome do usuário associado ao ID
            $user = User::find($userId);

            // Verifique se o usuário foi encontrado
            if ($user) {
                $username = $user->username;
            }
        }

        // Se o tipo de usuário for diferente, você pode ajustar aqui
        // dependendo das diferenças de lógica que você precisa implementar
        // talvez seja necessário ajustar a lógica de acordo com o tipo de usuário

        $type_user = $userType;

        if ($userId == 0) {
            AssociarEncomenda::where('numero_encomenda', $imprId)->delete();
        } else {
            AssociarEncomenda::updateOrCreate(
                ['numero_encomenda' => $imprId],
                [
                    'user_id' => $userId,
                    'name' => $username,
                    'username' => $username,
                    'type_user' => $type_user
                ]
            );
        }

        // Atualize o array $selectedUsers usando o número da encomenda como chave única
        $this->selectedUsers[$imprId] = $userId;

        // Se o usuário selecionado for "A Todos", remova a associação
        if ($userId == 0) {
            unset($this->selectedUsers[$imprId]);
        }

        // Salvar os dados na sessão
        session(['selectedUsers' => $this->selectedUsers]);

        // Se desejar, você pode emitir uma mensagem de sucesso
        session()->flash('message', 'Associação salva com sucesso!');
    }
    public function render()
    {
        $this->optionsSaidas = $this->encomendaRepository->menusaidas();

        $this->stoqueSelect = $this->encomendaRepository->selectStock();

        $usersStock = User::where('type_user', '!=', 0)->get();

        $this->usersSelect = $usersStock->mapWithKeys(function ($user) {
            return [$user->id => [
                'username' => $user->username,
                'id' => $user->id,
                'authstock' => $user->authstock
            ]];
        })->toArray();

        if ($this->options !== null) {
            $this->saidas = $this->encomendaRepository->entradarefsaidas($this->options, $this->perPage);
        }

        return view('tenant.livewire.administracao.adm', [
            'optionsSaidas' => $this->optionsSaidas,
            'saidas' => $this->saidas,
            "emailsStored" => $this->emailsStored,
            "report_email" => $this->report_email,
            "selectedUsers" => $this->selectedUsers,
            'associacoes' => $this->associacoes,
            "stoqueSelect" => $this->stoqueSelect,
            "usersSelect" => $this->usersSelect,
        ]);
    }
}
