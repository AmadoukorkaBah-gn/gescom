<?php

namespace App\Http\Controllers;

use App\Exports\VentesExport;
use App\Models\Vente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class VenteExportController extends Controller
{
    private function getVentesQuery(Request $request)
    {
        $ownerId = Auth::user()->getOwnerId();

        $query = Vente::where('user_id', $ownerId)
            ->with('client')
            ->orderBy('date_vente', 'desc');

        if ($request->filled('date_debut')) {
            $query->whereDate('date_vente', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('date_vente', '<=', $request->date_fin);
        }

        return $query;
    }

    public function pdf(Request $request)
    {
        $ventes = $this->getVentesQuery($request)->get();

        $pdf = Pdf::loadView('ventes.exports.pdf', [
            'ventes' => $ventes,
            'dateDebut' => $request->date_debut,
            'dateFin' => $request->date_fin,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('ventes_' . now()->format('Y-m-d_His') . '.pdf');
    }

    public function excel(Request $request)
    {
        return Excel::download(
            new VentesExport($request->date_debut, $request->date_fin),
            'ventes_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }
}