<?php
session_start();
if (isset($_COOKIE['user']) && isset($_COOKIE['pass'])) {
    $user = $_COOKIE['username'];
    $pass = $_COOKIE['password'];
} else {
    $user = "";
    $pass = "";
}
$_SESSION['logedin'] = true;
$_SESSION['attempts'] = 0;

if (isset($_SESSION['locked'])) {
    $time_taken = time() - $_SESSION['locked'];
    if ($time_taken > (1 * 60 * 60 * 24 * 30)) {
        unset($_SESSION['locked']);
        unset($_SESSION['attempts']);
    }
}

if (isset($_POST['login'])) {

    $con = mysqli_connect("localhost", "root", "", " rgi_student ");
    if (!$con) {
        die("Database connection error: " . mysqli_connect_error());
    }
    $username = mysqli_real_escape_string($con, $_POST["username"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);

    if (!empty($username) && !empty($password)) {

        $sql = " SELECT * FROM student_reg WHERE username='$username' ";
        $query = mysqli_query($con, $sql);

        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                if (password_verify($password, $row['password'])) {
                    echo '<script>alert("You logged in");</script>';
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    header("location:home.php");

                    if (isset($remember)) {
                        setcookie("username", $user, time() + (60 * 60 * 24));
                        setcookie("password", $pass, time() + (60 * 60 * 24));
                    } else {
                        setcookie("username", "", time() - (60 * 60 * 24));
                        setcookie("password", "", time() - (60 * 60 * 24));
                    }
                } else {
                    $_SESSION['attempts']++;
                    echo "Wrong username or password.";
                }
            }
        } else {
            echo '<script>alert("Username OR Password is incorrect.");</script>';
        }
    } else {
        echo "All the fields are required.";
    }
}
if (isset($_POST['register'])) {
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
    <style type="text/css">
        h1 {
            text-align: center;
        }

        h1,
        th {
            text-transform: uppercase;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        input {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>login</h1>
    <form method="post">
        <table align="center">
            <tr>
                <th><label>username:</label></th>
                <td> <input type="text" name="username" value="<?php echo $user; ?>"></td>
            </tr>
            <tr>
                <th><label>password:</label></th>
                <td> <input type="password" name="password" value="<?php echo $pass; ?>"></td>
            </tr>
            <tr>
                <td><button type="submit" name="register" value="register">REGISTER</button></td>
                <td><button type="submit" name="login" value="login">LOGIN</button></td>
            </tr>
            <tr>
                <td colspan='2' align="center"><input type="checkbox" name="remember" <?php
                                                                                        if (isset($_COOKIE['user'])) { ?> checked <?php } ?>>Remember me!</td>
            </tr>
        </table>
    </form>
</body>

</html>