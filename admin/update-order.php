<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br><br>
        <?php
        //check id is set or  not 
        if (isset($_GET['id'])) {
            //get the order details
            $id = $_GET['id'];
            //sql query
            $sql = "SELECT * FROM tbl_order WHERE id=$id";
            // echo $sql;
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                //details available
                $row = mysqli_fetch_assoc($res);
                $food = $row['food'];
                $price = $row['price'];
                $qty = $row['qty'];
                $total = $row['total'];
                $status = $row['status'];
                $customer_name = $row['customer_name'];
                $customer_contact = $row['customer_contact'];
                $customer_email = $row['customer_email'];
                $customer_address = $row['customer_address'];
            } else {

                header('location:' . SITEURL . 'admin/manage-order.php');
            }
        } else {
            //redirect manage order page
            header('location:' . SITEURL . 'admin/manage-order.php');
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-full text-center">
                <tr>
                    <td>Food Name</td>
                    <td>
                        <b><?php echo $food; ?></b>
                    </td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>
                        <b> RS<?php echo $price; ?></b>
                    </td>
                </tr>
                <tr>
                    <td>Qty</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">

                            <option <?php if ($status == "Ordered") {
                                        echo "selected";
                                    } ?> value="Ordered">Ordered</option>

                            <option <?php if ($status == "OnDelivery") {
                                        echo "selected";
                                    } ?> value="OnDelivery">OnDelivery</option>

                            <option <?php if ($status == "Deliverd") {
                                        echo "selected";
                                    } ?> value="Deliverd"> Deliverd</option>
                            <option <?php if ($status == "Cancelled") {
                                        echo "selected";
                                    } ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Customer Name:</td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer Contact</td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer Email</td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer Address</td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>


                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="total" value="<?php echo $total; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update" class="btn-secondary mr-2">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        //check wether update button click or not
        if (isset($_POST['submit'])) {


            // echo "clicked";
            //get all the from form
            $id = $_POST['id'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $total = $_POST['total'];
            $status = $_POST['status'];
            $customer_name = $_POST['customer_name'];
            $customer_contact = $_POST['customer_contact'];
            $customer_email = $_POST['customer_email'];
            $customer_address = $_POST['customer_address'];
            //update the value
            $sql2 = "UPDATE tbl_order SET
            qty='$qty',
            total='$total',
            status='$status',
            customer_name='$customer_name',
            customer_contact='$customer_contact',
            customer_email='$customer_email',
            customer_address='$customer_address'
            WHERE id=$id";
            // echo $sql2;
            //exicute the query
            $res2 = mysqli_query($conn, $sql2);
            if ($res2 == true) {
                //update
                $_SESSION['update'] = "<div class='success'>Order Update Successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-order.php');
            } else {
                //failed Update
                $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
                header('location:' . SITEURL . 'admin/manage-order.php');
            }
            // redirect to manage with massege
        }
        ?>
    </div>
</div>
<?php include('partials/footer.php'); ?>