<?php

namespace App\Exports;

use App\Models\Programacion;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProgramacionExport implements FromView, ShouldAutoSize
{
    protected $programacionId;

    public function __construct($programacionId)
    {
        $this->programacionId = $programacionId;
    }

    public function view(): View
    {
        $programacion = Programacion::with([
            'detalles.programa',
            'detalles.competencia',
            'detalles.resultadoAprendizaje'
        ])->findOrFail($this->programacionId);

        return view('exports.programacion', [
            'instructor' => auth()->user(),
            'mes' => $programacion->mes_anio,
            'programacion' => $programacion,
            'programaciones' => $programacion->detalles
        ]);
    }
}