<?php 
require 'auth.php';

if (isLoggedIn()) {
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="register container">
        <div class="card">
            <div class="card-header">
                <h2>Register</h2>
            </div>
            <form method="post" action="register.php" enctype="multipart/form-data">
                <div class="card-body">
                    <!-- show error message  -->
                    <em><?php echo display_error(); ?></em>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password_1">Password</label>
                        <input type="password" class="form-control" name="password_1">
                    </div>
                    <div class="form-group">
                        <label for="password_2">Confirm password</label>
                        <input type="password" class="form-control" name="password_2">
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary register_btn" name="register_btn">Register</button>
                    </div>
                    <p>
                        Already a member? <a href="login.php">Log in</a>
                    </p>
            </form>
        </div>
    </div>
</body>

</html>