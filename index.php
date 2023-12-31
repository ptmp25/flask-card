<?php

session_start();
try {
    // Connect to the database using PDO
    $db = new PDO('mysql:host=localhost;dbname=flask_card', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
$stmt = $db->prepare("SELECT * FROM words");
$stmt->execute();
$words = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New word</title>
</head>

<body>
    <?php foreach ($words as $word): ?>
        <p>Term:
            <?php echo $word['term']; ?>
        </p>
        <p>Definition:
            <?php echo $word['definition']; ?>
        </p>
        <form action="delete_word.php" method="post">
            <input type="hidden" name="word_id" value="<?php echo $word['id']; ?>">
            <input type="submit" value="Delete">
        </form>
    <?php endforeach; ?>
    <form action="new_word.php" method="post">
        <label for="term">Term</label>
        <input type="text" name="term" id="term">
        <label for="definition">Definition</label>
        <input type="text" name="definition" id="definition">
        <input type="submit" value="Add word">
    </form>
</body>

</html>