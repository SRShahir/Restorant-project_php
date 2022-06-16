<?php
// echo " Delete food";
include('../config/constants.php');
if (isset($_GET['id']) && isset($_GET['image_name'])) {
    //process to delete
    // echo "Process to Delete";
    //get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //remove the image
    if ($image_name != "") {
        $path = "../images/food/" . $image_name;
        //image delete from folder
        if (file_exists($path)) {
            $remove = unlink($path);
        }
        //image is removed or not
        if ($remove == false) {
            $_SESSION['upload'] = "<div class='error'>Failed to remove Image file.</div>";
            header('location:' . SITEURL . 'admin/manage-food.php');
        }
    }
    //delete food form Database
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    //exicute the query
    $res = mysqli_query($conn, $sql);
    //the query exicuted or not
    if ($res == true) {
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    } else {
        $_SESSION['delete'] = "<div class='error'> Failed to Delete Food </div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    }
    //manage food with session  message
} else {
    //redirect to manage food page
    // echo "Redirect";
    $_SESSION['unathorize'] = "<div class='error'>Unathorized Access.<?div>";
    header('location:' . SITEURL . 'admin/manage-food.php');
}
