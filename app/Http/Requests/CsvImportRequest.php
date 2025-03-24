<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CsvImportRequest extends FormRequest
{

    /**
     * Meghatározza, hogy a felhasználó jogosult-e ezt a kérést végrehajtani.
     *
     * @return bool Mindig true, mert minden felhasználó jogosult az importálásra.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * A fájl validációs szabályainak megadása.
     *
     * @return array A validációs szabályok tömbként.
     */
    public function rules(): array
    {
        return [
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ];
    }

    /**
     * Egyedi hibaüzenetek meghatározása a validációhoz.
     *
     * @return array Egyedi hibaüzenetek tömbje.
     */
    public function messages(): array
    {
        return [
            'csv_file.required' => 'A fájl kiválasztása kötelező.',
            'csv_file.mimetypes' => 'A fájlnak CSV formátumúnak kell lennie.',
            'csv_file.max' => 'A fájl mérete nem haladhatja meg a 2 MB-ot.',
            'csv_file.uploaded' => 'A fájl feltöltése sikertelen. Próbáld újra!',
        ];
    }
}
