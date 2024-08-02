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

        .form-control.status-dropdown {
            margin: 0.6rem 0.3rem;
            padding: 0rem 0.2rem;
            height: 3rem;
            width: 12rem;
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
            }

            .form-control.status-dropdown {
                padding: 0rem 0.2rem;
                height: 2rem;
                width: 3rem;
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
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Gestão Stock</a></li>
                                <li class="breadcrumb-item active"><a href="javascript:void(0)">Reportados</a>
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
                        <div id="default_collapseOne" class="accordion__body collapse" data-parent="#accordion-one">
                            <div class="accordion__body--text">
                                <div class="col-12" style="margin-bottom:0;padding-left:0px;">
                                    <div class="row">
                                        {{-- <div class="col-12 col-sm-4 col-md-4">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <select id="OrigemEstado" class="form-control" wire:model="OrigemEstado"
                                                    placeholder="escolha">
                                                    <option value="">Escolha um estado</option>
                                                    @foreach ($estados as $status)
                                                       <option value="{{ $status }}">{{ $status }}</option>
                                                     @endforeach
                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-12 col-sm-4 col-md-4">
                                           <div id="dataTables_search_filter" class="dataTables_filter">
                                                <label>Número encomenda</label>
                                                <input class="form-control" type="search" name="searchNumeroEncomenda"
                                                    wire:model="searchNumeroEncomenda"></input>
                                            </div>
                                        </div> --}}
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div id="dataTables_search_filter" class="dataTables_filter">
                                                <label>Referência</label>
                                                <input class="form-control" type="search" name="searchReferencia"
                                                    wire:model="searchReferencia"></input>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div id="dataTables_search_filter" class="dataTables_filter">
                                                <label>Observação</label>
                                                <input class="form-control" type="search" name="designacao"
                                                    wire:model="designacao"></input>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label>Data de Reporte</label>
                                                <select id="ordenation" class="form-control" name="ordenation"
                                                    wire:model="ordenation">
                                                    <option value="desc">Mais Recente para o mais antigo</option>
                                                    <option value="asc">Mais Antigo para o mais recente</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label>Data</label>
                                                <input type="date" class="form-control" name="selectedDate"
                                                    wire:model.lazy="selectedDate">
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
                                    <h4 class="card-title">{{ __('Listagem Reportados') }}</h4>
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
                                                <th class="titulo-th" style="padding-bottom: 10px;">Referência</th>
                                                <th class="titulo-th" style="padding-bottom: 10px;">Observação</th>
                                                <th class="titulo-th" style="padding-bottom: 10px;">QTD Correta</th>
                                                <th class="titulo-th" style="padding-bottom: 10px;">Status</th>
                                                <th class="titulo-th" style="padding-bottom: 10px;">Data de Reporte
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $index = 0 @endphp
                                            @foreach ($reportados_stock as $reportados)
                                                <tr id="linha-{{ $reportados->id }}"
                                                    style="border:1px #0d0d0d7a solid; text-align:center; cursor:context-menu; background-color: {{ $index % 2 == 0 ? '#FFFFFF' : '#F0F0F0' }}">

                                                    <td><span class="paragrafo-td">{{ $reportados->referencia }}</span>
                                                    </td>
                                                    <td><span class="paragrafo-td">{{ $reportados->observacao }}</span>
                                                    </td>
                                                    <td><span
                                                            class="paragrafo-td">{{ $reportados->qtd_correta }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center"
                                                            style="justify-content: center;">
                                                            <span class="circle"
                                                                style="color: {{ $reportados->status == 'atualizado' ? 'green' : 'orange' }}; padding: 0 5px;">
                                                                <i class="fas fa-circle"></i>
                                                            </span>
                                                            <span class="loading-icon d-none"><i
                                                                    class="fas fa-spinner fa-spin"></i></span>
                                                            <select class="form-control status-dropdown"
                                                                data-id="{{ $reportados->id }}">
                                                                <option value="reportado"
                                                                    {{ $reportados->status == 'reportado' ? 'selected' : '' }}>
                                                                    Reportado
                                                                </option>
                                                                <option value="atualizado"
                                                                    {{ $reportados->status == 'atualizado' ? 'selected' : '' }}>
                                                                    Atualizado
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td><span
                                                            class="paragrafo-td">{{ date('Y-m-d H:i:s', strtotime($reportados->created_at)) }}</span>
                                                    </td>
                                                </tr>
                                                @php $index++ @endphp
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                {{ $reportados_stock->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @push('custom-scripts')
        <script>
            var services = [];
            var arrayServices = [];


            /** SCANNER **/

            function scanToJpg() {

                scanner.scan(displayImagesOnPage, {
                    "output_settings": [{
                        "type": "return-base64",
                        "format": "jpg"
                    }]
                });



            }

            /** Processes the scan result */
            function displayImagesOnPage(successful, mesg, response) {
                if (!successful) { // On error
                    console.error('Failed: ' + mesg);
                    return;
                }

                if (successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
                    console.info('User cancelled');
                    return;
                }

                var arrImg = [];

                var scannedImages = scanner.getScannedImages(response, true, false); // returns an array of ScannedImage
                for (var i = 0;
                    (scannedImages instanceof Array) && i < scannedImages.length; i++) {
                    var scannedImage = scannedImages[i];
                    processScannedImage(scannedImage);
                    arrImg.push(scannedImage);
                }

                Livewire.emit("ReceiveImage", arrImg);

            }

            /** Images scanned so far. */
            var imagesScanned = [];

            /** Processes a ScannedImage */
            function processScannedImage(scannedImage) {
                imagesScanned.push(scannedImage);
                var elementImg = scanner.createDomElementFromModel({
                    'name': 'img',
                    'attributes': {
                        'class': 'scanned',
                        'src': scannedImage.src
                    }
                });

                //Livewire.emit("ReceiveImage",scannedImage.src);

            }

            window.addEventListener('swalFire', function(e) {
                swal.fire({
                    title: e.detail.title,
                    html: e.detail.message,
                    type: e.detail.status,
                })
            });

            window.addEventListener('SendBarCode', function(e) {

                swal.fire({
                        title: e.detail.title,
                        html: e.detail.message,
                        type: e.detail.status,
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        confirmButtonText: "Alterar",
                        cancelButtonText: "Cancelar",
                        onOpen: function() {

                        }
                    })
                    .then((result) => {
                        if (result.value) {
                            var encNumber = jQuery("#encNumber").val();

                            if (encNumber != "") {
                                Livewire.emit('encChange', encNumber, e.detail.id);
                            }
                        }
                    });
            });

            window.addEventListener('downloadImage', function(e) {
                window.open(window.location.protocol + '//' + window.location.hostname + "/cl/" + e.detail.img,
                    '_blank');
            });



            // $(document).ready(function() {
            //     // Usando delegação de eventos para capturar alterações de status
            //     $(document).on('change', '.status-dropdown', function() {
            //         var id = $(this).data('id');
            //         var referencia = $(this).closest('tr').attr('id').replace('linha-', '');
            //         var status = $(this).val();
            //         var circle = $(this).closest('td').find('.circle');
            //         var loadingIcon = $(this).closest('td').find('.loading-icon');

            //         // Exibir o ícone de carregamento e ocultar o círculo
            //         circle.hide();
            //         loadingIcon.removeClass('d-none');

            //         // Enviar solicitação AJAX para atualizar o status no banco de dados
            //         $.ajax({
            //             url: '/atualizar-status/' + id,
            //             method: 'POST',
            //             data: {
            //                 _token: '{{ csrf_token() }}',
            //                 status: status
            //             },
            //             success: function(response) {
            //                 // Atualizar a interface do usuário, se necessário

            //                 // Após o término da solicitação, ocultar o ícone de carregamento e exibir o círculo novamente
            //                 loadingIcon.addClass('d-none');
            //                 circle.css('color', status == 'atualizado' ? 'green' : 'orange').show();
            //             },
            //             error: function(xhr, status, error) {
            //                 // Em caso de erro, também é necessário ocultar o ícone de carregamento e exibir o círculo novamente
            //                 loadingIcon.addClass('d-none');
            //                 circle.css('color', status == 'atualizado' ? 'green' : 'orange').show();
            //                 console.error('Erro ao atualizar o status: ' + error);
            //             }
            //         });
            //     });
            // });




            $(document).on('change', '.status-dropdown', function() {
                var id = $(this).data('id');
                var referencia = $(this).closest('tr').attr('id').replace('linha-', '');
                var status = $(this).val();
                var circle = $(this).closest('td').find('.circle');
                var loadingIcon = $(this).closest('td').find('.loading-icon');

                // Exibir o ícone de carregamento e ocultar o círculo
                circle.hide();
                loadingIcon.removeClass('d-none');

                // Enviar solicitação AJAX para atualizar o status no banco de dados
                $.ajax({
                    url: '/atualizar-status/' + id,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(response) {
                        // Atualizar a interface do usuário, se necessário

                        // Após o término da solicitação, ocultar o ícone de carregamento e exibir o círculo novamente
                        loadingIcon.addClass('d-none');
                        circle.css('color', status == 'atualizado' ? 'green' : 'orange').show();

                        // Se o status for "atualizado", exclua os registros da tabela no banco de dados
                        if (status == 'atualizado') {
                            $.ajax({
                                url: '/excluir-registros',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    referencia: referencia
                                },
                                success: function(response) {
                                    // Atualizar a interface do usuário, se necessário
                                    // Por exemplo, recarregar a página ou atualizar a tabela
                                },
                                error: function(xhr, status, error) {
                                    console.error('Erro ao excluir os registros: ' + error);
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Em caso de erro, também é necessário ocultar o ícone de carregamento e exibir o círculo novamente
                        loadingIcon.addClass('d-none');
                        circle.css('color', status == 'atualizado' ? 'green' : 'orange').show();
                        console.error('Erro ao atualizar o status: ' + error);
                    }
                });
            });




            // $(document).on('change', '.status-dropdown', function() {
            //     var id = $(this).data('id');
            //     var referencia = $(this).closest('tr').attr('id').replace('linha-', '');
            //     var status = $(this).val();
            //     var circle = $(this).closest('td').find('.circle');
            //     var loadingIcon = $(this).closest('td').find('.loading-icon');

            //     // Exibir o ícone de carregamento e ocultar o círculo
            //     circle.hide();
            //     loadingIcon.removeClass('d-none');

            //     // Enviar solicitação AJAX para atualizar o status no banco de dados
            //     $.ajax({
            //         url: '/atualizar-status/' + id,
            //         method: 'POST',
            //         data: {
            //             _token: '{{ csrf_token() }}',
            //             status: status
            //         },
            //         success: function(response) {
            //             // Atualizar a interface do usuário, se necessário

            //             // Após o término da solicitação, ocultar o ícone de carregamento e exibir o círculo novamente
            //             loadingIcon.addClass('d-none');
            //             circle.css('color', status == 'atualizado' ? 'green' : 'orange').show();

            //             // Se o status for "atualizado", exibir um popup de confirmação para deletar o item
            //             if (status == 'atualizado') {
            //                 swal.fire({
            //                     title: 'Tem certeza?',
            //                     text: 'Deseja excluir este item?',
            //                     type: 'warning',
            //                     showCancelButton: true,
            //                     confirmButtonColor: '#d33',
            //                     confirmButtonText: 'Sim, excluir!',
            //                     cancelButtonText: 'Cancelar'
            //                 }).then((result) => {
            //                     if (result.value) {
            //                         // Aqui você faz a requisição para excluir o item
            //                         $.ajax({
            //                             url: '/excluir-item/' +
            //                             id, // Certifique-se de que esta rota está correta e corresponde à rota de exclusão em seu aplicativo Laravel
            //                             method: 'POST',
            //                             data: {
            //                                 _token: '{{ csrf_token() }}'
            //                             },
            //                             success: function(response) {
            //                                 // Atualizar a interface do usuário, se necessário
            //                                 $('#linha-' + referencia)
            //                                     .remove(); // Remove a linha da tabela
            //                             },
            //                             error: function(xhr, status, error) {
            //                                 console.error(
            //                                     'Erro ao excluir o item: ' +
            //                                     error);
            //                             }
            //                         });
            //                     } else {
            //                         // Se o usuário cancelar, você pode reverter o status de volta para "reportado"
            //                         // Exemplo: reverterStatus(id, 'reportado');
            //                     }
            //                 });
            //             }
            //         },
            //         error: function(xhr, status, error) {
            //             // Em caso de erro, também é necessário ocultar o ícone de carregamento e exibir o círculo novamente
            //             loadingIcon.addClass('d-none');
            //             circle.css('color', status == 'atualizado' ? 'green' : 'orange').show();
            //             console.error('Erro ao atualizar o status: ' + error);
            //         }
            //     });
            // });
        </script>
    @endpush
</div>
