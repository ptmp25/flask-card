<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wordId = $_POST['word_id'];
    $chosenIndex = $_POST['chosen_definition'];

    $word = fetchWord($wordId);
    // Check if the user's answer is correct
    $isCorrect = ($chosenIndex == $word['definition']);

    // Display the result
    echo "Your answer is " . ($isCorrect ? "correct" : "incorrect") . "!";
    if ($isCorrect) {
        updateReview($wordId);
    } else{
        // echo $chosenIndex . ' ' . $word['id'];
        resetReview($$wordId);
    }
    // echo $word['word'] . ':' . $word['definition'] . "\n"; 
    echo "<a href=\"card.php\">Next </a>";
}
?>