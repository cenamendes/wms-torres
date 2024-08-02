<link href="/assets/resources/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.cdnfonts.com/css/syfy-fantasy" rel="stylesheet">
<style>
    .dropdown-filter {
        position: relative;
        display: inline-block;
    }

    .dropdown-filter-btn {
        width: 200px;
        border: none;
        cursor: pointer;
        position: relative;
        z-index: 10;
        border-radius: 1.25rem;
        background: #fff;
        border: 1px solid #f0f1f5;
        color: #B1B1B1;

        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 400;
        height: 41px;
        display: flex;
        align-items: center;
    }

    .dropdown-filter-btn i {
        margin-left: auto;
    }

    .dropdown-filter-content {
        display: none;
        position: absolute;
        border-top: 0px solid black !important;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        animation: slideDown 0.5s ease;
        z-index: 1;
        height: 105px;
        width: 200px;
        overflow-y: auto;
        border-radius: 0 0 1.25rem 1.25rem;
        background: #fff;
        border: 1px solid #f0f1f5;
        color: #B1B1B1;
    }

    .dropdown-filter-content a {
        color: black;
        text-decoration: none;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        display: block;
        height: 41px;
    }

    .dropdown-filter-content a:hover {
        background-color: #ddd;
    }

    .dropdown-filter-content ::-webkit-scrollbar {
        width: 9px;
        height: 9px;
    }

    .dropdown-filter-content ::-webkit-scrollbar-button:start:decrement,
    .dropdown-filter-content ::-webkit-scrollbar-button:end:increment {
        display: block;
        height: 0;
        background-color: #ffffff;
    }

    .dropdown-filter-content ::-webkit-scrollbar-track-piece {
        background-color: #ffffff;
        opacity: 1;
    }

    #ajaxLoadingHome .sk-child.sk-bounce1,
    #ajaxLoadingHome .sk-child.sk-bounce2,
    #ajaxLoadingHome .sk-child.sk-bounce3 {
        background: #0d0d0d;
    }

    /* border-bottom: 0px !important;
    border-radius:  5px 5px 0 0; */

    @keyframes slideDown {
        from {
            height: 0;
        }

        to {
            height: height: 105px;
            ;
        }
    }
</style>
<!-- vinicius -->

<x-guest-layout title="{ __('Pelase login') }" :action="$action" :message="$message">
    <div id="ajaxLoadingHome" wire:loading.flex class="w-100 h-100 flex "
        style="background:rgba(255, 255, 255, 0.8);z-index:999;position:fixed;top:0;left:0;align-items: center;justify-content: center;display: none;">
        <div class="sk-three-bounce" style="background:none;">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="authincation-content" style="background-color:#ffffff">
            <div class="row no-gutters">
                <div class="col-xl-12">
                    <div class="auth-form">
                        <div class="text-center mb-3">
                            <a href="{!! url('/') !!}"><img src="{!! '/assets/resources/images/logo_png_boxpt.png' !!}" alt=""
                                    style="width:50%;"></a>
                        </div>
                        <div class="text-center mb-3">
                            <h2 style="color:black!important;font-weight: 900 !important;">WMS</h2>
                        </div>
                        <x-auth-validation-errors class="mb-4 text-black" :errors="$errors" />
                        <input type="hidden" id="messageSwal" value="{!! $message !!}">
                        <input type="hidden" id="statusSwal" value="{!! $action !!}">
                        <form method="POST" action="{{ route('tenant.verify') }}">
                            @csrf
                            <div class="form-group">
                                <x-label for="username" class="mb-1" :value="__('Username')" />
                                <x-input id="username" class="block mt-1 w-full form-control" type="text"
                                    name="username" :value="old('username')" required autofocus />
                            </div>
                            <div class="form-group">
                                <x-label for="password" class="mb-1" :value="__('Senha')" />
                                <x-input id="password" class="block mt-1 w-full form-control" type="password"
                                    name="password" required autocomplete="current-password" />
                            </div>
                            <div class="form-row d-flex justify-content-between mt-4 mb-2">

                                <div class="dropdown-filter form-group">
                                    <x-label for="username" class="mb-1" :value="__('Warehouses')" />
                                    <div class="dropdown-filter-btn shadow-sm" id="dropdown-filter-btn"><i
                                            class="fa-solid fa-chevron-down" id="dropdown-icon-filter"></i></div>
                                    <input type="hidden" id="dropdown-filter-btn-id">

                                    <div class="dropdown-filter-content shadow-sm" id="dropdown-filter-content">

                                        @foreach ($stoqueSelect->warehouse as $warehouse)
                                            <a class="dropdown-item"
                                                data-id="{{ $warehouse->id }}">{{ $warehouse->name }}</a>
                                        @endforeach
                                        @foreach ($usersSelect as $user)
                                            <input type="hidden" class="userGetAll" data-name="{{ $user['username'] }}"
                                                data-id="{{ $user['id'] }}"
                                                data-auth-stoque="{{ $user['authstock'] }}">
                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" name="selected_stock" id="selected_stock" value="">

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

                                <button type="submit" id="submitButton" class="btn bg-white text-primary btn-block"
                                    style="background:#090909!important;color:white!important;">{{ __('Entrar') }}</button>

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

                    foreach ($errors->all() as $err) {
                        $allInfo .= $err . '<br>';
                    }

                    $message = $allInfo;

                @endphp
                message = '{!! $message !!}';
            </script>
        @endif
    </div>
