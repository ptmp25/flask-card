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
$word = $_POST['word'];
$definition = $_POST['definition'];

$sql = "INSERT INTO vocabulary (word, definition, repetition_number) VALUES (:word, :definition, 0)";
$stmt = $db->prepare($sql);

$stmt->bindParam(':word', $word);
$stmt->bindParam(':definition', $definition);

if ($stmt->execute())
    header("Location: index.php");

?>