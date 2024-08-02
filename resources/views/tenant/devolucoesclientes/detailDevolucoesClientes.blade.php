<style>
    .white-text-popup {
    color: #fff !important;
}
@media (max-width: 785px) {
        .card-title {
                display: none;
            }
        }
</style>
<link rel="icon" type="image/png" sizes="16x16" href="{{ 'assets/resources/images/logo_png_boxpt.png' }}">
<x-tenant-layout title="Detalhe da Encomenda Devoluções" :themeAction="$themeAction" :status="$status" :message="$message">
    {{-- Content --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-9 col-xs-6">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Devoluções de Clientes</a></li>
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
                        @livewire('tenant.devolucoes-clientes.show-devolucoes-clientes-detail', ['document' => $document, $encomenda])
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
</script>
