@extends('layouts.app')

@section('title', 'Clientes — Soporte Laptops')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Clientes</h3>
    <a href="{{ route('clientes.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i>Nuevo Cliente
    </a>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form action="{{ route('clientes.index') }}" method="GET" class="row g-2">
            <div class="col-md-10">
                <input type="text" name="buscar" value="{{ $buscar }}" class="form-control"
                       placeholder="Buscar por DNI, nombres o apellidos...">
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search me-1"></i>Buscar
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
                    <th>DNI</th>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th class="text-center">Órdenes</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientes as $cliente)
                <tr>
                    <td class="fw-semibold">{{ $cliente->dni }}</td>
                    <td>{{ $cliente->nombre_completo }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->email ?? '—' }}</td>
                    <td class="text-center">
                        <span class="badge bg-secondary">{{ $cliente->ordenes_servicio_count }}</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-outline-info">Ver</a>
                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-outline-warning">Editar</a>
                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No se encontraron clientes.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $clientes->links('pagination::bootstrap-5') }}
</div>
@endsection