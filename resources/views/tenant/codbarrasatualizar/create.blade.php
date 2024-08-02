<x-tenant-layout title="Nova Localização" :themeAction="$themeAction">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{ __('Localizações') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('Create') }}</a></li>
            </ol>
        </div>
        <div class="default-tab">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home"><i class="la la-home mr-2"></i> {{ __("Localizações") }}</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <div>
                        <x-tenant.localizacoes.form :action="route('tenant.locations.store')" :update="false" buttonAction="{{__('Create Location')}}" formTitle="{{ __('Create Location') }}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="erros">

        @if ($errors->any())
            <script>
                let status = '';
                let message = '';

                status = 'error';

                @php

                $allInfo = '';

                foreach ($errors->all() as $err )
                {
                   $allInfo .= $err."<br>";
                }

                $message = $allInfo;

                @endphp
                message = '{!! $message !!}';
            </script>
        @endif
    </div>
</x-tenant-layout>
