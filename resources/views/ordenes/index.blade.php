@extends('layouts.app')

@section('title', 'Órdenes de Servicio — Soporte Laptops')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Órdenes de Servicio</h3>
    <a href="{{ route('ordenes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nueva Orden
    </a>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form action="{{ route('ordenes.index') }}" method="GET" class="row g-2">
            <div class="col-md-6">
                <input type="text" name="buscar" value="{{ $buscar }}" class="form-control"
                       placeholder="Buscar por código, cliente, DNI o equipo...">
            </div>
            <div class="col-md-4">
                <select name="estado" class="form-select">
                    <option value="">-- Todos los estados --</option>
                    <option value="pendiente" {{ $estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="en_proceso" {{ $estado === 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                    <option value="reparada" {{ $estado === 'reparada' ? 'selected' : '' }}>Reparada</option>
                    <option value="cancelada" {{ $estado === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-funnel me-1"></i>Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Equipo</th>
                    <th>Técnico</th>
                    <th>Estado</th>
                    <th>Reparación</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ordenes as $orden)
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
                        <span class="badge bg-{{ $badge }}">{{ ucfirst(str_replace('_', ' ', $orden->estado)) }}</span>
                    </td>
                    <td>
                        @if($orden->reparacion)
                            <a href="{{ route('reparaciones.show', $orden->reparacion) }}" class="badge bg-success text-decoration-none">
                                Registrada (S/ {{ number_format($orden->reparacion->costo_servicio, 2) }})
                            </a>
                        @elseif($orden->estado !== 'cancelada')
                            <a href="{{ route('reparaciones.create', ['orden_id' => $orden->id]) }}" class="btn btn-sm btn-outline-success">
                                + Registrar
                            </a>
                        @else
                            <span class="text-muted small">N/A</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('ordenes.show', $orden) }}" class="btn btn-sm btn-outline-info">Ver</a>
                        <a href="{{ route('ordenes.edit', $orden) }}" class="btn btn-sm btn-outline-warning">Editar</a>
                        <form action="{{ route('ordenes.destroy', $orden) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta orden de servicio?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No se encontraron órdenes de servicio.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $ordenes->links('pagination::bootstrap-5') }}
</div>
@endsection