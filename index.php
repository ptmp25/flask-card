<?php
require "auth.php";
$stmt = $db->prepare("SELECT * FROM topics WHERE user_id = :user_id");
// $params = array(':user_id' => $_SESSION['user']['user_id']);
// $stmt->execute($params);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$words = $stmt->fetchAll(PDO::FETCH_ASSOC);
include('header.php');
?>

<body>
    <table>
        <tr>
            <th>Topic</th>
            <th>Description</th>
        </tr>
        <?php foreach ($words as $word) { ?>
            <tr>
                <td>
                    <?php echo $word['topic']; ?>
                </td>
                <td>
                    <?php echo $word['description']; ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <a href="new_topic.php">New Topic</a>
</body>

</html>