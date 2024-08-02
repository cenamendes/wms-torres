<div>
    <style>
        .accordion-primary .accordion__header.collapsed {
            background: #e2e2e2;
            border-color: #5a5a5a;
            color: #211c37;
            box-shadow: none;
        }

        .accordion-primary .accordion__header {
            background: #343637;
            border-color: #636769;
            color: #fff;
            box-shadow: 0 15px 20px 0 rgba(87, 71, 69, 0.15);
        }

        .page-titles .breadcrumb li.active a {
            color: #2b2929;
            font-weight: 600;
        }

        .form-control {
            border: 1px solid #dddddd;
            color: #585858
        }

        .form-control:hover {
            color: #585858
        }

        .form-control:focus {
            border-color: #6c757d;
            /* Cor mais escura quando em foco */
            box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
            /* Adiciona um efeito de sombra */
            color: #585858
        }

        .btn {
            padding: 0.6rem 0.8rem;
            font-size: 1.2rem;
        }

        .btn-danger-custom {
            background: rgb(255, 190, 10);
            border: none;
            color: #ffffff;
        }

        .btn-danger-custom:hover {
            background: rgb(255, 153, 0);
            color: #ffffff;
        }

        .alert-success {
            background: #13b040;
            border: 1px solid #13b040;
            color: white;
            margin: 0;
            padding: 15px 12px;
        }

        .alert-cancel {
            background: #b01313;
            border: 1px solid #b01313;
            color: white;
            margin: 0;
            padding: 15px 12px;
        }

        .custom-label {
            font-weight: 400;
            color: #383838;
            margin-bottom: 0;
        }

        .swal2-popup .swal2-input[type=number] {
            max-width: 6rem;
            margin-top: 10px;
        }

        p {
            line-height: 1.6;
            color: #383838;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .swal2-popup .swal2-textarea {
            height: 6.5rem;
            padding: .5rem;
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

        .circle-orange {
            background: #ed8d10;
            border-radius: 50%;
            /* Usar 50% para fazer um círculo perfeito */
            width: 15px;
            /* Definir a largura */
            height: 15px;
            /* Definir a altura */
            display: inline-block;
            /* Garantir que o elemento seja exibido como um bloco */
        }

        div.itens-2 {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-check-input {
            position: absolute;
            margin-top: 3px;
            margin-right: 60px;
        }

        input[type="checkbox"]:after {
            content: '' ;
            display: block ;
            width: 1rem ;
            height: 1rem ;
            margin-top: -2px ;
            margin-left: -1px ;
            border: 1px solid transparent ;
            border-radius: 3px ;
            background: #d4d7da ;
            line-height: 1.3 ;
        }

        @media (max-width: 785px) {
            .form-group {
                margin-bottom: 0rem !important;
            }

            .table-responsive-reference {
                position: relative;
                width: 100%;
            }

            .name-table {
                font-size: 0.7rem;
            }

            button #terminarStock,
            #imprimirSelecionados {
                padding: 0.8rem 0.4rem;
            }

            .swal2-popup .swal2-styled.swal2-confirm {
                padding: 0.6rem 0.8rem;
            }

            .swal2-styled.swal2-cancel {
                padding: 0.6rem 0.8rem;
            }

            .accordion__body--text {
                padding: 0.5rem 0.5rem;
            }

            .card-body {
                padding: 0.5rem;
            }

            div.col-12 {
                padding: 0;
            }

            span.paragrafo-td {
                font-size: 0.7rem;
            }

            .titulo-th {
                font-size: 0.7rem;
                width: 4rem;
            }

            .btn {
                padding: 0.4rem 0.6rem;
                font-size: 0.8rem;
            }

            input[type="checkbox"]:after {
                content: '' ;
                display: block ;
                width: 0.8rem ;
                height: 0.8rem ;
                margin-top: -2px ;
                margin-left: -1px ;
                margin-top: -1px ;
                margin-left: -1px ;
                border: 1px solid transparent ;
                border-radius: 3px ;
                background: #d4d7da ;
                line-height: 1.3 ;
            }

            input[type="checkbox"]:checked:after {
                width: 1rem ;
                height: 1rem ;
                display: block ;
                content: "\f00c" ;
                font-family: 'FontAwesome' ;
                color: #fff ;
                font-weight: 100 ;
                text-align: center ;
                border-radius: 3px ;
                background: #326c91 ;
                font-size: 11px ;
            }

            .form-check-input {
                margin-right: 20px;
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
        }

        @media (max-width: 520px) {

            span.paragrafo-td {
                font-size: 0.6rem;
            }

            .titulo-th {
                font-size: 0.6rem;
                width: 3rem;
            }

            div.card-header {
                padding: 0.5rem !important;
            }
            .alert-success {
                background: #13b040;
                border: 1px solid #13b040;
                color: white;
                margin: 0;
                padding: 8px 8px;
                font-size: 0.8rem;
            }

            .alert-cancel {
                background: #b01313;
                border: 1px solid #b01313;
                color: white;
                margin: 0;
                padding: 8px 8px;
                font-size: 0.8rem;
            }
        }
    </style>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ 'assets/resources/images/logo_png_boxpt.png' }}">


    <div id="accordion-one" class="accordion accordion-primary" wire:ignore>
        <div class="accordion__item">
            <div class="accordion__header rounded-lg show" data-toggle="collapse" data-target="#default_collapseOne"
                aria-expanded="true">
                <span class="accordion__header--text">Adicionar ao Stock</span>
                <span class="accordion__header--indicator"></span>
            </div>
            <div id="default_collapseOne" class="accordion__body collapse show" data-parent="#accordion-one">
                <div class="accordion__body--text">
                    <div class="col-12" style="margin-bottom:0;padding-left:0px;">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Codigo de Barras') }}</label>
                                    <input type="text" id="cod_barras" class="form-control" wire:model="codbarras"
                                        autofocus>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Descrição') }}</label>
                                    <input type="text" id="descricao" class="form-control"
                                        wire:model.defer="descricao" readonly> <!-- READONLY -->
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Quantidade') }}</label>
                                    <input type="number" id="qtd" class="form-control" wire:model.defer="qtd"
                                        value="1">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Quantidade no Stock') }}</label>
                                    <input type="number" id="qtdestoque" class="form-control" wire:model="qtdstock"
                                        readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12"
                                style="display:flex; gap:0.8rem; justify-content:end; padding:30px 10px; flex-wrap: wrap;
                                flex-direction: row; ">

                                <div style="position: fixed; bottom: 25px; right: 15px; z-index: 9999;">
                                    <div class="alert alert-success" style="display: none" role="alert">
                                        <span id='clicksuccess'></span>
                                    </div>
                                </div>

                                <div style="position: fixed; bottom: 25px; right: 15px; z-index: 8888;">
                                    <div class="alert alert-cancel" style="display: none" role="alert">
                                        <span id='clickcancel'></span>
                                    </div>
                                </div>


                                {{-- <div style="position: fixed; bottom: 15px; right: 15px; z-index: 9999;">
                                    <div class="alert alert-success" role="alert" wire:loading.attr="hidden"
                                        wire:target="guardaStock" wire:offline.attr="hidden"
                                        @if (!(session()->has('message') && session()->get('status') === 'success')) style="display: none;" @endif>
                                        @if (session()->has('message') && session()->get('status') === 'success')
                                            {{ session()->get('message') }}
                                        @endif
                                    </div>
                                </div> --}}

                                <div class="row" style="justify-content:end; margin:0;">
                                    <button type="button" id="guardaStock" wire:click="guardaStock"
                                        class="btn-sm btn btn-primary" style=" border:none;"><i class="fa fa-plus"></i>
                                        Adicionar</button>
                                </div>
                                <div class="row" style="justify-content:end; margin:0">
                                    <button type="button" id="terminarStock" wire:click="terminarStock"
                                        class="btn-sm btn btn-success"><i class="fa fa-floppy-disk"></i> Gravar</button>
                                </div>
                                <div class="row" style="justify-content:end; margin:0;">
                                    <button type="button" id="cancelarStock" wire:click="cancelarStock"
                                        class="btn-sm btn btn-danger"><i class="fa fa-ban"></i> Cancelar</button>

                                </div>
                                <div class="row" style="justify-content:end; margin:0;">
                                    <button type="button" id="reportarStock" wire:click="reportarStock"
                                        class="btn-sm btn btn-danger-custom"><i class="fa-solid fa-circle-info"></i>
                                        Reportar</button>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Fim do Filtro -->

    <div class="table-responsive" wire:key="tenantcustomersshow">

        <div id="ajaxLoading" wire:loading.flex class="w-100 h-100 flex "
            style="background:rgba(255, 255, 255, 0.8);z-index:999;position:fixed;top:0;left:0;align-items: center;justify-content: center;">
            <div class="sk-three-bounce" style="background:none;">
                <div class="sk-child sk-bounce1"></div>
                <div class="sk-child sk-bounce2"></div>
                <div class="sk-child sk-bounce3"></div>
            </div>
        </div>

        <div id="dataTables_wrapper" class="dataTables_wrapper">
            <div class="dataTables_length" id="dataTables_length">
                <label>{{ __('Show') }}
                    <select name="perPage" aria-controls="select" wire:model="perPage">
                        <option value="10" @if ($perPage == 10) selected @endif>10</option>
                        <option value="25" @if ($perPage == 25) selected @endif>25</option>
                        <option value="50" @if ($perPage == 50) selected @endif>50</option>
                        <option value="100" @if ($perPage == 100) selected @endif>100</option>
                    </select>
                    {{ __('entries') }}</label>
            </div>


        </div>


        <!-- display dataTable no-footer -->
        <div class="table-responsive-reference">
            <table class="table-striped-reference" style="width:100%;table-layout:fixed;">
                <thead>
                    <tr style="text-align:center;">
                        <th class="titulo-th" style="padding-bottom: 10px;">Referencia</th>
                        <th class="titulo-th" style="padding-bottom: 10px;">Descrição</th>
                        <th class="titulo-th" style="padding-bottom: 10px;">Cód de Barras</th>
                        <th class="titulo-th" style="padding-bottom: 10px;">QTD Separada</th>
                        <th class="titulo-th" style="padding-bottom: 10px;">QTD Encomenda</th>
                        <th class="titulo-th" style="padding-bottom: 10px;">Check / Impressão</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = -1;
                    @endphp

                    @foreach ($devolucoesclientesdetail as $i => $impr)
                        <tr class="table-tr"
                            style="text-align:center; background-color: {{ $i % 2 == 0 ? '#FFFFFF' : '#F0F0F0' }};">
                            <td style="padding-bottom:25px; padding-right: 5px;"><br><span class="paragrafo-td"
                                    style="padding-right: 5px;padding-left: 5px;"
                                    class="{{ in_array($impr->referense, $referencias_reportadas) ? 'circle-orange' : '' }}">
                                </span><span class="paragrafo-td"
                                    style="padding-right: 5px;padding-left: 5px;">{{ $impr->referense }}</span></td>
                            <td style="padding-bottom:25px; padding-right: 5px;"><br><span class="paragrafo-td"
                                    style="padding-right: 5px;padding-left: 5px;">{{ $impr->design }}</span></td>
                            <td style="padding-bottom:25px; padding-right: 5px;"><br><span class="paragrafo-td"
                                    style="padding-right: 5px;padding-left: 5px;">{{ $impr->barcode }}</span></td>
                            <td style="padding-bottom:25px; padding-right: 5px;"><br><span class="paragrafo-td"
                                    style="padding-right: 5px;padding-left: 5px;">@php
                                        $qtdmovstock = \App\Models\Tenant\MovimentosDevolucoesClientes::where(
                                            'numero_encomenda',
                                            $encomenda,
                                        )
                                            ->where('referencia', $impr->referense)
                                            ->get();
                                        $soma = 0;
                                        foreach ($qtdmovstock as $qtdstock) {
                                            $soma += $qtdstock->qtd_separada;
                                        }
                                    @endphp
                                    {{ $soma }}
                                </span></td>
                            <td style="padding-bottom:25px; padding-right: 5px;"><br><span class="paragrafo-td"
                                    style="padding-right: 5px;padding-left: 5px;">{{ $impr->quantity }} </span></td>
                            <td style=" align-items:center; justify-content: space-around;">
                                <div class="itens-2">
                                    <input type="checkbox" class="form-check-input imprimir-checkbox"
                                        wire:model="selectoptions.{{ $impr->referense }}"
                                        wire:click="selecionarCheck('{{ $impr->document }}', '{{ $impr->referense }}', {{ $impr->design }})"
                                        style="transform: scale(1.7);">
                                    <a style="margin-left: 20px"
                                        wire:click="detalhesimpressao({{ json_encode($impr->document) }}, {{ json_encode($impr->referense) }}, {{ json_encode($impr->quantity) }}, {{ json_encode($impr->design) }}, {{ json_encode($impr->barcode) }})"
                                        class="btn btn-primary">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-12" style="display:flex; gap:0.8rem; justify-content:end; padding:30px;">
            <div class="row" style="justify-content:end; margin:0">
                <button type="button" id="imprimirSelecionados" class="btn-sm btn btn-primary"
                    wire:click="impressaoMassa">
                    <i class="fa fa-print"></i> Imprimir Selecionados
                </button>
            </div>
            <div class="row" style="justify-content:end; margin:0">
                <button type="button" id="" wire:click="enviar('{{ $encomenda }}')"
                    class="btn-sm btn btn-success"><i class="fa fa-regular fa-paper-plane"></i> Terminar</button>
            </div>
        </div>
        {{-- </div> --}}
        {{ $devolucoesclientesdetail->links() }}
    </div>
