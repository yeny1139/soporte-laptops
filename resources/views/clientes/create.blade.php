@extends('layouts.app')

@section('title', 'Nuevo Cliente — Soporte Laptops')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Registrar Nuevo Cliente</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">DNI *</label>
                            <input type="text" name="dni" maxlength="8" value="{{ old('dni') }}"
                                   class="form-control @error('dni') is-invalid @enderror" required>
                            @error('dni') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nombres *</label>
                            <input type="text" name="nombres" value="{{ old('nombres') }}"
                                   class="form-control @error('nombres') is-invalid @enderror" required>
                            @error('nombres') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Apellidos *</label>
                            <input type="text" name="apellidos" value="{{ old('apellidos') }}"
                                   class="form-control @error('apellidos') is-invalid @enderror" required>
                            @error('apellidos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono *</label>
                            <input type="text" name="telefono" value="{{ old('telefono') }}"
                                   class="form-control @error('telefono') is-invalid @enderror" required>
                            @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="direccion" value="{{ old('direccion') }}"
                                   class="form-control @error('direccion') is-invalid @enderror">
                            @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection