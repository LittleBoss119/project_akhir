<?php
session_start();
require 'config.php';

if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']); // Hapus pesan error dari session setelah ditampilkan
}

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin_list.php");
    } elseif ($_SESSION['role'] == 'user') {
        header("Location: user_cari.php");
    }
    exit();
}

    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        if ($email == 'admin@gmail.com' && $password == 'admin') {
            $_SESSION['role'] = 'admin';
            header("Location: admin_list.php");
        } else {
            $query = "SELECT * FROM new_user WHERE email='$email' AND password='$password'";
            $result = mysqli_query($conn, $query);
    
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['role'] = 'user';
                $_SESSION['user_id'] = $row['user_id'];
                header("Location: user_cari.php");
            } else {
                $_SESSION['error'] = "Email atau password salah.";
                header("Location: login.php");
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
    <p>"Masuk untuk jelajahi berbagai resep masakan nusantara !"</p>
</header>

<div class="container py-4 px-3 mx-auto">
        <div class="card">
            <h5 class="card-header">Buat Akun Mu!</h5>
            <div class="card-body">
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <form action="login.php" method="POST">
                <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="kamu@gmail.com" required>
                        <div id="emailHelp" class="form-text">Kami tidak akan membagikan email mu pada siapapun.</div>
                    </div>   
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password Mu" required>
                        </div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Lihat</label>
                    </div>
                        <button type="submit" class="btn btn-primary" name="submit" value="submit">Masuk</button>
                    <br><br>
                    <div class="form-text">Belum Memiliki Akun? <a href="register.php">Buat</a></div>
                </form>
            </div>   
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const showPasswordCheckbox = document.getElementById('exampleCheck1');

        exampleCheck1.addEventListener('change', function () {
            if (showPasswordCheckbox.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>

<script>
    
</script>

</body>
</html>