</x-guest-layout>

<!-- vinicius -->
<script>
    document.getElementById('submitButton').addEventListener('click', function(event) {
        var nameValueImput = document.getElementById('username').value;
        var IdValueSelecionado = document.getElementById('dropdown-filter-btn-id').textContent;


        if (nameValueImput === '') {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Por favor, selecione um utilizador!',
            });
            return;
        }
        if (document.getElementById('dropdown-filter-btn').innerText === '') {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Por favor, selecione um armazén!',
            });
            return;
        }
        document.addEventListener('livewire:load', function() {
            restartObjects();
            jQuery("#alert_email").val("");
        });

        var noPermissionUsers = [];

        var users = document.querySelectorAll('.userGetAll');

        users.forEach(function(user) {
            var userId = user.dataset.id;
            var authStoque = user.dataset.authStoque;
            var userName = user.dataset.name;
            var usertype = user.dataset.type_user;

            var authStoqueArray = JSON.parse(authStoque);

            var hasPermission = null;

            for (var i = 0; i < authStoqueArray.length; i++) {
                var item = authStoqueArray[i];
                console.log(userName, nameValueImput);

                if (userName === nameValueImput) {
                    if (usertype == 0) {
                        hasPermission = item.id;
                        break;
                    } else {
                        if (item.id === IdValueSelecionado) {
                            hasPermission = item.id;
                            break;
                        } else {}
                    }
                }
            }
            if (hasPermission) {
                noPermissionUsers.push(hasPermission);
            }
        });

        if (noPermissionUsers.length === 0) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: 'Não têm permissão para acessar este armazém',
            });
            return;
        }
        LoadingHome()

        function LoadingHome() {
            var dropdownfilterContent = document.getElementById("ajaxLoadingHome");

            if (dropdownfilterContent.style.display === "block") {
                dropdownfilterContent.style.display = "none";
            } else {
                dropdownfilterContent.style.display = "block";
            }
        }
    });




    const links = document.querySelectorAll('.dropdown-filter-content a');
    var dropdownfilterContent = document.getElementById("dropdown-filter-content");
    links.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            dropdownfilterContent.style.display = "none";
            document.getElementById('dropdown-filter-btn-id').textContent = this.dataset.id;
            document.getElementById('dropdown-filter-btn').textContent = this.textContent;
        });
    });
    if (jQuery("#messageSwal").val() != "[]" && jQuery("#messageSwal").val() != "") {
        Swal.fire(
            'Login',
            jQuery("#messageSwal").val(),
            jQuery("#statusSwal").val()
        )
    }

    function toggledropdownfilter() {
        var dropdownfilterContent = document.getElementById("dropdown-filter-content");
        var dropdownfilterIcon = document.getElementById("dropdown-icon-filter");

        if (dropdownfilterContent.style.display === "block") {
            dropdownfilterContent.style.display = "none";
            dropdownfilterIcon.style.transform = "rotate(0deg)"
        } else {
            dropdownfilterContent.style.display = "block";
            dropdownfilterIcon.style.transform = "rotate(180deg)"

        }
    }
    document.getElementById("dropdown-filter-btn").addEventListener("click", function() {
        toggledropdownfilter();
    });

    $(document).ready(function() {
        $('.dropdown-item').click(function() {
            var selectedStock = $(this).data('id');
            $('#selected_stock').val(selectedStock);
        });
    });
</script>
<!-- vinicius -->
