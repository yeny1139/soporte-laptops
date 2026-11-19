@extends('layouts.app')

@section('title', 'Panel Principal — Soporte Laptops')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Panel General del Taller</h3>
        <p class="text-muted mb-0">Bienvenido, {{ $user->name }}</p>
    </div>
    <a href="{{ route('ordenes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nueva Orden de Servicio
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Clientes</div>
                <div class="fs-3 fw-bold">{{ $resumen['clientes'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Técnicos Activos</div>
                <div class="fs-3 fw-bold">{{ $resumen['tecnicos'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm h-100 border-start border-warning border-4">
            <div class="card-body">
                <div class="text-muted small">Pendientes</div>
                <div class="fs-3 fw-bold text-warning">{{ $resumen['pendientes'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm h-100 border-start border-info border-4">
            <div class="card-body">
                <div class="text-muted small">En Proceso</div>
                <div class="fs-3 fw-bold text-info">{{ $resumen['en_proceso'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
            <div class="card-body">
                <div class="text-muted small">Reparadas</div>
                <div class="fs-3 fw-bold text-success">{{ $resumen['reparadas'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Ingresos Totales</div>
                <div class="fs-5 fw-bold text-dark">S/ {{ number_format($resumen['ingresos'], 2) }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">Últimas Órdenes Registradas</h5>
        <a href="{{ route('ordenes.index') }}" class="btn btn-sm btn-outline-secondary">Ver todas</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Equipo</th>
                    <th>Técnico</th>
                    <th>Estado</th>
                    <th>Ingreso</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($ultimasOrdenes as $orden)
                <tr>
                    <td class="fw-semibold">{{ $orden->codigo_orden }}</td>
                    <td>{{ $orden->cliente->nombre_completo }}</td>
                    <td>{{ $orden->marca_laptop }} {{ $orden->modelo_laptop }}</td>
                    <td>{{ $orden->tecnico ? $orden->tecnico->nombre_completo : 'Sin asignar' }}</td>
                    <td>
                        @php
                            $badge = match($orden->estado) {
                                'pendiente'  => 'warning',
                                'en_proceso' => 'info',
                                'reparada'   => 'success',
                                'cancelada'  => 'danger',
                                default      => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $badge }}">{{ str_replace('_', ' ', ucfirst($orden->estado)) }}</span>
                    </td>
                    <td>{{ $orden->created_at->format('d/m/Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('ordenes.show', $orden) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No hay órdenes registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection