<?php
    session_start();
    
    require("header.php");

    $host = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "supermarket";

// Establish a database connection
$connection = mysqli_connect($host, $db_username, $db_password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
    
    if(isset($_POST['submit'])) {
        $productname = mysqli_real_escape_string($connection, $_POST['pname']);
        $costprice = mysqli_real_escape_string($connection, $_POST['cp']);
        $marketprice = mysqli_real_escape_string($connection, $_POST['mp']);
        $category = mysqli_real_escape_string($connection, $_POST['category']);
        $supplierid = mysqli_real_escape_string($connection, $_POST['sid']);
        $product_qty = mysqli_real_escape_string($connection, $_POST['pqty']);

        $query = "INSERT INTO product (product_name, cost_price, market_price, category, supplier_id, product_quantity) VALUES('$productname', '$costprice', '$marketprice', '$category', '$supplierid', '$product_qty')";
       $result = mysqli_query($connection, $query);
        if($result) {
            echo "Product added successfully.";
            header('Location: productlist.php');
        
           }
           else{
           echo "Product not added";
            header('Location: addproduct.php');
           }

        }
        
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="login_container">
        <div>
            <?php
                require("menu.php");
            ?>
        </div>  
            <div class="login_box">
    
            <form method="post" action='addproduct.php'>
                
                <div class="user">
                     <label>ProductName</label>
                     <input type="text" name= "pname" placeholder= "productname" required></input>
                 </div>    
                 <div class="user">
                    <label>Cost Price</label>
                    <input type="text" name= "cp" placeholder= "costprice" required></input>
                 </div>
                 <div class="user">
                    <label>Market Price</label>
                    <input type="text" name= "mp" placeholder= "marketprice" required></input>
                 </div>
                 <div class="user">
                    <label>Category</label>
                    <input type="text" name= "category" placeholder= "category" required></input>
                 </div>
                 <div class="user">
                    <label>SupplierID</label>
                    <input type="text" name= "sid" placeholder= "supplierid" required></input>
                 </div>
                 <div class="user">
                    <label>Product Quantity</label>
                    <input type="text" name= "pqty" placeholder= "productqty" required></input>
                 </div>
                 <div class="submit">
                     <input type="submit" name= "submit" value='submit'></input>
                 </div>
                
                </form>
            </div>
        
    </div>
    <div class="footer_box">
        <?php
        require("footer.php")
    ?>
    </div>
    
    
</body>
</html>