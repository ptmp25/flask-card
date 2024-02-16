<?php

session_start();
try {
    // Connect to the database using PDO
    $db = new PDO('mysql:host=localhost;dbname=flask_card', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
$stmt = $db->prepare("SELECT * FROM vocabulary");
$stmt->execute();
$words = $stmt->fetchAll(PDO::FETCH_ASSOC);
include('header.php');
?>

<body>

    <form action="new_word.php" method="post">
        <label for="word">Word</label>
        <input type="text" name="word" id="word">
        <label for="definition">Definition</label>
        <input type="text" name="definition" id="definition">
        <label for="Sound">Sound</label>
        <input type="file" name="sound" id="sound">
        <input type="submit" value="Add word">
    </form>

    <table>
        <tr>
            <th>Word</th>
            <th>Pronounce</th>
            <th>Definition</th>
            <th>Action</th>
        </tr>
        <?php foreach ($words as $word): ?>
            <tr>
                <td>
                    <?php echo $word['word']; ?>
                </td>
                <td>
                    <button onclick="playSound('audio/uk_sound.mp3')">UK</button>
                    <button>us</button>
                </td>
                <td>
                    <?php echo $word['definition']; ?>
                </td>
                <td>
                    <form action="delete_word.php" method="post">
                        <input type="hidden" name="word_id" value="<?php echo $word['id']; ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>

<script>
    function playSound(soundFile) {
        var audio = new Audio(soundFile);
        audio.play();
    }
</script>