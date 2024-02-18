<?php
require "auth.php";
if (!isLoggedIn()) {
    header("Location: login.php");
}

// Assuming you have a PDO instance $db
$word = $_POST['word'];
$description = $_POST['description'];
$user_id = $_SESSION['user']['user_id'];

$sql = "INSERT INTO words (word, description, user_id, repetitions) VALUES (:word, :description, :user_id, 0)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':word', $word);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
if ($stmt->execute())
    header("Location: index.php");

?>