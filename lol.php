<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "monitoring";

$connect    = mysqli_connect($host, $user, $pass, $db);
if (!$connect) {
    die("Tidak bisa terkoneksi ke database");
}

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id = $_GET['id'];
    $sqlDelete = "DELETE FROM monitoring WHERE id = '$id'";
    $qDelete = mysqli_query($connect, $sqlDelete);
    if ($qDelete) {
        $sukses = "Data berhasil dihapus";
    } else {
        $error = "Data gagal dihapus";
    }
}

if ($op == 'edit') {
    $id                 = $_GET['id'];
    $sql1               = "SELECT * FROM monitoring WHERE id = '$id'";
    $q1                 = mysqli_query($connect, $sql1);
    $r1                 = mysqli_fetch_array($q1);
    $cabai              = $r1['cabai'];
    $nilai_suhu         = $r1['nilai_suhu'];
    $konsentrasi_gas    = $r1['konsentrasi_gas'];
    $tanggal            = $r1['tanggal'];
    $waktu              = $r1['waktu'];

    if ($cabai == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) { // untuk create atau update
    $cabai              = mysqli_real_escape_string($connect, $_POST['cabai']);
    $nilai_suhu         = mysqli_real_escape_string($connect, $_POST['nilai_suhu']);
    $konsentrasi_gas    = mysqli_real_escape_string($connect, $_POST['konsentrasi_gas']);
    $tanggal            = mysqli_real_escape_string($connect, $_POST['tanggal']);
    $waktu              = mysqli_real_escape_string($connect, $_POST['waktu']);

    if ($cabai && $nilai_suhu && $konsentrasi_gas) {
        if ($op == 'edit') { // untuk update
            $sql1       = "UPDATE monitoring SET cabai = '$cabai', nilai_suhu = '$nilai_suhu', konsentrasi_gas = '$konsentrasi_gas', tanggal = '$tanggal', waktu = '$waktu' WHERE id = '$id'";
            $q1         = mysqli_query($connect, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { // untuk insert
            $sql1   = "INSERT INTO monitoring (cabai, nilai_suhu, konsentrasi_gas, tanggal, waktu) VALUES ('$cabai', '$nilai_suhu', '$konsentrasi_gas', '$tanggal', '$waktu')";
            $q1     = mysqli_query($connect, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Data Cabai</title>
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
            position: relative;
            background: #ebe9e9;
            width: 100%;
            padding: 1rem;
        }

        .header--wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            background: #fff;
            border-radius: 10px;
            padding: 10px 2rem;
            margin-bottom: 1rem;
        }

        .header--title {
            color: rgba(113, 99, 186, 255);
        }

        .search--box {
            position: absolute;
            right: 2rem;
            top: 1.5rem;
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

        .card--container {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
        }

        .main--title {
            color: rgba(113, 99, 186, 255);
            padding-bottom: 10px;
            font-size: 15px;
        }

        .tabular--wrapper {
            background: #fff;
            margin-top: 1rem;
            border-radius: 10px;
            padding: 1rem;
        }

        .table--container {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: rgba(113, 99, 186, 255);
            color: #fff;
        }

        th {
            padding: 15px;
            text-align: left;
        }

        tbody {
            background: #f2f2f2;
        }

        td {
            padding: 15px;
            font-size: 14px;
            color: #333;
        }

        /* Keep the even row background color */
        tr:nth-child(even) {
            background: #fff;
        }

        tfoot {
            background: rgba(113, 99, 186, 255);
            font-weight: bold;
            color: #fff;
        }

        tfoot td {
            color: green;
            background: none;
        }

        .form--container {
            display: flex;
            flex-direction: column;
            margin-top: 1rem;
        }

        .form--container label,
        .form--container input {
            margin-bottom: 10px;
        }

        .form--container form {
            width: 100%;
        }

        .form--field {
            flex: 1;
            margin: 0 10px 10px 0;
        }
        .edit {
        cursor: pointer;
        color: #fff;
        background-color: rgba(113, 99, 186, 0.7);
        padding: 0 10px;
        border-radius: 5px;
        }

        .edit:hover {
        background-color: rgba(113, 99, 186, 1);
        }

        .delete {
        cursor: pointer;
        color: #fff;
        background-color: #dc3545;
        padding: 0 10px;
        border-radius: 5px;
        }

        .delete:hover {
        background-color: #dc3545;
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
        <div class="header--wrapper">
            <div class="header--title">
                <h2>Data Tabel</h2>
            </div>
            <div class="search--box">
                <form action="" method="get">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Cari" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" />
                
                </form>
            </div>
        </div>
        <!-- Tambahkan formulir input di bawah tabel -->
        <div class="card--container">
            <div class="tabular--wrapper">
                <h3 class="main--title">Data Cabai</h3>
                <div class="table--container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Cabai</th>
                                <th>Nilai Suhu</th>
                                <th>Konsentrasi Gas</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sqlCabai = "SELECT * FROM monitoring";

                                // Cek apakah parameter pencarian diset
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $search = mysqli_real_escape_string($connect, $_GET['search']);
                                $sqlCabai .= " WHERE cabai LIKE '%$search%' OR nilai_suhu LIKE '%$search%' OR konsentrasi_gas LIKE '%$search%' OR tanggal LIKE '%$search%' OR waktu LIKE '%$search%'";
                            }
                                
                            $resultCabai = mysqli_query($connect, $sqlCabai);
                                
                            if (!$resultCabai) {
                                die("Query error: " . mysqli_error($connect));
                            }
                                

                            $urut = 1;
                             while ($rowCabai = mysqli_fetch_assoc($resultCabai)) {
                                $id = $rowCabai['id'];
                                $namaCabai = $rowCabai['cabai'];
                                $nilaiSuhu = $rowCabai['nilai_suhu'];
                                $konsentrasiGas = $rowCabai['konsentrasi_gas'];
                                $tanggal = $rowCabai['tanggal'];
                                $waktu = $rowCabai['waktu'];
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++ ?></th>
                                    <td><?php echo $namaCabai ?></td>
                                    <td><?php echo $nilaiSuhu ?></td>
                                    <td><?php echo $konsentrasiGas ?></td>
                                    <td><?php echo $tanggal ?></td>
                                    <td><?php echo $waktu ?></td>
                                    <td>
                                        <a href="?op=edit&id=<?php echo $id; ?>" class="edit"><i class="fas fa-edit"></i></a>
                                        <a href="?op=delete&id=<?php echo $id; ?>" class="delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }


                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Formulir Input -->
            <div class="form--container">
                <h3 class="main--title"><?php echo ($op == 'edit') ? 'Edit Data' : 'Tambah Data Baru'; ?></h3>
                <form action="" method="post" class="form--wrapper">
                    <div class="form--field">
                        <label for="cabai">Nama Cabai:</label>
                        <input type="text" name="cabai" value="<?php echo isset($cabai) ? $cabai : ''; ?>" required>
                    </div>

                    <div class="form--field">
                        <label for="nilai_suhu">Nilai Suhu:</label>
                        <input type="text" name="nilai_suhu" value="<?php echo isset($nilai_suhu) ? $nilai_suhu : ''; ?>" required>
                    </div>

                    <div class="form--field">
                        <label for="konsentrasi_gas">Konsentrasi Gas:</label>
                        <input type="text" name="konsentrasi_gas" value="<?php echo isset($konsentrasi_gas) ? $konsentrasi_gas : ''; ?>" required>
                    </div>

                    <div class="form--field">
                        <label for="tanggal">Tanggal:</label>
                        <input type="date" name="tanggal" value="<?php echo isset($tanggal) ? $tanggal : ''; ?>" required>
                    </div>

                    <div class="form--field">
                        <label for="waktu">Waktu:</label>
                        <input type="time" name="waktu" value="<?php echo isset($waktu) ? strtotime($waktu) : ''; ?>" required>
                    </div>

                    <button type="submit" name="simpan"><?php echo ($op == 'edit' || $op == 'delete') ? 'Simpan Perubahan' : 'Tambah Data'; ?></button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>