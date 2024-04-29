<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cambio;
use App\Models\Ordenador;

class RegistroHistorico extends Component
{
    public $ordenador_id;

    public function mount($ordenador_id)
    {
        $this->ordenador_id = $ordenador_id;
    }

    public function eliminar_cambios()
    {
        // Buscar todos los cambios relacionados con el ordenador actual
        $cambios = Cambio::where('ordenador_id', $this->ordenador_id)->get();

        // Eliminar cada cambio encontrado
        foreach ($cambios as $cambio) {
            $cambio->delete();
        }

        // Mostrar mensaje de éxito y recargar la página
        session()->flash('success', 'Los cambios se han eliminado correctamente.');
        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.registro-historico');
    }
}
