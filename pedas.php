<?php
require 'config.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
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

<header>
    <h1>Dapur Nusantara</h1>
    <p>"Temukan berbagai resep dengan tingkat pedas yang sesuai dengan preferensi Anda, mulai dari pedas ringan hingga sangat pedas."</p>
</header>

<nav class="navbar">
    <ul>
        <li><a href="user_cari.php">Beranda</a></li>
        <li><a href="user.php">Profil</a></li>
        <li><a href="#" onclick="confirmLogout()">Log Out</a></li>
    </ul>
</nav>

<div class="container">
            <div class="row">
                <!-- Blog entries-->
                
                <div class="col-lg-8">
                <?php 
                $id_pedas = $_GET['id_pedas'];
                $sql = "SELECT * FROM pedas WHERE id_pedas = '$id_pedas'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $nama_pedas = $row['tingkat_pedas'];
                }
                ?>
                <h2>Resep masakan berdasarkan tingkat pedas "<?php echo $nama_pedas;?>"</h2>
                <?php } ?>
                <br><br>
                    <div class="row">
                    
                    <?php
                    
                    $id_pedas_terpilih = $_GET['id_pedas'];
                    $sql = "SELECT kontributor.id_kontributor, resep.nama_resep, resep.bahan, resep.langkah, resep.gambar, resep.deskripsi, pedas.tingkat_pedas, teknik_masak.teknik, jenis_masakan.jenis, teknik_masak.id_teknik, pedas.id_pedas, jenis_masakan.id_jenis
                            FROM kontributor 
                            JOIN resep ON kontributor.id_resep = resep.id_resep 
                            JOIN pedas ON kontributor.id_pedas = pedas.id_pedas 
                            JOIN teknik_masak ON kontributor.id_teknik = teknik_masak.id_teknik 
                            JOIN jenis_masakan ON kontributor.id_jenis = jenis_masakan.id_jenis
                            WHERE kontributor.id_pedas = '$id_pedas_terpilih'
                            ORDER BY id_kontributor DESC";

                    $result_post = mysqli_query($conn, $sql);
                    $no = 0;

                    if (mysqli_num_rows($result_post)>0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result_post)) {
                        $no++;
                        $nama_resep = $row['nama_resep'];
                        $gambar_resep = $row['gambar'];
                        $deskripsi_resep = $row['deskripsi'];
                        $data_id_kontributor = $row['id_kontributor'];
                    ?>
                        <div class="col-lg-6 mb-4">
                            <!-- Blog post-->
                            <div class="card">
                                <a href="#!"><img class="card-img-top" src="<?php echo $gambar_resep; ?>" alt="..." /></a>
                                <div class="card-body">
                                    <h2 class="card-title"><?php echo $nama_resep; ?></h2>
                                    <p class="card-text"><?php echo $deskripsi_resep;?></p>
                                    <a class="btn btn-primary" href="user_resep.php?id_kontributor=<?php echo $data_id_kontributor; ?>">Lihat →</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                        // Setelah dua card ditampilkan, tutup baris dan mulai baris baru jika nomor berpasangan
                        if ($no % 2 == 0) {
                            echo '</div><div class="row">';
                        }
                    }
                    ?>
                            
                            <!-- Blog post-->
                        </div>
                    </div>
                    <!-- Side widgets-->
                <div class="col-lg-4">
                <br><br><br><br>
                <h5>Sesuaikan kategori dengan selera kalian !</h5>
                    <!-- Jenis Makanan widget-->
                    <div class="card mb-4">
                        <div class="card-header">Jenis Makanan</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="list-group">
                                    <?php
                                        $sql = "SELECT id_jenis, jenis FROM jenis_masakan ORDER BY id_jenis DESC";
                                        $result = mysqli_query($conn, $sql);

                                        if(mysqli_num_rows($result)>0){
                                            $no = 1;
                                            while($row = mysqli_fetch_assoc($result)){
                                                $no++;
                                                $data_id_jenis = $row['id_jenis'];
                                                $data_jenis = $row['jenis'];
                                    ?>
                                        <a href="jenis.php?id_jenis=<?php echo $data_id_jenis; ?>" class="list-group-item list-group-item-action"><?php echo $data_jenis ?></a>
                                    <?php
                                            }
                                        }else{

                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Teknik Masak widget-->
                    <div class="card mb-4">
                        <div class="card-header">Teknik Masakan</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="list-group">
                                    <?php
                                        $sql = "SELECT id_teknik, teknik FROM teknik_masak ORDER BY id_teknik DESC";
                                        $result = mysqli_query($conn, $sql);

                                        if(mysqli_num_rows($result)>0){
                                            $no = 1;
                                            while($row = mysqli_fetch_assoc($result)){
                                                $no++;
                                                $data_id_teknik = $row['id_teknik'];
                                                $data_teknik = $row['teknik'];
                                    ?>
                                        <a href="teknik.php?id_teknik=<?php echo $data_id_teknik; ?>" class="list-group-item list-group-item-action"><?php echo $data_teknik ?></a>
                                    <?php
                                            }
                                        }else{

                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tingkat Pedas widget-->
                    <div class="card mb-4">
                        <div class="card-header">Tingkat Pedas</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="list-group">
                                    <?php
                                        $sql = "SELECT id_pedas, tingkat_pedas FROM pedas ORDER BY id_pedas DESC";
                                        $result = mysqli_query($conn, $sql);

                                        if(mysqli_num_rows($result)>0){
                                            $no = 1;
                                            while($row = mysqli_fetch_assoc($result)){
                                                $no++;
                                                $data_id_pedas = $row['id_pedas'];
                                                $data_pedas = $row['tingkat_pedas'];
                                    ?>
                                        <a href="pedas.php?id_pedas=<?php echo $data_id_pedas; ?>" class="list-group-item list-group-item-action"><?php echo $data_pedas ?></a>
                                    <?php
                                            }
                                        }else{

                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Side widget-->
                    <div class="card mb-4">
                        <div class="card-header">Tentang</div>
                        <div class="card-body" id="tentang">Tentang</div>
                    </div>
                    
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

</html>
