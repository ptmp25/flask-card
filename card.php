<?php
include 'functions.php';

$word = getWordToReview();

if ($word) {
    $word_id = $word['id'];
    $definitions = getOtherDefinitions($word_id, 3);
} else {
    echo "No words to review at the moment. You're all caught up!";
    exit;
}
?>

<body>
    Word:
    <?php echo $word['word']; ?>
    <form action="process_answer.php" method="post">
        <input type="hidden" name="word_id" value="<?php echo $word_id; ?>">
        <?php
        foreach ($definitions as $definition) {
            echo "<button type='submit' name='chosen_definition' value='$definition'>$definition</button><br>";
        }
        ?>
    </form>

</body>