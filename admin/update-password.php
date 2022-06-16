<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>

        <br><br>
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password</td>
                    <td>
                        <input type="password" name="current_password" value="" placeholder="Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php
//check wheter the submit button clicked or not
if (isset($_POST['submit'])) {
    //get the data from form


    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    //current password
    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

    //exicute the query
    $res = mysqli_query($conn, $sql);
    if ($res == TRUE) {
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            //change password
            //echo "User Found";
            ///check whether the new pass and confirm match or not
            if ($new_password == $confirm_password) {
                $sql2 = "UPDATE tbl_admin SET
                password='$new_password'
                WHERE id=$id";
                //Exicute the query
                $res2 = mysqli_query($conn, $sql2);
                if ($res2 == TRUE) {
                    //display massege
                    $_SESSION['change-pwd'] = "<div class='success'>Password Change Successfully</div>";
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                } else {
                    //display errror massege
                    $_SESSION['change-pwd'] = "<div class='errors'> Failed to Change Password</div>";
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            } else {
                //dose not exit
                $_SESSION['pass-not-match'] = "<div class='error'>Password Not Match</div>";
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        } else {
            //dose not exit
            $_SESSION['user-not-found'] = "<div class='error'>User Not found</div>";
            header('location:' . SITEURL . 'admin/manage-admin.php');
        }
    }
    //confirm password
    //change password
}
?>
<?php include('partials/footer.php');
?>