<?php

//include constant.php
include('../config/constants.php');
//get the id of Admin deleted 
$id = $_GET['id'];
//create sql query deleted
$sql = "DELETE FROM tbl_admin WHERE id=$id";

//exicye the query
$res = mysqli_query($conn, $sql);
//check where the query exicuted successfully or not
if ($res == TRUE) {
    //  echo "Admin Deleted";
    $_SESSION['delete'] = "<div class='success'>Admin Delete Successfully </div>";
    header('location:' . SITEURL . 'admin/manage-admin.php');
} else {
    // echo "Failed to delete Admin";
    $_SESSION['delete'] = "<div class='error>Failed to Delete Admin.Try Again Later </div>";
    header('location:' . SITEURL . 'admin/manage-admin.php');
}
 //Redirect the amnage admin page with massege
