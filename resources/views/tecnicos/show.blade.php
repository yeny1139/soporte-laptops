@extends('layouts.app')

@section('title', 'Detalle del Técnico — Soporte Laptops')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">{{ $tecnico->nombre_completo }} ({{ $tecnico->codigo_tecnico }})</h3>
    <div class="d-flex gap-2">
        <a href="{{ route('tecnicos.edit', $tecnico) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('tecnicos.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3"><strong>DNI:</strong> {{ $tecnico->dni }}</div>
            <div class="col-md-3"><strong>Especialidad:</strong> {{ $tecnico->especialidad }}</div>
            <div class="col-md-3"><strong>Estado:</strong> {{ $tecnico->activo ? 'Activo' : 'Inactivo' }}</div>
            <div class="col-md-3"><strong>Cuenta:</strong> {{ $tecnico->user ? $tecnico->user->email : 'Sin vincular' }}</div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">Órdenes Asignadas</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Equipo</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($tecnico->ordenesServicio as $orden)
                <tr>
                    <td class="fw-semibold">{{ $orden->codigo_orden }}</td>
                    <td>{{ $orden->cliente->nombre_completo }}</td>
                    <td>{{ $orden->marca_laptop }} {{ $orden->modelo_laptop }}</td>
                    <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $orden->estado)) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('ordenes.show', $orden) }}" class="btn btn-sm btn-outline-primary">Ver Orden</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Este técnico no tiene órdenes asignadas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection