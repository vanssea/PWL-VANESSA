<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Kid Category</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Kategori Baby Kid</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Produk Kategori Baby Kid</h2>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Produk 1">
                    <div class="card-body">
                        <h5 class="card-title">Produk Baby Kid 1</h5>
                        <p class="card-text">Deskripsi singkat produk.</p>
                        <button class="btn btn-primary">Beli Sekarang</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Produk 2">
                    <div class="card-body">
                        <h5 class="card-title">Produk Baby Kid 2</h5>
                        <p class="card-text">Deskripsi singkat produk.</p>
                        <button class="btn btn-primary">Beli Sekarang</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Produk 3">
                    <div class="card-body">
                        <h5 class="card-title">Produk Baby Kid 3</h5>
                        <p class="card-text">Deskripsi singkat produk.</p>
                        <button class="btn btn-primary">Beli Sekarang</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url('/') }}" class="btn btn-secondary">Kembali ke Home</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
