<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Profil Pengguna</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Profil Pengguna</h2>

        <div class="card mt-4">
            <div class="card-body">
                <h4>ID Pengguna: {{ $id }}</h4>
                <h4>Nama: {{ $name }}</h4>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
