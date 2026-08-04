<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RapportCache extends Model
{
    protected $table = 'rapports_cache';

    protected $fillable = [
        'type_rapport',
        'data',
        'filtres',
        'date_generation',
        'valide_jusqu',
    ];

    protected $casts = [
        'data' => 'array', // Convertit JSON en array automatiquement
        'filtres' => 'array',
        'date_generation' => 'datetime',
        'valide_jusqu' => 'datetime',
    ];

    /**
     * Vérifie si le cache est encore valide
     */
    public function isValid(): bool
    {
        return now()->lessThanOrEqualTo($this->valide_jusqu);
    }

    /**
     * Récupère un rapport en cache s'il est valide
     */
    public static function getValid(string $typeRapport, array $filtres = []): ?RapportCache
    {
        return self::where('type_rapport', $typeRapport)
            ->where('valide_jusqu', '>', now())
            ->first();
    }

    /**
     * Crée ou met à jour un cache de rapport
     */
    public static function storeReport(string $typeRapport, array $data, array $filtres = [], int $validityHours = 24): RapportCache
    {
        return self::updateOrCreate(
            ['type_rapport' => $typeRapport],
            [
                'data' => $data,
                'filtres' => $filtres,
                'date_generation' => now(),
                'valide_jusqu' => now()->addHours($validityHours),
            ]
        );
    }
}
