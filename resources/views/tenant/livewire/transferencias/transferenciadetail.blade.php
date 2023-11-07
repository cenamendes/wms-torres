
       <!-- Inicio do Filtro  -->

       <div id="accordion-one" class="accordion accordion-primary">
        <div class="accordion__item">
            <div class="accordion__header rounded-lg show" data-toggle="collapse" data-target="#default_collapseOne" aria-expanded="true">
                <span class="accordion__header--text">Transferência de Stock</span>
                <span class="accordion__header--indicator"></span>
            </div>
            <div id="default_collapseOne" class="accordion__body collapse show" data-parent="#accordion-one">
                <div class="accordion__body--text">
                    <div class="col-12" style="margin-bottom:25px;padding-left:0px;">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{__("Codigo de Barras")}}</label>
                                    <input type="text" id="cod_barras" class="form-control" wire:model="codbarras" autofocus>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{__("Descrição")}}</label>
                                    <input type="text" id="descricao" class="form-control" wire:model.defer="descricao" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{__("Quantidade")}}</label>
                                    <input type="number" id="qtd" class="form-control" wire:model.defer="qtd" value="1">
                                </div>
                            </div>
                           
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{__("Origem")}}</label>
                                    <input type="text" id="selectOrigin" name="selectOrigin" wire:model.defer="selectOrigin" class="form-control">
                                </div>
                            </div> 

                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{__("Transferir para")}}</label>
                                    <input type="text" id="transferir" class="form-control" wire:model.defer="transferir">
                                </div>
                            </div>
                        </div>
                                    
                        <div class="row">
                            <div class="col-md-6 col-xs-6">

                            </div>
                            <div class="col-md-6 col-xs-12" style="padding-left:0px;padding-right:0px;">
                                <div class="row" style="justify-content:end;">
                                   
                                    <button type="button" id="guardaStock" wire:click="guardaStock" class="btn-sm btn btn-primary"><i class="fa fa-plus"></i> Transferir</button>

                                    <button type="button" id="cancelarStock" wire:click="cancelarStock" class="btn-sm btn btn-danger"><i class="fa fa-ban"></i> Cancelar</button>

                                    <button type="button" id="terminarStock" wire:click="terminarStock" class="btn-sm btn btn-success"><i class="fa fa-floppy-disk"></i> Terminar</button>
                                                     
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Fim do Filtro -->  
