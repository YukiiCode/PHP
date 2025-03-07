<!DOCTYPE html>
<html>
<head>
    <title>Factura #{{ $cuota->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Factura #{{ $cuota->id }}</h2>
        <p>Fecha de emisión: {{ $cuota->fecha_emision }}</p>
    </div>

    <div class="content">
        <h3>Cliente:</h3>
        <p>{{ $cuota->cliente->nombre }} {{ $cuota->cliente->apellidos }}</p>
        <p>Email: {{ $cuota->cliente->email }}</p>

        <h3>Detalles de la cuota:</h3>
        <table>
            <tr>
                <th>Tipo</th>
                <th>Monto</th>
                <th>Estado</th>
            </tr>
            <tr>
                <td>{{ ucfirst($cuota->tipo) }}</td>
                <td>
                    {{ number_format($cuota->importe, 2) }} {{ $cuota->cliente->moneda ?? 'EUR' }}
                    @if($cuota->cliente && $cuota->cliente->moneda && $cuota->cliente->moneda !== 'EUR')
                        <br><small>({{ number_format($cuota->getImporteEnEuros(), 2) }}€)</small>
                    @endif
                </td>
                <td>{{ $cuota->pagado ? 'Pagada' : 'Pendiente' }}</td>
            </tr>
        </table>
    </div>
</body>
</html>