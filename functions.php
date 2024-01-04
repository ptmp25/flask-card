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

function updateReview($wordId, $intervalDays)
{
    global $db;

    $nextReviewDate = date('Y-m-d H:i:s', strtotime("+{$intervalDays} days"));

    $query = $db->prepare("UPDATE vocabulary SET last_reviewed = NOW(), next_review = :nextReview, interval_days = :intervalDays WHERE id = :wordId");
    $query->bindParam(':nextReview', $nextReviewDate);
    $query->bindParam(':intervalDays', $intervalDays);
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


function fetchWord($wordId){
    global $db;

    $query = $db->prepare("SELECT * FROM vocabulary WHERE id = :wordId");
    $query->bindParam(':wordId', $wordId);
    $query->execute();

    return $query->fetch(PDO::FETCH_ASSOC);
}