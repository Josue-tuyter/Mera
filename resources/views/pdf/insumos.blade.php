@extends('pdf.base')

@section('content')

<table>
    <thead>
        <tr>
            <th>Insumo</th>
            <th>Descripción</th>
            <th>Unidad</th>
            <th>Stock</th>
            <th>Stock Mínimo</th>
            <th>Proveedor</th>
        </tr>
    </thead>
    <tbody>
        @forelse($insumos as $insumo)
            <tr>
                <td>{{ $insumo->nombre }}</td>
                <td>{{ $insumo->descripcion ?? '-' }}</td>
                <td>{{ $insumo->unidad ?? '-' }}</td>
                <td>{{ $insumo->stock ?? 0 }}</td>
                <td>{{ $insumo->stock_minimo ?? 0 }}</td>
                <td>{{ $insumo->proveedor ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center; font-style:italic;">
                    No existen insumos registrados.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
