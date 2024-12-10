<?php
session_start();
include 'db_connect.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Ambil media ID dari URL
$media_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data media berdasarkan ID
$query = "SELECT * FROM media WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $media_id);
$stmt->execute();
$media = $stmt->get_result()->fetch_assoc();

if (!$media) {
    echo "Media tidak ditemukan.";
    exit;
}

// Jika form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = intval($_POST['rating']);
    $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
    $user_id = $_SESSION['user_id']; // ID pengguna dari sesi login

    // Validasi data
    if ($rating < 1 || $rating > 5 || empty($comment)) {
        $error_message = "Data tidak valid. Silakan coba lagi.";
    } else {
        // Masukkan data ke tabel 'reviews'
        $insert_query = "INSERT INTO reviews (media_id, user_id, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iiis", $media_id, $user_id, $rating, $comment);

        if ($stmt->execute()) {
            $success_message = "Ulasan Anda berhasil disimpan!";
        } else {
            $error_message = "Terjadi kesalahan: " . $stmt->error;
        }
    }
}

// Ambil ulasan untuk media ini
$review_query = "SELECT r.rating, r.comment, u.username, r.created_at 
                 FROM reviews r 
                 JOIN users u ON r.user_id = u.id 
                 WHERE r.media_id = ?";
$stmt = $conn->prepare($review_query);
$stmt->bind_param("i", $media_id);
$stmt->execute();
$reviews = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Detail Media</title>
</head>
<body>
<div class="container mt-5">
    <h1><?php echo htmlspecialchars($media['title']); ?></h1>
    <p><strong>Genre:</strong> <?php echo htmlspecialchars($media['genre']); ?></p>
    <p><strong>Sinopsis:</strong> <?php echo htmlspecialchars($media['synopsis']); ?></p>

    <hr>

    <!-- Form Ulasan -->
    <h3>Berikan Ulasan</h3>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-5)</label>
            <select name="rating" id="rating" class="form-select" required>
                <option value="">Pilih Rating</option>
                <option value="1">1 - Sangat Buruk</option>
                <option value="2">2 - Buruk</option>
                <option value="3">3 - Cukup</option>
                <option value="4">4 - Baik</option>
                <option value="5">5 - Sangat Baik</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="comment" class="form-label">Komentar</label>
            <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
    </form>

    <hr>

    <!-- Daftar Ulasan -->
    <h3>Ulasan</h3>
    <?php if ($reviews->num_rows > 0): ?>
        <ul class="list-group">
            <?php while ($review = $reviews->fetch_assoc()): ?>
                <li class="list-group-item">
                    <strong><?php echo htmlspecialchars($review['username']); ?></strong> 
                    memberikan rating <strong><?php echo $review['rating']; ?>/5</strong>
                    <p><?php echo htmlspecialchars($review['comment']); ?></p>
                    <small class="text-muted">Pada <?php echo $review['created_at']; ?></small>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Belum ada ulasan untuk media ini.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
