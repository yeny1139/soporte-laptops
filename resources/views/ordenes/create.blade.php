@extends('layouts.app')

@section('title', 'Nueva Orden de Servicio — Soporte Laptops')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Registrar Orden de Servicio</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('ordenes.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Código de Orden *</label>
                            <input type="text" name="codigo_orden" value="{{ old('codigo_orden', $codigoSugerido) }}"
                                   class="form-control @error('codigo_orden') is-invalid @enderror" required>
                            @error('codigo_orden') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Cliente *</label>
                            <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                                <option value="">-- Seleccione cliente --</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->dni }} - {{ $cliente->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Técnico Asignado</label>
                            <select name="tecnico_id" class="form-select @error('tecnico_id') is-invalid @enderror">
                                <option value="">-- Sin asignar --</option>
                                @foreach($tecnicos as $tecnico)
                                    <option value="{{ $tecnico->id }}" {{ old('tecnico_id') == $tecnico->id ? 'selected' : '' }}>
                                        {{ $tecnico->codigo_tecnico }} - {{ $tecnico->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tecnico_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Marca Laptop *</label>
                            <input type="text" name="marca_laptop" value="{{ old('marca_laptop') }}"
                                   placeholder="Lenovo, HP, Dell, Asus..."
                                   class="form-control @error('marca_laptop') is-invalid @enderror" required>
                            @error('marca_laptop') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Modelo *</label>
                            <input type="text" name="modelo_laptop" value="{{ old('modelo_laptop') }}"
                                   class="form-control @error('modelo_laptop') is-invalid @enderror" required>
                            @error('modelo_laptop') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Número de Serie</label>
                            <input type="text" name="numero_serie" value="{{ old('numero_serie') }}"
                                   class="form-control @error('numero_serie') is-invalid @enderror">
                            @error('numero_serie') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Accesorios entregados</label>
                            <input type="text" name="accesorios" value="{{ old('accesorios') }}"
                                   placeholder="Cargador original, mochila, mouse..."
                                   class="form-control @error('accesorios') is-invalid @enderror">
                            @error('accesorios') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estado inicial *</label>
                            <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                                <option value="pendiente" {{ old('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_proceso" {{ old('estado') === 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                            </select>
                            @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Problema reportado por el cliente *</label>
                            <textarea name="problema_reportado" rows="3"
                                      class="form-control @error('problema_reportado') is-invalid @enderror" required>{{ old('problema_reportado') }}</textarea>
                            @error('problema_reportado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('ordenes.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Orden</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection