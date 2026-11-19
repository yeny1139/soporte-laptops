<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\OrdenServicio;
use App\Models\Tecnico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdenServicioController extends Controller
{
    public function index(Request $request)
    {
        $estado = $request->input('estado');
        $buscar = $request->input('buscar');
        $user   = Auth::user();

        $ordenes = OrdenServicio::with(['cliente', 'tecnico', 'reparacion'])
            ->when($user->rol === 'tecnico' && $user->tecnico, function ($query) use ($user) {
                $query->where('tecnico_id', $user->tecnico->id);
            })
            ->when($estado, function ($query, $estado) {
                $query->where('estado', $estado);
            })
            ->when($buscar, function ($query, $buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('codigo_orden', 'like', "%{$buscar}%")
                      ->orWhere('marca_laptop', 'like', "%{$buscar}%")
                      ->orWhere('modelo_laptop', 'like', "%{$buscar}%")
                      ->orWhereHas('cliente', function ($qc) use ($buscar) {
                          $qc->where('nombres', 'like', "%{$buscar}%")
                             ->orWhere('apellidos', 'like', "%{$buscar}%")
                             ->orWhere('dni', 'like', "%{$buscar}%");
                      });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('ordenes.index', compact('ordenes', 'estado', 'buscar'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('apellidos')->get();
        $tecnicos = Tecnico::where('activo', true)->orderBy('apellidos')->get();

        $siguienteId = (OrdenServicio::max('id') ?? 0) + 1;
        $codigoSugerido = 'ORD-' . str_pad($siguienteId, 5, '0', STR_PAD_LEFT);

        return view('ordenes.create', compact('clientes', 'tecnicos', 'codigoSugerido'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo_orden'       => ['required', 'string', 'max:20', 'unique:ordenes_servicio,codigo_orden'],
            'cliente_id'         => ['required', 'exists:clientes,id'],
            'tecnico_id'         => ['nullable', 'exists:tecnicos,id'],
            'marca_laptop'       => ['required', 'string', 'max:80'],
            'modelo_laptop'      => ['required', 'string', 'max:100'],
            'numero_serie'       => ['nullable', 'string', 'max:100'],
            'problema_reportado' => ['required', 'string'],
            'accesorios'         => ['nullable', 'string', 'max:255'],
            'estado'             => ['required', 'in:pendiente,en_proceso,reparada,cancelada'],
        ]);

        OrdenServicio::create($data);

        return redirect()->route('ordenes.index')
            ->with('success', 'Orden de servicio registrada correctamente.');
    }

    public function show(OrdenServicio $ordene)
    {
        $ordene->load(['cliente', 'tecnico', 'reparacion']);

        return view('ordenes.show', ['orden' => $ordene]);
    }

    public function edit(OrdenServicio $ordene)
    {
        $clientes = Cliente::orderBy('apellidos')->get();
        $tecnicos = Tecnico::where('activo', true)
            ->orWhere('id', $ordene->tecnico_id)
            ->orderBy('apellidos')
            ->get();

        return view('ordenes.edit', [
            'orden'    => $ordene,
            'clientes' => $clientes,
            'tecnicos' => $tecnicos,
        ]);
    }

    public function update(Request $request, OrdenServicio $ordene)
    {
        $data = $request->validate([
            'codigo_orden'       => ['required', 'string', 'max:20', 'unique:ordenes_servicio,codigo_orden,' . $ordene->id],
            'cliente_id'         => ['required', 'exists:clientes,id'],
            'tecnico_id'         => ['nullable', 'exists:tecnicos,id'],
            'marca_laptop'       => ['required', 'string', 'max:80'],
            'modelo_laptop'      => ['required', 'string', 'max:100'],
            'numero_serie'       => ['nullable', 'string', 'max:100'],
            'problema_reportado' => ['required', 'string'],
            'accesorios'         => ['nullable', 'string', 'max:255'],
            'estado'             => ['required', 'in:pendiente,en_proceso,reparada,cancelada'],
        ]);

        $ordene->update($data);

        return redirect()->route('ordenes.show', $ordene)
            ->with('success', 'Orden de servicio actualizada.');
    }

    public function destroy(OrdenServicio $ordene)
    {
        if ($ordene->reparacion()->exists()) {
            return back()->with('error', 'No se puede eliminar una orden que ya tiene una reparación registrada.');
        }

        $ordene->delete();

        return redirect()->route('ordenes.index')
            ->with('success', 'Orden de servicio eliminada.');
    }
}