

<div class="table-responsive" wire:key="tenantteammembersshow">
    <div id="ajaxLoading" wire:loading.flex class="w-100 h-100 flex "
        style="background:rgba(255, 255, 255, 0.8);z-index:999;position:fixed;top:0;left:0;align-items: center;justify-content: center;">
        <div class="sk-three-bounce" style="background:none;">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <div class="container-fluid" style="padding-left:0px;padding-top:0px;">
    <div class="row">
        <div class="col-xl-2">
          <div class="card">
            <div class="card-header">
                <h4 class="card-intro-title">{{__("Locais")}}</h4>
            </div> 
            <div class="card-body">
                <div>
                    <div class="list-group mb-4" id="list-tab" role="tablist">
                        @foreach ($transferenciasLeft as $local => $item)
                           
                            <a class="list-group-item list-group-item-action" data-toggle="list" role="tab" aria-selected="false" id="local{{$local}}" data-local="{{ $local }}" href="javascript:void(0)">
                                {{ $local }}
                            </a>
                         
                        @endforeach
                    </div>
                    
                </div>
            </div>
            </div>
        </div>
        <div class="col-xl-10">
            <div class="row">
                <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__("Information")}}</h4>
                    </div>
                    <div class="card-body">
                            @if($resultLocal == null)
                                <h4>{{__("Selecione um local para ver a situação atual")}}</h4>
                            @else
                            <div class="row">
                                <!-- Começa aqui -->
                               <div class="container-fluid" style="padding-left:0px;padding-top:0px;">
                                <div class="default-tab">
                                    <div>
                                                                            
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="filesPanel" role="tabpanel">



                                                <div class="table-responsive" wire:key="tenantcustomersshow">
                                                    <div id="ajaxLoading" wire:loading.flex class="w-100 h-100 flex "
                                                        style="background:rgba(255, 255, 255, 0.8);z-index:999;position:fixed;top:0;left:0;align-items: center;justify-content: center;">
                                                        <div class="sk-three-bounce" style="background:none;">
                                                            <div class="sk-child sk-bounce1"></div>
                                                            <div class="sk-child sk-bounce2"></div>
                                                            <div class="sk-child sk-bounce3"></div>
                                                        </div>
                                                    </div>
                                                   
                                                    <!-- display dataTable no-footer -->
                                                    <table id="dataTables-data" class="table table-responsive-lg mb-0 table-striped">
                                                        <thead>
                                                            <tr>
                            
                                                                <th>{{ __('Referência') }}</th>
                                                                <th>{{ __('Quantidade') }}</th>
                                    
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($transferencias as $local)
                                                                @foreach ($local as $item )
                                                                    @if($item["qtd"] != "0")
                                                                        <tr>
                                                                            
                                                                            <td>{{ $item["reference"] }}</td>
                                                                            <td>{{ $item["qtd"] }}</td>
                                                                        
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    {{ $transferencias->links() }}





                                            </div>
                                           
                                        </div>
                                    </div>
                                   </div>   
                                </div>
                                <!-- acaba aqui-->
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@push('custom-scripts')
   <script>
      
      jQuery(document).ready(function() {
         jQuery("body").on("click",".list-group-item",function(){
            Livewire.emit("getLocal",jQuery(this).attr("data-local"));
            jQuery("#selectedCustomer").val(jQuery(this).attr("data-local"))
                     
         })

       
       
      });
   </script> 
@endpush
