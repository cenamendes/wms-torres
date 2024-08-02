<div>
    @foreach($saidas->types as $type)
    <li><a href="{{ route('tenant.saida', ['idsaida' => $type->Id]) }}">
            <span>{{ $type->Name }}</span>
        </a></li>
    @endforeach
</div>
