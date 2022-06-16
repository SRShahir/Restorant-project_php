<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Decription:</td>
                    <td>
                        <textarea name="description" id="" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                            //create php code to display from database
                            //create sql active category
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);
                            //category or not
                            $count = mysqli_num_rows($res);
                            if ($count > 0) {
                                // have category
                                while ($row = mysqli_fetch_assoc($res)) {
                                    //details of categotry
                                    $id = $row['id'];
                                    $title = $row['title'];
                            ?>

                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                <?Php
                                }
                            } else {

                                // donot have category
                                ?>
                                <option value="0">No Category Found</option>

                            <?php
                            }
                            //display on drop down
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
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
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        //check the button is clicked or not
        if (isset($_POST['submit'])) {
            // echo "clicked";
            //get the data from form 
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            if (isset($_POST['featured'])) {

                $featured = $_POST['featured'];
            } else {

                $featured = "No";
            }
            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No"; //default value
            }
            // upload the image is selected
            //selcet image is click or not upload the image
            print_r($_FILES);


            if (isset($_FILES['image']['name'])) {
                //selected image
                $image_name = $_FILES['image']['name'];

                echo $image_name;

                if ($image_name != "") {
                    //image is selected
                    //rename image
                    //extention selected eg-(jpg,gif,pnj)

                    $ext =  explode('.', $image_name)[1];


                    $image_name = "Food-Name-" . time() . "." . $ext;
                    //upload the image

                    //source path
                    $src = $_FILES['image']['tmp_name'];
                    
                    //image to be uploaded
                    $dst = "../images/food/" . $image_name;
                    //finally upload
                    $upload = move_uploaded_file($src, $dst);

                    if ($upload == false) {
                        //Failed upload image
                        $_SESSION['upload'] = "<div class='error'>Failed to upload Image.</div>";
                          header('location:' . SITEURL . 'admin/add-food.php');
                       
                    }
                }
            } else {
                $image_name = ""; //default value
            }
            //insert into data base
            $sql2 = "INSERT INTO tbl_food SET
            title='$title',
            description='$description',
            price='$price',
            image_name='$image_name',
            category_id='$category',
            featured='$featured',
            active='$active'

            ";

            //exicute the query
            $res2 = mysqli_query($conn, $sql2);
            if ($res2 == true) {
                $_SESSION['add'] = "<div class='success'>Food Added Successfully </div>";
                  header('location:' . SITEURL . 'admin/manage-food.php');
            } else {
                //Failedd the insert data
                $_SESSION['add'] = "<div class='error'>Failed to Add Food</div>";
               header('location:' . SITEURL . 'admin/manage-food.php');
            }
            //redirect massege

        }
        ?>
    </div>
</div>
<?php include('partials/footer.php'); ?>