<?php
include('partials/menu.php'); ?>
<div class="main-container">
    <div class="wrapper">
        <h1>Update</h1>
        <form action="" method="POST">
            <br><br>
            <?php
            //get thne id of selected admin
            $id = $_GET['id'];
            //sql query
            $sql = "SELECT * FROM tbl_admin WHERE id=$id";
            $res = mysqli_query($conn, $sql);

            //chech the query is exicuted or not
            if ($res == TRUE) {
                //data is avilable or not
                $count = mysqli_num_rows($res);
                if ($count == 1) {
                    //get the details
                    // echo "Admin Available";
                    $row = mysqli_fetch_assoc($res);
                    $full_name = $row['full_name'];
                    $username = $row['username'];
                } else {
                    //manage admin page
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            }
            ?>
            <table class="tbl-30">
                <tr>
                    <td>Full name</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" value="<?php
                                                                    echo $username; ?>"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php
if (isset($_POST['submit'])) {
    //echo "button clicked";
    //get all the value from the to update
    $id=$_POST['id'];
    $full_name=$_POST['full_name'];
    $username=$_POST['username'];
    //create  sql query 
    $sql="UPDATE tbl_admin SET
    full_name='$full_name',
    username='$username'
    WHERE id='$id'
    ";
    //exicute the query

    $res=mysqli_query($conn,$sql);
    if($res==TRUE){
$_SESSION['update']="<div class='success'>Admin Updated Successfully</div>";
header('location:'.SITEURL.'admin/manage-admin.php');
    }else{
        $_SESSION['update'] = "<div class='error'>Failed to  Updated Admin</div>";
        header('location:' . SITEURL . 'admin/manage-admin.php');

    }
    
}
?>
<?php
include('partials/footer.php');
?>