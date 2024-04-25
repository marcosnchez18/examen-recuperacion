<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//para imágenes:
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
        $cambios = Cambio::where('ordenador_id', $this->id)->get();   //obtener todas las filas
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
        $cuantos = Dispositivo::where('colocable_id', $this->id)->count();
        return $cuantos;
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



    //para imágenes:

    private function imagen_url_relativa()
   {
       return '/uploads/' . $this->foto;
   }


   public function getImagenUrlAttribute()
   {
       return Storage::url(mb_substr($this->imagen_url_relativa(), 1));
   }


   public function existeImagen()
   {
       return Storage::disk('public')->exists($this->imagen_url_relativa());
   }


   public function guardar_imagen(UploadedFile $imagen, string $nombre, int $escala, ?ImageManager $manager = null)
   {
       if ($manager === null) {
           $manager = new ImageManager(new Driver());
       }
       Storage::makeDirectory('public/uploads');
       $imagen = $manager->read($imagen);
       $imagen->scaleDown($escala);
       $ruta = Storage::path('public/uploads/' . $nombre);
       $imagen->save($ruta);
   }

}
