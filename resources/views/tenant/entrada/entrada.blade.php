<link rel="icon" type="image/png" sizes="16x16" href="{{ 'assets/resources/images/logo_png_boxpt.png' }}">
<x-tenant-layout title="Home" :themeAction="$themeAction" :status="$status" :message="$message">

    @livewire('tenant.entrada.entrada')

</x-tenant-layout>
