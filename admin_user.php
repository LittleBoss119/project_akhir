<?php
session_start();
require 'config.php';


if (isset($_SESSION['message'])) {
    echo '<script>alert("' . $_SESSION['message'] . '");</script>';
    unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
}

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}



if (isset($_POST['submit'])) {
    $target_dir = "user/";
    $uploadOk = 1;

    // Ensure file is selected
    if (isset($_FILES["foto"]) && $_FILES["foto"]["name"] != "") {
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
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
                echo "The file " . htmlspecialchars(basename($_FILES["foto"]["name"])) . "";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file selected.";
        $uploadOk = 0;
    }

    // Insert data if file upload is successful or not required
    if ($uploadOk == 1) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $tentang = $_POST['tentang'];
        $gambar = $target_file;

        // Check for duplicate email
        $duplicate = mysqli_query($conn, "SELECT * FROM new_user WHERE email = '$email'");
        if (mysqli_num_rows($duplicate) > 0) {
            echo "<script>alert('Email Has Already Taken')</script>";
        } else {
            // Corrected SQL query
            $query = "INSERT INTO new_user (username, email, password, gambar, tentang) VALUES ('$username', '$email', '$password', '$gambar', '$tentang')";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Akun user baru berhasil di buat!')</script>";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        }
    }
}

