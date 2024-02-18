<?php
require "auth.php";
if (!isLoggedIn()) {
    header("Location: login.php");
}
$user_id = $_SESSION['user']['user_id'];
$topic_id = $_GET['topic_id'];
$stmt = $db->prepare("SELECT * FROM words WHERE user_id = :user_id AND topic_id = :topic_id");
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
if (!$stmt->execute()) {
    echo "Error: " . $stmt->errorInfo()[2];
    exit();
}
$words = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($words === false) {
    header("Location: index.php");
    exit();
}
include('header.php');
?>

<body>

    <form action="new_word.php" method="post">
        <!-- <?php echo $topic_id; ?> -->
        <label for="word">Word</label>
        <input type="text" name="word" id="word">
        <label for="description">Description</label>
        <input type="text" name="description" id="description">
        <!-- <label for="Sound">Sound</label>
        <input type="file" name="sound" id="sound"> -->
        <input type="submit" value="Add word">
    </form>

    <table>
        <tr>
            <th>Word</th>
            <!-- <th>Pronounce</th> -->
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php foreach ($words as $line): ?>
            <tr>
                <td>
                    <?php echo $line['word']; ?>
                </td>
                 <td>
                    <button onclick="playSound('audio/uk_sound.mp3')">UK</button>
                    <button>us</button>
                </td> 
                <td>
                    <?php echo $line['description']; ?>
                </td>
                <td>
                    <form action="delete_word.php" method="post">
                        <input type="hidden" name="word_id" value="<?php echo $line['word_id']; ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>
<!-- 
<script>
    function playSound(soundFile) {
        var audio = new Audio(soundFile);
        audio.play();
    }
</script> -->