<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Cambio;
use App\Models\Ordenador;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Exists;

class OrdenadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ordenadores.index', [
            'ordenadores' => Ordenador::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ordenadores.create', [
            'aulas' => Aula::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'marca' => 'required|max:255',
            'modelo' => 'required|max:255',
            'aula_id' => 'required|exists:aulas,id',
        ]);

        $ordenador = new Ordenador();
        $ordenador->marca = $validated['marca'];
        $ordenador->modelo = $validated['modelo'];
        $ordenador->aula_id = $validated['aula_id'];
        $ordenador->save();

        session()->flash('success', 'El ordenador se ha creado correctamente.');
        return redirect()->route('ordenadores.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ordenador $ordenador)
    {
        return view('ordenadores.show', [
            'ordenador' => $ordenador,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ordenador $ordenador)
    {
        return view('ordenadores.edit', [

            'ordenador' => $ordenador,
            'aulas' => Aula::all(),

        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ordenador $ordenador)
    {
        if ($ordenador->aula_id != $request->aula_id) {
            $cambio = new Cambio();
            $cambio->ordenador_id = $ordenador->id;
            $cambio->origen_id = $ordenador->aula_id;
            $cambio->destino_id = $request->aula_id;
            $cambio->save();
        }

        $validated = $request->validate([
            'marca' => 'required|max:255',
            'modelo' => 'required|max:255',
            'aula_id' => 'required|exists:aulas,id',
        ]);
        $ordenador->marca = $validated['marca'];
        $ordenador->modelo = $validated['modelo'];
        $ordenador->aula_id = $validated['aula_id'];
        $ordenador->save();
        return redirect()->route('ordenadores.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ordenador $ordenador)
    {
        $cambios = Cambio::where('ordenador_id', $ordenador->id)->get();

        foreach ($cambios as $cambio) {
            $cambio->delete();
        }

        $ordenador->delete();
        session()->flash('success', 'El ordenador se ha eliminado correctamente.');
        return redirect()->route('ordenadores.index');
    }
}
