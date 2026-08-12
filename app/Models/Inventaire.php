<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
    protected $fillable = [
        'user_id',
        'reference',
        'date_inventaire',
        'statut',
        'total_gain',
        'total_perte',
        'date_cloture',
    ];

    protected $casts = [
        'date_inventaire' => 'datetime',
        'date_cloture' => 'datetime',
        'total_gain' => 'decimal:2',
        'total_perte' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(InventaireDetail::class);
    }

    public function estCloture()
    {
        return $this->statut === 'cloture';
    }
}