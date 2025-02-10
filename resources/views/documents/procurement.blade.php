<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Contenedor principal de la boleta */
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Títulos y subtítulos */
        h1, h2 {
            margin: 0;
            padding: 0;
            color: #4a4a4a;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #1a73e8;
        }

        h2 {
            font-size: 18px;
            font-weight: normal;
            color: #5f6862;
            margin-top: 20px;  /* Espacio superior */
            margin-bottom: 20px;  /* Espacio inferior */
            text-decoration: underline;  /* Subrayado */
        }

        /* Sección de la empresa y RUC */
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ddd;
        }

        .company-name {
            font-size: 26px;
            font-weight: bold;
            color: #1a73e8;
        }

        .company-ruc {
            font-size: 16px;
            color: #555;
        }

        /* Información de la boleta */
        .info {
            margin-top: 20px;
            font-size: 16px;
        }

        .info div {
            margin-bottom: 10px;
        }

        .info div span {
            font-weight: bold;
        }

        .info .date {
            text-align: right;
            color: #777;
        }

        /* Tabla con detalles */
        .details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .details th, .details td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .details th {
            background-color: #f4f7fb;
            font-weight: bold;
            color: #333;
        }

        .details td {
            color: #555;
        }

        .details .total {
            font-weight: bold;
            color: #333;
            background-color: #f4f7fb;
        }

        /* Pie de página */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="company-name">COOPERATIVA AGRARIA YAKATHEO</div>
            <div class="company-ruc">RUC: 20608478311</div>
        </div>

        <div class="info">
            <div class="date">Fecha: {{ \Carbon\Carbon::parse($procurement->created_at)->format('d/m/Y') }}</div>
            <!-- Agregamos el Número de Transacción -->
            <div><span>Número de Transacción:</span> {{$procurement->id}}</div>
        </div>

        <div class="info">
            <h2>Detalles de la Transacción</h2>
            <div><span>Producto:</span> {{$procurement->product->name}}</div>
            <div><span>Productor:</span> {{$procurement->productor->names}} {{$procurement->productor->surnames}}</div>
            <div><span>DNI del Productor:</span> {{$procurement->productor->dni}}</div>
            <div><span>Peso:</span> {{$procurement->weight}} kg</div>
            <div><span>Precio unitario:</span> S/. {{$procurement->unit_price}}</div>
            <div><span>Total:</span> S/. {{$procurement->total()}}</div>
        </div>

        <div class="footer">
            <p>Gracias por confiar en nosotros.</p>
        </div>
    </div>
</body>

</html>
