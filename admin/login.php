<?php include('../config/constants.php');
?>
<html>

<head>
    <title>Login-Food Order</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br><br>
        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        if (isset($_SESSION['no-login-message'])) {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }

        ?>
        <br>
        <!-- Login From Start -->
        <form action="" method="POST" class="text-center">Username: <br>
            <input type="text" name="username" placeholder="Enter username"><br><br>
            Password: <br>
            <input type="password" name="password" placeholder="Enter password"><br><br>
            <input type="submit" name="submit" value="Login" class="btn-primary"><br><br>
        </form>
        <!-- Login From end -->
        <p class="text-center">Created by- <a href="">Shreya Shahir</a></p>
    </div>
</body>

</html>
<?php
//check the submit is clicked or not
if (isset($_POST['submit'])) {
    //process for login
    // get the data form login form
    $usename = $_POST['username'];
    $password = md5($_POST['password']);
    //username,password exist match or not
    $sql = "SELECT * FROM  tbl_admin WHERE username='$usename' AND password='$password'";
    //Exicute Query
    $res = mysqli_query($conn, $sql);

    //count rows to check exist or  not
    $count = mysqli_num_rows($res);
    if ($count == 1) {
        //user available login succes
        $_SESSION['login'] = "<div class='success'>Login Successful</div>";
        $_SESSION['user'] = $usename;
        header('location:' . SITEURL . 'admin/');
    } else {
        //user not available
        $_SESSION['login'] = "<div class='error text-center'>Username or password did not match.</div>";
        header('location:' . SITEURL . 'admin/login.php');
    }
}
