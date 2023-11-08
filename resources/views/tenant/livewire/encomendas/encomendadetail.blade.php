
       <!-- Inicio do Filtro  -->

       <div id="accordion-one" class="accordion accordion-primary" wire:ignore>
        <div class="accordion__item">
            <div class="accordion__header rounded-lg show" data-toggle="collapse" data-target="#default_collapseOne" aria-expanded="true">
                <span class="accordion__header--text">Adicionar ao Stock</span>
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
                                    <input type="text" id="descricao" class="form-control" wire:model.defer="descricao" readonly> <!-- READONLY -->
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{__("Quantidade")}}</label>
                                    <input type="number" id="qtd" class="form-control" wire:model.defer="qtd" value="1">
                                </div>
                            </div>
                        </div>
                                    
                        <div class="row">
                            <div class="col-md-6 col-xs-6">

                            </div>
                            <div class="col-md-6 col-xs-12" style="padding-left:0px;padding-right:0px;">
                                <div class="row" style="justify-content:end;">
                                   
                                        <button type="button" id="guardaStock" wire:click="guardaStock" class="btn-sm btn btn-primary"><i class="fa fa-plus"></i> Adicionar</button>
                                
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
                  <option value="10"
                      @if ($perPage == 10) selected @endif>10</option>
                  <option value="25"
                      @if ($perPage == 25) selected @endif>25</option>
                  <option value="50"
                      @if ($perPage == 50) selected @endif>50</option>
                  <option value="100"
                      @if ($perPage == 100) selected @endif>100</option>
              </select>
              {{ __('entries') }}</label>
      </div>
      
      
  </div>
  
  
  <!-- display dataTable no-footer -->
  {{-- <div class="table-responsive"> --}}
    <table class="table-striped" style="width:100%;table-layout:fixed;">
        <thead>
            <tr style="text-align:center;">
                <th style="padding-bottom: 10px;">Referencia</th>
                <th style="padding-bottom: 10px;">Designacao</th>
                <th style="padding-bottom: 10px;">QTD Separada</th>
                <th style="padding-bottom: 10px;">QTD Inícial</th>
            </tr>
        </thead>
        <tbody>
            @php
                $count = -1;
            @endphp
    
            @foreach ($encomendaDetail as $i => $impr)
                
                   @php
                        $soma = 0;
                       $encomendas = \App\Models\Tenant\Encomendas::where('id',$encomenda)->first(); 

                       $movimentos = \App\Models\Tenant\MovimentosStock::where('tipo','Entrada')->where('reference',$impr->referencias)->get();

                       foreach($movimentos as $mov)
                       {
                          if($mov->cod_barras == $impr->cod_barras)
                          {
                            $soma += $mov->qtd;
                          }
                        
                       }
                       $response_decoded = json_decode($encomendas->linhas_encomenda);
                 

                   @endphp

              

                        <tr style="text-align:center;">
                            <td style="padding-bottom:30px;"><br><span>{{ $impr->referencias }}</span></td>
                            <td style="padding-bottom:30px;"><br><span style="padding-right: 5px;padding-left: 5px;">{{ $impr->designacoes }}</span></td>
                            <td style="padding-bottom:30px;"><br><span style="padding-right: 5px;padding-left: 5px;">{{ $soma }}</span></td>
                            <td style="padding-bottom:30px;"><br><span style="padding-right: 5px;padding-left: 5px;">{{ $impr->qtd }} </span></td>
                        </tr>
              
            @endforeach
        </tbody>
    </table>
{{-- </div> --}}
{{ $encomendaDetail->links() }}
</div>

