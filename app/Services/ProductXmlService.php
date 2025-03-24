<?php

namespace App\Services;

use App\Models\Product;
use SimpleXMLElement;

class ProductXmlService
{

    /**
     * XML feed generálása a termékekből.
     *
     * A metódus lekéri az összes terméket a hozzájuk tartozó kategóriákkal együtt,
     * majd ezekből dinamikusan épít fel egy XML struktúrát.
     *
     * @return string A generált XML tartalom szövegként.
     */
    public function generateXml()
    {
        // Termékek lekérése kategóriákkal együtt
        $products = Product::with('categories')->get();

        // Új XML dokumentum létrehozása, alap elemmel: <products>
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><products></products>');

        foreach ($products as $product) {
            // Termék elem hozzáadása
            $productNode = $xml->addChild('product');

            // Termék neve és ára hozzáadása
            $productNode->addChild('title', htmlspecialchars($product->product_name));
            $productNode->addChild('price', $product->price);

            // Kategóriák hozzáadása a termékhez
            $categoriesNode = $productNode->addChild('categories');
            if ($product->categories->isNotEmpty()) {
                foreach ($product->categories as $category) {
                    $categoriesNode->addChild('category', htmlspecialchars($category->category_name));
                }
            }
        }

        // Az XML visszaadása szöveges formában
        return $xml->asXML();
    }
}
