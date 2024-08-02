<style>
    .white-text-popup {
        color: #fff !important;
    }
    .sk-child.sk-bounce1,.sk-child.sk-bounce2, .sk-child.sk-bounce3{
                background: #0d0d0d;
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

        @media (max-width: 785px) {
        .card-title {
                display: none;
            }
        }
</style>
<link rel="icon" type="image/png" sizes="16x16" href="{{ 'assets/resources/images/logo_png_boxpt.png' }}">
<x-tenant-layout title="Detalhe da Encomenda" :themeAction="$themeAction" :status="$status" :message="$message">
    {{-- Content --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-9 col-xs-6">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Compras a Fornecedor</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ __('List') }}</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">

                                {{ $document }}

                            </a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Detalhe da Encomenda</h4>
                    </div>
                    <div class="card-body">
                        @livewire('tenant.encomendas.show-rececao-detail', ['document' => $document, $encomenda])
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
<script>
    window.addEventListener('terminarStock', function(e) {

        swal.fire({
                title: e.detail.title,
                html: e.detail.message,
                type: e.detail.status,
                showCancelButton: true,
                confirmButtonColor: 'green',
                confirmButtonText: "Finalizar",
                cancelButtonText: "Cancelar",

                onOpen: function() {

                    jQuery("body").on("click", "#btnLoc", function() {
                        Livewire.emit('removeDosTemporariosRececao', jQuery(this).attr(
                            "data-mov"));
                    });

                }
            })

            .then((result) => {
                if (result.value) {


                    Livewire.emit('EnviarMovimentosPrincipalRececao');


                }
            });

    });


    //impressao

    window.addEventListener('detalhesimpressao', function(e) {
        swal.fire({
            title: e.detail.title,
            html: e.detail.message,
            type: e.detail.status,
            showCancelButton: true,
            background: '#1d1d1dcb',
            confirmButtonColor: 'rgb(100, 100, 240)',
            cancelButtonColor: 'red',
            confirmButtonText: "Imprimir",
            cancelButtonText: "Fechar",
            onOpen: function() {
                jQuery("body").on("click", "#btnLoc", function() {
                    Livewire.emit('removeDosTemporariosRececao', jQuery(this).attr(
                        "data-mov"));
                });
            }
        }).then((result) => {
            if (result.value) {
                var qtdimpre = document.getElementById('qtdimpre').value;

                // Check if quantity is greater than 0
                if (qtdimpre > 0) {
                    Livewire.emit('enviarImpressao', qtdimpre, e.detail.design, e.detail.barcode);
                    // Show success message
                    swal.fire({
                        title: 'Sucesso!',
                        text: 'Impressão enviada com sucesso!',
                        type: 'success',
                        background: '#FFFFFF',
                    });
                } else {
                    // Show error message for quantity less than or equal to 0
                    swal.fire({
                        title: 'Erro!',
                        text: 'Quantidade deve ser maior que zero!',
                        type: 'error',
                        background: '#FFFFFF',
                    });
                    swalPopup.then(() => {
                        $('.swal2-title, .swal2-content, .swal2-confirm').css('color', '#fff');
                    });
                }
            }
        });
    });

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
                    Livewire.emit('reportarStockConfirm', quantidadeCorreta, observacoes, e.detail.email);
                }
            }
        });
    });
</script>
