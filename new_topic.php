<?php
require "auth.php";
// $stmt = $db->prepare("SELECT * FROM topics WHERE user_id = :user_id");
// // $params = array(':user_id' => $_SESSION['user']['user_id']);
// // $stmt->execute($params);
// $stmt->bindParam(':user_id', $user_id);
// $stmt->execute();
// $words = $stmt->fetchAll(PDO::FETCH_ASSOC);
$user_id = $_SESSION['user']['user_id'];
include('header.php');
if (isset($_POST['add_topic_btn'])) {
    $stmt = $db->prepare("INSERT INTO topics (topic, description, user_id) VALUES (:topic, :description, :user_id)");
    $stmt->bindParam(':topic', $_POST['topic']);
    $stmt->bindParam(':description', $_POST['description']);
    $stmt->bindParam(':user_id', $user_id);
    // echo var_dump($_POST);
    try {
        $stmt->execute();
        header("Location: topic.php");
    } catch (PDOException $e) {
        echo ("Error: " . $e->getMessage());
    }
}
?>
<form action="new_topic.php" method="post">
    <!-- <label for="">
        <?php echo $user_id; ?>
    </label> -->
    <label for="topic">Topic</label>
    <input type="text" name="topic" id="topic">
    <label for="description">Description</label>
    <input type="text" name="description" id="description">
    <input type="submit" value="Add" name="add_topic_btn">
</form>