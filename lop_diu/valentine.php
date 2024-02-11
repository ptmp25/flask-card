<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Will you be my valentine?</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="card">
        <p>Hey baby! I love you so much. Will you be my valentine?</p>
        <button class="btn" >Yes</button>
        <button class="btn" id="no">No</button>
    </div>

</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var button = document.getElementById("no");
        var originalText = button.innerHTML;

        button.addEventListener("mouseover", function () {
            button.innerHTML = "Of Course!";
        });

        button.addEventListener("mouseout", function () {
            button.innerHTML = originalText;
        });
    });
</script>

</html>