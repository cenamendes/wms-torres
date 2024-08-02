<link rel="icon" type="image/png" sizes="16x16" href="{{ 'assets/resources/images/logo_png_boxpt.png' }}">
<x-tenant-layout title="Stock" :themeAction="$themeAction" :status="$status" :message="$message">
    <script src="//cdn.asprise.com/scannerjs/scanner.js" type="text/javascript"></script>

    @livewire('tenant.stock.stock')

</x-tenant-layout>
