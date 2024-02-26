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
include('header.php');
?>

<body>
    <div class="card">
        <div class="front detail">
            <?php
            $randomIndex = array_rand($words);
            $randomWord = $words[$randomIndex];
            echo $randomWord['word'];
            ?>
        </div>
        <div class="back detail">
            <?php
            echo $randomWord['description'];
            ?>
        </div>
    </div>
    <script>
        // document.querySelector(".card").addEventListener("click", function() {
        //         document.querySelector(".front").style.display = "none";
        //         document.querySelector(".back").style.display = "flex";
        //     });

        document.querySelector(".card").addEventListener("click", function () {
            if (document.querySelector(".front").style.display === "flex") {
                document.querySelector(".front").style.display = "none";
                document.querySelector(".back").style.display = "flex";
            }
            else {
                document.querySelector(".front").style.display = "flex";
                document.querySelector(".back").style.display = "none";
            }
        });
    </script>
</body>

</div>
</body>