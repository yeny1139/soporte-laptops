<?php

namespace App\Http\Controllers;

use App\Models\OrdenServicio;
use App\Models\Reparacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReparacionController extends Controller
{
    public function index()
    {
        $reparaciones = Reparacion::with(['ordenServicio.cliente', 'ordenServicio.tecnico'])
            ->latest()
            ->paginate(10);

        return view('reparaciones.index', compact('reparaciones'));
    }

    public function create(Request $request)
    {
        $ordenSeleccionadaId = $request->input('orden_id');

        $ordenesDisponibles = OrdenServicio::with('cliente')
            ->whereDoesntHave('reparacion')
            ->where('estado', '!=', 'cancelada')
            ->orderByDesc('id')
            ->get();

        return view('reparaciones.create', compact('ordenesDisponibles', 'ordenSeleccionadaId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'orden_servicio_id' => ['required', 'exists:ordenes_servicio,id', 'unique:reparaciones,orden_servicio_id'],
            'diagnostico'       => ['required', 'string'],
            'trabajo_realizado' => ['required', 'string'],
            'repuestos_usados'  => ['nullable', 'string', 'max:255'],
            'costo_servicio'    => ['required', 'numeric', 'min:0'],
            'fecha_entrega'     => ['nullable', 'date'],
        ]);

        DB::transaction(function () use ($data) {
            Reparacion::create($data);

            OrdenServicio::where('id', $data['orden_servicio_id'])
                ->update(['estado' => 'reparada']);
        });

        return redirect()->route('reparaciones.index')
            ->with('success', 'Reparación registrada y orden marcada como reparada.');
    }

    public function show(Reparacion $reparacione)
    {
        $reparacione->load(['ordenServicio.cliente', 'ordenServicio.tecnico']);

        return view('reparaciones.show', ['reparacion' => $reparacione]);
    }

    public function edit(Reparacion $reparacione)
    {
        $reparacione->load('ordenServicio.cliente');

        return view('reparaciones.edit', ['reparacion' => $reparacione]);
    }

    public function update(Request $request, Reparacion $reparacione)
    {
        $data = $request->validate([
            'diagnostico'       => ['required', 'string'],
            'trabajo_realizado' => ['required', 'string'],
            'repuestos_usados'  => ['nullable', 'string', 'max:255'],
            'costo_servicio'    => ['required', 'numeric', 'min:0'],
            'fecha_entrega'     => ['nullable', 'date'],
        ]);

        $reparacione->update($data);

        return redirect()->route('reparaciones.show', $reparacione)
            ->with('success', 'Informe de reparación actualizado.');
    }

    public function destroy(Reparacion $reparacione)
    {
        DB::transaction(function () use ($reparacione) {
            $ordenId = $reparacione->orden_servicio_id;
            $reparacione->delete();

            OrdenServicio::where('id', $ordenId)
                ->update(['estado' => 'en_proceso']);
        });

        return redirect()->route('reparaciones.index')
            ->with('success', 'Reparación eliminada y orden devuelta a estado En Proceso.');
    }
}