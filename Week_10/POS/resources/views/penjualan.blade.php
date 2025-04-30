<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan - POS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Point of Sales</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Data Penjualan</h2>

        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Ayam Goreng</td>
                    <td>2</td>
                    <td>Rp 20.000</td>
                    <td>Rp 40.000</td>
                    <td>2024-02-27</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Nasi Uduk</td>
                    <td>1</td>
                    <td>Rp 15.000</td>
                    <td>Rp 15.000</td>
                    <td>2024-02-27</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Es Teh Manis</td>
                    <td>3</td>
                    <td>Rp 5.000</td>
                    <td>Rp 15.000</td>
                    <td>2024-02-27</td>
                </tr>
            </tbody>
        </table>

        <div class="text-center mt-4">
            <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Dashboard</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
