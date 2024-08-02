<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */

    public EncomendasInterface $encomendasRepository;
    public $filterId;
    private ?object $stoqueSelect = null;
    public ?array $users = [];
    public ?array $usersSelect = [];

    public function __construct(EncomendasInterface $encomendasinterface)
    {
        $this->encomendasRepository = $encomendasinterface;
    }
    public function create()
    {
        $this->filterId = null;
        $action = session('status');
        $message = session('message');
        $this->stoqueSelect = $this->encomendasRepository->selectStock();

        $this->users = User::where('type_user', 1)->pluck('username', 'id')->toArray();

        $usersStock = User::get();

        $this->usersSelect = $usersStock->mapWithKeys(function ($user) {
            return [$user->id => [
                'type_user' => $user->type_user,
                'username' => $user->username,
                'id' => $user->id,
                'authstock' => $user->authstock,
            ]];
        })->toArray();

        // Verificar se o usuário atual é 'adminboxpt' ou 'gestorbrvr'
        $currentUser = Auth::user();
        if ($currentUser && ($currentUser->id === 1 || $currentUser->id === 16)) {
            // Renderizar a view sem o seletor de armazéns
            return view('tenant.auth.login', compact('action', 'message'));
        } else {
            // Renderizar a view normalmente com o seletor de armazéns
            return view('tenant.auth.login', compact('action', 'message'), ["stoqueSelect" => $this->stoqueSelect, "usersSelect" => $this->usersSelect]);
        }
    }
    public function applyFilter()
    {

        if ($this->filterId !== null) {

        }
    }
    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        // Obter o usuário autenticado
        $user = Auth::user();

        // Verificar se a opção "a todos" foi selecionada
        if ($request->selected_stock === 'all') {
            // Definir 'loginstock' como nulo para indicar "a todos"
            $user->loginarmazem = null;
        } else {
            // Atualizar o atributo 'loginstock' do usuário autenticado com a opção selecionada
            $user->loginarmazem = $request->selected_stock;
        }

        // Salvar as alterações no banco de dados
        $user->save();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }



    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
