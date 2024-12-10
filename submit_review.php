<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('You must be logged in to submit a review.');
            window.location.href = 'login.php';
          </script>";
    exit;
}

if (!isset($_POST['content_id'], $_POST['content_type'], $_POST['rating'], $_POST['review_text'])) {
    echo "<script>
            alert('Invalid input. Please try again.');
            window.history.back();
          </script>";
    exit;
}

$content_id = intval($_POST['content_id']);
$content_type = $conn->real_escape_string($_POST['content_type']);
$user_id = $_SESSION['user_id'];
$rating = intval($_POST['rating']);
$review_text = $conn->real_escape_string($_POST['review_text']);

// Periksa apakah pengguna sudah memberikan ulasan
$check_query = "SELECT * FROM Reviews 
                WHERE content_id = $content_id 
                AND content_type = '$content_type' 
                AND user_id = $user_id";
$check_result = $conn->query($check_query);

if ($check_result === false) {
    die("SQL Error: " . $conn->error);
}

if ($check_result->num_rows > 0) {
    echo "<script>
            alert('You have already submitted a review for this content.');
            window.history.back();
          </script>";
    exit;
} else {
    $insert_query = "INSERT INTO Reviews (content_id, content_type, user_id, rating, review_text, created_at)
                     VALUES ($content_id, '$content_type', $user_id, $rating, '$review_text', NOW())";

    if ($conn->query($insert_query) === true) {
        echo "<script>
                alert('Your review has been submitted.');
                window.location.href = 'detail.php?id=$content_id&type=$content_type';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
