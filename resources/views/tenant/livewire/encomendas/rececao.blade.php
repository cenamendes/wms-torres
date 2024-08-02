<div>
    <style>
        .accordion-primary .accordion__header.collapsed {
            background: #e2e2e2;
            border-color: #5a5a5a;
            color: #211c37;
            box-shadow: none;
        }

        .accordion-primary .accordion__header {
            background: #2b2e30;
            border-color: #585b5d;
            color: #fff;
            box-shadow: 0 15px 20px 0 rgba(111, 94, 91, 0.15);
        }

        .page-titles .breadcrumb li.active a {
            color: #2b2929;
            font-weight: 600;
        }

        .form-control:focus {
            border-color: #8c9399;
            /* Cor mais escura quando em foco */
            box-shadow: 0 0 0 0.2rem rgba(129, 137, 145, 0.25);
            /* Adiciona um efeito de sombra */
        }

        .sk-child.sk-bounce1,
        .sk-child.sk-bounce2,
        .sk-child.sk-bounce3 {
            background: #0d0d0d;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
        .dataTables_wrapper .dataTables_paginate .paginate_button.next {
            background: #0d0d0d !important;
            color: #fff !important;
            border: 0px solid #0d0d0d !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            color: #fff !important;
            background: #0d0d0d !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: 0 !important;
            background: transparent !important;
            color: #0d0d0d !important;
        }

        .titulo-th {
            font-size: 0.9rem;
        }

        .sharp {
            min-width: 40px;
            padding: 7px;
            height: 40px;
            min-height: 40px;
        }

        .svg-inline--fa.fa-eye {
            padding: 5px;
        }
        .alert-success {
            background: #13b040;
            border: 1px solid #13b040;
            color: white;
            margin: 0;
            padding: 15px 12px;
        }


        @media (max-width: 1400px) {
            input .form-control {
                border: none;
                border-radius: 10px;
                width: 90%;
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
                font-weight: 400;
                line-height: 1.5;
                border-radius: 1.25rem;
                background: #fff;
                border: 1px solid #f0f1f5;
                color: #B1B1B1;
                height: 56px;
            }
        }

        @media (max-width: 785px) {
            .form-group {
                margin-bottom: 0rem !important;
            }

            .table-responsive-fornecedor {
                position: relative;
                width: 100%;
            }

            .card-body {
                padding: 1rem 0.5rem;
            }

            .name-table {
                font-size: 0.5rem;
            }

            .btn:not(:disabled):not(.disabled) {
                cursor: pointer;
                margin: 15px 0;
            }

            div.col-12 {
                padding: 0;
            }

            span.paragrafo-td {
                font-size: 0.65rem;
            }

            .titulo-th {
                font-size: 0.65rem;
                width: 4.8rem;
                padding-left: 0.2rem;
            }

            svg.svg-inline--fa.fa-eye {
                height: 0.8rem;
            }

            .sharp {
                min-width: 28px;
                padding: 3px;
                height: 28px;
                min-height: 28px;
                width: 28px;
            }

            .card-title {
                display: none;
            }

            .card-header {
                display: none;
            }

            .accordion__body--text {
                padding-bottom: 0rem;
            }

            .accordion__header--text {
                font-size: 1rem;
            }

            .accordion-primary .accordion__header.collapsed {
                height: 2.8rem;
                padding: 0 0.8rem;
                display: flex;
                justify-content: center;
                flex-direction: column;
            }

            .accordion-primary .accordion__header {
                height: 2.8rem;
                padding: 0 0.8rem;
                display: flex;
                justify-content: center;
                flex-direction: column;
            }

            .accordion__item {
                margin-bottom: 0.5rem !important;
                padding: 0rem 1.2rem;
            }

            select.form-control {
                width: 90%;
                font-size: 0.75rem;
            }

            input.form-control {
                width: 90%;
                font-size: 0.75rem;
            }

            label {
                display: inline-block;
                margin: 0 0.3rem;
                font-size: 12px;
                margin-top: 0.8rem;
                margin-bottom: 0.2rem;
            }

            .btn:not(:disabled):not(.disabled) {
                cursor: pointer;
                margin-top: 1.2rem;
            }

            .svg-inline--fa.fa-eye {
                padding: 4px;
            }
        }

        @media (max-width: 520px) {
            .card-body {
                padding: 1rem 0.3rem 1rem 0rem;
            }

            span.paragrafo-td {
                font-size: 0.6rem;
            }

            .titulo-th {
                font-size: 0.6rem;
            }

            div.card-header {
                padding: 0.5rem !important;
            }
        }
    </style>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ 'assets/resources/images/logo_png_boxpt.png' }}">
    <div>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <div class="table-responsive" wire:key="tenantcustomersshow">
            <div id="ajaxLoading" wire:loading.flex class="w-100 h-100 flex "
                style="background:rgba(255, 255, 255, 0.8);z-index:999;position:fixed;top:0;left:0;align-items: center;justify-content: center;">
                <div class="sk-three-bounce" style="background:none;">
                    <div class="sk-child sk-bounce1"></div>
                    <div class="sk-child sk-bounce2"></div>
                    <div class="sk-child sk-bounce3"></div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-9 col-xs-6">
                        <div class="page-titles">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Compras a Fornecedor</a></li>
                                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('List') }}</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- Inicio do Filtro  -->

                <div id="accordion-one" class="accordion accordion-primary" wire:ignore>
                    <div class="accordion__item">
                        <div class="accordion__header rounded-lg collapsed" data-toggle="collapse"
                            data-target="#default_collapseOne" aria-expanded="false">
                            <span class="accordion__header--text">{{ __('Filters') }}</span>
                            <span class="accordion__header--indicator"></span>
                        </div>

                        <div wire:ignore.self style="position: fixed; bottom: 15px; right: 15px; z-index: 9999;">
                            <div class="alert alert-success" role="alert" wire:loading.attr="hidden"
                                wire:target="guardaStock" wire:offline.attr="hidden"
                                @if (!(session()->has('message') && session()->get('status') === 'success')) style="display: none;" @endif>
                                @if (session()->has('message') && session()->get('status') === 'success')
                                    {{ session()->get('message') }}
                                @endif
                            </div>
                        </div>

                        <div id="default_collapseOne" class="accordion__body collapse" data-parent="#accordion-one">
                            <div class="accordion__body--text">
                                <div class="col-12" style="margin-bottom:0;padding-left:0px;">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label>Origem/Zona</label>
                                                <select id="OrigemZona" class="form-control" wire:model="OrigemZona"
                                                    placeholder="escolha">
                                                    <option value="">Escolha uma Zona</option>
                                                    @foreach ($zonas as $zona)
                                                        <option value="{{ $zona }}">{{ $zona }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label>Data Prevista</label>
                                                <select id="ordenation" class="form-control" name="ordenation"
                                                    wire:model="ordenation">
                                                    <option value="desc">Mais Recente para o mais antigo</option>
                                                    <option value="asc">Mais Antigo para o mais recente</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div id="dataTables_search_filter" class="dataTables_filter">
                                                <label>Número encomenda</label>
                                                <input class="form-control" type="search" name="searchString"
                                                    wire:model="searchString"></input>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div id="dataTables_search_filter" class="dataTables_filter">
                                                <label>Nome do Fornecedor</label>
                                                <input class="form-control" type="search" name="designacao"
                                                    wire:model="designacao"></input>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type="button" id="clearFilter" wire:click="clearFilter"
                                                class="btn-sm btn btn-danger"
                                                style="border: none">{{ __('Clear Filter') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Fim do Filtro -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-xs-6 col-md-9">
                                    <h4 class="card-title">{{ __('Compras Fornecedores') }}</h4>
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
                                <div id="dataTables_wrapper" class="dataTables_wrapper">
                                    <div class="dataTables_length" id="dataTables_length">
                                        <label>{{ __('Show') }}
                                            <select name="perPage" aria-controls="select" wire:model="perPage">
                                                <option value="10"
                                                    @if ($perPage == 10) selected @endif>10
                                                </option>
                                                <option value="25"
                                                    @if ($perPage == 25) selected @endif>25
                                                </option>
                                                <option value="50"
                                                    @if ($perPage == 50) selected @endif>50
                                                </option>
                                                <option value="100"
                                                    @if ($perPage == 100) selected @endif>100
                                                </option>
                                            </select>
                                            {{ __('entries') }}</label>
                                    </div>
                                </div>

                                <!-- display dataTable no-footer -->
                                <div class="table-responsive-fornecedor">
                                    <table class="table-striped-fornecedor" style="width:100%;table-layout:fixed;">
                                        <thead>
                                            <tr style="text-align:center;">
                                                <th class="titulo-th" style=" padding-bottom: 10px;">Número de
                                                    Encomenda</th>
                                                <th class="titulo-th" style=" padding-bottom: 10px;">Nome do
                                                    Fornecedor</th>
                                                <th class="titulo-th" style=" padding-bottom: 10px;">Origem/Zona</th>
                                                <th class="titulo-th" style=" padding-bottom: 10px;">Data Prevista
                                                </th>
                                                <th class="titulo-th" style=" padding-bottom: 10px;">
                                                    {{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $index = 0 @endphp
                                            @foreach ($encomendas as $impr)
                                                <tr style="border:1px #0d0d0d7a solid; text-align:center; cursor: pointer; background-color: {{ $index % 2 == 0 ? '#FFFFFF' : '#F0F0F0' }}"
                                                    onclick="window.location='{{ route('tenant.encomendas.encomendadetail', $impr->id) }}';">
                                                    <td style="padding-bottom:30px;">
                                                        <br><span class="paragrafo-td">{{ $impr->document }}</span>
                                                    </td>
                                                    <td><span class="paragrafo-td">{{ $impr->name }}</span>
                                                    </td>
                                                    <td><span class="paragrafo-td">{{ $impr->zone }}</span>
                                                    </td>
                                                    <td><span
                                                            class="paragrafo-td">{{ date('Y-m-d', strtotime($impr->date)) }}</span>
                                                    </td>
                                                    <td>
                                                        <!--<a wire:click="sendBarcode({{ $impr->document }})" class="btn btn-primary shadow sharp mr-1" onclick="event.stopPropagation()">
                                                            <i class="fa fa-edit" style="padding:3px;"></i>
                                                        </a>-->
                                                        <a href="{{ route('tenant.encomendas.encomendadetail', $impr->id) }}"
                                                            class="btn btn-primary shadow sharp" style="border:none;">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @php $index++ @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $encomendas->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @push('custom-scripts')
        <script>
            document.addEventListener('livewire:load', function() {
                setTimeout(function() {
                    var successMessage = document.querySelector('.alert-success');
                    if (successMessage) {
                        successMessage.style.display = 'none';
                    }
                }, 3300); // Hide after 3 seconds
            });
        </script>
    @endpush
</div>
