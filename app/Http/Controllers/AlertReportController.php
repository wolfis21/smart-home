<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Alert;

class AlertReportController extends Controller
{
    public function exportPdf()
    {
        // Obtener todas las alertas con los dispositivos asociados
        $alerts = Alert::with('device')->orderBy('created_at', 'desc')->get();
    
        // Generar el PDF a partir de la vista
        $pdf = Pdf::loadView('reports.alerts', compact('alerts'));
    
        // Descargar el archivo PDF
        return $pdf->download('reporte_alertas.pdf');
    }
    
}
