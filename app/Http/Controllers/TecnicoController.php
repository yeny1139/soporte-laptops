<?php

namespace App\Http\Controllers;

use App\Models\Tecnico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TecnicoController extends Controller
{
    private function autorizarAdmin()
    {
        if (Auth::user()->rol !== 'administrador') {
            abort(403, 'Acceso restringido solo para administradores.');
        }
    }

    public function index()
    {
        $this->autorizarAdmin();

        $tecnicos = Tecnico::withCount('ordenesServicio')
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('tecnicos.index', compact('tecnicos'));
    }

    public function create()
    {
        $this->autorizarAdmin();

        $usuariosTecnicos = User::where('rol', 'tecnico')
            ->whereDoesntHave('tecnico')
            ->get();

        return view('tecnicos.create', compact('usuariosTecnicos'));
    }

    public function store(Request $request)
    {
        $this->autorizarAdmin();

        $data = $request->validate([
            'user_id'        => ['nullable', 'exists:users,id', 'unique:tecnicos,user_id'],
            'dni'            => ['required', 'digits:8', 'unique:tecnicos,dni'],
            'nombres'        => ['required', 'string', 'max:100'],
            'apellidos'      => ['required', 'string', 'max:100'],
            'especialidad'   => ['required', 'string', 'max:120'],
            'codigo_tecnico' => ['required', 'string', 'max:20', 'unique:tecnicos,codigo_tecnico'],
            'activo'         => ['nullable', 'boolean'],
        ]);

        $data['activo'] = $request->boolean('activo', true);

        Tecnico::create($data);

        return redirect()->route('tecnicos.index')
            ->with('success', 'Técnico registrado correctamente.');
    }

    public function show(Tecnico $tecnico)
    {
        $this->autorizarAdmin();

        $tecnico->load(['user', 'ordenesServicio.cliente']);

        return view('tecnicos.show', compact('tecnico'));
    }

    public function edit(Tecnico $tecnico)
    {
        $this->autorizarAdmin();

        $usuariosTecnicos = User::where('rol', 'tecnico')
            ->where(function ($query) use ($tecnico) {
                $query->whereDoesntHave('tecnico')
                      ->orWhere('id', $tecnico->user_id);
            })
            ->get();

        return view('tecnicos.edit', compact('tecnico', 'usuariosTecnicos'));
    }

    public function update(Request $request, Tecnico $tecnico)
    {
        $this->autorizarAdmin();

        $data = $request->validate([
            'user_id'        => ['nullable', 'exists:users,id', 'unique:tecnicos,user_id,' . $tecnico->id],
            'dni'            => ['required', 'digits:8', 'unique:tecnicos,dni,' . $tecnico->id],
            'nombres'        => ['required', 'string', 'max:100'],
            'apellidos'      => ['required', 'string', 'max:100'],
            'especialidad'   => ['required', 'string', 'max:120'],
            'codigo_tecnico' => ['required', 'string', 'max:20', 'unique:tecnicos,codigo_tecnico,' . $tecnico->id],
            'activo'         => ['nullable', 'boolean'],
        ]);

        $data['activo'] = $request->boolean('activo');

        $tecnico->update($data);

        return redirect()->route('tecnicos.index')
            ->with('success', 'Datos del técnico actualizados.');
    }

    public function destroy(Tecnico $tecnico)
    {
        $this->autorizarAdmin();

        if ($tecnico->ordenesServicio()->exists()) {
            return back()->with('error', 'No se puede eliminar un técnico con órdenes asignadas. Márcalo como inactivo.');
        }

        $tecnico->delete();

        return redirect()->route('tecnicos.index')
            ->with('success', 'Técnico eliminado correctamente.');
    }
}