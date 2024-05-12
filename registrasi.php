<?php
session_start();

@include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "monitoring";

    $conn = mysqli_connect($host, $user, $pass, $db);
    if (!$conn) {
        die("Tidak bisa terkoneksi ke database");
    }

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['username'] = $username;
        header('Location: login.php'); // Arahkan ke halaman login setelah registrasi
        exit();
    } else {
        $error = "Gagal mendaftar. Username mungkin sudah ada.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
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
        background-color: #333;
        font-family: Arial, sans-serif;
        color: #323238;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-image: linear-gradient(120deg, #7163ba, #7163ba);
        background-size: cover;
        background-repeat: no-repeat;
        }

        /* Ornamen bintang-bintang */
        .stars {
        background: transparent;
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        }

        .stars:before, .stars:after {
        content: "";
        position: absolute;
        top: 100px;
        left: 50%;
        width: 1px;
        height: 100px;
        background: #FFF;
        }

        .stars:before {
        left: 25%;
        }

        .stars:after {
        left: 75%;
        }

        .container {
        width: 80%; /* Lebar container */
        max-width: 500px;
        padding: 20px;
        padding-bottom: 60px;
        background-color: #7163ba; /* Background color for the container */
        border-radius: 10px;
        }

        /* Formulir registrasi */
        .form-container {
        background-color: #7163ba;
        }

        .form-container form {
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 5px 10px rgba(0,0,0,.1);
        background: #ffffff;
        text-align: center;
        width: 100%;
        }

        .form-container form h3 {
        font-size: 30px;
        text-transform: uppercase;
        margin-bottom: 20px;
        color: #333;
        }

        .form-container form label {
            display: block;
            font-size: 17px;
            margin-bottom: 8px;
            color: #333;
        }

        .form-container form input,
        .form-container form select {
            width: 100%;
            padding: 10px 15px;
            font-size: 17px;
            margin-bottom: 8px;
            background: #e8f0fe;
            border-radius: 5px;
        }

        .form-container form select option {
            background: #eee;
        }

        .form-container form .form-btn {
            background: #7163ba;
            color: crimson;
            text-transform: capitalize;
            font-size: 20px;
            cursor: pointer;
        }

        .form-container form .form-btn:hover {
            background: crimson;
            color: #e8f0fe;
        }

        .form-container form p {
            margin-top: 0;
            font-size: 15px;
            color: #413e46;
        }

        .form-container form p a {
            color: crimson;
        }

        .form-container form .error-msg {
            margin: 10px 0;
            display: block;
            background: crimson;
            color: #fff;
            border-radius: 5px;
            font-size: 20px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <!-- Ornamen bintang-bintang -->
    <div class="stars"></div>

    <div class="container">
        <h2>Registrasi</h2>
        <?php if (isset($error)) : ?>
            <div class="alert" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Formulir registrasi -->
        <div class="form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <?php
                if(isset($error)){
                    foreach($error as $error){
                        echo '<span class="error-msg">'.$error.'</span>';
                    };
                };
                ?>
                <div class="mb-3">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required placeholder="Enter your name">
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>
                <div class="mb-3">
                    <label for="cpassword">Confirm Password</label>
                    <input type="password" id="cpassword" name="cpassword" required placeholder="Confirm your password">
                </div>
                <input type="submit" name="submit" value="Register Now" class="form-btn">
                <p>Already have an account? <a href="login.php">Login now</a></p>
            </form>
        </div>
        <!-- Tombol untuk mengarahkan kembali ke halaman login -->
    </div>
</body>
</html>
