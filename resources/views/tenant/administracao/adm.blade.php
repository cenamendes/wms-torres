<link rel="icon" type="image/png" sizes="16x16" href="{{ 'assets/resources/images/logo_png_boxpt.png' }}">
<x-tenant-layout title="{{ __('Administração') }}" :themeAction="$themeAction" :status="$status" :message="$message">
    {{-- Content --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-9 col-xs-6">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ __('Administração') }}</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('Gestão') }}</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-xs-6 col-md-9">
                        <h4 class="card-title">{{ __('Gestão') }}</h4>
                        </div>
                        {{--@php

                        $result = \App\Models\Tenant\Config::first();

                    @endphp

                    @if ($result->scan_accept >= 1)
                        <div class="col-xs-6 col-md-3" id="scan_pick">
                            <div class="col-xl-12 col-xs-6 text-right">
                                <button type="button" class="btn btn-primary" onclick="scanToJpg();"><i
                                        class="fa fa-print"></i> Scan</button>
                            </div>
                        </div>
                    @endif--}}
                    </div>
                    <div class="card-body">
                        @livewire('tenant.administracao.adm')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
