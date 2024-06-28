<?php
require 'config.php';

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if(isset($_POST['btn_simpan'])){
    $target_dir = "gambar/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }
  
    // Check file size
    if ($_FILES["gambar"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
  
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }
  
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["gambar"]["name"])). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
  
    $data_nama = $_POST['nama'];
    $data_bahan = $_POST['bahan'];
    $data_langkah = $_POST['langkah'];
    $data_teknik = $_POST['teknik'];
    $data_jenis = $_POST['jenis'];
    $data_pedas = $_POST['pedas'];
    $data_deskripsi = $_POST['deskripsi'];
    $data_gambar = $target_file;
  
    $sql = "INSERT INTO resep (nama_resep, bahan, langkah, gambar, deskripsi)
    VALUES ('$data_nama', '$data_bahan', '$data_langkah', '$data_gambar', '$data_deskripsi')";
  
    if (mysqli_query($conn, $sql)) {
      $sql = "SELECT * FROM resep ORDER BY id_resep DESC LIMIT 1";
      $result = mysqli_query($conn, $sql);
      $data_id_artikel = "";
      if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
          $data_id_resep = $row['id_resep'];
        }
      } else {
        echo "0 results";
      }
  
    
    $sql = "INSERT INTO kontributor (id_resep, id_teknik, id_pedas, id_jenis)
    VALUES ('$data_id_resep', '$data_teknik', '$data_pedas', '$data_jenis')";

    if (mysqli_query($conn, $sql)) {
      header('location:admin_list.php'); 
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  } 
  }

