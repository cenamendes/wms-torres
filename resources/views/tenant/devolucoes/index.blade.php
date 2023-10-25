<x-tenant-layout title="Detalhes das Devoluções" :themeAction="$themeAction" :status="$status" :message="$message">
    {{-- Content --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-9 col-xs-6">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Devoluções</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Referências</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Devoluções</h4>
                    </div>
                    <div class="card-body">
                        @livewire('tenant.devolucoes.show-devolucoes-detail')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
