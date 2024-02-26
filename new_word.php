<?php
require "auth.php";
if (!isLoggedIn()) {
    header("Location: login.php");
}

// Assuming you have a PDO instance $db
$word = $_POST['word'];
$description = $_POST['description'];
$user_id = $_SESSION['user']['user_id'];
$topic_id = $_POST['topic_id'];
// note change to the following line
// sometime there is a problem with the topic_id being null, so we add it as an empty string if not set
if (!$topic_id) {
    header("Location: index.php");
    exit();
}

$sql = "INSERT INTO words (word, description, user_id, topic_id, repetitions, review_time) VALUES (:word, :description, :user_id, :topic_id, 0, 0)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':word', $word);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
if ($stmt->execute())
    header("Location: topic.php?topic_id=" . $topic_id);

?>