<?php
include('partials/menu.php');
// echo "Update category";
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>
        <?php
        //check id set or not
        if (isset($_GET['id'])) {
            // echo "Getting the data";
            $id = $_GET['id'];
            $sql = "SELECT * FROM tbl_category WHERE id=$id";
            $res = mysqli_query($conn, $sql);
            //count the rows
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
                //get all data
            } else {
                //manage category
                $_SESSION['no-category-found'] = "<div class='error'>Category not Found</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        } else {
            header('location:' . SITEURL . 'admin/manage-category.php');
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image</td>
                    <td>
                        <?php
                        if ($current_image !== "") {
                        ?>
                            <img src="<?php echo SITEURL; ?>Images/category/<?php echo $current_image; ?> " width="100px">
                        <?php
                        } else {
                            echo "<div class='error'>Image not Added.</div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "Checked";
                                } ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if ($featured == "No") {
                                    echo "Checked";
                                } ?> type="radio" name="featured" value="No">No

                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "Checked";
                                } ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if ($active == "No") {
                                    echo "Checked";
                                } ?> type="radio" name="active" value="No">No

                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            // echo "clicked";
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];
            //updating new image
            // the image is selected or not
            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];
                if ($image_name != "") {
                    //image available
                    //upload the new image
                    //get the exention(jpg,png,gif)eg-food.jpg
                    $ext = explode('.', $image_name)[1];
                    //rename image
                    $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;
                    //eg-Food_Category_345.jpg

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/" . $image_name;
                    //upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);
                    //check image upload or not
                    //if the immage is not uploaded
                    if ($upload == false) {
                        //set images
                        $_SESSION['upload'] = "<div class='error'>Fail to Upload</div>";
                        //   header('location:' . SITEURL . 'admin/add-category.php');
                        die();
                    }

                    //remove the current image
                    $remove_path = "../images/category/" . $current_image;

                    if (file_exists($remove_path)) {
                        $remove = unlink($remove_path);
                        if ($remove == false) {
                            //failed to remove image
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image</div>";
                            header('location:' . SITEURL . 'admin/manage-category.php');
                            die();
                        }
                    }

                    //image is romove or not

                } else {
                    $image_name = $current_image;
                }
            } else {
                $image_name = $current_image;
            }
            //update the data base
            $sql2 = "UPDATE tbl_category SET
            -- id='$id',
            title='$title',
            image_name='$image_name',
            featured='$featured',
            active='$active'
            WHERE id=$id
            ";
            // echo "$sql2";
            $res2 = mysqli_query($conn, $sql2);
            //check query exicuted or not
            if ($res2 == true) {
                $_SESSION['update'] = "<div class='success'>Category Update Succesfullly</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to  Update Category</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        }
        ?>
    </div>
</div>
<?php include('partials/footer.php');
