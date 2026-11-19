@extends('layouts.app')

@section('title', 'Detalle del Cliente — Soporte Laptops')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">{{ $cliente->nombre_completo }}</h3>
    <div class="d-flex gap-2">
        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3"><strong>DNI:</strong> {{ $cliente->dni }}</div>
            <div class="col-md-3"><strong>Teléfono:</strong> {{ $cliente->telefono }}</div>
            <div class="col-md-3"><strong>Correo:</strong> {{ $cliente->email ?? 'No registrado' }}</div>
            <div class="col-md-3"><strong>Dirección:</strong> {{ $cliente->direccion ?? 'No registrada' }}</div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">Historial de Órdenes de Servicio</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Código</th>
                    <th>Equipo</th>
                    <th>Falla Reportada</th>
                    <th>Técnico</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($cliente->ordenesServicio as $orden)
                <tr>
                    <td class="fw-semibold">{{ $orden->codigo_orden }}</td>
                    <td>{{ $orden->marca_laptop }} {{ $orden->modelo_laptop }}</td>
                    <td>{{ Str::limit($orden->problema_reportado, 45) }}</td>
                    <td>{{ $orden->tecnico ? $orden->tecnico->nombre_completo : 'Sin asignar' }}</td>
                    <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $orden->estado)) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('ordenes.show', $orden) }}" class="btn btn-sm btn-outline-primary">Ver Orden</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Este cliente aún no tiene órdenes registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection