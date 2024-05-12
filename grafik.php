<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "monitoring";

$connect = mysqli_connect($host, $user, $pass, $db);
if (!$connect) {
    die("Tidak bisa terkoneksi ke database: " . mysqli_connect_error());
}

// Query untuk mengambil data cabai
$sqlCabai = "SELECT * FROM monitoring";
$resultCabai = mysqli_query($connect, $sqlCabai);

if (!$resultCabai) {
    die("Query error: " . mysqli_error($connect));
}

// Ambil data cabai dari database
$dataSuhu = [];
$dataKonsentrasiGas = [];

while ($rowCabai = mysqli_fetch_assoc($resultCabai)) {
    $nilaiSuhu = $rowCabai['nilai_suhu'];
    $konsentrasiGas = $rowCabai['konsentrasi_gas'];
    $tanggal = $rowCabai['tanggal'];
    $waktu = $rowCabai['waktu'];

    $timestamp = strtotime($tanggal . ' ' . $waktu);

    $dataSuhu['labels'][] = date('Y-m-d H:i:s', $timestamp);
    $dataSuhu['nilai_suhu'][] = $nilaiSuhu;

    $dataKonsentrasiGas['labels'][] = date('Y-m-d H:i:s', $timestamp);
    $dataKonsentrasiGas['konsentrasi_gas'][] = $konsentrasiGas;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Grafik</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap");

        * {
            margin: 0;
            padding: 0;
            border: none;
            outline: none;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
        }

        .sidebar {
            position: sticky;
            top: 0;
            left: 0;
            bottom: 0;
            width: 110px;
            height: 100vh;
            padding: 0 1.7rem;
            color: #fff;
            overflow: hidden;
            transition: all 0.5s linear;
            background: rgba(113, 99, 186, 255);
        }

        .sidebar:hover {
            width: 240px;
            transition: 0, 5s;
        }

        .logo {
            height: 80px;
            padding: 16px;
        }

        .menu {
            height: 88%;
            position: relative;
            list-style: none;
            padding: 0;
        }

        .menu li {
            padding: 1rem;
            margin: 8px 0;
            border-radius: 8px;
            transition: all 0.5s ease-in-out;
        }

        .menu li:hover,
        .active {
            background: #e0e0e058;
        }

        .menu a {
            color: #fff;
            font-size: 14px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .menu a span {
            overflow: hidden;
        }

        .menu a i {
            font-size: 1.2rem;
        }

        .logout {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        .main--content {
            flex: 1;
            position: relative;
            background: #ebe9e9;
            padding: 1rem;
            display: flex; /* Add this to make the charts display side by side */
            gap: 20px; /* Adjust the gap between charts as needed */
        }

        .chart-container {
            width: 48%;
            float: left;
            height: 400px; /* Sesuaikan tinggi grafik */
            margin-right: 20px;
        }

        .chart-container:nth-child(2) {
            width: 50%;
            float: right;
            height: 400px; /* Sesuaikan tinggi grafik */
        }

        .content canvas {
            max-width: 100%;
            max-height: 100%;
            width: 100%;
            height: 100%;
        }

        .header--wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            border-radius: 10px;
            padding: 10px 2rem;
            margin-bottom: 1rem;
        }

        .header--title {
            color: rgba(113, 99, 186, 255);
        }

        .search--box {
            background: rgb(237, 237, 237);
            border-radius: 15px;
            color: rgba(113, 99, 186, 255);
            display: flex;
            align-items: center;
            gap: 1s;
            padding: 0.5px 12px;
        }

        .search--box input {
            background: transparent;
            padding: 10px;
        }

        .search--box i {
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.5s ease-out;
        }

        .search--box:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<body>
<div class="sidebar">
        <div class="logo"></div>
        <ul class="menu">
            <li class="active">
                <a href="coba.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="index.php">
                    <i class="fas fa-table"></i>
                    <span>Input Data</span>
                </a>
            </li>
            <li>
                <a href="grafik.php">
                    <i class="fas fa-chart-line"></i>
                    <span>Data Grafik</span>
                </a>
            </li>
            <li class="logout">
                <a href="login.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>                
        </ul>
    </div>
    
    <div class="main--content">
        <div class="chart-container">
            <!-- Chart for Nilai Suhu -->
            <canvas id="chart_suhu"></canvas>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx_suhu = document.getElementById("chart_suhu").getContext("2d");

                var myChart_suhu = new Chart(ctx_suhu, {
                    type: "line",
                    data: {
                        labels: <?php echo json_encode($dataSuhu['labels']); ?>,
                        datasets: [
                            {
                                label: 'Nilai Suhu',
                                borderColor: 'red',
                                data: <?php echo json_encode($dataSuhu['nilai_suhu']); ?>,
                                fill: false
                            }
                        ]
                    },
                    options: {
                        // Konfigurasi Chart.js jika diperlukan
                    }
                });
            </script>
        </div>

        <div class="chart-container">
            <!-- Chart for Konsentrasi Gas -->
            <canvas id="chart_gas"></canvas>
            <script>
                var ctx_gas = document.getElementById("chart_gas").getContext("2d");

                var myChart_gas = new Chart(ctx_gas, {
                    type: "line",
                    data: {
                        labels: <?php echo json_encode($dataKonsentrasiGas['labels']); ?>,
                        datasets: [
                            {
                                label: 'Konsentrasi Gas',
                                borderColor: 'blue',
                                data: <?php echo json_encode($dataKonsentrasiGas['konsentrasi_gas']); ?>,
                                fill: false
                            }
                        ]
                    },
                    options: {
                        // Konfigurasi Chart.js jika diperlukan
                    }
                });
            </script>
        </div>
    </div>
</body>
</html>