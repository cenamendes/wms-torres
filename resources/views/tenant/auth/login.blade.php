<link href="/assets/resources/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css">
<script src="/assets/resources/vendor/sweetalert2/dist/sweetalert2.min.js"></script>

<x-guest-layout title="{ __('Pelase login') }" :action="$action" :message="$message">
    <div class="col-md-6">
        <div class="authincation-content" style="background-color:#ffffff">
            <div class="row no-gutters">
                <div class="col-xl-12">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <div class="auth-form">
                        <div class="text-center mb-3">
                            <a href="{!! url('/') !!}"><img
                                    src="{!! "http://".$_SERVER['SERVER_NAME']."/assets/resources/images/logo.png" !!}" alt="" style="width:50%;"></a>
                        </div>
                        <div class="text-center mb-3">
                            <h2 style="color:black;">WMS</h2>
                        </div>
                        <input type="hidden" id="messageSwal" value="{!!$message!!}">
                        <input type="hidden" id="statusSwal" value="{!!$action!!}">
                        <form method="POST" action="{{ route('tenant.verify') }}">
                            @csrf
                            <div class="form-group">
                                <x-label for="username" class="mb-1" :value="__('Username')" />
                                <x-input id="username" class="block mt-1 w-full form-control" type="text" name="username"
                                    :value="old('username')" required autofocus />
                            </div>
                            <div class="form-group">
                                <x-label for="password" class="mb-1" :value="__('Senha')" />
                                <x-input id="password" class="block mt-1 w-full form-control" type="password"
                                    name="password" required autocomplete="current-password" />
                            </div>
                            <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                <div class="form-group d-none">
                                    <div class="custom-control custom-checkbox ml-1 text-white">
                                        <label for="remember_me" class="inline-flex items-center">
                                            <input id="remember_me" type="checkbox"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                name="remember">
                                            <span class="ml-2 text-sm text-gray-600">{{ __('Lembrar-') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group d-none">
                                    <a class="text-white" href="{!! url('/forgot-password') !!}">{{ __('Perdeu a senha?') }}</a>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit"
                                    class="btn bg-white text-primary btn-block" style="background:#326c91!important;color:white!important;">{{ __('Entrar') }}</button>
                            </div>
                        </form>
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

        if(jQuery("#messageSwal").val() != "[]" && jQuery("#messageSwal").val() != "")
        {
            Swal.fire(
                'Login',
                jQuery("#messageSwal").val(),
                jQuery("#statusSwal").val()
            )
        }
       
    </script>


