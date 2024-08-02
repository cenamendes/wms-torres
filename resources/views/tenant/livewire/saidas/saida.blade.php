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

        .btn-dark-custom {
            background-color: #5f5f5f;
        }

        .btn-dark-custom:hover {
            background-color: #383838;
            /* Cor mais escura para hover */
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

        td {
            color: #2b2929;
        }

        .normal-font {
            font-weight: normal;
        }

        .bold-font {
            font-weight: bold;
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
                width: 100%;
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

            .svg-inline--fa {
                height: 1rem;
            }

            .svg-inline--fa.fa-eye {
                padding: 4px;
            }
        }

        @media (max-width: 520px) {
            .card-body {
                padding: 1rem 0rem 1rem 0rem;
            }

            span.paragrafo-td {
                font-size: 0.58rem;
            }

            .titulo-th {
                font-size: 0.58rem;
                width: 3.5rem;
            }

            .btn:not(:disabled):not(.disabled) {
                cursor: pointer;
                margin: 8px 0;
            }

            .btn:not(:disabled):not(.disabled) {
                cursor: pointer;
                margin-top: 0.5rem;
            }

            div.card-header {
                padding: 0.5rem !important;
            }
        }
    </style>
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Saídas</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('List') }}</a></li>
                        </ol>
                    </div>
                </div>
            </div>


            <div id="accordion-one" class="accordion accordion-primary" wire:ignore>
                <div class="accordion__item">
                    <div class="accordion__header rounded-lg collapsed" data-toggle="collapse"
                        data-target="#default_collapseOne" aria-expanded="false">
                        <span class="accordion__header--text">{{ __('Filters') }}</span>
                        <span class="accordion__header--indicator"></span>
                    </div>
                    <div id="default_collapseOne" class="accordion__body collapse" data-parent="#accordion-one">
                        <div class="accordion__body--text">
                            <div class="col-12" style="margin-bottom:0;padding-left:0px;">
                                <div class="row">
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
                                            <label>Nome do Cliente</label>
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


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="col-xs-6 col-md-9">
                                <h4 class="card-title">{{ $refsaida }}</h4>
                            </div>
                            {{-- @php
                                $result = \App\Models\Tenant\Config::first();
                            @endphp

                            @if ($result->scan_accept >= 1)
                                <div class="col-xs-6 col-md-3" id="scan_pick">
                                    <div class="col-xl-12 col-xs-6 text-right">
                                        <button type="button" class="btn btn-primary" onclick="scanToJpg();"><i
                                                class="fa fa-print"></i> Scan</button>
                                    </div>
                                </div>
                            @endif --}}
                        </div>
                        <div class="card-body">
                            <div id="dataTables_wrapper" class="dataTables_wrapper">
                                <div class="dataTables_length" id="dataTables_length">
                                    <label>{{ __('Show') }}
                                        <select name="perPage" aria-controls="select" wire:model="perPage">
                                            <option value="10" @if ($perPage == 10) selected @endif>10
                                            </option>
                                            <option value="25" @if ($perPage == 25) selected @endif>25
                                            </option>
                                            <option value="50" @if ($perPage == 50) selected @endif>50
                                            </option>
                                            <option value="100" @if ($perPage == 100) selected @endif>100
                                            </option>
                                        </select>
                                        {{ __('entries') }}</label>
                                </div>
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

                            <!-- display dataTable no-footer -->
                            <div class="table-responsive-fornecedor">
                                <table class="table-striped-saidas" style="width:100%;table-layout:fixed;">
                                    <thead>
                                        <tr style="text-align:center;">
                                            <th class="titulo-th" style="padding-bottom: 10px;">Número de Encomenda
                                            </th>
                                            <th class="titulo-th" style="padding-bottom: 10px;">Nome do Cliente</th>
                                            <th class="titulo-th" style="padding-bottom: 10px;">Numero Artigos</th>
                                            <th class="titulo-th" style="padding-bottom: 10px;">Peso</th>
                                            <th class="titulo-th" style="padding-bottom: 10px;">Data Prevista</th>
                                            <th class="titulo-th" style="padding-bottom: 10px;">{{ __('Action') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($saidas as $impr)
                                            @php
                                                $statusColor = '';

                                                switch ($impr->stock) {
                                                    case 'red':
                                                        $statusColor = 'rgba(180, 0, 0, 0.45)'; // Vermelho com transparência
                                                        break;
                                                    case 'yellow':
                                                        $statusColor = 'rgba(255, 255, 0, 0.35)'; // Amarelo com transparência
                                                        break;
                                                    case 'green':
                                                        $statusColor = 'rgba(0, 255, 0, 0.35)'; // Verde com transparência
                                                        break;
                                                    default:
                                                        $statusColor = '';
                                                }
                                                // Verifica se o ID da encomenda está presente na lista de encomendas guardadas
                                                $fontClass = in_array($impr->id, $saidasGuardadas)
                                                    ? 'normal-font'
                                                    : 'bold-font';

                                            @endphp
                                            @if (!in_array($impr->document, $encomendasNaoAssociadas->toArray()))
                                                <tr id="row_{{ $impr->id }}" class="{{ $fontClass }}"
                                                    style="border:1px #0d0d0d7a solid; text-align:center; cursor: pointer; background-color: {{ $statusColor }};"
                                                    wire:click="toggleRowFontAndSubmit('{{ $impr->id }}','{{ $impr->document }}', '{{ $impr->name }}', '{{ route('tenant.saidasDetail', $impr->id) }}')">

                                                    <td style="padding-bottom:30px;">
                                                        <br><span class="paragrafo-td">{{ $impr->document }}</span>
                                                    </td>
                                                    <td><span class="paragrafo-td">{{ $impr->name }}</span></td>
                                                    <td><span class="paragrafo-td">{{ $impr->number_of_lines }}</span>
                                                    </td>
                                                    <td><span class="paragrafo-td">{{ $impr->weight }}</span></td>
                                                    <td><span
                                                            class="paragrafo-td">{{ date('Y-m-d', strtotime($impr->date)) }}</span>
                                                    </td>
                                                    <td>
                                                        <!--<a wire{{-- :click="sendBarcode({{-- $impr->id --}})"
                                                        class="btn btn-primary shadow sharp mr-1">
                                                        <i class="fa fa-edit" style="padding:3px;"></i>
                                                    </a>-->
                                                        <button type="button"
                                                            class="btn btn-dark-custom shadow sharp mr-1"
                                                            wire:click="abrirPopUpInfo('{{ $impr->internal_notes }}')"
                                                            onclick="event.stopPropagation()">
                                                            <i class="fa fa-info"
                                                                style="padding: 1px; font-size: 20px; color: #ffffff"></i>
                                                        </button>
                                                        <a href="{{ route('tenant.saidasDetail', $impr->id) }}"
                                                            class="btn btn-primary shadow sharp mr-1"
                                                            style="border:none;">
                                                            <i class="fa fa-eye" style="padding:4px;"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $saidas->links() }}
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
        window.addEventListener('swalFire', function(e) {
            swal.fire({
                title: e.detail.title,
                html: e.detail.message,
                type: e.detail.status,
            })
        });

        document.addEventListener('livewire:load', function() {
            Livewire.on('abrirPopUpInfo', function(data) {
                Swal.fire({
                    title: data.title,
                    text: data.message,
                    icon: data.status
                });
            });
        });
    </script>
@endpush
</div>