</div>

<script>
       // document.addEventListener('livewire:load', function() {
    //     setTimeout(function() {
    //         var successMessage = document.querySelector('.alert-success');
    //         if (successMessage) {
    //             successMessage.style.display = 'none';
    //         }
    //     }, 3300);
    // });
    document.addEventListener('menssageerror', function(e) {
        swal.fire({
            title: "Erro",
            text: e.detail.message,
            type: 'error',
            background: '#FFFFFF',
        });
    });



    window.addEventListener('menssagesucess', function(e) {
        jQuery(".alert-success").css("display", "block");
        jQuery("#clicksuccess").text(e.detail.message);

        setTimeout(function() {
            jQuery(".alert-success").css("display", "none");
            jQuery("clicksuccess").text("");
        }, 2800);

    });

    window.addEventListener('menssagecencel', function(e) {
        jQuery(".alert-cancel").css("display", "block");
        jQuery("#clickcancel").text(e.detail.message);

        setTimeout(function() {
            jQuery(".alert-cancel").css("display", "none");
            jQuery("clickcancel").text("");
        }, 3300);

    });

    // window.addEventListener('joaovision', function(e) {
    //     if (e.detail.status == "error") {
    //         jQuery(".alert-danger").css("display", "block");
    //         jQuery("#clickerror").text(e.detail.message);
    //     } else {
    //         jQuery(".alert-success").css("display", "block");
    //         jQuery("#clicksuccess").text(e.detail.message);
    //     }
    //     setTimeout(function() {
    //         if (e.detail.status == "error") {
    //         jQuery(".alert-danger").css("display", "none");
    //         jQuery("#clickerror").text(e.detail.message);
    //     } else {
    //         jQuery(".alert-success").css("display", "block");
    //         jQuery("#clicksuccess").text(e.detail.message);
    //     }
    //     }, 3300);
    // });

    window.addEventListener('reportarDadosStock', function(e) {
        swal.fire({
            title: 'Reportar',
            html: e.detail.message,
            type: 'info',
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Enviar',
            confirmButtonColor: '#FFA500',
            cancelButtonText: 'Cancelar',
            onOpen: function() {}
        }).then((result) => {
            if (result.value) {
                // Obter valores dos campos
                const quantidadeCorreta = document.getElementById('quantidadeCorreta').value;
                const observacoes = document.getElementById('observacoes').value;

                // Verificar se a quantidade correta é um número inteiro
                if (!Number.isInteger(parseInt(quantidadeCorreta))) {
                    swal.fire({
                        title: 'Erro',
                        text: 'A quantidade correta deve ser um número inteiro.',
                        type: 'error'
                    });
                } else {
                    // Emitir o evento Livewire apenas se a quantidade correta for um número inteiro
                    Livewire.emit('reportarStockConfirm', quantidadeCorreta, observacoes, e.detail
                        .email);
                }
            }
        });
    });
</script>
