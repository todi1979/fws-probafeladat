<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvImportRequest;
use App\Models\Product;
use App\Models\ProductCategory;

class CsvImportController extends Controller
{

    /**
     * CSV fájl importálása és termékek hozzáadása az adatbázishoz.
     *
     * @param CsvImportRequest $request A CSV importálási kérés, amely validálja a feltöltött fájlt.
     * @return \Illuminate\Http\RedirectResponse Visszatérési érték: sikeres vagy hibás import esetén visszairányítás az előző oldalra.
     */
    public function import(CsvImportRequest $request)
    {
        $file = $request->file('csv_file');

        // MIME típus ellenőrzése
        if ($file->getMimeType() !== 'text/csv' &&
            ($file->getMimeType() == 'text/plain' && $file->getClientOriginalExtension() !== 'csv') &&
            $file->getMimeType() !== 'application/csv') {
            return back()->withErrors(['csv_file' => 'Csak CSV fájlokat engedélyezünk.']);
        }

        $path = $file->getRealPath();
        $handle = fopen($path, "r");

        // Az első sor beolvasása (fejléc)
        $header = fgetcsv($handle);

        // Sorok beolvasása és feldolgozása
        while (($row = fgetcsv($handle)) !== false) {
            $productName = $row[0] ?? null;
            $price = isset($row[1]) ? (int) $row[1] : null;
            $categories = array_slice($row, 2);

            // Ha a név vagy az ár nincs megadva, akkor a sort kihagyjuk
            if (!$productName || !$price) {
                continue;
            }

            // Termék keresése vagy létrehozása
            $product = Product::updateOrCreate(
                ['product_name' => $productName],
                ['price' => $price]
            );

            // Kategóriák feldolgozása és hozzárendelése a termékhez
            $categoryIds = [];
            foreach ($categories as $categoryName) {
                if ($categoryName) {
                    $category = ProductCategory::firstOrCreate(['category_name' => $categoryName]);
                    $categoryIds[] = $category->id;
                }
            }

            // Kapcsolatok frissítése (termék és kategóriák összerendelése)
            $product->categories()->sync($categoryIds);
        }

        fclose($handle);

        return back()->with('success', 'CSV importálás sikeres!');
    }
}
