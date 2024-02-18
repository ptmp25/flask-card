<?php
session_start();
try {
    // Connect to the database using PDO
    $db = new PDO('mysql:host=localhost;dbname=flask_card', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$username = "";
$email = "";
$errors = array();
$success = "";

if (isset($_POST['register_btn'])) {
    register();
} 

function register(){
    global $db, $errors, $username, $success;
    $username = e($_POST['username']);
    $email = e($_POST['email']);
    $password_1 = e($_POST['password_1']);
    $password_2 = e($_POST['password_2']);
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    if (strlen($password_1) < 6 || strlen($password_1) > 25) {
        array_push($errors, "Password must be between 6 and 25 characters long");
    }
    // Check if the username already exists in the database
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Username already exists, display an error message
        array_push($errors, "Username already exists");
    }
    // Check if the Email already exists in the database
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Email already exists, display an error message
        array_push($errors, "Email already exists");
    }

    if (count($errors) == 0) {
        $password = password_hash($password_1, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, password, email) VALUES('$username', '$password', '$email')";
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $db->exec($query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    }
}
function e($val)
{
    // Use htmlspecialchars for escaping user input when displaying it on the page
    return htmlspecialchars(trim($val), ENT_QUOTES, 'UTF-8');
}
function display_error()
{
    global $errors;

    if (count($errors) > 0) {
        echo '<div class="error">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
}


if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("Location: ../auth/login.php");
}

// LOGIN USER
function login()
{
    global $db, $username, $errors;
    $errors = array();
    // Grab form values
    $username = e($_POST['username']);
    $password = e($_POST['password']);

    // Make sure the form is filled properly
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // Attempt login if no errors on the form
    if (count($errors) == 0) {
        // Hash the password using PHP's password_hash function before comparing
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // User found and password matches
                $_SESSION['user'] = $user;
                $_SESSION['success'] = "You are now logged in";
                header('Location: index.php');

            } else {
                array_push($errors, "Wrong username/password combination");
            }
        } else {
            array_push($errors, "User not found");
        }
    }
}

function isLoggedIn()
{
    return (isset($_SESSION['user']));
}