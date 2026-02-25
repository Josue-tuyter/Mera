@extends('pdf.base')

@section('content')

<table>
    <thead>
        <tr>
            <th>Equipo</th>
            <th>Serial</th>
            <th>Ubicación</th>
            <th>Responsable</th>
            <th>Disponible</th>
            <th>Próx. mantenimiento</th>
            <th>Costo estimado</th>
        </tr>
    </thead>
    <tbody>
        @forelse($equipos as $equipo)
            <tr>
                <td>{{ $equipo->nombre }}</td>
                <td>{{ $equipo->serial ?? '-' }}</td>
                <td>{{ $equipo->ubicacion ?? '-' }}</td>
                <td>{{ $equipo->responsable?->name ?? '-' }}</td>
                <td>
                    {{ $equipo->disponible ? 'Sí' : 'No' }}
                </td>
                {{-- <td>
                    //{{ optional($equipo->proximo_mantenimiento)->format('d/m/Y') ?? '-' }}
                </td> --}}
                <td>
                    $ {{ number_format($equipo->costo_mantenimiento_estimado ?? 0, 2) }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align:center; font-style:italic;">
                    No existen equipos registrados.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
