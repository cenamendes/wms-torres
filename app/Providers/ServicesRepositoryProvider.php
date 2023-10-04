<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Tenant\Profile\ProfileInterface;

use App\Repositories\Tenant\Profile\ProfileRepository;
use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Repositories\Tenant\Encomendas\EncomendasRepository;
use App\Interfaces\Tenant\Localizacoes\LocalizacoesInterface;
use App\Repositories\Tenant\Localizacoes\LocalizacoesRepository;
use App\Interfaces\Tenant\SupplierDocuments\SupplierDocumentsInterface;
use App\Interfaces\Tenant\CustomersDocuments\CustomersDocumentsInterface;
use App\Repositories\Tenant\SupplierDocuments\SupplierDocumentsRepository;
use App\Repositories\Tenant\CustomersDocuments\CustomersDocumentsRepository;

class ServicesRepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        EncomendasInterface::class => EncomendasRepository::class,
        CustomersDocumentsInterface::class => CustomersDocumentsRepository::class,
        SupplierDocumentsInterface::class => SupplierDocumentsRepository::class,
        ProfileInterface::class => ProfileRepository::class,
        LocalizacoesInterface::class => LocalizacoesRepository::class
    ];
}
