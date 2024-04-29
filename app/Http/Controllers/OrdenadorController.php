<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Cambio;
use App\Models\Ordenador;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Exists;

//para imágenes:
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class OrdenadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $order = $request->query('order', 'marca');
        $order_dir = $request->query('order_dir', 'asc');

        $ordenadores = Ordenador::leftJoin('aulas', 'ordenadores.aula_id', '=', 'aulas.id')
            ->select('ordenadores.*')
            ->orderBy($order, $order_dir)
            ->get();


        return view('ordenadores.index', [
            'ordenadores' => $ordenadores,
            'order' => $order,
            'order_dir' => $order_dir
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

        $ordenador = new Ordenador();                 //img
        $imagen = $request->file('foto');            //img
        Storage::makeDirectory('public/album');      //img
        $nombre = Carbon::now() . '.jpeg';          //img
        $manager = new ImageManager(new Driver());  //img

        $ordenador->guardar_imagen($imagen, $nombre, 100, $manager);    //img

        //$ordenador = new Ordenador();    si no hay que añadir img se descomenta
        $ordenador->marca = $validated['marca'];
        $ordenador->modelo = $validated['modelo'];
        $ordenador->aula_id = $validated['aula_id'];
        $ordenador->foto = $nombre;     //si no img, se quita esta linea
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

        $imagen = $request->file('foto');            //img
        Storage::makeDirectory('public/album');      //img
        $nombre = Carbon::now() . '.jpeg';          //img
        $manager = new ImageManager(new Driver());  //img

        $ordenador->guardar_imagen($imagen, $nombre, 100, $manager);    //img


        $ordenador->marca = $validated['marca'];
        $ordenador->modelo = $validated['modelo'];
        $ordenador->aula_id = $validated['aula_id'];
        $ordenador->foto = $nombre;     //si no img, se quita esta linea
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
