<div class="row">
    <div class="col-12">
        <div class="card" style="border-top-left-radius: 0px; border-top-right-radius: 0px;">
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ $action }}" method="post" enctype="multipart/form-data">
                        @csrf

                        @if($update)
                            @method('PUT')
                        @else
                          @method('POST')
                        @endif
                        
                        <div class="row">
                            <div class="form-group row">
                                <section class="col-xl-12 col-xs-12">
                                    <input type="hidden" name="location_id" @isset($id) value="{{ $id }}" @endisset>
                                    <label>{{ __('Código de barras') }}</label>
                                    <input type="text" name="cod_barras" id="cod_barras" @if(isset($codbarras)) value="{{$codbarras}}" @endif class="form-control"
                                        placeholder="{{ __('Código de Barras') }}">
                                </section>
                                <section class="col-xl-12 col-xs-12">
                                    <label>{{ __('Descrição') }}</label>
                                    <input type="text" name="descricao" id="descricao" @if(isset($descricao)) value="{{$descricao}}" @endif class="form-control"
                                        placeholder="{{ __('Descrição') }}">
                                </section>
                                <section class="col-xl-12 col-xs-12">
                                    <label>{{ __('Abreviatura') }}</label>
                                    <input type="text" name="abreviatura" id="abreviatura" @if(isset($abreviatura)) value="{{$abreviatura}}" @endif class="form-control"
                                        placeholder="{{ __('Abreviatura') }}">
                                </section>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-footer justify-content-between">
        <div class="row">
            <div class="col text-right">
               
                <a href="{{ route('tenant.locations.index') }}" class="btn btn-secondary mr-2">{{
                    __('Back') }}
                    <span class="btn-icon-right"><i class="las la-angle-double-left"></i></span>
                </a>
             
                <button type="submit" style="border:none;background:none;">
                    <a type="submit" class="btn btn-primary"  role="button">
                        {{ $buttonAction }}
                        <span class="btn-icon-right"><i class="las la-check mr-2"></i></span>
                    </a>
                </button>
            </div>
        </div>
    </div>
</div>
</form>
