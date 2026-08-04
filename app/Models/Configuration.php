<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [
        'user_id',
        'nom_entreprise',
        'logo',
        'contact',
        'email_entreprise',
        'adresse',
        'devise',
        'symbole_devise',
        'couleur_primaire',
        'couleur_secondaire',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir la configuration de l'utilisateur connecté ou de son parent admin
     */
    public static function getForCurrentUser()
    {
        $user = auth()->user();
        
        if (!$user) {
            return null;
        }

        // Si l'utilisateur est un sous-utilisateur, récupérer la config du parent
        if ($user->parent_id) {
            return self::where('user_id', $user->parent_id)->first();
        }

        return self::where('user_id', $user->id)->first();
    }

    /**
     * Obtenir la devise formatée
     */
    public static function getDevise()
    {
        $config = self::getForCurrentUser();
        return $config ? $config->symbole_devise : 'GNF';
    }
}
