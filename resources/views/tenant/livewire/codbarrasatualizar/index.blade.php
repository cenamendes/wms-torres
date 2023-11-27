<div>
    <div id="ajaxLoading" wire:loading.flex class="w-100 h-100 flex "
        style="background:rgba(255, 255, 255, 0.8);z-index:999;position:fixed;top:0;left:0;align-items: center;justify-content: center;">
        <div class="sk-three-bounce" style="background:none;">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <div class="col-12" style="margin-bottom:25px;padding-left:0px;">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Referência / Código de Barras</label>
                    <input type="text" id="cod_barras" class="form-control" wire:model="codbarras" autofocus>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label>Designação</label>
                    <input type="text" id="descricao" class="form-control" wire:model="descricao" readonly>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label>Novo Código de Barras</label>
                    <input type="text" id="qtd" class="form-control" wire:model.defer="newcodbarras" value="1">
                </div>
            </div>
           
        </div>
                    
        <div class="row">
            <div class="col-md-6 col-xs-6">

            </div>
            <div class="col-md-6 col-xs-12" style="padding-left:0px;padding-right:0px;">
                <div class="row" style="justify-content:end;">
                   
                    <button type="button" id="guardaStock" wire:click="guardaStock" class="btn-sm btn btn-primary"><i class="fa fa-save"></i> Alterar</button>
                                            
                </div>
            </div>
          
        </div>
    </div>
</div>

<script>
     window.addEventListener('swalFire',function(e){
                swal.fire({
                        title: e.detail.title,
                        html: e.detail.message,
                        type: e.detail.status,
                })
            });
</script>

