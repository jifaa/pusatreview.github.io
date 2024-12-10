<?php
// Sertakan file koneksi database
include 'db_connect.php';

// Tangkap parameter dari URL
$id = $_GET['id'];
$type = $_GET['type'];

// Query untuk mendapatkan detail item berdasarkan ID dan Type
$query = "SELECT * FROM Media WHERE id = $id AND type = '$type'";
$result = $conn->query($query);

// Cek apakah data ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<p>Data not found.</p>";
    exit;
}
$avg_rating_query = "SELECT AVG(rating) AS avg_rating FROM Reviews WHERE content_id = $id AND content_type = '$type'";
$avg_rating_result = $conn->query($avg_rating_query);

if ($avg_rating_result->num_rows > 0) {
    $avg_rating_row = $avg_rating_result->fetch_assoc();
    $avg_rating = round($avg_rating_row['avg_rating'], 1); // Pembulatan ke 1 desimal
} else {
    $avg_rating = "No ratings yet"; // Jika belum ada rating
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Detail Page</title>
</head>
<body class="bg-info-subtle">

<?php 
include 'navbar.php'; 
?>

<div class="container mt-5">
    <!-- Detail Konten -->
    <div class="row">
        <div class="col-md-4">
            <img src="<?php echo $row['poster_url']; ?>" class="poster rounded-5 mt-5" alt="<?php echo $row['title']; ?>" style="width: 100%; border: 5px solid #45f3ff">
        </div>
        <div class="col-md-8">
            <center><h1 class="mb-3 mt-5"><?php echo $row['title']; ?></h1></center>
            <table>
                <tr valign="top">
                    <td><strong>Creator</strong> </td>
                    <td> <strong>:</strong></td>
                    <td><?php echo $row['creator']; ?></td>
                </tr>
                <tr valign="top">
                    <td><strong>Type</strong></td>
                    <td> <strong>:</strong></td>
                    <td><?php echo ucfirst($row['type']); ?></td>
                </tr>
                <tr valign="top">
                    <td><strong>Genre</strong></td>
                    <td> <strong>:</strong></td>
                    <td><?php echo $row['genre']; ?></td>
                </tr>
                <tr valign="top">
                    <td><strong>Release</strong></td>
                    <td> <strong>:</strong></td>
                    <td><?php echo $row['year']; ?></td>
                </tr>
                <tr  valign="top">
                    <td><strong>Synopsis</strong></td>
                    <td> <strong>: </strong></td>
                    <td><?php echo $row['synopsis']; ?></td>
                </tr>
                <tr valign="top">
                    <td><strong>Rating</strong></td>
                    <td> <strong>: </strong></td>
                    <td><?php echo $avg_rating; ?> / 5</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Komentar dan Rating -->
    <div class="mt-5">
        <h2>Comments and Ratings</h2>
        <form action="submit_review.php" method="POST">
            <input type="hidden" name="content_id" value="<?php echo $id; ?>">
            <input type="hidden" name="content_type" value="<?php echo $type; ?>">

            <!-- Rating -->
            <div class="mb-3">
                <label for="rating" class="form-label"><strong>Rate this:</strong></label>
                <div class="rating-container">
                    <select name="rating" id="rating" class="form-select w-auto">
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Good</option>
                        <option value="3">3 - Average</option>
                        <option value="2">2 - Poor</option>
                        <option value="1">1 - Terrible</option>
                    </select>
                </div>
            </div>

            <!-- Komentar -->
            <div class="mb-3">
                <label for="comment" class="form-label"><strong>Your Comment:</strong></label>
                <textarea name="review_text" id="comment" class="form-control comment-box" rows="4" placeholder="Write your comment here..." required></textarea>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary" style="background-color: #45f3ff; border-color: #45f3ff;">Submit</button>
        </form>
    </div>

    <!-- Tampilkan Komentar -->
    <div class="mt-5">
        <h3>User Comments</h3>
        <ul class="list-group">
            <?php
            // Query untuk mengambil komentar dan username
            $comment_query = "SELECT r.*, u.username 
                  FROM Reviews r 
                  JOIN Users u ON r.user_id = u.id 
                  WHERE r.content_id = $id AND r.content_type = '$type' 
                  ORDER BY r.created_at DESC";
            $comment_result = $conn->query($comment_query);

            if ($comment_result->num_rows > 0) {
                while ($comment = $comment_result->fetch_assoc()) {
                    echo "
                    <li class='list-group-item'>
                        <strong>Username:</strong> " . $comment['username'] . "<br>
                        <strong>Rating:</strong> " . $comment['rating'] . "/5<br>
                        <strong>Comment:</strong> " . $comment['review_text'] . "<br>
                        <small><em>Posted on: " . $comment['created_at'] . "</em></small>
                    </li>
                    ";
                }
            } else {
                echo "<p>No comments yet. Be the first to comment!</p>";
            }
            ?>
        </ul>
    </div>
</div>
<?php
include "offcanvas.php";
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
