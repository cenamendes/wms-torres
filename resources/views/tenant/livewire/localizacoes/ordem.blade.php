<div>
    <div id="ajaxLoading" wire:loading.flex class="w-100 h-100 flex "
        style="background:rgba(255, 255, 255, 0.8);z-index:999;position:fixed;top:0;left:0;align-items: center;justify-content: center;">
        <div class="sk-three-bounce" style="background:none;">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <div class="card-body">
        <div class="card-content mb-4">
          @if($message == '')
            <div class="nestable">
                <div class="dd" id="nestable" wire:ignore>
                  <ol class="dd-list" data-type="grouplist">
                      @foreach ($planeamento as $id => $plan)
                        <li class="dd-item dd-nochildren" data-id="{{$id}}" data-type="group">
                          <div class="dd-handle" style="font-size:18px;font-weight:500;">
                            <input type="hidden" class="abreviatura" value={{ $plan->abreviatura }}>
                            {{$plan->abreviatura}}
                          </div>
                        </li>
                      @endforeach
                    </ol>
                  </div>
            </div>
            @else
             {!! $message !!}
            @endif
        </div>
    </div>
    <div class="card-footer justify-content-between">
            <div class="row">
                {{-- <div class="col-6 text-left">
                   
                </div> --}}
                <div class="col-12 text-right">
                    <a wire:click="refreshPlanning" class="btn btn-primary">
                        <i class="las la-check mr-2"></i>Atualizar ordem
                    </a>
                </div>
            </div>
    </div>  
  </div>
  
