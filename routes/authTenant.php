<?php

use App\Http\Controllers\Tenant\Administracao\AdmController;
use App\Http\Controllers\Tenant\Analises\PickingController;
use App\Http\Controllers\Tenant\Analises\ReportadosAtualizadosController;
use App\Http\Controllers\Tenant\Stock\StockController;
use App\Http\Controllers\Tenant\GestaoStock\ReportadosController;
use App\Http\Controllers\Tenant\Arrumacoes\ArrumacoesController;
use App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Tenant\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Tenant\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Tenant\Auth\NewPasswordController;
use App\Http\Controllers\Tenant\Auth\PasswordResetLinkController;
use App\Http\Controllers\Tenant\Auth\RegisterController;
use App\Http\Controllers\Tenant\Auth\RegisteredUserController;
use App\Http\Controllers\Tenant\Auth\VerifyEmailController;
use App\Http\Controllers\Tenant\CodBarrasAtualizar\CodBarrasAtualizarController;
use App\Http\Controllers\Tenant\DevolucoesClientes\DevolucoesClientesController;
use App\Http\Controllers\Tenant\DevolucoesMaterialDanificado\DevolucoesMaterialDanificadoController;
use App\Http\Controllers\Tenant\Devolucoes\DevolucoesController;
use App\Http\Controllers\Tenant\Encomendas\EncomendasController;
use App\Http\Controllers\Tenant\Entrada\EntradaController;
use App\Http\Controllers\Tenant\LocalizacoesAtualizar\LocalizacoesAtualizarController;
use App\Http\Controllers\Tenant\Localizacoes\LocalizacoesController;
use App\Http\Controllers\Tenant\Profile\ProfileController;
use App\Http\Controllers\Tenant\Saidas\SaidaController;
use App\Http\Controllers\Tenant\Separacoes\SeparacoesController;
use App\Http\Controllers\Tenant\Setup\ConfigController;
use App\Http\Controllers\Tenant\Transferencias\ListagemController;
use App\Http\Controllers\Tenant\Transferencias\TransferenciaController;
use Illuminate\Support\Facades\Route;

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

    /***** ROTA DA ENTRADAS ******/

    // Route::get('dashboard', [DashboardController::class, 'show'])
    //     ->name('tenant.dashboard');

    Route::get('dashboard', [EncomendasController::class, 'rececao'])
        ->name('tenant.dashboard');

    /****** FIM DA ENTRADAS *****/

    /***** ROTA DA PAGINA INICIAL ******/

    Route::get('entrada', [EntradaController::class, 'entrada'])
        ->name('tenant.entrada');

    /****** FIM ROTAS DA PAGINA INICIAL *****/

    /*** ROTAS DAS DEVOLUÇÕES CLIENTES ***/

    Route::get('devolucoesclientes/devolucoesClientes/{numero_encomenda}', [DevolucoesClientesController::class, 'detaildevolucoesclientes'])->name('tenant.devolucoesclientes.devolucoesclientesdetail');
    Route::get('devolucoesclientes', [DevolucoesClientesController::class, 'devolucoesClientes'])->name('tenant.devolucoesclientes');

    /************** */

    /*** ROTAS DAS DEVOLUÇÕES MATERIAL DANIFICADO ***/

    Route::get('devolucoesmaterialdanificado/devolucoesMaterialDanificado/{numero_encomenda}', [DevolucoesMaterialDanificadoController::class, 'detailmaterialdanificado'])->name('tenant.devolucoesmaterialdanificado.devolucoesmaterialdanificadodetail');
    Route::get('devolucoesmaterialdanificado', [DevolucoesMaterialDanificadoController::class, 'devolucoesmaterialdanificado'])->name('tenant.devolucoesmaterialdanificado');

    /************** */

    /*** TRANSFERENCIAS STOCK ***/

    Route::get('transferencias/transferencia', [TransferenciaController::class, 'transferencia'])->name('tenant.transferencias.transferencia');

    Route::get('transferencias/listagemdetail', [ListagemController::class, 'detailListagem'])->name('tenant.transferencias.listagemdetail');

    /************** */

    /*** ANÁLISES***/

    Route::get('analises/picking', [PickingController::class, 'picking'])->name('tenant.analises.picking');
    Route::get('analises/reportadosatualizados', [ReportadosAtualizadosController::class, 'reportadosatualizados'])->name('tenant.analises.reportadosatualizados');
    /** Route::get('analises/analise/{numero_encomenda}',[AnaliseController::class,'detailAnalise'])->name('tenant.analises.analisedetail');**/

    /************** */

    /*** GESTÃO STOCK ***/
    Route::get('gestaostock/reportados', [ReportadosController::class, 'reportados'])->name('tenant.gestaostock.reportados');
    Route::post('/atualizar-status/{id}', [ReportadosController::class, 'atualizarStatus'])->name('atualizar-status');
    Route::post('/excluir-registros', [ReportadosController::class, 'excluirRegistros'])->name('excluir-registros');

    Route::get('stock/stock', [StockController::class, 'stock'])->name('tenant.stock.stock');
    /************* */

    /*** ROTAS DAS SAIDAS ***/

    Route::get('saidas/{idsaida}', [SaidaController::class, 'saida'])->name('tenant.saida');

    Route::get('saidasDetail/{numero_encomenda}', [SaidaController::class, 'SaidaDetail'])->name('tenant.saidasDetail');

    /************** */

    /***** ROTAS DO SCAN *****/

    Route::get('encomendas/rececao', [EncomendasController::class, 'rececao'])->name('tenant.encomendas.rececao');
    Route::get('encomendas/rececao/{numero_encomenda}', [EncomendasController::class, 'detailEncomenda'])->name('tenant.encomendas.encomendadetail');

    /*******FIM DAS ROTAS DE SCAN*******/

    /**** ROTAS DA PARTE DO PERFIL ****/

    Route::post('user-info', [ProfileController::class, 'UserInfo'])->name('tenant.user-info.userinfo');

    Route::resource('profile', ProfileController::class, [
        'as' => 'tenant',
    ]);

    /**** FIM DAS ROTAS DE PERFIL ****/

    /*** ROTAS DAS ARRUMAÇÕES ***/

    Route::get('arrumacoes/encomenda', [ArrumacoesController::class, 'detailEncomendaArrumacao'])->name('tenant.arrumacoes.encomenda.detail');
    Route::get('arrumacoes/encomendas', [ArrumacoesController::class, 'index'])->name('tenant.arrumacoes.index');

    /************** */

    /*** ROTAS DAS DEVOLUÇÕES ***/

    Route::get('devolucoes/encomendas', [DevolucoesController::class, 'index'])->name('tenant.devolucoes.index');

    /************** */

    /*** ROTAS DAS SEPARACOES ***/

    Route::get('separacoes/encomenda/{numero_encomenda}', [SeparacoesController::class, 'detailEncomendaSeparacao'])->name('tenant.separacoes.encomenda.detail');
    Route::get('separacoes/encomendas', [SeparacoesController::class, 'index'])->name('tenant.separacoes.index');

    /************** */

    /*** ROTAS ADMINISTRAÇÃO ***/
    Route::get('administracao/adm', [AdmController::class, 'adm'])->name('tenant.administracao.adm');
    /*** ***/

    /**** ROTAS DA PARTE DE CONFIGURAÇÃO ****/

    Route::prefix('setup')->group(function () {

        Route::get('config', [ConfigController::class, 'index'])
            ->name('tenant.setup.app');

        Route::resource('codbarras-produto', CodBarrasAtualizarController::class, [
            'as' => 'tenant',
        ]);

        Route::resource('codbarras-localizacao', LocalizacoesAtualizarController::class, [
            'as' => 'tenant',
        ]);

        Route::get('locations/order', [LocalizacoesController::class, 'order'])->name('tenant.locations.order');

        Route::resource('locations', LocalizacoesController::class, [
            'as' => 'tenant',
        ]);

    });

    /**** FIM DAS ROTAS DE CONFIGURAÇÃO ****/

});
