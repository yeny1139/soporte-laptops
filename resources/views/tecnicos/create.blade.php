@extends('layouts.app')

@section('title', 'Nuevo Técnico — Soporte Laptops')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Registrar Nuevo Técnico</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('tecnicos.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Código Técnico *</label>
                            <input type="text" name="codigo_tecnico" value="{{ old('codigo_tecnico') }}"
                                   placeholder="TEC-005" class="form-control @error('codigo_tecnico') is-invalid @enderror" required>
                            @error('codigo_tecnico') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">DNI *</label>
                            <input type="text" name="dni" maxlength="8" value="{{ old('dni') }}"
                                   class="form-control @error('dni') is-invalid @enderror" required>
                            @error('dni') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Cuenta de Usuario (opcional)</label>
                            <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                <option value="">-- Sin vincular --</option>
                                @foreach($usuariosTecnicos as $u)
                                    <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                                        {{ $u->name }} ({{ $u->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nombres *</label>
                            <input type="text" name="nombres" value="{{ old('nombres') }}"
                                   class="form-control @error('nombres') is-invalid @enderror" required>
                            @error('nombres') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellidos *</label>
                            <input type="text" name="apellidos" value="{{ old('apellidos') }}"
                                   class="form-control @error('apellidos') is-invalid @enderror" required>
                            @error('apellidos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Especialidad *</label>
                            <input type="text" name="especialidad" value="{{ old('especialidad') }}"
                                   placeholder="Ej. Microsoldadura, Pantallas, Software"
                                   class="form-control @error('especialidad') is-invalid @enderror" required>
                            @error('especialidad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo" checked>
                                <label class="form-check-label" for="activo">Técnico activo</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('tecnicos.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Técnico</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection