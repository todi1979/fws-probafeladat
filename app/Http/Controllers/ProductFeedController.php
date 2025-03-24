<?php

namespace App\Http\Controllers;

use App\Services\ProductXmlService;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\Support\Facades\Storage;

class ProductFeedController extends Controller
{

    protected $productXmlService;

    /**
     * Konstruktor a termék XML szolgáltatás inicializálásához.
     *
     * @param ProductXmlService $productXmlService Az XML feed generálását végző szolgáltatás.
     */
    public function __construct(ProductXmlService $productXmlService)
    {
        $this->productXmlService = $productXmlService;
    }

    /**
     * XML feed generálása és letöltése.
     *
     * Ez a metódus legenerálja a termékek XML feedjét, elmenti egy fájlba, majd letöltésre kínálja.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse Az XML fájl letöltése.
     */
    public function generateFeedDownload()
    {
        $xmlContent = $this->productXmlService->generateXml();
        $fileName = 'product_feed.xml';

        Storage::put($fileName, $xmlContent);

        return ResponseFacade::download(storage_path('app/public/'.$fileName), $fileName, [
            'Content-Type' => 'application/xml',
        ]);
    }

    /**
     * XML feed generálása és megjelenítése a böngészőben.
     *
     * Ez a metódus legenerálja a termékek XML feedjét és közvetlenül visszaadja a válaszban.
     *
     * @return \Illuminate\Http\Response Az XML feed tartalmát tartalmazó HTTP válasz.
     */
    public function generateFeedView()
    {
        $xmlContent = $this->productXmlService->generateXml();

        return ResponseFacade::make($xmlContent, 200)
            ->header('Content-Type', 'application/xml');
    }

}
