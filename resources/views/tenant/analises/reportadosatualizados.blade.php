<link rel="icon" type="image/png" sizes="16x16" href="{{ 'assets/resources/images/logo_png_boxpt.png' }}">
<x-tenant-layout title="Reportados Atualizados" :themeAction="$themeAction" :status="$status" :message="$message">
    {{-- Content --}}
    {{-- <script src="{!! global_asset('assets/scanner.js') !!}" type="text/javascript"></script> --}}
    <script src="//cdn.asprise.com/scannerjs/scanner.js" type="text/javascript"></script>

    @livewire('tenant.analises.reportados-atualizados')

</x-tenant-layout>
