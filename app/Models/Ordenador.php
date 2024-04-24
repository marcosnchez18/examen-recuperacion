<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordenador extends Model
{
    use HasFactory;

    protected $table = 'ordenadores'; //proteccion ordenadors

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function cambios()
    {
        return $this->hasMany(Cambio::class);
    }

    public function dispositivos()
    {
        return $this->morphMany(Dispositivo::class, 'colocable');
    }

    public function comprueba_origen()
    {
        $cambio = Cambio::where('ordenador_id', $this->id)->first();

        if ($cambio) {
            $origen_id = $cambio->origen_id;
            $aula = Aula::find($origen_id);
            return $aula->nombre;
        } else {

            return 'Sin cambio';
        }
    }

    public function comprueba_destino()
    {
        $cambio = Cambio::where('ordenador_id', $this->id)->first();

        if ($cambio) {
            $destino_id = $cambio->destino_id;
            $aula = Aula::find($destino_id);
            return $aula->nombre;
        } else {

            return 'Sin cambio';
        }
    }

    public function fecha_cambio()
    {

        $cambio = Cambio::where('ordenador_id', $this->id)->first();
        if ($cambio) {
            $fecha = $cambio->updated_at;
            return $fecha;
        } else {
            return 'Sin cambio';
        }
    }

    public function cantidad_dispositivos()
    {
        return Dispositivo::where('colocable_id', $this->id)->count();
    }

    public function dispositivos_contenidos()
    {
        $dispositivos = Dispositivo::where('colocable_id', $this->id)->get();
        

        if ($dispositivos->isEmpty()) {
            return 'Sin dispositivos';
        }

        $nombres = [];

        foreach ($dispositivos as $dispositivo) {
            $nombres[] = $dispositivo->nombre;
        }

        return implode(', ', $nombres);
    }
}
