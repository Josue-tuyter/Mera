<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo ?? 'Reporte' }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* ---------------------------
           ENCABEZADO
        --------------------------- */
        .header {
            width: 100%;
            border-bottom: 2px solid #2f6f4e;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .logo {
            width: 90px;
        }

        .finca-info {
            text-align: left;
        }

        .finca-nombre {
            font-size: 16px;
            font-weight: bold;
            color: #1f4d36;
        }

        .finca-detalle {
            font-size: 11px;
        }

        .fecha {
            text-align: right;
            font-size: 10px;
            color: #666;
        }

        /* ---------------------------
           TÍTULO DEL REPORTE
        --------------------------- */
        .titulo-reporte {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            margin: 15px 0;
            color: #1f4d36;
            text-transform: uppercase;
        }

        /* ---------------------------
           TABLAS
        --------------------------- */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background-color: #2f6f4e;
            color: #ffffff;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 6px 5px;
            text-align: left;
        }

        th {
            font-size: 11px;
            text-transform: uppercase;
        }

        tbody tr:nth-child(even) {
            background-color: #f4f8f6;
        }

        /* ---------------------------
           FOOTER
        --------------------------- */
        .footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #777;
        }
    </style>
</head>
<body>

    {{-- ENCABEZADO --}}
    <div class="header">
        <table width="100%">
            <tr>
                <td width="20%">
                    @if(file_exists($logoPath))
                        <img src="{{ $logoPath }}" class="logo">
                    @endif
                </td>
                <td width="80%">
                    <strong>{{ $nombreFinca }}</strong><br>
                    Propietario: {{ $propietario }}<br>
                    Fecha de exportación: {{ $fechaExportacion }}
                </td>
            </tr>
        </table>
    </div>

    {{-- TÍTULO --}}
    <div class="titulo">
        {{ $titulo ?? 'Reporte' }}
    </div>

    {{-- CONTENIDO --}}
    @yield('content')

</html>
