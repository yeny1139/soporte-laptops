<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $clientes = Cliente::withCount('ordenesServicio')
            ->when($buscar, function ($query, $buscar) {
                $query->where('dni', 'like', "%{$buscar}%")
                      ->orWhere('nombres', 'like', "%{$buscar}%")
                      ->orWhere('apellidos', 'like', "%{$buscar}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('clientes.index', compact('clientes', 'buscar'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'dni'       => ['required', 'digits:8', 'unique:clientes,dni'],
            'nombres'   => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'telefono'  => ['required', 'string', 'max:20'],
            'email'     => ['nullable', 'email', 'max:120'],
            'direccion' => ['nullable', 'string', 'max:255'],
        ]);

        Cliente::create($data);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente registrado correctamente.');
    }

    public function show(Cliente $cliente)
    {
        $cliente->load(['ordenesServicio.tecnico']);

        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $data = $request->validate([
            'dni'       => ['required', 'digits:8', 'unique:clientes,dni,' . $cliente->id],
            'nombres'   => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'telefono'  => ['required', 'string', 'max:20'],
            'email'     => ['nullable', 'email', 'max:120'],
            'direccion' => ['nullable', 'string', 'max:255'],
        ]);

        $cliente->update($data);

        return redirect()->route('clientes.index')
            ->with('success', 'Datos del cliente actualizados.');
    }

    public function destroy(Cliente $cliente)
    {
        if ($cliente->ordenesServicio()->exists()) {
            return back()->with('error', 'No se puede eliminar un cliente que tiene órdenes de servicio registradas.');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}