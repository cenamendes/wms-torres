<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ config('dz.name') }} | @yield('title', $page_title ?? '')</title>
    <meta name="description" content="@yield('page_description', $page_description ?? '')"/>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ 'assets/resources/images/logo_png_boxpt.png' }}">
    <link href="{{ 'assets/resources/css/style.css' }}" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/syfy-fantasy" rel="stylesheet">

    <script src="https://kit.fontawesome.com/993199b4e7.js" crossorigin="anonymous"></script>

</head>

<body class="h-100" style="background: #111111">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                {{ $slot }}
            </div>
        </div>
    </div>
    @include('tenant.elements.footer-scripts')
</body>

</html>
