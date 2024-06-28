<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

// Kode halaman user lainnya
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Rekomendasi Masakan Nusantara</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Rekomendasi Masakan Nusantara</title>
    <style>
        /* CSS Anda di sini */
    </style>
</head>
<body>

<div class="container mt-5">
            <div class="row">
                <div class="col-lg-20">
                    <!-- Post content-->
                    <article>
    <?php  
        require 'config.php';
        $data_id_kontributor = $_GET['id_kontributor'];
        

        $sql = "SELECT kontributor.id_kontributor, resep.nama_resep, resep.bahan, resep.langkah, resep.gambar, resep.deskripsi, pedas.tingkat_pedas, teknik_masak.teknik, jenis_masakan.jenis, teknik_masak.id_teknik, pedas.id_pedas, jenis_masakan.id_jenis
                FROM kontributor 
                JOIN resep ON kontributor.id_resep = resep.id_resep 
                JOIN pedas ON kontributor.id_pedas = pedas.id_pedas 
                JOIN teknik_masak ON kontributor.id_teknik = teknik_masak.id_teknik 
                JOIN jenis_masakan ON kontributor.id_jenis = jenis_masakan.id_jenis
                WHERE kontributor.id_kontributor = '$data_id_kontributor'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                $nama_resep = $row['nama_resep'];
                $bahan_resep = $row['bahan'];
                $langkah_resep = $row['langkah'];
                $gambar_resep = $row['gambar'];
                $deskripsi_resep = $row['deskripsi'];
                $data_pedas = $row['tingkat_pedas'];
                $data_teknik = $row['teknik'];
                $data_jenis = $row['jenis'];
                $data_id_jenis = $row['id_jenis'];
                $data_id_teknik = $row['id_teknik'];
                $data_id_pedas = $row['id_pedas'];
                $data_id_kontributor = $row['id_kontributor'];
    ?>
    <!-- Post header-->
    <header class="mb-4">
        <!-- Post title-->
        <h1 class="fw-bolder mb-1"><?php echo $nama_resep; ?></h1>
        
        <!-- Post categories-->
        <div>
            <a class="badge bg-secondary text-decoration-none link-light me-2" href="jenis.php?id_jenis=<?php echo $data_id_jenis; ?>"><?php echo $data_jenis; ?></a>
            <a class="badge bg-secondary text-decoration-none link-light me-2" href="teknik.php?id_teknik=<?php echo $data_id_teknik; ?>"><?php echo $data_teknik; ?></a>
            <a class="badge bg-secondary text-decoration-none link-light" href="pedas.php?id_pedas=<?php echo $data_id_pedas; ?>"><?php echo $data_pedas; ?></a>
        </div>
    </header>
    <!-- Preview image figure-->
    
    <figure class="mb-4"><img class="img-fluid rounded" src="<?php echo $gambar_resep; ?>" alt="..." /></figure>
    <p class="card-text"><?php echo $deskripsi_resep;?></p>
    <br>
    <!-- Post content-->
    <section class="mb-5">
        <h3>Bahan-bahan:</h3>
        <p><?php echo $bahan_resep; ?></p>
        <br>
        <h3>Langkah-langkah:</h3>
        <p><?php echo $langkah_resep; ?></p>
        <br>       
        <div class="d-flex justify-content-end mt-3">
            <button class="btn btn-outline-primary" onclick="history.back()">Kembali</button>
        </div>
    </section>
    <?php
        }
        } else {
            echo "0 results";
        }
    ?>
</article>

                    
                </div>
                <!-- Side widgets-->
                
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