//   Button Update
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
                
                // Delete the old image file
                $sql_get_old_image = "SELECT gambar FROM new_user WHERE user_id = '$user_id'";
                $result = mysqli_query($conn, $sql_get_old_image);
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $old_file_path = $row['gambar'];
                    if (file_exists($old_file_path)) {
                        unlink($old_file_path);
                    }
                }

                // Update the database with the new image path
                $sql_update = "UPDATE new_user SET username='$username', email='$email', password='$password', tentang='$tentang', gambar='$target_file' WHERE user_id='$user_id'";
                if (mysqli_query($conn, $sql_update)) {
                    $_SESSION['message'] = "Akun berhasil diperbarui.";
                    header("location:admin_user.php");
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
            header("location:admin_user.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}



if (isset($_POST['btn_hapus_akun'])) {
    $id_hapus = $_POST['id_hapus_akun'];

    // Get the file path of the user's image
    $sql_get_gambar = "SELECT gambar FROM new_user WHERE user_id = '$id_hapus'";
    $result = mysqli_query($conn, $sql_get_gambar);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $file_path = $row['gambar'];

        // Delete the image file
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete the user record from the database
        $sql_hapus_resep = "DELETE FROM new_user WHERE user_id = '$id_hapus'";
        if (mysqli_query($conn, $sql_hapus_resep)) {
            $_SESSION['message'] = "Akun berhasil dihapus.";
            header("location:admin_user.php");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Error fetching record: " . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Rekomendasi Masakan Nusantara</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group select, .form-group button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group button {
            background-color: #ff9800;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-group button:hover {
            background-color: #e68900;
        }
        .category {
            margin-bottom: 40px;
        }
        .category h2 {
            border-bottom: 2px solid #ff9800;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .category ul {
            display: flex;
            flex-wrap: wrap;
            list-style-type: none;
            padding: 0;
        }
        .category ul li {
            background-color: #ffebcd;
            margin: 10px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: calc(33.333% - 40px);
            box-sizing: border-box;
            transition: transform 0.3s;
        }
        .category ul li:hover {
            transform: scale(1.05);
        }
        .results {
            margin-top: 20px;
        }
        .results ul {
            list-style-type: none;
            padding: 0;
        }
        .results ul li {
            background-color: #ffebcd;
            margin: 10px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .results ul li:hover {
            transform: scale(1.05);
        }
        footer {
            background-color: #795548;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>

<header>
    <h1>Dapur Nusantara</h1>
    <p>"Selamat datang admin, silahkan kelola semua data di web ini !"</p>
</header>

<nav class="navbar">
    <ul>
        <li><a href="admin_user.php">User</a></li>
        <li><a href="admin_list.php">Resep</a></li>
        <li><a href="logout.php" onclick="confirmLogout()">Keluar</a></li>
    </ul>
</nav>
<script>
function confirmLogout() {
    if (confirm("Apakah anda yakin akan keluar?")) {
        window.location.href = "logout.php";
    } else {
        // Tidak melakukan apa-apa
    }
}
</script>
<div class="container-fluid px-4">
    <h1 class="mt-4">Data User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Silahkan Kelola User !</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            <button type="button" class="btn btn-primary" name="btn_artikel_baru" id="btn_artikel_baru" data-bs-toggle="modal" data-bs-target="#myModal">Tambah User</button>
        </div>
        <div class="card-body">
    <table id="datatablesSimple" class="table table-striped">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Password</th>
                <th>Foto</th>
                <th>Tentang</th>
                <th>Aksi</th> <!-- Tambah kolom Aksi untuk tombol hapus -->
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM new_user ORDER BY user_id DESC";
            $result = mysqli_query($conn, $sql);
            $no = 0;
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $no++;
                    $data_nama = $row['username'];
                    $data_email = $row['email'];
                    $data_password = $row['password'];
                    $data_gambar = $row['gambar'];
                    $data_tentang = $row['tentang'];
                    ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $data_nama; ?></td>
                        <td><?php echo $data_email; ?></td>
                        <td><?php echo $data_password; ?></td>
                        <td><?php echo $data_gambar ?></td>
                        <td><?php echo $data_tentang ?></td>
                        <td>
                            <!-- Button trigger modal Edit -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditArtikel<?php echo $row['user_id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                </svg>
                            </button>
                            <!-- Button trigger modal Hapus -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusArtikel<?php echo $row['user_id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <!-- Modal Edit User -->
                    <div class="modal fade" id="modalEditArtikel<?php echo $row['user_id']; ?>" tabindex="-1" aria-labelledby="modalEditArtikelLabel<?php echo $row['user_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditArtikelLabel<?php echo $row['user_id']; ?>">Edit Akun User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="admin_user.php" method="POST" enctype="multipart/form-data">
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
                                                <input type="text" class="form-control" id="password" name="password" value="<?php echo $data_password; ?>" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Tentang</label>
                                            <textarea class="form-control" id="bahan_resep" rows="3" name="tentang"><?php echo $data_tentang; ?></textarea>
                                        </div>
                                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                        <div class="mt-3 mb-3 d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-primary" name="btn_update">Simpan Perubahan</button>
                                            <button class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Hapus User -->
                    <div class="modal fade" id="modalHapusArtikel<?php echo $row['user_id']; ?>" tabindex="-1" aria-labelledby="modalHapusArtikelLabel<?php echo $row['user_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalHapusArtikelLabel<?php echo $row['user_id']; ?>">Hapus Akun User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST">
                                        <div class="mb-3">
                                            Apakah Akun <?php echo "<b>" . $data_nama . "</b>"; ?> akan dihapus?
                                        </div>
                                        <div class="mt-3 mb-3 d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-danger" name="btn_hapus_akun">Hapus</button>
                                            <input type="hidden" name="id_hapus_akun" value="<?php echo $row['user_id']; ?>">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<tr><td colspan='7'>0 results</td></tr>";
            }
            ?>
        </tbody>
    </table>
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
</script>
<!-- Modal form artikel -->
<div class="modal fade" data-bs-backdrop="static" id="myModal">
        <div class="modal-dialog modal-xl" >
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Buat Akun User Baru !</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
            <form action="admin_user.php" method="POST"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="foto_profil">Foto Profil</label>
                        <input type="file" id="foto_profil" name="foto" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama Pengguna</label>
                        <input type="text" class="form-control" id="email" name="username" aria-describedby="emailHelp" placeholder="" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Lihat</label>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tentang</label>
                        <textarea class="form-control" id="bahan_resep" rows="3" name="tentang"></textarea>
                    </div>
                        <button type="submit" class="btn btn-primary" name="submit" value="submit">Buat</button>
                    <br><br>
                </form>
</div>


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
</script>
</body>
</html>
