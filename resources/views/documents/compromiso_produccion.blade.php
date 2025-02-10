<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>

<body>
    <h1 id="titulo">CONTRATO DE COMPROMISO DE PRODUCCIÓN ORGÁNICA Y DEL COMERCIO JUSTO.</h1>
    <p style="font-size: 14px">
        Suscrito entre la COOPERATIVA AGRARIA YAKATHEO DEL AMAZONAS-COOPAYAKAT, y el
        productor {{ $nombres }} identificado con DNI {{ $dni }}. Con domicilio en {{ $domicilio }} la firma del presente contrato se convierte en obligación entre las
        partes para el cumplimiento de las condiciones en la gestión y manejo de las certificaciones que posee el
        programa, en donde ambas partes manifiestan la aceptación de los siguientes compromisos:
    </p>
    <h3>COMPROMISOS DE COOPAYAKAT</h3>
    <ol>
        <li>Administrar el Sistema Interno de Control –SIC y mantener su adecuado funcionamiento para acceder y
            mantener las certificaciones orgánicas y del comercio Justo.</li>
        <li>Desarrollar programas de capacitación en coordinación con entidades de apoyo del sector cacaotero y de
            cooperación.</li>
        <li>Promover el uso y la implementación de buenas prácticas agrícolas y la responsabilidad social y ambiental
            establecidas en las normas de producción de cacao (orgánico y Comercio Justo).</li>
        <li>Manejar el proceso productivo, de acopio, control de calidad, procesamiento y comercialización acorde con
            las regulaciones de las normas de producción de cacao (NOP-USDA, REGLAMENTO EUROPEO, REGLAMENTO TECNICO PARA
            LOS PRODUCTOS ORGÁNICOS Y LOS CRITERIOS DEL COMERCIO JUSTO).</li>
        <li>Administrar la información de la organización con criterios de confidencialidad, honestidad y
            transparencia.</li>
    </ol>
    <h3>COMPROMISOS DEL PRODUCTOR</h3>
    <ol>
        <li>Conocer los reglamentos y las demás regulaciones del SIC.</li>
        <li>Cumplir con los criterios de cumplimiento de las normas de producción de cacao: NOP-USDA, REGLAMENTO
            EUROPEO, REGLAMENTO TECNICO PARA LOS PRODUCTOS ORGÁNICOS Y LOS CRITERIOS DEL COMERCIO JUSTO. establecidos
            por la organización.</li>
        <li>Aplicar las recomendaciones técnicas y de manejo que sean impartidas por el personal técnico del SIC.</li>
        <li>Brindar información veraz y oportuna a los inspectores internos y externos, así como también autorizar y dar
            las facilidades para su ingreso a las finca y demás establecimientos de producción.</li>
        <li>Participar a las jornadas de capacitación que COOPAYAKAT programe mediante sus órganos de capacitación.</li>
        <li>Aceptar y cumplir con las sanciones que se derivan del reglamento mediante sus órganos de capacitación.</li>
        <li>Informar sobre cualquier variación o cambio en las condiciones de producción en la finca.</li>
        <li>Acopiar por lo menos el 80% de su producción de cacao.</li>
    </ol>
    <h3>VIGENCIA DEL CONTRATO.</h3>
    <p style="font-size: 14px">
        Este contrato es anual y puede darse por terminado por el incumplimiento de los compromisos de alguna de las
        partes, pudiendo ser además por retiro voluntario del productor o por decisión del SIC, mediante comunicación
        oportuna a la otra parte interesada.
        <br><br>
        Para mayor constancia, lo firman por duplicado en señal de conformidad.
    </p>
    
    <p class="fecha">{{ $fecha }}</p>
    
    <div class="firmas">
        <div class="firma" style="float: left; width: 45%;">
            <hr>
            <p>COOPAYAKAT</p>
        </div>
        <div class="firma" style="float: right; width: 45%;">
            <hr>
            <p>PRODUCTOR</p>
            <p>DNI: ____________</p>
        </div>
        <div style="clear: both;"></div> 
    </div>
</body>

</html>

<style>
    body {
        font-family: 'figtree', sans-serif;
    }
    #titulo {
        font-size: 16px;
        text-align: center;
        font-weight: bold;
    }
    .fecha {
        text-align: right;
        margin-top: 20px;
        font-weight: bold;
    }
    .firmas {
        text-align: center;
        margin-top: 50px;
    }
    .firma hr {
        width: 100%;
        margin-bottom: 5px;
    }

    h1 {
        font-size: 14px;
        font-weight: bold;
        text-align: center;
    }

    li {
        font-size: 14px;
    }

    .firma p {
        font-size: 14px;
    }
</style>