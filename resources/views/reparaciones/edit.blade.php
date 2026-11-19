@extends('layouts.app')

@section('title', 'Editar Reparación — Soporte Laptops')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Editar Reparación — Orden {{ $reparacion->ordenServicio->codigo_orden }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('reparaciones.update', $reparacion) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Diagnóstico Técnico *</label>
                            <textarea name="diagnostico" rows="3"
                                      class="form-control @error('diagnostico') is-invalid @enderror" required>{{ old('diagnostico', $reparacion->diagnostico) }}</textarea>
                            @error('diagnostico') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Trabajo Realizado *</label>
                            <textarea name="trabajo_realizado" rows="3"
                                      class="form-control @error('trabajo_realizado') is-invalid @enderror" required>{{ old('trabajo_realizado', $reparacion->trabajo_realizado) }}</textarea>
                            @error('trabajo_realizado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-5">
                            <label class="form-label">Repuestos Usados</label>
                            <input type="text" name="repuestos_usados" value="{{ old('repuestos_usados', $reparacion->repuestos_usados) }}"
                                   class="form-control @error('repuestos_usados') is-invalid @enderror">
                            @error('repuestos_usados') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Costo del Servicio (S/) *</label>
                            <input type="number" step="0.01" min="0" name="costo_servicio" value="{{ old('costo_servicio', $reparacion->costo_servicio) }}"
                                   class="form-control @error('costo_servicio') is-invalid @enderror" required>
                            @error('costo_servicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha de Entrega</label>
                            <input type="date" name="fecha_entrega"
                                   value="{{ old('fecha_entrega', $reparacion->fecha_entrega ? \Carbon\Carbon::parse($reparacion->fecha_entrega)->format('Y-m-d') : '') }}"
                                   class="form-control @error('fecha_entrega') is-invalid @enderror">
                            @error('fecha_entrega') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('reparaciones.show', $reparacion) }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Reparación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection