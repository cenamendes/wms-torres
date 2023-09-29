<?php

namespace App\Providers;

use App\Interfaces\Tenant\CustomersDocuments\CustomersDocumentsInterface;
use Illuminate\Support\ServiceProvider;

use App\Interfaces\Tenant\Encomendas\EncomendasInterface;
use App\Interfaces\Tenant\Profile\ProfileInterface;
use App\Interfaces\Tenant\SupplierDocuments\SupplierDocumentsInterface;
use App\Repositories\Tenant\CustomersDocuments\CustomersDocumentsRepository;
use App\Repositories\Tenant\Encomendas\EncomendasRepository;
use App\Repositories\Tenant\Profile\ProfileRepository;
use App\Repositories\Tenant\SupplierDocuments\SupplierDocumentsRepository;

class ServicesRepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        EncomendasInterface::class => EncomendasRepository::class,
        CustomersDocumentsInterface::class => CustomersDocumentsRepository::class,
        SupplierDocumentsInterface::class => SupplierDocumentsRepository::class,
        ProfileInterface::class => ProfileRepository::class
    ];
}
