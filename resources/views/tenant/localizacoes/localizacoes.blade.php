<x-tenant-layout title="{{ __('Listagem Localizações') }}" :themeAction="$themeAction" :status="$status" :message="$message">

    <script src="//cdn.asprise.com/scannerjs/scanner.js" type="text/javascript"></script>
    {{-- Content --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-9 col-xs-6">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ __('Localizações') }}</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('List') }}</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-3 col-xs-6 text-right">
                <a href="{{ route('tenant.locations.create') }}" class="btn btn-primary">Criar Localização</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Localizações') }}</h4>
                    </div>
                    <div class="card-body">
                        @livewire('tenant.localizacoes.localizacoes')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
