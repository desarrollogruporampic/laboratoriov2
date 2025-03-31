<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada de Unidad</title>
    <style>
        /* Estilo general de la página */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #212529;
        }

        .container {
            width: 100%;
            max-width: 900px;
            margin: auto;
        }

        /* Configuración de la página para mPDF (para generar PDFs) */
        @page {
            header: page-header;
            footer: page-footer;
            margin-top: 250px;
            margin-bottom: 50px;
            margin-left: 20px;
            margin-right: 20px;
        }

        /* Estilo para el encabezado */
        .header {
            width: 100%;
            border-radius: 8px;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-container {
            width: 130px;
            height: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            overflow: hidden;
            float: left;
        }

        .logo {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        /* Estilo para el título principal h1 */
        .header h1 {
            font-size: 24px;
            color: #242525;
            font-weight: 700;
            text-align: left;
            padding-top: 40px;
            width: 70%;
            float: right;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
            font-weight: 200;
        }

        /* Estilo de la fecha */
        .header .fecha {
            font-size: 14px;
            color: white;
        }

        /* Estilo del panel informativo con dos columnas */
        .panel-info {
            background-color: #ffffff;

            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
            border: 2px solid #28a745;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 20px;
        }

        .panel-info p {
            font-size: 12px;
            margin: 5px 0;
            color: #495057;
            line-height: 1.6;
        }

        .panel-info p strong {
            font-weight: 600;
            color: #28a745;
        }

        /* Estilo de la tabla */
        .vertical-table {
            width: 100%;
            margin-top: 20px;
            border: 1px solid #dee2e6;
            border-collapse: collapse;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            page-break-inside: auto;
        }

        .vertical-table th,
        .vertical-table td {
            padding: 10px;
            text-align: left;
            font-size: 12px;
            border: 1px solid #dee2e6;
        }

        .vertical-table th {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            font-size: 13px;
        }

        .vertical-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .vertical-table td {
            background-color: #ffffff;
        }

        .vertical-table tr {
            page-break-inside: avoid !important;
        }

        .vertical-table tr:last-child {
            page-break-before: always;
        }

        /* Estilo para el pie de página */
        .footer {
            font-size: 10px;
            color: #6c757d;
            padding-top: 10px;
            border-top: 2px solid #343a40;
            text-align: center;
        }

        html {
            margin-bottom: 50px;
        }
    </style>
</head>

<body>
    <!-- Encabezado -->
    <htmlpageheader name="page-header">
        <div class="header">
            <div class="logo-container">
                <img src="{{ asset('storage/miempresa/1.png') }}" alt="Logo" class="logo">
            </div>

            @if ($unidad->tipo_unidad=='entrada')
            <h1>Entrada de Unidad </h1>
            @else
            <h1>Salida de Unidad</h1>
            @endif

            <div class="fecha">
                {{ Carbon\Carbon::parse($unidad->created_at)->format('d/m/Y') }}
            </div>
        </div>
        <!-- Panel Informativo con dos columnas -->
        <table class="panel-info" width="100%" border="1" cellspacing="0" cellpadding="5">

            <tr>
                @if ($unidad->tipo_unidad=='entrada')
                <td width="10%"><strong>Número entrada</strong></td>
                @else
                <td width="10%"><strong>Número salida</strong></td>
                @endif
                <td width="15%">{{ $unidad->id_entrada_unidad }}</td>
                @if ($unidad->tipo_unidad=='entrada')
                <td width="10%"><strong>Fecha entrada</strong></td>
                @else
                <td width="10%"><strong>Fecha salida</strong></td>
                @endif
                <td width="15%">{{ Carbon\Carbon::parse($unidad->created_at)->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                @if ($unidad->tipo_unidad=='entrada')
                <td width="10%"><strong>Cantidad entradas</strong></td>
                @else
                <td width="10%"><strong>Cantidad salidas</strong></td>
                @endif
                <td width="15%">{{ count($unidad->entradadetalle) }}</td>
                <td width="10%"><strong>Creado por</strong></td>
                <td width="25%">{{ $unidad->usercrea->name }}</td>
            </tr>
        </table>
    </htmlpageheader>

    <!-- Contenido Principal -->
    <div class="container">
        <div class="table-container">
            <table class="vertical-table">
                <thead>
                    <tr>
                        <th width="25%">Detalle</th>
                        <th width="17%">Valor</th>
                        <th width="25%">Detalle</th>
                        <th width="34%">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($unidad->entradadetalle as $detalle)
                    <tr>
                        <td><strong>Número serie</strong></td>
                        <td>{{ $detalle->unidadtransfusional->numero_componente }}</td>
                        <td><strong>Tipo hemocomponente</strong></td>
                        <td>{{ $detalle->tipohemocomponente->nombre_tipo_hemocomponente }}</td>
                    </tr>
                    <tr>
                        <td><strong>Fecha donación</strong></td>
                        <td>
                            {{ Carbon\Carbon::parse($detalle->unidadtransfusional->fecha_donacion)->format('d/m/Y H:i')
                            }}
                        </td>
                        <td><strong>Fecha caducidad</strong></td>
                        <td>
                            {{ Carbon\Carbon::parse($detalle->unidadtransfusional->fecha_caducidad)->format('d/m/Y H:i')
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Fecha entrada</strong></td>
                        <td>
                            {{ Carbon\Carbon::parse($detalle->unidadtransfusional->fecha_entrada)->format('d/m/Y H:i')
                            }}
                        </td>
                        <td><strong>Fenotipo</strong></td>
                        @if ($detalle->unidadtransfusional->is_fenotipo==1)
                        <td>{{ $detalle->unidadtransfusional->nombre_fenotipo }}</td>
                        @else
                        <td>{{ 'Sin Fenotipo' }}</td>
                        @endif

                    </tr>
                    <tr>
                        <td><strong>Grupo sanguíneo</strong></td>
                        <td>{{ $detalle->unidadtransfusional->gruposanguineo->nombre_grupo_sanguineo }}</td>
                        <td><strong>Tipo RH</strong></td>
                        <td>{{ $detalle->unidadtransfusional->tiporh->nombre_tipo_rh }}</td>
                    </tr>
                    @if ($detalle->comentario)
                    <tr>
                        <td><strong>Comentario</strong></td>
                        <td colspan="3">
                            {!! nl2br($detalle->comentario)!!}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="4" style="height: 10px;"></td> <!-- Espacio entre registros -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pie de Página -->
    <htmlpagefooter name="page-footer">
        <div class="footer">
            &copy; {{ date('Y') }} - Sistema de Registro de Unidades | Página {PAGENO} de {nbpg}
        </div>
    </htmlpagefooter>
</body>

</html>