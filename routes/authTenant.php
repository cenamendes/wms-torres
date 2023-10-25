<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\Authenticated;
use App\Http\Controllers\Tenant\Setup\ConfigController;
use App\Http\Controllers\Tenant\Auth\RegisterController;
use App\Http\Controllers\Tenant\Profile\ProfileController;
use App\Http\Controllers\Tenant\Auth\NewPasswordController;
use App\Http\Controllers\Tenant\Auth\VerifyEmailController;
use App\Http\Controllers\Tenant\Auth\RegisteredUserController;
use App\Http\Controllers\Tenant\Arrumacoes\ArrumacoesController;
use App\Http\Controllers\Tenant\Devolucoes\DevolucoesController;
use App\Http\Controllers\Tenant\Encomendas\EncomendasController;
use App\Http\Controllers\Tenant\Separacoes\SeparacoesController;
use App\Http\Controllers\Tenant\Auth\PasswordResetLinkController;
use App\Http\Controllers\Tenant\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Tenant\Localizacoes\LocalizacoesController;
use App\Http\Controllers\Tenant\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Tenant\Transferencias\TransferenciasController;

/**** ROTAS ANTES DO LOGIN ********/

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');

    Route::get('/sign-up', [RegisterController::class, 'create']);
    Route::post('/sign-up', [RegisterController::class, 'store'])->name('registerEntity');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('tenant.verify');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');

});


/******************* */


Route::middleware(['auth', 'cmsSettings'])->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');


    /***** ROTA DA PÁGINA INICIAL ******/    

    // Route::get('dashboard', [DashboardController::class, 'show'])
    //     ->name('tenant.dashboard');

    Route::get('dashboard', [EncomendasController::class,'rececao'])
        ->name('tenant.dashboard');

    /****** FIM DA PÁGINA INICIAL *****/    

   

    /***** ROTAS DO SCAN *****/

    Route::get('encomendas/rececao/{numero_encomenda}',[EncomendasController::class,'detailEncomenda'])->name('tenant.encomendas.rececao.detail');
    Route::get('encomendas/rececao', [EncomendasController::class,'rececao'])->name('tenant.encomendas.rececao');
    

    /*******FIM DAS ROTAS DE SCAN*******/
 
   
    /**** ROTAS DA PARTE DO PERFIL ****/

    Route::post('user-info', [ProfileController::class,'UserInfo'])->name('tenant.user-info.userinfo');

    Route::resource('profile', ProfileController::class, [
        'as' => 'tenant'
    ]);

    /**** FIM DAS ROTAS DE PERFIL ****/

    /*** ROTAS DAS ARRUMAÇÕES ***/

    Route::get('arrumacoes/encomenda',[ArrumacoesController::class,'detailEncomendaArrumacao'])->name('tenant.arrumacoes.encomenda.detail');
    Route::get('arrumacoes/encomendas', [ArrumacoesController::class,'index'])->name('tenant.arrumacoes.index');

    /************** */

    /*** ROTAS DAS DEVOLUÇÕES ***/

    Route::get('devolucoes/encomendas', [DevolucoesController::class,'index'])->name('tenant.devolucoes.index');


    /************** */

    /*** ROTAS DAS SEPARACOES ***/

    Route::get('separacoes/encomenda/{numero_encomenda}',[SeparacoesController::class,'detailEncomendaSeparacao'])->name('tenant.separacoes.encomenda.detail');
    Route::get('separacoes/encomendas', [SeparacoesController::class,'index'])->name('tenant.separacoes.index');

    /************** */

    /*** ROTAS DE TRANSFERÊNCIAS ***/

    Route::get('transferencias',[TransferenciasController::class,'index'])->name('tenant.transferencia.index');

    /*************** */
  

    /**** ROTAS DA PARTE DE CONFIGURAÇÃO ****/

    Route::prefix('setup')->group(function () {
     
        Route::get('config', [ConfigController::class, 'index'])
            ->name('tenant.setup.app');

        // Route::delete('locations/{id}', [LocalizacoesController::class, 'delete'])
        //     ->name('tenant.localizacoes.delete');    
        // Route::post('locations/store', [LocalizacoesController::class, 'store'])
        //     ->name('tenant.localizacoes.store');
        // Route::get('locations/create', [LocalizacoesController::class, 'create'])
        //     ->name('tenant.localizacoes.create');
        // Route::get('locations', [LocalizacoesController::class, 'index'])
        //     ->name('tenant.localizacoes.index');

        Route::get('locations/order', [LocalizacoesController::class,'order'])->name('tenant.locations.order');

        Route::resource('locations', LocalizacoesController::class, [
                'as' => 'tenant'
        ]);

    });

     /**** FIM DAS ROTAS DE CONFIGURAÇÃO ****/

});
