<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Cabai</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;
        }

        body {
            background-color: #ffffff;
            font-family: Arial, sans-serif;
            color: #FFFFFF;
            /* Text color */
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: linear-gradient(120deg, #7163ba, #7163ba);
            /* Latar belakang dengan gradient warna */
            background-size: cover;
            background-repeat: no-repeat;
        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 20px;
            padding-bottom: 60px;
        }

        h2 {
            font-size: 30px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .alert {
            background-color: #D32F2F;
            /* Red alert background color */
            color: #FFFFFF;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, .1);
            background: #fff;
            text-align: center;
            width: 500px;
        }

        label {
            text-align: center;
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px 15px;
            font-size: 17px;
            margin: 8px 0;
            background: #eee;
            border-radius: 5px;
        }

        button {
            background: #7163ba;
            color: crimson;
            text-transform: capitalize;
            font-size: 20px;
            cursor: pointer;
            padding: 10px 30px;
            margin-top: 10px;
        }

        button:hover {
            background: crimson;
            color: #fff;
        }

        .mt-3 {
            margin-top: 3px;
        }

        a {
            color: crimson;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Hello, you!</h2>
        <?php
        session_start();
        if (isset($_SESSION['username'])) {
            header('Location: index.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $host = "localhost";
            $user = "root";
            $pass = "";
            $db = "monitoring";

            $koneksi = mysqli_connect($host, $user, $pass, $db);
            if (!$koneksi) {
                die("Tidak bisa terkoneksi ke database");
            }

            $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
            $result = mysqli_query($koneksi, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $_SESSION['username'] = $username;
                header('location: index.php');  // Ganti dengan halaman yang sesuai
                exit();
            } else {
                $error = "Username atau password salah.";
            }
        }
        ?>

        
        <?php if (isset($error)) : ?>
            <div class="alert" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <!-- Integrated Form -->
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <!-- Tombol untuk mengarahkan ke halaman registrasi -->
        <p class="mt-3 text-center">Belum punya akun? <a href="registrasi.php">Registrasi</a></p>
    </div>
</body>
</html>
