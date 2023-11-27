<x-tenant-layout title="{{ __('Atualizar Código de barras') }}" :themeAction="$themeAction" :status="$status" :message="$message">

    {{-- Content --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-9 col-xs-6">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ __('Código de barras de produto') }}</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('Atualizar') }}</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Código de Barras') }}</h4>
                    </div>
                    <div class="card-body">
                        @livewire('tenant.cod-barras-atualizar.cod-barras-atualizar')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
