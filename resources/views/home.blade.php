<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fejlesztői próbafeladat</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="mb-3">Fejlesztői próbafeladat</h1>
                <!-- Importálás és Exportálás form -->
                <div class="card">
                    <div class="card-header">
                        <h5>CSV Importálás</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif

                        <form action="{{ route('csv.import') }}" method="POST" enctype="multipart/form-data"
                            class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label for="csv_file" class="form-label">Válassz egy CSV fájlt</label>
                                <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Importálás</button>
                        </form>
                    </div>
                    <div class="card-header">
                        <h5>XML exportálás</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('product-feed-download') }}" class="btn btn-success">XML exportálás</a>
                        <a href="{{ route('product-feed-view') }}" class="btn btn-warning" target="_blank">XML megtekintés</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5>SQL lekérdezés</h5>
                    </div>
                    <div class="card-body">
                        <pre>
WITH LatestPrices AS (
    SELECT
        ph.product_id,
        ph.price,
        ph.updated_at,
        ROW_NUMBER() OVER (PARTITION BY ph.product_id ORDER BY ph.updated_at DESC) AS rn
    FROM price_history ph
    WHERE ph.updated_at <= '2024-01-15' -- A kívánt időpont
)
SELECT 
    pp.id AS product_package_id,
    pp.title AS product_package_title,
    SUM(lr.price * ppc.quantity) AS package_price
FROM 
    product_packages pp
JOIN 
    product_package_contents ppc ON pp.id = ppc.product_package_id
JOIN 
    products p ON ppc.product_id = p.id
JOIN 
    LatestPrices lr ON p.id = lr.product_id
WHERE 
    pp.id = 2 -- A kívánt termékcsomag ID-ja
    AND lr.rn = 1
GROUP BY 
    pp.id;</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>