//   Button Update
if (isset($_POST['btn_update'])) {
    $id_kontributor = $_POST['id_kontributor'];
    $data_nama = mysqli_real_escape_string($conn, $_POST['nama_resep']);
    $data_bahan = mysqli_real_escape_string($conn, $_POST['bahan_resep']);
    $data_langkah = mysqli_real_escape_string($conn, $_POST['langkah_resep']);
    $data_deskripsi = mysqli_real_escape_string($conn, $_POST['deksripsi_resep']);
    $data_teknik = $_POST['id_teknik'];
    $data_jenis = $_POST['id_jenis'];
    $data_pedas = $_POST['tingkat_pedas'];

    // Default value for new image
    $gambar_resep = '';

    // Check if new image file is selected
    if ($_FILES['gambar_resep']['name']) {
        $target_dir = "gambar/";
        $gambar_resep = basename($_FILES["gambar_resep"]["name"]);
        $target_file = $target_dir . $gambar_resep;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size
        if ($_FILES["gambar_resep"]["size"] > 500000) {
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
            // Remove old image file if it exists
            $sql_select_old_image = "SELECT gambar FROM resep WHERE id_resep = (SELECT id_resep FROM kontributor WHERE id_kontributor = '$id_kontributor')";
            $result_select_old_image = mysqli_query($conn, $sql_select_old_image);
            if ($result_select_old_image) {
                $row_old_image = mysqli_fetch_assoc($result_select_old_image);
                $old_image_path = $target_dir . $row_old_image['gambar'];
                if (file_exists($old_image_path)) {
                    unlink($old_image_path); // Hapus gambar lama dari direktori
                }
            }

            // Upload new image file
            if (move_uploaded_file($_FILES["gambar_resep"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["gambar_resep"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // Use existing image if no new image is selected
        $sql_select_old_image = "SELECT gambar FROM resep WHERE id_resep = (SELECT id_resep FROM kontributor WHERE id_kontributor = '$id_kontributor')";
        $result_select_old_image = mysqli_query($conn, $sql_select_old_image);
        if ($result_select_old_image) {
            $row_old_image = mysqli_fetch_assoc($result_select_old_image);
            $gambar_resep = $row_old_image['gambar'];
        }
    }

    // Update data resep
    $sql_update_resep = "UPDATE resep SET 
                         nama_resep = '$data_nama', 
                         bahan = '$data_bahan', 
                         langkah = '$data_langkah', 
                         gambar = '$gambar_resep',
                         deskripsi = '$data_deskripsi'
                         WHERE id_resep = (SELECT id_resep FROM kontributor WHERE id_kontributor = '$id_kontributor')";

    if (mysqli_query($conn, $sql_update_resep)) {
        // Update data kontributor
        $sql_update_kontributor = "UPDATE kontributor SET 
                                   id_teknik = '$data_teknik', 
                                   id_jenis = '$data_jenis', 
                                   id_pedas = '$data_pedas'
                                   WHERE id_kontributor = '$id_kontributor'";

        if (mysqli_query($conn, $sql_update_kontributor)) {
            header('location: admin_list.php');
        } else {
            echo "Error updating kontributor: " . mysqli_error($conn);
        }
    } else {
        echo "Error updating resep: " . mysqli_error($conn);
    }
}

if(isset($_POST['btn_hapus_resep'])){
    $id_hapus = $_POST['id_hapus_resep'];
    
    $sql_hapus_resep = "DELETE FROM resep WHERE id_resep IN(SELECT id_resep FROM kontributor WHERE id_kontributor = '$id_hapus')";

    $sql_hapus_kontributor = "DELETE FROM kontributor WHERE id_kontributor = '$id_hapus'";

    if (mysqli_query($conn, $sql_hapus_resep)) {
        if (mysqli_query($conn, $sql_hapus_resep)) {
            header("location:admin_list.php");
        } else {
            echo "Error deleting record: " . $conn->error;
        } 
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
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css" />

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
        <li><a href="#" onclick="confirmLogout()">Keluar</a></li>
    </ul>
</nav>

<div class="container-fluid px-4">
    <h1 class="mt-4">Data Resep</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Silahkan Kelola Resep !</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            <button type="button" class="btn btn-primary" name="btn_artikel_baru" id="btn_artikel_baru" data-bs-toggle="modal" data-bs-target="#myModal">Buat Resep</button>
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Bahan</th>
                        <th>Langkah</th>
                        <th>Gambar</th>
                        <th>Deskripsi</th>
                        <th>Level Pedas</th>
                        <th>Teknik</th>
                        <th>Jenis</th>
                        <th>Aksi</th> <!-- Tambah kolom Aksi untuk tombol hapus -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT kontributor.id_kontributor, resep.nama_resep, resep.bahan, resep.langkah, resep.gambar, resep.deskripsi, pedas.tingkat_pedas, teknik_masak.teknik, jenis_masakan.jenis, teknik_masak.id_teknik, pedas.id_pedas, jenis_masakan.id_jenis
                            FROM kontributor 
                            JOIN resep ON kontributor.id_resep = resep.id_resep 
                            JOIN pedas ON kontributor.id_pedas = pedas.id_pedas 
                            JOIN teknik_masak ON kontributor.id_teknik = teknik_masak.id_teknik 
                            JOIN jenis_masakan ON kontributor.id_jenis = jenis_masakan.id_jenis
                            ORDER BY id_kontributor DESC";

                    $result = mysqli_query($conn, $sql);
                    $no = 0;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $no++;
                            $nama_resep = $row['nama_resep'];
                            $bahan_resep = $row['bahan'];
                            $langkah_resep = $row['langkah'];
                            $gambar_resep = $row['gambar'];
                            $data_pedas = $row['tingkat_pedas'];
                            $data_teknik = $row['teknik'];
                            $data_jenis = $row['jenis'];
                            $data_idteknik = $row['id_teknik'];
                            $data_idpedas = $row['id_pedas'];
                            $data_idjenis = $row['id_jenis'];
                            $resep_deskripsi = $row['deskripsi'];
                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $nama_resep; ?></td>
                                <td><?php echo $bahan_resep; ?></td>
                                <td><?php echo $langkah_resep; ?></td>
                                <td><?php echo $gambar_resep; ?></td>
                                <td><?php echo $resep_deskripsi; ?></td>
                                <td><?php echo $data_pedas; ?></td>
                                <td><?php echo $data_teknik; ?></td>
                                <td><?php echo $data_jenis; ?></td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditArtikel<?php echo $row['id_kontributor']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
</svg>
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusArtikel<?php echo $row['id_kontributor']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
</svg>
                                    </button>
                                </td>
                            </tr>
                            <!-- Modal Edit Resep -->
                <div class="modal fade" id="modalEditArtikel<?php echo $row['id_kontributor']; ?>" tabindex="-1" aria-labelledby="modalEditArtikelLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditArtikelLabel">Edit Artikel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="admin_list.php" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="nama_resep" class="form-label">Nama Resep:</label>
                                        <input type="text" class="form-control" id="nama_resep" name="nama_resep" value="<?php echo $nama_resep; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="bahan_resep" class="form-label">Bahan-bahan:</label>
                                        <textarea class="form-control" id="editor4" rows="3" name="bahan_resep"><?php echo $bahan_resep; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="langkah_resep" class="form-label">Langkah-langkah:</label>
                                        <textarea class="form-control" id="editor1" rows="5" name="langkah_resep"><?php echo $langkah_resep; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="langkah_resep" class="form-label">Deskripsi:</label>
                                        <textarea class="form-control" id="" rows="5" name="deksripsi_resep"><?php echo $resep_deskripsi; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gambar_resep" class="form-label">Gambar:</label>
                                        <input type="file" class="form-control" id="gambar_resep" name="gambar_resep">
                                        <img src="<?php echo $gambar_resep; ?>" class="img-fluid mt-2" alt="Gambar Resep">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tingkat_pedas" class="form-label">Tingkat Pedas:</label>
                                        <select class="form-select" id="tingkat_pedas" name="tingkat_pedas">
                                            <option value="1" <?php if ($data_pedas == 'Tidak Pedas') echo 'selected'; ?>>Tidak Pedas</option>
                                            <option value="2" <?php if ($data_pedas == 'Sedang') echo 'selected'; ?>>Sedang</option>
                                            <option value="3" <?php if ($data_pedas == 'Pedas') echo 'selected'; ?>>Pedas</option>
                                            <option value="4" <?php if ($data_pedas == 'Sangat Pedas') echo 'selected'; ?>>Sangat Pedas</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="id_teknik" class="form-label">Teknik Masak:</label>
                                        <select class="form-select" id="id_teknik" name="id_teknik">
                                            <?php
                                            $sql_teknik = "SELECT id_teknik, teknik FROM teknik_masak";
                                            $result_teknik = mysqli_query($conn, $sql_teknik);
                                            while ($row_teknik = mysqli_fetch_assoc($result_teknik)) {
                                                $selected = ($row_teknik['id_teknik'] == $data_idteknik) ? 'selected' : '';
                                                echo '<option value="' . $row_teknik['id_teknik'] . '" ' . $selected . '>' . $row_teknik['teknik'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="id_jenis" class="form-label">Jenis Masakan:</label>
                                        <select class="form-select" id="id_jenis" name="id_jenis">
                                            <?php
                                            $sql_jenis = "SELECT id_jenis, jenis FROM jenis_masakan";
                                            $result_jenis = mysqli_query($conn, $sql_jenis);
                                            while ($row_jenis = mysqli_fetch_assoc($result_jenis)) {
                                                $selected = ($row_jenis['id_jenis'] == $data_idjenis) ? 'selected' : '';
                                                echo '<option value="' . $row_jenis['id_jenis'] . '" ' . $selected . '>' . $row_jenis['jenis'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <input type="hidden" name="id_kontributor" value="<?php echo $row['id_kontributor']; ?>">
                                    <div class="mt-3 mb-3 d-flex justify-content-end gap-2"><button type="submit" class="btn btn-primary" name="btn_update">Simpan Perubahan</button>
                                    <button class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                            <!-- Modal Hapus Resep -->
                            <div class="modal fade" id="modalHapusArtikel<?php echo $row['id_kontributor']; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Hapus Resep</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <form action="" method="POST">
                                            <div class="modal-body mb-3">
                                                Apakah resep <?php echo "<b>" . $nama_resep . "</b>"; ?> akan dihapus?
                                                <div class="mt-3 mb-3 d-flex justify-content-end gap-2">
                                                    <button type="submit" class="btn btn-danger" name="btn_hapus_resep">Hapus</button>
                                                    <input type="hidden" name="id_hapus_resep" value="<?php echo $row['id_kontributor']; ?>">
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='9'>0 results</td></tr>";
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
<!-- Modal form Buat Resep -->
<div class="modal fade" data-bs-backdrop="static" id="myModal">
        <div class="modal-dialog modal-xl" >
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Buat Resep !</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
    <form method="POST" enctype="multipart/form-data">
    
        <div class="mb-3 mt-3">
            <label for="judul" class="form-label">Nama :</label>
            <input type="text" class="form-control" id="nama" name="nama">
        </div>
        
        <div class="mb-3 mt-3">
            <label for="isi" class="form-label">Bahan :</label>
            <textarea class="form-control" rows="5" id="editor2" name="bahan"></textarea>
        </div>
        
        <div class="mb-3 mt-3">
            <label for="isi" class="form-label">Langkah :</label>
            <textarea class="form-control" rows="5" id="editor" name="langkah"></textarea>
        </div>
        
        <div class="mb-3 mt-3">
            <label for="isi" class="form-label">Deskripsi :</label>
            <textarea class="form-control" rows="5" id="" name="deskripsi"></textarea>
        </div>
        
        <div class="mb-3 mt-3">
            <label for="gambar" class="form-label">Gambar :</label>
            <input class="form-control" type="file" id="gambar" name="gambar">
        </div>
        
        
        <div class="mb-3 mt-3">
            <label for="teknik" class="form-label">Teknik Masak :</label>
            <select class="form-select" id="teknik" name="teknik">
                <?php
                $sql = "SELECT id_teknik, teknik FROM teknik_masak";
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $data_id_teknik = $row['id_teknik'];
                        $data_teknik = $row['teknik'];
                        ?>      
                        <option value="<?php echo $data_id_teknik; ?>"><?php echo $data_teknik; ?></option>
                        <?php
                    }
                } else {
                    echo "<option value=''>Tidak ada data</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="mb-3 mt-3">
            <label for="kategori" class="form-label">Jenis Masakan :</label>
            <select class="form-select" id="jenis" name="jenis">
                <?php
                $sql = "SELECT id_jenis, jenis FROM jenis_masakan";
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $data_id_jenis = $row['id_jenis'];
                        $data_jenis = $row['jenis'];
                        ?>      
                        <option value="<?php echo $data_id_jenis; ?>"><?php echo $data_jenis; ?></option>
                        <?php
                    }
                } else {
                    echo "<option value=''>Tidak ada data</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="mb-3 mt-3">
            <label for="pedas" class="form-label">Tingkat Pedas :</label>
            <select class="form-select" id="pedas" name="pedas">
                <?php
                $sql = "SELECT id_pedas, tingkat_pedas FROM pedas";
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $data_id_pedas = $row['id_pedas'];
                        $data_pedas = $row['tingkat_pedas'];
                        ?>      
                        <option value="<?php echo $data_id_pedas; ?>"><?php echo $data_pedas; ?></option>
                        <?php
                    }
                } else {
                    echo "<option value=''>Tidak ada data</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="mb-3 mt-3 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary" name="btn_simpan">Simpan</button>
            <button class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
        </div>
    </form>
</div>


            </div>
        </div>
        </div>

        <script type="importmap">
            {
                "imports": {
                    "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.js",
                    "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.0/"
                }
            }
        </script>

        <script type="module">
            import {
                ClassicEditor,
                Essentials,
                Bold,
                Italic,
                Font,
                Paragraph
            } from 'ckeditor5';

            ClassicEditor
                .create( document.querySelector( '#editor' ), {
                    plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
                    toolbar: {
                        items: [
                            'undo', 'redo', '|', 'bold', 'italic', '|',
                            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                        ]
                    }
                } )
                .then( /* ... */ )
                .catch( /* ... */ );
        </script>

        <script type="module">
            import {
                ClassicEditor,
                Essentials,
                Bold,
                Italic,
                Font,
                Paragraph
            } from 'ckeditor5';

            ClassicEditor
                .create( document.querySelector( '#editor1' ), {
                    plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
                    toolbar: {
                        items: [
                            'undo', 'redo', '|', 'bold', 'italic', '|',
                            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                        ]
                    }
                } )
                .then( /* ... */ )
                .catch( /* ... */ );
        </script>
        <script type="module">
            import {
                ClassicEditor,
                Essentials,
                Bold,
                Italic,
                Font,
                Paragraph
            } from 'ckeditor5';

            ClassicEditor
                .create( document.querySelector( '#editor2' ), {
                    plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
                    toolbar: {
                        items: [
                            'undo', 'redo', '|', 'bold', 'italic', '|',
                            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                        ]
                    }
                } )
                .then( /* ... */ )
                .catch( /* ... */ );
        </script>
        <script type="module">
            import {
                ClassicEditor,
                Essentials,
                Bold,
                Italic,
                Font,
                Paragraph
            } from 'ckeditor5';

            ClassicEditor
                .create( document.querySelector( '#editor4' ), {
                    plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
                    toolbar: {
                        items: [
                            'undo', 'redo', '|', 'bold', 'italic', '|',
                            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                        ]
                    }
                } )
                .then( /* ... */ )
                .catch( /* ... */ );
        </script>
    
</body>
</html>
