<?php
include('partials/menu.php');
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }


        ?>
        <br><br>
        <!-- Add category form Start -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl_30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">NO
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add category form End -->
        <?php
        //check the submit button click or not
        if (isset($_POST['submit'])) {
            // echo "clicked";
            //get the value from form
            $title = $_POST['title'];
            //radio -check the button is selected or not
            if (isset($_POST['featured'])) {
                //get the value from form 
                $featured = $_POST['featured'];
            } else {
                $featured = "No";
            }
            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No";
            }
            //image is selected or  not
            // print_r($_FILES['image']);
            // die();
            if (isset($_FILES['image']['name'])) {



                //upload the image
                //image name, source path,destination path
                $image_name = $_FILES['image']['name'];
                if ($image_name !== "") {

                    //get the exention(jpg,png,gif)eg-food.jpg
                    $ext = end(explode('.', $image_name));
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
                        header('location:' . SITEURL . 'admin/add-category.php');
                        die();
                    }
                }
            } else {
                //Dont upload image
                $image_name = "";
            }
            $sql = "INSERT INTO tbl_category SET
            title='$title',
            image_name='$image_name',
            featured='$featured',
            active='$active'
            ";
            // echo "$sql";
            $res = mysqli_query($conn, $sql);
            if ($res == TRUE) {
                //query exicuted and category
                $_SESSION['add'] = "<div class='success'>Category added successfully</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                //Failed to add to category
                $_SESSION['add'] = "<div class='error'>Fail to added Category</div>";
                header('location:' . SITEURL . 'admin/add-category.php');
            }
        }
        ?>
    </div>
</div>
<?php
include('partials/footer.php');
