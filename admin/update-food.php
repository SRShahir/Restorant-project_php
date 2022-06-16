<?php
include('partials/menu.php');
// echo " update food";
?>
<?Php
if (isset($_GET['id'])) {
    //get the details
    $id = $_GET['id'];
    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
    $res2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($res2);
    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
} else {
    header('location:' . SITEURL . 'admin/manage-food.php');
}
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image</td>
                    <td>
                        <?php
                        if ($current_image == "") {
                            echo "<div class='error'>Image not available</div>";
                        } else {
                        ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                            $sql = "SELECT * FROM tbl_category WHERE active='yes'";
                            $res = mysqli_query($conn, $sql);
                            //count rows
                            $count = mysqli_num_rows($res);
                            //category available or not
                            if ($count > 0) {
                                //category Available
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];
                                    // echo "<option value='$category_id'>$category_title</option>";
                            ?>
                                    <option <?php if ($current_category == $category_id) {
                                                echo "selected";
                                            } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                            <?php
                                }
                            } else {
                                //category not available
                                echo "<option value='0'>Category not Available</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        //check button click or not
        if (isset($_POST['submit'])) {

            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //upload the image
            if (isset($_FILES['image']['name'])) {
                //upload button clicked
                $image_name = $_FILES['image']['name']; //new image here
                //filke is available or not
                if ($image_name != "") {
                    //upload the im age
                    $ext = explode('.', $image_name)[1];
                    $image_name = "Food-Name-" . time() . '.' . $ext;
                    //get the source path and destination path
                    $src_path = $_FILES['image']['tmp_name'];
                    $dest_path = "../images/food/" . $image_name; //destination path
                    $upload = move_uploaded_file($src_path, $dest_path);
                    if ($upload == false) {
                        //failed to upload
                        $_SESSION['upload'] = "<div class='error'>Failed to upload New Image.<?div>";
                        header('location:' . SITEURL . 'admin/manage-food.php');
                        die();
                    }
                    //remove current image
                    if ($current_image != "") {
                        //current image is available
                        //remove the image
                        $remove_path = "../images/food/" . $current_image;
                        if (file_exists($remove_path)) {
                            $remove = unlink($remove_path);
                        }
                        //image is remove or not
                        if ($remove == false) {
                            //Failed to remove current image
                            $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image</div>";
                            //redirect to manage food
                            header('location:' . SITEURL . 'admin/manage-food.php');
                            //stop the process
                            die();
                        }
                    }
                }
            } else {
                $image_name = $current_image;
            }
            //remove the image
            //update the food in database
            $sql3 = "UPDATE tbl_food SET 
            title='$title',
            description='$description',
            price='$price',
            image_name='$image_name',
            category_id='$category',
            featured='$featured',
            active='$active'
            WHERE id=$id
            ";
            //exicute the sql query
            $res3 = mysqli_query($conn, $sql3);
            if ($res3 == true) {
                $_SESSION['update'] = "<div class='success'>Food Updated Succesfully</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Updated Food </div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
            }
        }
        ?>
    </div>
</div>
<?php include('partials/footer.php'); ?>