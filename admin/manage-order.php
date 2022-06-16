<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>
        <br><br><br>
        <?php
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>
        <br><br><br>
        <table border="1px solid black" class="tbl-full">
            <tr>
                <th>S.No</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Order Date</th>
                <th width="7%">Status</th>
                <th>Customer Name</th>
                <th>Customer Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>

            <?php
            //Get all orders from database
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            $sn = 1; //Serial no
            // $siteurl = SITEURL;
            if ($count > 0) {
                //order available
                while ($row = mysqli_fetch_assoc($res)) {

                    //order Details
                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];


            ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $food; ?></td>
                        <td><?php echo $price; ?></td>
                        <td><?php echo $qty ?></td>
                        <td><?php echo $total; ?></td>
                        <td><?php echo $order_date; ?></td>

                        <td><?php
                            // echo $status;
                            // ordered ,delivery, On delivery,cancelled
                            if ($status == "Ordered") {
                                echo "<lable>$status<lable>";
                            } elseif ($status == "OnDelivery") {
                                echo "<lable style='color:orange'>$status<lable>";
                            } elseif ($status == "Deliverd") {
                                echo "<lable style='color:green'>$status<lable>";
                            } elseif ($status == "Cancelled") {
                                echo "<lable style='color:red'>$status<lable>";
                            }

                            ?></td>

                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $customer_contact; ?></td>
                        <td><?php echo $customer_email; ?></td>
                        <td><?php echo $customer_address; ?></td>
                        <td>
                            <a href="<?php SITEURL; ?>update-order.php?id=<?Php echo $id; ?>" class='btn-secondary p-4'>Update</a>
                        </td>
                    </tr>
            <?php
                }
            } else {
                //order not available
                echo "<tr><td colspan='12' class='error'>Order not Available.<td><tr>";
            }
            ?>

        </table>
    </div>
</div>
<?php include('partials/footer.php'); ?>