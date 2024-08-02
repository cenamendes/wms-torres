<link rel="icon" type="image/png" sizes="16x16" href="{{ 'assets/resources/images/logo_png_boxpt.png' }}">
<x-tenant-layout title="Saídas" :themeAction="$themeAction" :status="$status" :message="$message">

    @livewire('tenant.saidas.saida', ['saida'=>$saida])

</x-tenant-layout>
