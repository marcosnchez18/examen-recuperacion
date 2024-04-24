<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    public function ordenadores()
    {
        return $this->hasMany(Ordenador::class);
    }

    public function cambioOrigen()
    {
        return $this->hasMany(Cambio::class, 'origen_id');
    }

    public function cambioDestino()
    {
        return $this->hasMany(Cambio::class, 'destino_id');
    }

    public function dispositivos()
    {
        return $this->morphMany(Dispositivo::class, 'colocable');
    }
}
