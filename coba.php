><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap");
*{
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
.sidebar:hover{
width: 240px;
transition: 0,5s;

}
/* Dashboard icon */
.fas.fa-tachometer-alt {
  color: #fff;
  font-size: 24px;
}

/* Pencil icon */
.fas.fa-pencil-alt {
  color: #fff;
  font-size: 24px;
}

/* Table icon */
.fas.fa-table {
  color: #fff;
  font-size: 24px;
}

/* Chart icon */
.fas.fa-chart-line {
  color: #fff;
  font-size: 24px;
}

/* Sign out icon */
.fas.fa-sign-out-alt {
  color: #fff;
  font-size: 24px;
}

/* Search icon */
.fa-solid.fa-search {
  color: #fff;
  font-size: 24px;
}

.logo{
    height: 80px;
    padding: 16px;
}
.menu{
    height: 88%;
    position: relative;
    list-style: none;
    padding: 0;
}
.menu li{
    padding: 1rem;
    margin: 8px 0;
    border-radius: 8px;
    transition: all 0.5s ease-in-out;
}
.menu li:hover,
.active {
    background: #e0e0e058;
}
.menu a{
    color: #fff;
    font-size: 14px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}
.menu a span{
    overflow: hidden;
}
.menu a i{
    font-size: 1.2rem;
}
.logout{
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
    display: 50px;
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
    top: 2rem;
    background: rgb(237, 237, 237);
    border-radius: 15px;
    color: rgba(113, 99, 186, 255);
    display: flex;
    align-items: center;
    gap: 1s;
    padding: 4px 12px;
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
.search--box hover {
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
    padding: 2rem;
}
  
.table-container {
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
tbody{
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
tfoot{
    background: rgba(113, 99, 186, 255);
    font-weight: bold;
    color: #fff;
}
tfoot td {
    color: green;
    background: none;
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
                <span>Primary</span>
                <h2>Dashboard</h2>
            </div>
            <div class="search--box">
            <i class="fa-solid fa-search"></i>
            <input type="text" placeholder="Cari" />
            </div>
        </div>
    </div>


</body>
</html>