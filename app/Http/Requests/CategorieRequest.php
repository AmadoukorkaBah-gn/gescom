<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategorieRequest extends FormRequest
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
        $categorieId = $this->route('categorie') ? $this->route('categorie')->id : null;

        $uniqueRule = 'unique:categories,nom_categorie';
        if ($categorieId) {
            $uniqueRule .= ',' . $categorieId;
        }

        return [
            'nom_categorie' => ['required', 'string', 'max:255', $uniqueRule],
        ];
    }
}
