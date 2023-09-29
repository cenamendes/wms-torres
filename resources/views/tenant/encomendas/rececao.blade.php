<x-tenant-layout title="Scan Encomenda" :themeAction="$themeAction" :status="$status" :message="$message">
    {{-- Content --}}
    {{-- <script src="{!! global_asset('assets/scanner.js') !!}" type="text/javascript"></script> --}}
    <script src="//cdn.asprise.com/scannerjs/scanner.js" type="text/javascript"></script>
  
    @livewire('tenant.encomendas.rececao')
                 
</x-tenant-layout>

