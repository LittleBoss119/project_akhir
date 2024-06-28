<?php
session_start();
require 'config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user dari database
$query = "SELECT * FROM new_user WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $data_nama = $row['username'];
    $data_email = $row['email'];
    $data_password = $row['password'];
    $data_gambar = !empty($row['gambar']) ? $row['gambar'] : 'user/user_kopong.PNG'; // Gambar default jika null
    $data_tentang = !empty($row['tentang']) ? $row['tentang'] : '-'; // "-" jika tentang kosong
} else {
    $_SESSION['error'] = "Data pengguna tidak ditemukan.";
    header("Location: user_cari.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - Sistem Rekomendasi Masakan Nusantara</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-vkMp1x9B+orEWjO0iv3FcluFx2Yfo9KsO1naU8C/9pWp+B1WghWfs3q1TxROU1zN" crossorigin="anonymous">

<!-- Bootstrap JavaScript and dependencies (Popper.js and Bootstrap Bundle) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.3/umd/popper.min.js" integrity="sha512-6p8s1X2yCCjs+YpS6N0gjq3BSl8bODU7LMXOxKos2zFgeQ6GdPD7BLBQxOoU/WVb2V7aX66C62FVzF1XyNl3m7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js" integrity="sha384-PClAFa6+pEyfghJgcu+NcbNt+/ztlQ+U5G8Qk7R5BIkMqYB4D7OdWvoU+yOwvNAO" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Untuk memastikan footer tetap di bawah */
        }
        header {
            background-color: #ff9800;
            color: white;
            padding: 20px;
            text-align: center;
            background-image: url('https://example.com/header-background.jpg'); /* Contoh URL gambar */
            background-size: cover;
            background-position: center;
        }
        nav {
            background-color: #795548;
            overflow: hidden;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            float: left;
        }
        nav ul li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        nav ul li a:hover {
            background-color: #5d4037;
        }
        .navbar {
            display: flex;
            justify-content: center;
        }
        .container {
            padding: 20px;
            flex: 1; /* Untuk memastikan konten tetap di tengah */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .profile-card {
            max-width: 800px; /* Lebar maksimum kartu diperbesar */
            width: 100%; /* Menyesuaikan lebar penuh kontainer */
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 40px; /* Padding kartu diperbesar */
            margin-top: 30px;
            text-align: center;
        }
        .profile-card h2 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .profile-info {
            margin-bottom: 20px;
        }
        .profile-info label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .profile-info p {
            margin: 0;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        .edit-profile-btn {
            margin-top: 40px; /* Memberi jarak lebih besar ke bawah */
        }
        footer {
            background-color: #795548;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

<header>
    <h1>Sistem Rekomendasi Masakan Nusantara</h1>
    <p>"Silahkan atur kembali profil anda !"</p>
</header>

<nav class="navbar">
    <ul>
        <li><a href="user_cari.php">Beranda</a></li>
        <li><a href="user.php">Profil</a></li>
        <li><a href="#" onclick="confirmLogout()">Log Out</a></li>
    </ul>
</nav>

<?php

?>

<div class="container">
    <div class="profile-card">
        <h2>Profil Pengguna</h2>

        <div class="profile-info">
            <label for="foto_profil">Foto Profil</label>
            <div class="mb-3">
                <img src="<?= htmlspecialchars($data_gambar) ?>" alt="Foto Profil" class="profile-img">
            </div>
        </div>

        <div class="profile-info">
            <label for="nama">Nama</label>
            <p><?= htmlspecialchars($data_nama) ?></p>
        </div>

        <div class="profile-info">
            <label for="email">Email</label>
            <p><?= htmlspecialchars($data_email) ?></p>
        </div>
        
        <div class="profile-info">
            <label for="password">Password</label>
            <p><?= htmlspecialchars($data_password) ?></p>
        </div>

        <div class="profile-info">
            <label for="about">Tentang Saya</label>
            <p><?= htmlspecialchars($data_tentang) ?></p>
        </div>

        <a href="user_edit.php"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit</button></a>

    </div>
</div>

<script>
    function confirmLogout() {
        var result = confirm("Apakah Anda yakin ingin keluar?");
        if (result) {
            // Jika pengguna menekan "OK", arahkan ke halaman logout
            window.location.href = "logout.php";
        }
    }
</script>

<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit Profil Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="user.php" method="POST">
                    <div class="mb-3">
                        <label for="foto_profil" class="form-label">Foto Profil</label>
                        <input type="text" class="form-control" id="foto_profil" name="foto_profil" value="<?= htmlspecialchars($data_gambar) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($data_nama) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($data_email) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" value="<?= htmlspecialchars($data_password) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="tentang" class="form-label">Tentang Saya</label>
                        <textarea class="form-control" id="tentang" name="tentang" rows="3"><?= htmlspecialchars($data_tentang) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.3/umd/popper.min.js" integrity="sha512-6p8s1X2yCCjs+YpS6N0gjq3BSl8bODU7LMXOxKos2zFgeQ6GdPD7BLBQxOoU/WVb2V7aX66C62FVzF1XyNl3m7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js" integrity="sha384-PClAFa6+pEyfghJgcu+NcbNt+/ztlQ+U5G8Qk7R5BIkMqYB4D7OdWvoU+yOwvNAO" crossorigin="anonymous"></script>

</body>
</html>
