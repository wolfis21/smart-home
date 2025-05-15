<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Automation;

class ReportController extends Controller
{
    public function exportPdf()
    {
        // Obtener todas las automatizaciones
        $automations = Automation::all();

        // Cargar la vista y pasar los datos
        $pdf = Pdf::loadView('reports.automation', compact('automations'));

        // Descargar el archivo PDF
        return $pdf->download('automatizaciones.pdf');
    }
}
