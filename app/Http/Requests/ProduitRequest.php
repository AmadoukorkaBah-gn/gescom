<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProduitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nom_produit'        => 'required|string|max:255',
            'categorie_id'       => 'required|exists:categories,id',
            'fournisseur_id'     => 'nullable|exists:fournisseurs,id',
            'prix_produit'       => 'required|numeric|min:0',
            'prix_vente'         => 'required|numeric|min:0',
            'stock_minimum'      => 'required|integer|min:0',
            'quantite_initiale'  => 'nullable|integer|min:0',
            'statut'             => 'required|boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
    'statut' => $this->statut == '1' ? true : false,
]);
    }
}