<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Factura #{{ $cuota->id }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 15px;
        }
        .header {
            border-bottom: 1px solid #2c3e50;
            padding-bottom: 10px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }
        .company-info {
            text-align: left;
        }
        .company-info h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 22px;
        }
        .company-info p {
            margin: 3px 0;
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-details h2 {
            color: #2c3e50;
            margin: 0;
            font-size: 16px;
        }
        .invoice-details p {
            margin: 3px 0;
        }
        .client-info {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .client-info h3 {
            margin-top: 0;
            margin-bottom: 5px;
            color: #2c3e50;
            font-size: 14px;
        }
        .client-info p {
            margin: 3px 0;
        }
        .client-details {
            display: flex;
            flex-wrap: wrap;
        }
        .client-details p {
            width: 50%;
            margin: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            font-size: 10px;
        }
        .payment-info {
            margin-top: 15px;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }
        .payment-info h3 {
            margin-top: 0;
            margin-bottom: 5px;
            color: #2c3e50;
            font-size: 14px;
        }
        .payment-info p {
            margin: 3px 0;
        }
        .status-paid {
            color: #28a745;
            font-weight: bold;
        }
        .status-pending {
            color: #dc3545;
            font-weight: bold;
        }
        .two-column {
            display: flex;
            justify-content: space-between;
        }
        .column {
            width: 48%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="company-info">
                <h1>EMPRESA S.L.</h1>
                <p>C/ Principal, 123</p>
                <p>28001 Madrid, España</p>
                <p>CIF: B12345678</p>
                <p>Tel: +34 91 123 45 67</p>
                <p>Email: info@empresa.com</p>
            </div>
            <div class="invoice-details">
                <h2>FACTURA</h2>
                <p><strong>Nº:</strong> {{ str_pad($cuota->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Fecha de emisión:</strong> {{ $cuota->fecha_emision->format('d/m/Y') }}</p>
                @if($cuota->pagado && $cuota->fecha_pago)
                <p><strong>Fecha de pago:</strong> {{ $cuota->fecha_pago->format('d/m/Y') }}</p>
                @endif
                <p><strong>Estado:</strong> 
                    <span class="{{ $cuota->pagado ? 'status-paid' : 'status-pending' }}">
                        {{ $cuota->pagado ? 'PAGADA' : 'PENDIENTE DE PAGO' }}
                    </span>
                </p>
            </div>
        </div>

        <div class="client-info">
            <h3>DATOS DEL CLIENTE</h3>
            <div class="client-details">
                <p><strong>Nombre:</strong> {{ $cuota->cliente->nombre }}</p>
                <p><strong>CIF/NIF:</strong> {{ $cuota->cliente->cif }}</p>
                <p><strong>Dirección:</strong> {{ $cuota->cliente->direccion ?? 'No disponible' }}</p>
                <p><strong>País:</strong> {{ $cuota->cliente->pais }}</p>
                <p><strong>Email:</strong> {{ $cuota->cliente->correo }}</p>
                <p><strong>Teléfono:</strong> {{ $cuota->cliente->telefono }}</p>
            </div>
        </div>

        <div class="two-column">
            <div class="column">
                <h3>DETALLES DE LA FACTURA</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Concepto</th>
                            <th>Tipo</th>
                            <th>Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $cuota->concepto ?? 'Cuota de servicio' }}</td>
                            <td>{{ ucfirst($cuota->tipo) }}</td>
                            <td>
                                {{ number_format($cuota->importe, 2, ',', '.') }} {{ $cuota->cliente->moneda ?? 'EUR' }}
                                @if($cuota->cliente && $cuota->cliente->moneda && $cuota->cliente->moneda !== 'EUR')
                                    <br><small>({{ number_format($cuota->getImporteEnEuros(), 2, ',', '.') }}€)</small>
                                @endif
                            </td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="2" style="text-align: right;"><strong>TOTAL</strong></td>
                            <td>
                                <strong>{{ number_format($cuota->importe, 2, ',', '.') }} {{ $cuota->cliente->moneda ?? 'EUR' }}</strong>
                                @if($cuota->cliente && $cuota->cliente->moneda && $cuota->cliente->moneda !== 'EUR')
                                    <br><small>({{ number_format($cuota->getImporteEnEuros(), 2, ',', '.') }}€)</small>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="column">
                <div class="payment-info">
                    <h3>INFORMACIÓN DE PAGO</h3>
                    <p><strong>Método de pago:</strong> Transferencia bancaria</p>
                    <p><strong>Cuenta bancaria:</strong> ES12 3456 7890 1234 5678 9012</p>
                    <p><strong>Titular:</strong> EMPRESA S.L.</p>
                    <p><strong>Concepto:</strong> Factura {{ str_pad($cuota->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>EMPRESA S.L. - CIF: B12345678 - Inscrita en el Registro Mercantil de Madrid, Tomo 12345, Folio 67, Hoja M-123456, Inscripción 1ª</p>
            <p>De acuerdo con la normativa de Protección de Datos (RGPD/LOPDGDD), sus datos serán tratados por EMPRESA S.L. como responsable del tratamiento con la finalidad de gestionar la relación comercial. Base legítima: ejecución de contrato. Sus datos no serán cedidos salvo obligación legal y se conservarán durante el tiempo necesario para cumplir con las obligaciones legales. Puede ejercer sus derechos de acceso, rectificación, supresión y portabilidad de datos, y oposición y limitación a su tratamiento en info@empresa.com.</p>
        </div>
    </div>
</body>
</html>