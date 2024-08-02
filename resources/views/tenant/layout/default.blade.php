<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('dz.name') }} | {{ $attributes['title'] }}</title>
    <meta name="description" content="@yield('page_description', $page_description ?? '')">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ global_asset('storage/resources/images/logo_png_boxpt.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>

	@if(!empty(config('dz.public.pagelevel.css.'.$attributes['themeAction'])))
		@foreach(config('dz.public.pagelevel.css.'.$attributes['themeAction']) as $style)
				<link href="{{ '/assets/resources/' . $style }}" rel="stylesheet" type="text/css">
		@endforeach

	@endif
	@if(!empty(config('dz.public.sweet.css')))
		@foreach(config('dz.public.sweet.css') as $style)
				<link href="{{ '/assets/resources/' . $style }}" rel="stylesheet" type="text/css">
		@endforeach
	@endif
	{{-- Global Theme Styles (used by all pages) --}}
	@if(!empty(config('dz.public.global.css')))
		@foreach(config('dz.public.global.css') as $style)
			<link href="{{ '/assets/resources/' . $style }}" rel="stylesheet" type="text/css">
		@endforeach
	@endif
    @livewireStyles

</head>

<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <div class="nav-header">
            <a href="{{ route('tenant.entrada') }}" class="brand-logo">
            @php
                $config_user = \App\Models\Tenant\Config::first();
            @endphp
            @if ($config_user->logotipo == null)
                <img class="logo-abbr" src="." alt="">
            @else
                <img class="logo" src="{{ global_tenancy_asset('/app/public/images/logo/' . $config_user->logotipo) }}" alt="{{ $config_user->company_name }}" title="{{ $config_user->company_name }}" style="max-width: 80%;">
            @endif
			{{-- @if(empty(session('logotipo')))
				<img class="logo-abbr" src="." alt="">
			@else
                <img class="logo" src="{{ global_tenancy_asset('/app/public/images/logo/' . session('logotipo')) }}" alt="{{ session('company_name') }}" title="{{ session('company_name') }}" style="max-width: 80%;">
			@endif --}}

            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line" style="background:black !important;"></span><span class="line" style="background:black !important;"></span><span class="line" style="background:black !important;"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Header start
        ***********************************-->
        <x-elements.header />

        <!--**********************************
            Sidebar start
        ***********************************-->
        <x-elements.sidebar />

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            {{ $slot }}
        </div>

        <!--**********************************
            Footer start
        ***********************************-->
		@include('tenant.elements.footer')

        <!--**********************************
            Footer end
        ***********************************-->
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
	@include('tenant.elements.footer-scripts')
    <script>
        jQuery(document).ready(function() {
            if ( status != '' && message != '') {
                if( status == "sucess" ) {
                    swal("{{ __('Success') }}", message, "success");
                } else if ( status == "error") {
                    swal("{{ __('Error') }}", message, "error");
                } else if ( status == "info") {
                    swal("{{ __('Information') }}", message, "info");
                }
            }


            if( "{{ $attributes['message'] }}" != "" ) {
                if( "{{ $attributes['status'] }}" == "sucess" ) {
                    swal("{{ __('Success') }}", "{{ $attributes['message'] }}", "success");
                } else if ("{{ $attributes['status'] }}" == "error") {
                    swal("{{ __('Error') }}", "{{ $attributes['message'] }}", "error");
                } else if ("{{ $attributes['status'] }}" == "info") {
                    swal("{{ __('Information') }}", "{{ $attributes['message'] }}", "info");
                }
            }

            var emptyFrom = '';

            jQuery('body').on('click', '.btn-sweet-alert', function() {
                swal.fire({
                    title: jQuery(this).attr('data-title'),
                    text: jQuery(this).attr('data-text'),
                    type: jQuery(this).attr('data-style'),
                    showCancelButton: !0,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: jQuery(this).attr('data-btn-ok'),
                    cancelButtonText: jQuery(this).attr('data-btn-cancel'),
                }).then((e) => {
                    if(e.value) {
                        jQuery('ajaxLoading').show();
                        if(jQuery(this).attr('data-type') == 'form') {
                            emptyFrom = '<form action="' + jQuery(this).attr('data-route') + '" method="post" id="formAction">';
                        }
                        if(jQuery(this).attr('data-csrf') == 'csrf') {
                            emptyFrom += '@csrf';
                        }
                        if(jQuery(this).attr('data-method') == 'DELETE') {
                            emptyFrom += 'method="@method('DELETE')"';
                        }
                        emptyFrom += '</form>';
                        jQuery('#generatedScripts').append(emptyFrom);
                        jQuery('#formAction').submit();
                    }
                });
            });

        })
    </script>
    <div id="generatedScripts"></div>
    @stack('custom-scripts')
</body>
</html>
