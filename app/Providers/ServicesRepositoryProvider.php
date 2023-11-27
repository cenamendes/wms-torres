<?php

namespace App\Providers;

use App\Interfaces\Tenant\Arrumacoes\ArrumacoesInterface;
use App\Interfaces\Tenant\CodBarrasAtualizar\CodBarrasAtualizarInterface;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Tenant\Profile\ProfileInterface;

use App\Repositories\Tenant\Profile\ProfileRepository;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Repositories\Tenant\Encomendas\EncomendasRepository;
use App\Interfaces\Tenant\Localizacoes\LocalizacoesInterface;
use App\Repositories\Tenant\Localizacoes\LocalizacoesRepository;
use App\Interfaces\Tenant\SupplierDocuments\SupplierDocumentsInterface;
use App\Interfaces\Tenant\CustomersDocuments\CustomersDocumentsInterface;
use App\Interfaces\Tenant\Devolucoes\DevolucoesInterface;
use App\Interfaces\Tenant\LocalizacoesAtualizar\LocalizacoesAtualizarInterface;
use App\Interfaces\Tenant\Separacoes\SeparacoesInterface;
use App\Interfaces\Tenant\Transferencias\TransferenciasInterface;
use App\Repositories\Tenant\Arrumacoes\ArrumacoesRepository;
use App\Repositories\Tenant\CodBarrasAtualizar\CodBarrasAtualizarRepository;
use App\Repositories\Tenant\SupplierDocuments\SupplierDocumentsRepository;
use App\Repositories\Tenant\CustomersDocuments\CustomersDocumentsRepository;
use App\Repositories\Tenant\Devolucoes\DevolucoesRepository;
use App\Repositories\Tenant\LocalizacoesAtualizar\LocalizacoesAtualizarRepository;
use App\Repositories\Tenant\Separacoes\SeparacoesRepository;
use App\Repositories\Tenant\Transferencias\TransferenciasRepository;

class ServicesRepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        EncomendasInterface::class => EncomendasRepository::class,
        CustomersDocumentsInterface::class => CustomersDocumentsRepository::class,
        SupplierDocumentsInterface::class => SupplierDocumentsRepository::class,
        ProfileInterface::class => ProfileRepository::class,
        LocalizacoesInterface::class => LocalizacoesRepository::class,
        ArrumacoesInterface::class => ArrumacoesRepository::class,
        TransferenciasInterface::class => TransferenciasRepository::class,
        DevolucoesInterface::class => DevolucoesRepository::class,
        SeparacoesInterface::class => SeparacoesRepository::class,
        CodBarrasAtualizarInterface::class => CodBarrasAtualizarRepository::class,
        LocalizacoesInterface::class => LocalizacoesRepository::class,
        LocalizacoesAtualizarInterface::class => LocalizacoesAtualizarRepository::class
    ];
}
