<?php
//user is logged or not
if (!isset($_SESSION['user'])) {
    //user is not login
    $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin panel.</div>";
    header('location:' . SITEURL . 'admin/login.php');
}
?>
