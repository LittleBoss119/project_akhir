<?php
require 'config.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['btn_update'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tentang = $_POST['tentang'];
    
    // Check if a new image was uploaded
    if (isset($_FILES["foto"]) && $_FILES["foto"]["name"] != "") {
        $target_dir = "user/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
  
        // Check file size
        if ($_FILES["foto"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
  
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
  
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars(basename($_FILES["foto"]["name"])). " has been uploaded.";
                
                // Delete the old image file if exists and update the database with the new image path
                $sql_get_old_image = "SELECT gambar FROM new_user WHERE user_id = '$user_id'";
                $result = mysqli_query($conn, $sql_get_old_image);
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $old_file_path = $row['gambar'];
                    if (!empty($old_file_path) && file_exists($old_file_path)) {
                        unlink($old_file_path);
                    }
                }

                // Update the database with the new image path
                $sql_update = "UPDATE new_user SET username='$username', email='$email', password='$password', tentang='$tentang', gambar='$target_file' WHERE user_id='$user_id'";
                if (mysqli_query($conn, $sql_update)) {
                    $_SESSION['message'] = "Akun berhasil diperbarui.";
                    header("location:user.php");
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // If no new image is uploaded, just update the other fields
        $sql_update = "UPDATE new_user SET username='$username', email='$email', password='$password', tentang='$tentang' WHERE user_id='$user_id'";
        if (mysqli_query($conn, $sql_update)) {
            $_SESSION['message'] = "Akun berhasil diperbarui.";
            header("location:user.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun - Sistem Rekomendasi Masakan Nusantara</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group button {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .btn-primary {
            background-color: #ff9800;
            color: white;
        }
        .btn-primary:hover {
            background-color: #e68900;
        }
        .btn-danger {
            background-color: #f44336;
            color: white;
        }
        .btn-danger:hover {
            background-color: #df362d;
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
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .main-card {
            width: 100%;
            max-width: 800px; /* Atur lebar maksimum card sesuai kebutuhan */
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: #fff;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<header>
    <h1>Sistem Rekomendasi Masakan Nusantara</h1>
</header>

<nav class="navbar">
    <ul>
        <li><a href="user_cari.php">Beranda</a></li>
        <li><a href="user.php">Profil</a></li>
        <li><a href="#" onclick="confirmLogout()">Log Out</a></li>
    </ul>
</nav>

<?php
$user_id = $_SESSION['user_id'];

// Ambil data user dari database
$query = "SELECT * FROM new_user WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $data_nama = $row['username'];
    $data_email = $row['email'];
    $data_password = $row['password'];
    $data_gambar = !empty($row['gambar']) ? $row['gambar'] : ''; // Gambar default jika null
    $data_tentang = !empty($row['tentang']) ? $row['tentang'] : ''; // "-" jika tentang kosong
} else {
}
?>

<div class="container">
    <div class="main-content">
        <div class="main-card">
            <h2 class="mb-4">Pengaturan Akun</h2>
            
            <!-- Form untuk mengatur akun -->
            <form action="user_edit.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="foto_profil">Foto Profil</label>
        <input type="file" id="foto_profil" name="foto" accept="image/*"><img src="<?php echo $data_gambar; ?>" class="img-fluid mt-2" alt="Gambar Profil">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Nama Pengguna</label>
        <input type="text" class="form-control" id="email" name="username" aria-describedby="emailHelp" value="<?php echo $data_nama; ?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Alamat Email</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="<?php echo $data_email; ?>" required>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <div class="input-group">
            <input type="text" class="form-control" id="text" name="password" value="<?php echo $data_password; ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Tentang</label>
        <textarea class="form-control" id="bahan_resep" rows="3" name="tentang"><?php echo $data_tentang; ?></textarea>
    </div>
    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
    <div class="mt-3 mb-3 d-flex justify-content-end gap-2">
        <button type="submit" class="btn btn-primary" name="btn_update">Simpan Perubahan</button>
        <a href="user.php" class="btn btn-danger">Batal</a>
    </div>
</form>

        </div>
    </div>
</div>

<script>
    function confirmLogout() {
        var result = confirm("Apakah Anda yakin ingin keluar?");
        if (result) {
            // Jika pengguna menekan "OK", arahkan ke halaman logout
            window.location.href = "logout.php";
        } else {
            // Jika pengguna menekan "Cancel", tidak lakukan apa-apa
            // Anda bisa menambahkan kode lain di sini jika diperlukan
        }
    }

    function cancelChanges() {
        // Fungsi ini bisa diimplementasikan jika Anda ingin menambahkan tindakan ketika tombol "Batal" ditekan
        alert("Perubahan dibatalkan");
    }
</script>

</body>
</html>
    