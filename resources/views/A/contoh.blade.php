<!DOCTYPE html>
<html>
<head>
    <title>Belajar Laravel View</title>
</head>
<body>
    <h1>Halo, Laravel!</h1>

    <?php
    // Ini adalah kode PHP biasa
    $pesan = "Belajar Laravel itu menyenangkan!";
    ?>

    <p>{{ $pesan }}</p> <!-- Blade Laravel untuk menampilkan variabel PHP -->

    <ul>
        @for ($i = 1; $i <= 5; $i++)
            <li>Item ke-{{ $i }}</li>
        @endfor
    </ul>
</body>
</html>
