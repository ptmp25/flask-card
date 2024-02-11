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
        header('Location: update_review.php');
    } else{
        // echo $chosenIndex . ' ' . $word['id'];
        resetReview($wordId);
        echo "<a href=\"card.php\">Next </a>";
    }
    // echo $word['word'] . ':' . $word['definition'] . "\n"; 
}
?>