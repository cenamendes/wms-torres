<x-tenant-layout title="{{ __('Ordem das localizações') }}" :themeAction="$themeAction" :status="$status" :message="$message">

    <script src="//cdn.asprise.com/scannerjs/scanner.js" type="text/javascript"></script>
    {{-- Content --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-9 col-xs-6">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ __('Ordem das localizações') }}</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('List') }}</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Ordem das localizações') }}</h4>
                    </div>
                    <div class="card-body">
                        @livewire('tenant.localizacoes.ordem-localizacoes')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
<script>

    window.addEventListener('planning',function(e){
        var arrayPosition = [];

         jQuery('.dd-handle').each(function(i, obj) {
            var arrayPlan = {};
            var abreviatura = jQuery(this).find(".abreviatura").val();

            arrayPlan.abreviatura = abreviatura;

            arrayPosition.push(arrayPlan);
        });

         Livewire.emit("sendChangesPlanning",arrayPosition)

    });


    jQuery("#nestable").nestable('init');


</script>
