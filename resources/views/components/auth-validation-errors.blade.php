@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li style="color:#ca0000; font-size:0.85rem">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



