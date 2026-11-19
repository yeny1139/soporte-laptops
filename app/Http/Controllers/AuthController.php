<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\OrdenServicio;
use App\Models\Reparacion;
use App\Models\Tecnico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales ingresadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        $user = Auth::user();

        $resumen = [
            'clientes'     => Cliente::count(),
            'tecnicos'     => Tecnico::where('activo', true)->count(),
            'pendientes'   => OrdenServicio::where('estado', 'pendiente')->count(),
            'en_proceso'   => OrdenServicio::where('estado', 'en_proceso')->count(),
            'reparadas'    => OrdenServicio::where('estado', 'reparada')->count(),
            'ingresos'     => Reparacion::sum('costo_servicio'),
        ];

        $ultimasOrdenes = OrdenServicio::with(['cliente', 'tecnico'])
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact('user', 'resumen', 'ultimasOrdenes'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}