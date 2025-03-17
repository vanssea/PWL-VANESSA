<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food & Beverage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Food & Beverage</a>
            <a class="btn btn-light" href="{{ url('/') }}">Home</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Kategori: Food & Beverage</h2>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Produk 1">
                    <div class="card-body">
                        <h5 class="card-title">Minuman Segar</h5>
                        <p class="card-text">Harga: Rp 10.000</p>
                        <a href="#" class="btn btn-primary">Beli</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Produk 2">
                    <div class="card-body">
                        <h5 class="card-title">Makanan Ringan</h5>
                        <p class="card-text">Harga: Rp 15.000</p>
                        <a href="#" class="btn btn-primary">Beli</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Produk 3">
                    <div class="card-body">
                        <h5 class="card-title">Makanan Berat</h5>
                        <p class="card-text">Harga: Rp 25.000</p>
                        <a href="#" class="btn btn-primary">Beli</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
