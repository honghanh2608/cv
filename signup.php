<?php
$err = [];
$username = '';
$password = '';
$confirmPassword = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $flag = true;
    $confirmPassword = $_POST['confirm_password'];
    if (empty($username)) {
        $err['username'] = 'Username can not be empty';
        $flag = false;
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $nameErr = "Only letters or digits allowed";
        $flag = false;
    }

    if (strlen($password) < 6) {
        $err['password'] = 'Password must be at least 6 character';
        $flag = false;
    } else if (preg_match("/ $/", $password)) {
        $err['password'] = 'Password can not contain space';
        $flag = false;
    }

    if ($password != $confirmPassword) {
        $err['confirmPassword'] = 'Confirm password is not match';
        $flag = false;
    }

    if ($flag) {
        $connection = mysqli_connect('localhost', 'root', '', 'cv');
        if (checkDuplicate($connection, $username)) {
            $err['username'] = "Username has been existed already";
        } else {
            $sql = "INSERT INTO user(username, password) VALUES ('$username','$password')";
            $isSuccess = mysqli_query($connection, $sql);
            if ($isSuccess) {
                $userId = getUserId($connection, $username);
                header("Location: index.php?user=$userId");
            } else {
                $err['sql'] = 'Something went wrong! Please try again later.';
            }
        }
        mysqli_close($connection);
    }
}

function getUserId($connection, $username) {
    $query = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($connection, $query);
    return $result -> fetch_row()[0];
}

function checkDuplicate($connection, $username)
{
    $query = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result) > 0;
}

?>
<html lang="vi">
<head>
    <title>CV | Sign Up</title>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="signup.css">
    <meta charset="utf-8">
</head>
<body>
<form class="form" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <div class="form_input">
        <label>
            <span class="field">Username:</span>
            <input class="text_input" name="username" value="<?php echo $username ?>"/>
            <span class="field">
                 <?php
                 if (array_key_exists('username', $err)) {
                     echo $err['username'];
                 }
                 ?>
            </span>
        </label><br>
        <label>
            <span class="field">Password:</span>
            <input class="text_input" name="password" value="<?php echo $password ?>">
            <span class="field">
            <?php
            if (array_key_exists('password', $err)) {
                echo $err['password'];
            }
            ?>
            </span>
        </label><br>
        <label>
            <span class="field">Confirm password:</span>
            <input class="text_input" name="confirm_password" value="<?php echo $confirmPassword ?>">
            <span class="field">
            <?php
            if (array_key_exists('confirmPassword', $err)) {
                echo $err['confirmPassword'];
            }
            ?>
            </span>
        </label><br>
        <span class="field">
        <?php
        if (array_key_exists('sql', $err)) {
            echo $err['sql'];
        }
        ?>
        </span>
    </div>
    <input class="btn_submit" type="submit" name="submit" value="SIGN UP">
</form>
</body>
</html>