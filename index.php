<?php
require "auth.php";
if (!isLoggedIn()) {
    header("Location: login.php");
}
$user_id = $_SESSION['user']['user_id'];

$stmt = $db->prepare("SELECT * FROM topics WHERE user_id = :user_id");
// $params = array(':user_id' => $_SESSION['user']['user_id']);
// $stmt->execute($params);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

include('header.php');
?>

<head>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <div class="main">
        <!-- <?php echo  $user_id; ?> -->
        <table>
            <tr>
                <th>Topic</th>
                <th>Description</th>
            </tr>
            <?php foreach ($topics as $topic) { ?>
                <tr>
                    <td>
                        <a href="topic.php?topic_id=<?php echo $topic['topic_id'];?>"><?php echo $topic['topic']; ?></a>
                    </td>
                    <td>
                        <?php echo $topic['description']; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <a href="new_topic.php">New Topic</a>
    </div>
</body>

</html>