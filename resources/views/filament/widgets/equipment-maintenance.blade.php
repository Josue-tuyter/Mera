<div>
    <h3>Próximos mantenimientos</h3>
    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr>
                <th style="text-align:left;padding:4px">Equipo</th>
                <th style="text-align:left;padding:4px">Próximo mantenimiento</th>
                <th style="text-align:left;padding:4px">Disponible</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td style="padding:4px">{{ $item->nombre }}</td>
                    <td style="padding:4px">{{ optional($item->proximo_mantenimiento)->format('Y-m-d') }}</td>
                    <td style="padding:4px">{{ $item->disponible ? 'Sí' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>