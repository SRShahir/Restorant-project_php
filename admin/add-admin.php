<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo ($_SESSION['add']); //display Session
            unset($_SESSION['add']); // Remove Sessions
        }
        ?>
        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td><input type="text" name="full_name" placeholder="Enter your Name"></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" placeholder="Enter your Username"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" placeholder="Your Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include('partials/footer.php'); ?>
<?php
//Process tyhe value from save in data base
//check wheter the button is click or not
if (isset($_POST['submit'])) {
    // echo "Button Clicked";
    //button click
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    //sql query to save data into database
    $sql = "INSERT INTO tbl_admin SET
   full_name='$full_name',
   username='$username',
   password='$password'
   ";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if ($res == TRUE) {
        //data inserted
        // echo "data inserted";
        $_SESSION['add'] = "<div class='success'>Admin Added Successfully </div>";

        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        // echo "Failed to insert data";
        //failed to insert
        $_SESSION['add'] = "<div class='error'>Fail to  Add Admin </div>";

        header("location:" . SITEURL . 'admin/add-admin.php');
    }
}
