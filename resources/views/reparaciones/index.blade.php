@extends('layouts.app')

@section('title', 'Reparaciones — Soporte Laptops')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Reparaciones Realizadas</h3>
    <a href="{{ route('reparaciones.create') }}" class="btn btn-primary">
        <i class="bi bi-tools me-1"></i>Registrar Reparación
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Orden</th>
                    <th>Cliente</th>
                    <th>Equipo</th>
                    <th>Diagnóstico</th>
                    <th>Costo</th>
                    <th>Entrega</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reparaciones as $rep)
                <tr>
                    <td class="fw-semibold">
                        <a href="{{ route('ordenes.show', $rep->ordenServicio) }}" class="text-decoration-none">
                            {{ $rep->ordenServicio->codigo_orden }}
                        </a>
                    </td>
                    <td>{{ $rep->ordenServicio->cliente->nombre_completo }}</td>
                    <td>{{ $rep->ordenServicio->marca_laptop }} {{ $rep->ordenServicio->modelo_laptop }}</td>
                    <td>{{ Str::limit($rep->diagnostico, 45) }}</td>
                    <td class="fw-semibold text-success">S/ {{ number_format($rep->costo_servicio, 2) }}</td>
                    <td>{{ $rep->fecha_entrega ? \Carbon\Carbon::parse($rep->fecha_entrega)->format('d/m/Y') : 'Pendiente' }}</td>
                    <td class="text-end">
                        <a href="{{ route('reparaciones.show', $rep) }}" class="btn btn-sm btn-outline-info">Ver</a>
                        <a href="{{ route('reparaciones.edit', $rep) }}" class="btn btn-sm btn-outline-warning">Editar</a>
                        <form action="{{ route('reparaciones.destroy', $rep) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta reparación? La orden volverá a En Proceso.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No hay reparaciones registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $reparaciones->links('pagination::bootstrap-5') }}
</div>
@endsection