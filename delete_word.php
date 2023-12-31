<?php
session_start();
try {
    // Connect to the database using PDO
    $db = new PDO('mysql:host=localhost;dbname=flask_card', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Assuming you have a PDO instance $db
$word_id = $_POST['word_id'];

$sql = "DELETE FROM words WHERE id = :word_id";
$stmt = $db->prepare($sql);

$stmt->bindParam(':word_id', $word_id);

if ($stmt->execute())
    header("Location: index.php");
?>