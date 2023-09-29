<?php

namespace App\Http\Controllers\Tenant\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Interfaces\Tenant\Customers\CustomersInterface;
use App\Http\Requests\Tenant\Customers\CustomersFormRequest;

class RegisterController extends Controller
{

    private CustomersInterface $customersRepository;

    public function __construct(CustomersInterface $customersRepository)
    {
        $this->customersRepository = $customersRepository;
    }

   
    public function create()
    {
        $action = session('status');
        $message = session('message');

        return view('tenant.auth.register', compact('action','message'));
    }

  
    public function store(CustomersFormRequest $request)
    {
        //executo o add do repositorio e lá terei de pedir os ids ao sergio e guardo
        //perguntar como posso saber neste caso se é cliente ou fornecedor

        $this->customersRepository->add($request);

       return to_route('login')
       ->with('message', __('Customer created with success!'))
       ->with('status', 'success');
    }
}
