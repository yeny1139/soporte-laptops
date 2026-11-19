@extends('layouts.app')

@section('title', 'Técnicos — Soporte Laptops')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Técnicos del Taller</h3>
    <a href="{{ route('tecnicos.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i>Nuevo Técnico
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Código</th>
                    <th>DNI</th>
                    <th>Técnico</th>
                    <th>Especialidad</th>
                    <th>Usuario Sistema</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Órdenes</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tecnicos as $tecnico)
                <tr>
                    <td class="fw-semibold">{{ $tecnico->codigo_tecnico }}</td>
                    <td>{{ $tecnico->dni }}</td>
                    <td>{{ $tecnico->nombre_completo }}</td>
                    <td>{{ $tecnico->especialidad }}</td>
                    <td>{{ $tecnico->user ? $tecnico->user->email : 'Sin cuenta vinculada' }}</td>
                    <td class="text-center">
                        @if($tecnico->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge bg-dark">{{ $tecnico->ordenes_servicio_count }}</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('tecnicos.show', $tecnico) }}" class="btn btn-sm btn-outline-info">Ver</a>
                        <a href="{{ route('tecnicos.edit', $tecnico) }}" class="btn btn-sm btn-outline-warning">Editar</a>
                        <form action="{{ route('tecnicos.destroy', $tecnico) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Seguro que deseas eliminar este técnico?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">No hay técnicos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $tecnicos->links('pagination::bootstrap-5') }}
</div>
@endsection