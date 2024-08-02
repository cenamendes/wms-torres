<div>
    <style>
        .page-titles .breadcrumb li.active a {
            color: #1d1d1d;
            font-weight: 600;
        }

        a.nav-link:hover {
            color: #1d1d1d;
        }

        .custom-file-label:after {
            background: #1d1d1d;
            height: 100%;
            color: #fff;
            border-radius: 0;
            cursor: pointer;
        }

        .btn-primary {
            color: #fff;
            background-color: #1d1d1d;
            border: 1px solid #1d1d1d;
        }

        .right:hover {
            background: #fff;
            color: #1d1d1d;
            border: 1px solid #1d1d1d;
        }

        .btn-icon-right {
            border-left: 1px solid white;
            display: inline-block;
            margin: -.8rem 0 -.8rem 1rem;
            padding: 0.4375rem 0 0.4375rem 1rem;
            margin: -1rem -0.25rem -1rem 1rem;
            padding: 0.5rem 1.25rem;
        }

        input[type="checkbox"]:checked:after {
            width: 0.8rem !important;
            height: 0.8rem !important;
            display: block !important;
            content: "\f00c" !important;
            font-family: 'FontAwesome' !important;
            color: #fff !important;
            font-weight: 100 !important;
            text-align: center !important;
            border-radius: 3px !important;
            background: #326c91 !important;
            font-size: 11px !important;
        }

        .btn {
            padding: 0.85rem 1.2rem;
            border-radius: 1.25rem;
            font-weight: 500;
            font-size: 1rem;
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
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            color: #fff !important;
            background: #0d0d0d !important;
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: 0 !important;
            background: transparent !important;
            color: #0d0d0d !important;
            cursor: pointer;
        }


        td {
            color: #2b2929;
        }

        .form-control-list {
            width: 7.2rem;
            height: 2.4rem;
            border-radius: 0.5rem;
            padding: 0.2rem;
            background: #ffffffb3;
        }

        .paragrafo-tdV2 {
            margin-top: 15px !important;
        }

        .card-body .w-5 {
            width: 23px !important;
        }

        #pagination_wrapper {
            display: flex;
            justify-content: space-between;
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

            .table-responsive-fornecedor {
                position: relative;
                width: 100%;
            }

            .card-body {
                padding: 1rem 0.3rem;
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
                font-size: 0.6rem;
            }

            .titulo-th {
                font-size: 0.6rem;
                width: 4rem;
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

            .form-control.status-dropdown {
                margin: 0.6rem 0.1rem;
                padding: 0rem 0.2rem;
                height: 2rem;
                width: 7rem;
            }

            select.form-control-list {
                word-wrap: normal;
                width: 4.3rem;
                height: 1.5rem;
                font-size: 0.75rem;
            }

            .dataTables_wrapper .dataTables_paginate {
                text-align: center;
            }

            .dataTables_wrapper .dataTables_info {
                text-align: center;
            }

            #pagination_wrapper {
                justify-content: center;
                flex-direction: column;
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

            .titulo-thv2 {
                font-size: 0.58rem;
                width: 7.5rem;
            }

            .form-control.status-dropdown {
                padding: 0rem 0.2rem;
                height: 2rem;
                width: 3rem;
            }

            select.form-control-list {
                word-wrap: normal;
                width: 2.5rem;
                height: 1.5rem;
                font-size: 0.75rem;
            }

            .nav-tabs .nav-link {
                border: 1px solid transparent;
                border-top-left-radius: 0.75rem;
                border-top-right-radius: 0.75rem;
                font-size: 0.8rem;
            }

            .nav-tabs .nav-link.active,
            .nav-tabs .nav-item.show .nav-link {
                color: #495057;
                background-color: #F4F6FA;
                border-color: #dee2e6 #dee2e6 #F4F6FA;
                font-size: 0.8rem;
            }

            .paragrafo-tdV2 {
                margin-top: 18px !important;
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
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ $homePanel }}" data-toggle="tab" href="#homePanel">
                    <i class="fas fa-people-carry" aria-hidden="true"></i> {{ __('Associar Encomendas') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $pickPanel }}" data-toggle="tab" href="#pickPanel">
                    <i class="fa fa-user" aria-hidden="true"></i> {{ __('Associar Armazéns') }}
                </a>
            </li>
            {{-- <li class="nav-item">
            <a class="nav-link {{ $reportPanel }}" data-toggle="tab" href="#reportPanel">
                <i class="fa fa-circle-info" aria-hidden="true"></i> {{ __('Reportar') }}
            </a>
        </li> --}}
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade {{ $homePanel }}" id="homePanel" role="tabpanel">
                <div class="col-md-3 col-6">
                    <div class="row form-group">
                        <section class="col">
                            <label for="options_select">{{ __('Selecionar Lista de Saidas') }}</label>
                            <select name="options_select" id="options_select" class="form-control" wire:model="options">
                                <option value="">{{ __('- Select Options -') }}
                                </option>
                                @foreach ($optionsSaidas->types as $type)
                                    <option value="{{ $type->Id }}">{{ $type->Name }}
                                    </option>
                                @endforeach
                            </select>
                        </section>
                    </div>
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
                                    <option value="100" @if ($perPage == 100) selected @endif>
                                        100
                                    </option>
                                </select>
                                {{ __('entries') }}</label>
                        </div>
                    </div>


                    @if (isset($options))
                        <div class="table-responsive-fornecedor">
                            <table class="table-striped-saidas" style="width:100%;table-layout:fixed;">
                                <thead>
                                    <tr style="text-align:center;">
                                        <th class="titulo-th" style="padding-bottom: 10px;">Número de Encomenda</th>
                                        <th class="titulo-th" style="padding-bottom: 10px;">Nome do Cliente</th>
                                        <th class="titulo-th" style="padding-bottom: 10px;">Numero Artigos</th>
                                        <th class="titulo-th" style="padding-bottom: 10px;">Peso</th>
                                        <th class="titulo-th" style="padding-bottom: 10px;">Data Prevista</th>
                                        <th class="titulo-th" style="padding-bottom: 10px;">Associar Encomenda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($saidas as $j => $impr)
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
                                        @endphp
                                        <tr
                                            style="border:1px #0d0d0d7a solid; text-align:center; cursor:default; background-color: {{ $statusColor }};">
                                            <td style="padding-bottom:30px;">
                                                <br><span class="paragrafo-td">{{ $impr->document }}</span>
                                            </td>
                                            <td><span class="paragrafo-td">{{ $impr->name }}</span>
                                            </td>
                                            <td><span class="paragrafo-td">{{ $impr->number_of_lines }}</span>
                                            </td>
                                            <td><span class="paragrafo-td">{{ $impr->weight }}</span>
                                            </td>
                                            <td><span
                                                    class="paragrafo-td">{{ date('Y-m-d', strtotime($impr->date)) }}</span>
                                            </td>
                                            <td>
                                                <span style="padding-right: 5px;padding-left: 5px;">
                                                    <section class="col">
                                                        @php
                                                            $imprDocument = trim($impr->document);
                                                            $associacao = \App\Models\Tenant\AssociarEncomenda::where(
                                                                'numero_encomenda',
                                                                $imprDocument,
                                                            )->first();
                                                            $selectedUserId = $associacao ? $associacao->user_id : null;
                                                        @endphp
                                                        <div wire:loading.remove wire:target="mount()">
                                                            <select name="user_select"
                                                                id="user_select_{{ $impr->id }}"
                                                                class="form-control-list"
                                                                wire:change="userSelected('{{ $imprDocument }}', $event.target.value, 2)">
                                                                <option value="0">A Todos</option>
                                                                @foreach ($users as $i => $username)
                                                                    <option value="{{ $username->id }}"
                                                                        @if ($selectedUserId == $username->id) selected @endif>
                                                                        {{ $username->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </section>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $saidas->links() }}
                    @endif
                    {{-- <div class="card-footer justify-content-between">
                        <div class="row">
                            <div class="col text-right">
                                <a wire:click="saveTask" class="btn btn-primary right">
                                    {{ $actionButton }}
                                    <span class="btn-icon-right"><i class="las la-check mr-2"></i></span>
                                </a>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="tab-pane fade {{ $pickPanel }}" id="pickPanel" role="tabpanel">
                <div class="card-body">

                    <div class="table-responsive-fornecedor">
                        <!-- INICIO TABELA -->
                        <table class="table-striped-saidas" style="width:100%;table-layout:fixed;">
                            <thead>
                                <tr style="cursor:default;">
                                    <th class="titulo-thv2" style="padding: 15px;">Técnico</th>
                                    <th class="titulo-th" style="padding: 15px;display: flex;justify-content: center;">
                                        Associar Armazem
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usersSelect as $user)
                                    <tr style="border:1px #0d0d0d7a solid; cursor:default;">
                                        <td style="padding:auto;padding-left: 15px;padding-right: 15px;">
                                            <span class="paragrafo-td">{{ $user['username'] }}</span>
                                        </td>
                                        <td style="padding: 15px;">
                                            <div class="row">
                                                @foreach ($stoqueSelect->warehouse as $warehouse)
                                                    <span class="paragrafo-td col-6 paragrafo-tdV2"
                                                        style="margin-top: 5px;">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ $warehouse->id }}"
                                                            id="Check{{ $warehouse->id }}"
                                                            data-user-id="{{ $user['id'] }}"
                                                            wire:click="atualizarEstoqueUsuario({{ $user['id'] }},$event.target.value, $event.target.checked)"
                                                            @if (in_array($warehouse->id, array_column(json_decode($user['authstock'], true), 'id'))) checked @endif>
                                                        {{ $warehouse->name }}
                                                    </span>
                                                @endforeach

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- FIM TABELA -->
                </div>
            </div>
        </div>

        @push('custom-scripts')
            <script>
                document.addEventListener('livewire:load', function() {
                    restartObjects();
                    jQuery("#alert_email").val("");
                });

                function restartObjects() {
                    jQuery(document).ready(function() {
                        var HelloButton = function(context) {
                            var ui = $.summernote.ui;

                            // create button
                            var button = ui.button({
                                contents: '<i class="fa fa-compress"/> Small',
                                tooltip: 'hello',
                                click: function() {
                                    context.invoke('editor.pasteHTML', '<small>...</small>');
                                }
                            });

                            return button.render(); // return button as jquery object
                        }

                        jQuery(".summernote").summernote({
                            height: 190,
                            minHeight: null,
                            maxHeight: null,
                            focus: !1,
                            codeviewFilter: false,
                            codeviewIframeFilter: true,
                            toolbar: [
                                ['style', ['style']],
                                ['font', ['bold', 'underline', 'clear']],
                                ['mybutton', ['hello']],
                                ['fontname', ['fontname']],
                                ['color', ['color']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['table', ['table']],
                            ],
                            buttons: {
                                hello: HelloButton
                            },
                            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica',
                                'Impact', 'Tahoma', 'Times New Roman', 'Verdana'
                            ],
                            addDefaultFonts: false,
                            callbacks: {
                                onChange: function(contents) {
                                    @this.set('signature', contents, true);
                                    console.log(contents)
                                }
                            },
                        }), $(".inline-editor").summernote({
                            airMode: !0
                        });


                    });
                }



                $(document).ready(function() {
                    $('.user-select').change(function() {
                        var imprId = $(this).data('impr-id');
                        var userId = $(this).val();

                        // Envie uma solicitação AJAX para salvar a seleção
                        $.ajax({
                            url: '/save-selection',
                            method: 'POST',
                            data: {
                                impr_id: imprId,
                                user_id: userId
                            },
                            success: function(response) {
                                // Atualize a tabela saidas se necessário
                                // Por exemplo, você pode recarregar a página ou atualizar a linha correspondente na tabela
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    });
                });
            </script>
        @endpush
