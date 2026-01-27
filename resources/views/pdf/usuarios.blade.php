@extends('pdf.base')

@section('content')

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Fecha de registro</th>
        </tr>
    </thead>
    <tbody>
        @forelse($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ optional($usuario->created_at)->format('d/m/Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" style="text-align:center; font-style:italic;">
                    No existen usuarios registrados.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
