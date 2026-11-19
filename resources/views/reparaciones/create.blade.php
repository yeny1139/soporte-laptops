@extends('layouts.app')

@section('title', 'Registrar Reparación — Soporte Laptops')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Registrar Informe de Reparación</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('reparaciones.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Orden de Servicio *</label>
                            <select name="orden_servicio_id" class="form-select @error('orden_servicio_id') is-invalid @enderror" required>
                                <option value="">-- Seleccione una orden pendiente o en proceso --</option>
                                @foreach($ordenesDisponibles as $orden)
                                    <option value="{{ $orden->id }}"
                                        {{ old('orden_servicio_id', $ordenSeleccionadaId) == $orden->id ? 'selected' : '' }}>
                                        {{ $orden->codigo_orden }} — {{ $orden->cliente->nombre_completo }} ({{ $orden->marca_laptop }} {{ $orden->modelo_laptop }})
                                    </option>
                                @endforeach
                            </select>
                            @error('orden_servicio_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Diagnóstico Técnico *</label>
                            <textarea name="diagnostico" rows="3"
                                      class="form-control @error('diagnostico') is-invalid @enderror" required>{{ old('diagnostico') }}</textarea>
                            @error('diagnostico') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Trabajo Realizado *</label>
                            <textarea name="trabajo_realizado" rows="3"
                                      class="form-control @error('trabajo_realizado') is-invalid @enderror" required>{{ old('trabajo_realizado') }}</textarea>
                            @error('trabajo_realizado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-5">
                            <label class="form-label">Repuestos Usados</label>
                            <input type="text" name="repuestos_usados" value="{{ old('repuestos_usados') }}"
                                   placeholder="Pasta térmica, teclado, SSD..."
                                   class="form-control @error('repuestos_usados') is-invalid @enderror">
                            @error('repuestos_usados') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Costo del Servicio (S/) *</label>
                            <input type="number" step="0.01" min="0" name="costo_servicio" value="{{ old('costo_servicio', '0.00') }}"
                                   class="form-control @error('costo_servicio') is-invalid @enderror" required>
                            @error('costo_servicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha de Entrega</label>
                            <input type="date" name="fecha_entrega" value="{{ old('fecha_entrega', date('Y-m-d')) }}"
                                   class="form-control @error('fecha_entrega') is-invalid @enderror">
                            @error('fecha_entrega') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('reparaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar y Marcar como Reparada</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection