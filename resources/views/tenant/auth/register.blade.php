
<link href="/assets/resources/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css">
<script src="/assets/resources/vendor/sweetalert2/dist/sweetalert2.min.js"></script>

<x-guest-layout title="{ __('Pelase login') }" :action="$action" :message="$message">
    <div class="col-md-12">
        <div class="authincation-content" style="background-color:#2f3031">
            <div class="row no-gutters">
                <div class="col-xl-12">
                    {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}
                    <div class="auth-form">
                        <div class="text-center mb-3">
                            <a href="{!! url('/') !!}"><img
                                    src="{!! "http://".$_SERVER['SERVER_NAME']."/assets/resources/images/logo.png" !!}" alt="" style="width:20%;"></a>
                        </div>
                        <input type="hidden" id="messageSwal" value="{!!$errors!!}">
                        <h4 class="text-center mb-4 text-white">Registe a sua conta</h4>
                        <form method="POST" action="{{ route('registerEntity') }}">
                            @csrf
                            <div class="form-group row">
                                <section class="col-xl-8 col-xs-12">
                                    <input style="display:none" type="text" name="idCustomer" id="idCustomer" class="form-control" placeholder="{{ __('idCustomer') }}">
                                    <label class="text-white">{{ __('Customer Name') }}</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Customer Name') }}">
                                </section>
                                <section class="col-xl-2 col-xs-12">
                                    <label class="text-white">{{ __('Slug') }}</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="{{ __('slug') }}">
                                </section>
                                <section class="col-xl-2 col-xs-12">
                                    <label class="text-white">{{ __('VAT') }}</label>
                                    <input type="text" name="vat" id="vat" class="form-control" placeholder="{{ __('VAT') }}">
                                </section>
                            </div>
                            <div class="form-group row">
                                <section class="col-xl-3 col-xs-12">
                                    <label class="text-white">{{ __('Short Name') }}</label>
                                    <input type="text" name="short_name" id="short_name" class="form-control" placeholder="{{ __('Short Name') }}">
                                </section>
                                <section class="col-xl-3 col-xs-12">
                                    <label class="text-white">{{ __('Phone number') }}</label>
                                    <input type="text" name="contact" id="contact" class="form-control" placeholder="{{ __('Phone number') }}">
                                </section>
                                <section class="col-xl-6 col-xs-12">
                                    <label class="text-white">{{ __('Primary e-mail address') }}</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="{{ __('Primary e-mail address') }}">
                                </section>
                            </div>
                            <div class="form-group row">
                                <section class="col-xl-6 col-xs-12">
                                    <label class="text-white">{{ __('Customer Address') }}</label>
                                    <input type="text" name="address" id="address" class="form-control" placeholder="{{ __('Customer Address') }}">
                                </section>
                                <section class="col-xl-6 col-xs-12">
                                    <label class="text-white">{{ __('Username') }}</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="{{ __('Username') }}">
                                </section>
                            </div>
                            <div class="form-group row">
                                <section class="col-xl-2 col-xs-12">
                                    <label class="text-white">{{ __('Zip Code') }}</label>
                                    <input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="{{ __('Zip Code') }}">
                                </section>
                                @php
                                    $districts = \App\Models\Tenant\Districts::all();
                                    $counties = \App\Models\Tenant\Counties::all();
                                @endphp
                                @livewire('tenant.common.location',  ['districts' => $districts, 'counties' => $counties, 'register' => "yes"])
                            </div>
                            <div class="form-group row">
                                <section class="col-xl-12 col-xs-12">
                                    <label class="text-white">Entidade específica</label>
                                    <div class='row mt-2'>
                                        <div class='col-xl-2'>
                                            <div class='custom-control custom-checkbox mb-3 checkbox-success check-lg'>
                                                &nbsp;<input type='checkbox' class='custom-control-input' id='checkboxCliente' name='nr_cliente_phc'>
                                                <label class='custom-control-label text-white pl-2' for='checkboxCliente'>Cliente</label>
                                            </div>
                                        </div>
                                        <div class='col-xl-6 pl-0'>
                                            <div class='custom-control custom-checkbox mb-3 checkbox-success check-lg'>
                                                &nbsp;<input type='checkbox' class='custom-control-input' id='checkboxFornecedor' name='nr_fornecedor_phc'>
                                                <label class='custom-control-label text-white pl-2' for='checkboxFornecedor'>Fornecedor</label>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="text-center row" style="margin-top:50px;">
                                <div class="col-xl-12" style="display:flex;justify-content:center;">
                                    <button type="submit" class="btn bg-white text-primary btn-block" style="color:#326c91!important;width:50%;">Registar</button>
                                </div>
                            </div>
                        </form>
                        <div class="new-account mt-3 text-center">
                            <p class="text-white"><a class="text-white"
                                    href="{!! url('/') !!}">Já tem conta criada?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="erros">
       
        @if ($errors->any())
            <script>
                let status = '';
                let message = '';

                status = 'error';
            
                @php
                
                $allInfo = '';

                foreach ($errors->all() as $err )
                {
                   $allInfo .= $err."<br>";
                }
                                     
                $message = $allInfo;
                   
                @endphp
                message = '{!! $message !!}';
            </script>
        @endif
    </div>
</x-guest-layout>

<script>
    jQuery( document ).ready(function() {
        jQuery("#districtLabel").css("color","white");
        jQuery("#cityLabel").css("color","white");

        jQuery("body").on("change","#district", function(){
            console.log("gf");
            jQuery("#districtLabel").css("color","white");
            jQuery("#cityLabel").css("color","white");
        })

    });

    if(jQuery("#messageSwal").val() != "[]")
        {
            Swal.fire(
                'Login',
                'Tem de preencher todos os campos.',
                'error'
            )
        }

</script>