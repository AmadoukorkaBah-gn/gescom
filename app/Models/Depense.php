<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    protected $fillable = [
        'libelle',
        'montant',
        'date_depense',
        'caisse_id',
        'user_id',
    ];

    protected $casts = [
        'date_depense' => 'datetime',
    ];

    public function caisse()
    {
        return $this->belongsTo(Caisse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
