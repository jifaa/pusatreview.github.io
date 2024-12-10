<?php

include 'db_connect.php';

// Query untuk menda
$query = "
    SELECT id, title, genre, 'movie' AS type, poster_url
    FROM media
";


$result = $conn->query($query);
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Movie</title>
    </head>
    <body class="bg-info-subtle">

    <?php
    include 'navbar.php';
    ?>

    <center><h1 style="margin-top: 7%; background-color: #45f3ff" class="pb-4 pt-4">Kategori Movie</h1></center>
    <div style="padding-top: 20px; margin-top: -8px;">
        <div class="me-5">
        <div class="row" style="margin-top:">
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
<?php
include "offcanvas.php";
?>
        </div>
    </div>
    </body>
</html>
