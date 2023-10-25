<x-tenant-layout title="Detalhes das Arrumações" :themeAction="$themeAction" :status="$status" :message="$message">
    {{-- Content --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-9 col-xs-6">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Arrumações</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Referências</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Arrumações</h4>
                    </div>
                    <div class="card-body">
                        @livewire('tenant.arrumacoes.show-arrumacoes-detail')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>

<script>

    window.addEventListener('terminarStock',function(e){
        
        swal.fire({
            title: e.detail.title,
            html: e.detail.message,
            type: e.detail.status,
            showCancelButton: true,
            confirmButtonColor: 'green',
            confirmButtonText: "Finalizar",
            cancelButtonText: "Cancelar",

            onOpen: function() {

                jQuery("body").on("click","#btnLoc", function(){
                    Livewire.emit('removeDosTemporarios',jQuery(this).attr("data-mov"));
                });

            }
        })
        
        .then((result) => {
            if(result.value) {

                
                Livewire.emit('EnviarMovimentosPrincipal');
                
               
            }
        });
           
    });
    
</script>