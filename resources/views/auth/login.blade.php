@extends('layouts.app')

@section('title', 'Iniciar Sesión — Soporte Laptops')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <i class="bi bi-laptop text-primary" style="font-size: 2.5rem;"></i>
                    <h4 class="fw-bold mt-2 mb-0">Soporte Laptops</h4>
                    <p class="text-muted small">Acceso al sistema de gestión del taller</p>
                </div>

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="admin@soporte.test" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label for="remember" class="form-check-label small">Mantener sesión iniciada</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Ingresar
                    </button>
                </form>

                <hr class="my-4">
                <div class="small text-muted">
                    <div class="fw-semibold mb-1">Cuentas de prueba (clave: <code>password</code>):</div>
                    <div>• <code>admin@soporte.test</code> (Administrador)</div>
                    <div>• <code>recepcion@soporte.test</code> (Recepción)</div>
                    <div>• <code>tecnico@soporte.test</code> (Técnico)</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection