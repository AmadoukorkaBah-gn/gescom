<?php

use App\Models\Configuration;

if (!function_exists('devise')) {
    /**
     * Obtenir le symbole de la devise de l'utilisateur
     */
    function devise(): string
    {
        return Configuration::getDevise();
    }
}

if (!function_exists('formatMoney')) {
    /**
     * Formater un montant avec la devise
     */
    function formatMoney($amount, $decimals = 2): string
    {
        return number_format($amount, $decimals) . ' ' . devise();
    }
}
