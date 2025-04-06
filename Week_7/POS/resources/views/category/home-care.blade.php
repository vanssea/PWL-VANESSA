<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Care - POS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Point of Sales</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Kategori: Home Care</h2>

        <div class="row mt-4">
            <!-- Contoh Produk 1 -->
            <div class="col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Produk Home Care">
                    <div class="card-body">
                        <h5 class="card-title">Sabun Pembersih</h5>
                        <p class="card-text">Sabun cair untuk membersihkan rumah.</p>
                        <p class="text-success">Rp 25.000</p>
                        <a href="#" class="btn btn-primary">Beli Sekarang</a>
                    </div>
                </div>
            </div>

            <!-- Contoh Produk 2 -->
            <div class="col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Produk Home Care">
                    <div class="card-body">
                        <h5 class="card-title">Disinfektan</h5>
                        <p class="card-text">Cairan disinfektan untuk membunuh kuman dan bakteri.</p>
                        <p class="text-success">Rp 30.000</p>
                        <a href="#" class="btn btn-primary">Beli Sekarang</a>
                    </div>
                </div>
            </div>

            <!-- Contoh Produk 3 -->
            <div class="col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Produk Home Care">
                    <div class="card-body">
                        <h5 class="card-title">Pengharum Ruangan</h5>
                        <p class="card-text">Pengharum ruangan dengan aroma segar.</p>
                        <p class="text-success">Rp 20.000</p>
                        <a href="#" class="btn btn-primary">Beli Sekarang</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url('/product') }}" class="btn btn-secondary">Kembali ke Produk</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
