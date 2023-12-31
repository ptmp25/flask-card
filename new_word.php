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
$term = $_POST['term'];
$definition = $_POST['definition'];

$sql = "INSERT INTO words (term, definition) VALUES (:term, :definition)";
$stmt = $db->prepare($sql);

$stmt->bindParam(':term', $term);
$stmt->bindParam(':definition', $definition);

if ($stmt->execute())
    header("Location: index.php");

?>