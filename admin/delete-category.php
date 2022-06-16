<?php
include('../config/constants.php');

// session_start();

// echo "Delete Page";
//the id ,image is set or  not
if (isset($_GET['id']) and isset($_GET['image_name'])) {
    //get value delete
    // echo "Get value and Delete";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];


    //remove the physical file is avilable
    if ($image_name != "") {
        //remove images
        $path = "../images/category/" . $image_name;
        //remove the image
        if (file_exists($path)) {
            $remove = unlink($path);
        }
        //fail to remove iamge stop the process
        if ($remove == false) {
            //set the session massege 
            $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image</div>";
            header('location:' . SITEURL . 'admin/manage-category.php');
            //manage category

        }
    }
    //delete data from data base
    $sql = "DELETE FROM tbl_category WHERE id=$id";
    //exicute the query
    $res = mysqli_query($conn, $sql);
    if ($res == true) {
        //set success message
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
        header('location:' . SITEURL . 'admin/manage-category.php');
    } else {
        //Fail message
        $_SESSION['delete'] = "<div class='error'> Failed to  Delete Category</div>";
        header('location:' . SITEURL . 'admin/manage-category.php');
    }
} else {
    header('location:' . SITEURL . 'admin/manage-category.php');
}


// echo $_SESSION['delete'];