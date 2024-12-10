<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit;
}
?>

<?php
// Sertakan file koneksi database
include 'db_connect.php';

// Query untuk mendapatkan data terbaru
$query = "
    SELECT id, title, synopsis, type, genre, type, poster_url
    FROM media
";

$result = $conn->query($query);
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Homepage</title>
    <style>
        .stroked-text {
            font-size: 48px;
            color: #45f3ff;
            -webkit-text-stroke: 1px black; 
        }
    </style>
  
  </head>
  <body>

<?php
include 'navbar.php';
?>


<section class="header">
  
    <div class="mb-3" style="background-color: #23242a; margin-right: 15%;">
    <center><h1 style="margin-top: 7%; font-size: 60px; padding-top: 3%;" class="stroked-text"><strong><?php if (isset($_SESSION['username'])): ?>
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <?php else: ?>
            <a href="login.php">Login</a>
            <?php endif; ?></strong></h1></center>
        <div class="d-flex container align-items-center" style="margin-top: 1%;">
            <div class="col-md-5 mb-5 ms-5 mt-3">
                <h1 class="mb-4" style="padding-top: 15px; color: #45f3ff;"><b>PUSAT REVIEW</b></h1>
                <p style="text-align: justify; color: #45f3ff; margin-right: -60%;">Selamat datang di platform kami, wadah khusus tempat Anda dapat menjelajahi dan menilai film dan buku terbaru yang Anda sukai. Baik Anda seorang cinephile atau pembaca setia, ini adalah tempat untuk menemukan judul-judul baru, mempelajari sinopsis mendetail, dan berbagi pemikiran Anda dengan komunitas sesama penggemar. Dari rilis film terbaru hingga film terlaris terbaru, kami menghadirkan beragam konten pilihan hanya untuk Anda. Jangan ragu untuk mengungkapkan pendapat Anda, menilai pilihan favorit Anda</p>
            </div>
            <img class="" style="padding-top: 35px; padding-bottom: 35px; padding-left: 35px; padding-right: 35px; margin-left: 45%; width: 25%; background-color: #45f3ff; z-index: 20; margin-top: -9%;" src="review.png" alt="">  
        </div>
      </div>    
  
</section>


<center><h1 class="pt-4 pb-4" style="background-color: #45f3ff"> Film dan Buku Terbaru</h1></center>
<div class="bg-info-subtle" style= "padding-top: 20px; margin-top: -8px;">
<div  class="me-5">
        <div class="row">

          <?php
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "
                    <div class='col-md-2'>
                        <a href='detail.php?id=". $row['id'] . "&type=". $row['type'] . "' class='text-decoration-none text-dark'>
                        <div class='card border-primary-subtle mb-3 border border-3' style='background-color: #28292d'>
                          <img style='width: 90%; margin-left: 5%; margin-top: 30%;' src='" . $row['poster_url'] . "' class='card-img-top rounded' alt='" . $row['title'] . "'>
                          <div class='card-body'>
                            <h5 class='card-title pb-1' style='color: #45f3ff'>" ?>
                            <?php echo strlen($row['title']) > 20 ? substr($row['title'], 0, 20) . "..." : $row['title']; ?>
                            <?php echo "</h5>
                            <table style='color: #45f3ff'>
                              <tr>
                                <td><strong>Type </strong>  </td>
                                <td> <strong>:</strong> </td>
                                <td> " . ucfirst($row['type']) . "</td>
                              </tr>
                              <tr>
                                <td><strong>Genre </strong> </td>
                                <td> <strong>:</strong> </td>
                                <td>" . $row['genre'] . "</td>
                              </tr>
                            </table>
                          </div>
                        </a>
                      </div>
                  </div>
                  ";
              }
          } else {
              echo "<p class='text-center'>Tidak ada data tersedia.</p>";
          }
          ?>
        
        </div>
    </div>
</div>

<?php
include "offcanvas.php";
?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  </body>
</html>