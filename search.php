<?php
// Sertakan file koneksi database
include 'db_connect.php';

// Ambil kata kunci pencarian dari input pengguna
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Sanitasi input untuk mencegah SQL Injection
$query = $conn->real_escape_string($query);

// Query untuk mencari film atau buku berdasarkan judul atau genre
$sql = "
    SELECT id, title, synopsis, type, genre, poster_url 
    FROM media 
    WHERE title LIKE '%$query%' 
       OR genre LIKE '%$query%' 
    ORDER BY title ASC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Search Results</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div style="background-color: #c4f1ff; padding-top: 20px; margin-top: -8px;">
    <div class="ms-3 me-3" style="margin-top: 7%;">
        <h1 class="mb-4">Hasil pencarian: "<?php echo htmlspecialchars($query); ?>"</h1>
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
                echo "<p class='text-center'>No results found for \"$query\".</p>";
            }
            ?>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
