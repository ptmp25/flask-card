<?php
require 'auth.php';

if (isLoggedIn()) {
    header("Location: index.php");
}

if (isset($_POST['login_btn'])) {
    login();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form method="post" action="login.php">

        <div class="container">
            <div class="card">
                <div class="card-header">Login</div>
                <?php echo display_error(); ?>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" name="login_btn" class="btn btn-primary text-center">Login</button>
                        </div>
                    </form>
                    <p>
                        Not yet a member? <a href="register.php">Sign up</a>
                    </p>
                </div>
            </div>
        </div>
    </form>
</body>

</html>