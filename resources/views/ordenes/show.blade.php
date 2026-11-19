@extends('layouts.app')

@section('title', 'Detalle de Orden — Soporte Laptops')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="fw-bold mb-0">Orden {{ $orden->codigo_orden }}</h3>
        <span class="text-muted">Registrada el {{ $orden->created_at->format('d/m/Y H:i') }}</span>
    </div>
    <div class="d-flex gap-2">
        @if(!$orden->reparacion && $orden->estado !== 'cancelada')
            <a href="{{ route('reparaciones.create', ['orden_id' => $orden->id]) }}" class="btn btn-success">
                <i class="bi bi-tools me-1"></i>Registrar Reparación
            </a>
        @endif
        <a href="{{ route('ordenes.edit', $orden) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('ordenes.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold">Datos del Cliente y Técnico</div>
            <div class="card-body">
                <p class="mb-2"><strong>Cliente:</strong> {{ $orden->cliente->nombre_completo }} (DNI: {{ $orden->cliente->dni }})</p>
                <p class="mb-2"><strong>Teléfono:</strong> {{ $orden->cliente->telefono }}</p>
                <p class="mb-2"><strong>Técnico Asignado:</strong> {{ $orden->tecnico ? $orden->tecnico->nombre_completo . ' (' . $orden->tecnico->codigo_tecnico . ')' : 'Sin asignar' }}</p>
                <p class="mb-0"><strong>Estado Actual:</strong> <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $orden->estado)) }}</span></p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold">Datos del Equipo</div>
            <div class="card-body">
                <p class="mb-2"><strong>Laptop:</strong> {{ $orden->marca_laptop }} {{ $orden->modelo_laptop }}</p>
                <p class="mb-2"><strong>Número de Serie:</strong> {{ $orden->numero_serie ?? 'No especificado' }}</p>
                <p class="mb-2"><strong>Accesorios:</strong> {{ $orden->accesorios ?? 'Ninguno' }}</p>
                <p class="mb-0"><strong>Problema Reportado:</strong> {{ $orden->problema_reportado }}</p>
            </div>
        </div>
    </div>
</div>

@if($orden->reparacion)
<div class="card border-0 shadow-sm border-start border-success border-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold text-success">Informe de Reparación Completada</h5>
        <a href="{{ route('reparaciones.edit', $orden->reparacion) }}" class="btn btn-sm btn-outline-warning">Editar Reparación</a>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6"><strong>Diagnóstico Técnico:</strong><br>{{ $orden->reparacion->diagnostico }}</div>
            <div class="col-md-6"><strong>Trabajo Realizado:</strong><br>{{ $orden->reparacion->trabajo_realizado }}</div>
            <div class="col-md-4"><strong>Repuestos Usados:</strong> {{ $orden->reparacion->repuestos_usados ?? 'Ninguno' }}</div>
            <div class="col-md-4"><strong>Costo del Servicio:</strong> S/ {{ number_format($orden->reparacion->costo_servicio, 2) }}</div>
            <div class="col-md-4"><strong>Fecha Entrega:</strong> {{ $orden->reparacion->fecha_entrega ? \Carbon\Carbon::parse($orden->reparacion->fecha_entrega)->format('d/m/Y') : 'Pendiente' }}</div>
        </div>
    </div>
</div>
@endif
@endsection