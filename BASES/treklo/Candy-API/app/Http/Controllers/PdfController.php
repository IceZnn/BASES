<?php
namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DoceModel;

class PdfController extends Controller
{
    public function exportar_pdf() {
        $doces = DoceModel::all();
        $total = $doces->sum('Preco');
        $qtd   = $doces->sum('Quantidade');
        $data  = now()->format('d/m/Y H:i');

        $pdf = Pdf::loadView('pdf.pdf', compact('doces', 'total', 'qtd', 'data'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('relatorio-eversweet.pdf');
    }
}