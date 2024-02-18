<?php
session_start();
try {
    // Connect to the database using PDO
    $db = new PDO('mysql:host=localhost;dbname=flask_card', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}


function getWordToReview()
{
    global $db;

    $currentDate = date('Y-m-d H:i:s');

    $query = $db->prepare("SELECT * FROM vocabulary WHERE next_review IS NULL OR next_review <= :currentDate ORDER BY RAND() LIMIT 1");
    $query->bindParam(':currentDate', $currentDate);
    $query->execute();

    return $query->fetch(PDO::FETCH_ASSOC);
}

function getRepetitionNumber($wordId)
{
    global $db;

    $query = $db->prepare("SELECT repetitions FROM vocabulary WHERE id = :wordId");
    $query->bindParam(':wordId', $wordId);
    $query->execute();

    return $query->fetch(PDO::FETCH_COLUMN);
}

function increaseRepetition($wordId) 
{
    global $db;

    $query = $db->prepare("UPDATE vocabulary SET repetitions = repetitions + 1 WHERE id = :wordId");
    $query->bindParam(':wordId', $wordId);
    $query->execute();

}

function updateReview($wordId)
{
    global $db;

    increaseRepetition($wordId);

    // Assuming initial interval is stored in minutes
    $initialIntervalMinutes = 1; // Example: 1 day in minutes
    $repetitionNumber = getRepetitionNumber($wordId); // Implement a function to retrieve repetition number

    // Calculate the next interval in minutes
    $nextIntervalMinutes = $initialIntervalMinutes * (2 ** ($repetitionNumber - 1));

    // Calculate the next review date
    $nextReviewDate = date('Y-m-d H:i:s', strtotime("+{$nextIntervalMinutes} minutes"));

    // Update the database with the new review information
    $query = $db->prepare("UPDATE vocabulary SET last_reviewed = NOW(), next_review = :nextReview, repetitions = :repetitionNumber WHERE id = :wordId");
    $query->bindParam(':nextReview', $nextReviewDate);
    $query->bindParam(':repetitionNumber', $repetitionNumber);
    $query->bindParam(':wordId', $wordId);
    $query->execute();
}


function getOtherDefinitions($wordId, $num)
{
    global $db;

    $query = $db->prepare("SELECT definition FROM vocabulary WHERE id != :wordId ORDER BY RAND() LIMIT :num");
    $query->bindParam(':wordId', $wordId);
    $query->bindParam(':num', $num, PDO::PARAM_INT);
    $query->execute();

    $definitions = $query->fetchAll(PDO::FETCH_COLUMN);

    // Add the correct definition to the list
    $correctDefinition = getCorrectDefinition($wordId);
    array_push($definitions, $correctDefinition);

    // Shuffle the array to randomize the order
    shuffle($definitions);

    return $definitions;
}

function getCorrectDefinition($wordId)
{
    global $db;

    $query = $db->prepare("SELECT definition FROM vocabulary WHERE id = :wordId");
    $query->bindParam(':wordId', $wordId);
    $query->execute();

    return $query->fetch(PDO::FETCH_COLUMN);
}

function fetchWord($wordId)
{
    global $db;

    $query = $db->prepare("SELECT * FROM vocabulary WHERE id = :wordId");
    $query->bindParam(':wordId', $wordId);
    $query->execute();

    return $query->fetch(PDO::FETCH_ASSOC);
}

function resetReview($wordId)
{
    global $db;

    $query = $db->prepare("UPDATE vocabulary SET last_reviewed = NULL, next_review = NULL, repetitions = 0 WHERE id = :wordId");
    $query->bindParam(':wordId', $wordId);
    $query->execute();
}