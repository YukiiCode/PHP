@extends('plantilla')

@section('contenido')
<div class="container">
    <h2>Factura #{{ $cuota->id }}</h2>
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Detalles de la Cuota</h5>
            
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Cliente:</strong> {{ $cuota->cliente->nombre }}</p>
                    <p><strong>Fecha de Emisión:</strong> {{ $cuota->fecha_emision->format('d/m/Y') }}</p>
                    <p><strong>Tipo:</strong> {{ ucfirst($cuota->tipo) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Monto:</strong> €{{ number_format($cuota->monto, 2) }}</p>
                    <p><strong>Estado:</strong> {{ ucfirst($cuota->estado) }}</p>
                </div>
            </div>
            
            <hr>
            
            <p class="text-muted">Se adjunta el PDF de la factura para su registro.</p>
        </div>
    </div>
</div>
@endsection