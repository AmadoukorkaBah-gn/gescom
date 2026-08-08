<?php

namespace App\Exports;

use App\Models\Vente;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VentesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $dateDebut;
    protected $dateFin;

    public function __construct($dateDebut = null, $dateFin = null)
    {
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
    }

    public function collection()
    {
        $ownerId = Auth::user()->getOwnerId();

        $query = Vente::where('user_id', $ownerId)
            ->with('client')
            ->orderBy('date_vente', 'desc');

        if ($this->dateDebut) {
            $query->whereDate('date_vente', '>=', $this->dateDebut);
        }
        if ($this->dateFin) {
            $query->whereDate('date_vente', '<=', $this->dateFin);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'N° Vente',
            'Date',
            'Client',
            'Montant brut',
            'Remise',
            'Montant total',
            'Statut',
        ];
    }

    public function map($vente): array
    {
        return [
            $vente->id,
            $vente->date_vente->format('d/m/Y H:i'),
            $vente->client->nom_client ?? '-',
            number_format($vente->montant_brut ?? $vente->montant_total, 2, ',', ' '),
            number_format($vente->montant_remise ?? 0, 2, ',', ' '),
            number_format($vente->montant_total, 2, ',', ' '),
            ucfirst(str_replace('_', ' ', $vente->statut)),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}