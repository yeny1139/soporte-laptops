@extends('layouts.app')

@section('title', 'Detalle de Reparación — Soporte Laptops')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Informe de Reparación — {{ $reparacion->ordenServicio->codigo_orden }}</h3>
    <div class="d-flex gap-2">
        <a href="{{ route('reparaciones.edit', $reparacion) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('reparaciones.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4"><strong>Cliente:</strong> {{ $reparacion->ordenServicio->cliente->nombre_completo }}</div>
            <div class="col-md-4"><strong>Equipo:</strong> {{ $reparacion->ordenServicio->marca_laptop }} {{ $reparacion->ordenServicio->modelo_laptop }}</div>
            <div class="col-md-4"><strong>Técnico:</strong> {{ $reparacion->ordenServicio->tecnico ? $reparacion->ordenServicio->tecnico->nombre_completo : 'Sin asignar' }}</div>
        </div>
        <hr>
        <div class="row g-3">
            <div class="col-md-6">
                <strong>Diagnóstico Técnico:</strong>
                <p class="mt-1">{{ $reparacion->diagnostico }}</p>
            </div>
            <div class="col-md-6">
                <strong>Trabajo Realizado:</strong>
                <p class="mt-1">{{ $reparacion->trabajo_realizado }}</p>
            </div>
            <div class="col-md-4"><strong>Repuestos Usados:</strong> {{ $reparacion->repuestos_usados ?? 'Ninguno' }}</div>
            <div class="col-md-4"><strong>Costo del Servicio:</strong> <span class="text-success fw-bold">S/ {{ number_format($reparacion->costo_servicio, 2) }}</span></div>
            <div class="col-md-4"><strong>Fecha de Entrega:</strong> {{ $reparacion->fecha_entrega ? \Carbon\Carbon::parse($reparacion->fecha_entrega)->format('d/m/Y') : 'Pendiente' }}</div>
        </div>
    </div>
</div>
@endsection