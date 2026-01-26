@extends('pdf.base')

@section('content')

    {{-- Información de filtros --}}
    @if($fechaInicio && $fechaFin)
        <div class="mb-10">
            <strong>Periodo del reporte:</strong>
            {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }}
            —
            {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
        </div>
    @endif

    {{-- Tabla --}}
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Actividad</th>
                <th>Descripción</th>
                <th>Duración</th>
                <th>Encargado</th>
                <th>Estado</th>
                <th>Parcela</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registros as $registro)
                <tr>
                    <td>{{ optional($registro->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $registro->hora }}</td>
                    <td>{{ $registro->tipo_actividad }}</td>
                    <td>{{ $registro->descripcion }}</td>
                    <td>{{ $registro->duracion_minutos }} min</td>
                    <td>{{ $registro->encargado?->name ?? '-' }}</td>
                    <td>{{ $registro->estado?->nombre ?? '-' }}</td>
                    <td>{{ $registro->parcela ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; font-style: italic;">
                        No existen registros para los criterios seleccionados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection
