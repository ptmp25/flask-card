<?php

require "auth.php";
if (!isLoggedIn()) {
    header("Location: login.php");
}
$user_id = $_SESSION['user']['user_id'];
$topic_id = $_GET['topic_id'];
$time = time();
$stmt = $db->prepare("SELECT * FROM words WHERE topic_id = :topic_id and review_time <= :time");
$stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
$stmt->bindParam(':time', $time, PDO::PARAM_INT);
if (!$stmt->execute()) {
    echo "Error: " . $stmt->errorInfo()[2];
    exit();
}
$words = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <!-- <link rel="stylesheet" href="basic.css"> -->
</head>

<body>
    <?php include('header.php'); ?>
    <div class="card">
        <div class="detail front">
            <?php
            $randomIndex = array_rand($words);
            $randomWord = $words[$randomIndex];
            echo $randomWord['word'];
            ?>
        </div>
        <div class="detail back">
            <?php
            echo $randomWord['description'];
            ?>
        </div>
    </div>
    <script>
        var cards = document.querySelectorAll('.card');

        [...cards].forEach((card) => {
            card.addEventListener('click', function () {
                card.classList.toggle('is-flipped');
            });
        });
    </script>
</body>

</div>
</body>