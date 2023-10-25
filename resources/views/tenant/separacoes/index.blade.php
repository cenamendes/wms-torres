<x-tenant-layout title="Scan Separacao" :themeAction="$themeAction" :status="$status" :message="$message">
    {{-- Content --}}
    {{-- <script src="{!! global_asset('assets/scanner.js') !!}" type="text/javascript"></script> --}}
   
    @livewire('tenant.separacoes.separacoes')
                 
</x-tenant-layout>