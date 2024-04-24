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
        $cambios = Cambio::where('ordenador_id', $this->id)->get();
        $aulas_origen = '';
        foreach ($cambios as $cambio) {
            $origen_id = $cambio->origen_id;
            $aula = Aula::find($origen_id);
            $aulas_origen .= '<li>' . $aula->nombre . '</li>';
        }
        return $aulas_origen ? '<ul>' . $aulas_origen . '</ul>' : 'Sin cambio';
    }


    public function comprueba_destino()
    {
        $cambios = Cambio::where('ordenador_id', $this->id)->get();
        $aulas_destino = '';
        foreach ($cambios as $cambio) {
            $destino_id = $cambio->destino_id;
            $aula = Aula::find($destino_id);
            $aulas_destino .= '<li>' . $aula->nombre . '</li>';
        }
        // Si hay aulas de destino, devolverlas en una lista HTML
        // Si no hay cambios, devolver 'Sin cambio'
        return $aulas_destino ? '<ul>' . $aulas_destino . '</ul>' : 'Sin cambio';
    }


    public function fecha_cambio()
    {

        $cambios = Cambio::where('ordenador_id', $this->id)->get();
        $fechas = '';
        foreach ($cambios as $cambio) {
                $fechas .= '<li>' . $cambio->updated_at . '</li>';
            }
            return $fechas ? '<ul>' . $fechas . '</ul>' : 'Sin cambio';
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
