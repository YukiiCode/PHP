<!DOCTYPE html>
<html>
<head>
    <title>Factura #{{ $cuota->id }}</title>
</head>
<body>
    <h2>Factura #{{ $cuota->id }}</h2>
    <p>Hola {{ $cuota->cliente->nombre }},</p>
    
    <p>Adjunto encontrará su factura por un monto de {{ number_format($cuota->monto, 2) }}€.</p>
    
    <p>Detalles:
        <ul>
            <li>Tipo: {{ ucfirst($cuota->tipo) }}</li>
            <li>Estado: {{ ucfirst($cuota->estado) }}</li>
            <li>Fecha de emisión: {{ $cuota->fecha_emision }}</li>
        </ul>
    </p>
    
    <p>Saludos cordiales,<br>El equipo de administración</p>
</body>
</html>