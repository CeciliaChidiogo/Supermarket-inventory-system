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

$query = "SELECT * FROM product ";
$result = mysqli_query($connection, $query);
if ($result) {
    // Initialize an empty array to store all customer data
    $products = [];

    while ($product = mysqli_fetch_assoc($result)) {
        $products[] = $product;
    }
} else {
    $_SESSION['productlist_error'] = "Invalid product list.";
}


// Initialize the shopping cart in the session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add'])) {
    $id =  $_POST['id'];
    $quantity = $_POST['quantity'];

    $query1 = "SELECT * FROM product WHERE product_id = $id";
    $result1 = mysqli_query($connection, $query1);

    if ($result1 && mysqli_num_rows($result1) > 0) {
        $product = mysqli_fetch_assoc($result1);
        $pid = $product['product_id'];
        $pname = $product['product_name'];
        $price = $product['market_price'];
        // Create an array to represent the product being added to the cart
        $cartItem = [];
        if (is_array($product) && isset($product['product_id'], $product['product_name'], $product['market_price'])) {
            $cartItem = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'market_price' => $product['market_price'],
                'quantity' => $quantity,
            ];
        }

        // Add the item to the shopping cart in the session
        $_SESSION['cart'][$pid] = $product;
    } else {
        $_SESSION['transaction_error'] = "Invalid product selection.";
    }
}

//update database
// if(isset($_POST['update'])) {
//     $prod_id = $_POST['tran_id'];
//     $qty = $_POST['qty'];
//     $query2 = "SELECT product_quantity FROM product WHERE product_id = $prod_id";
//     $result2 = mysqli_query($connection, $query2);
//     if ($result2 && mysqli_num_rows($result2) > 0) {
//         $product = mysqli_fetch_assoc($result2); 
//         $pqty = $product['product_quantity'];
//         $new_qty = $pqty - $qty;
//         $query3 = "UPDATE product SET product_quantity = $new_qty WHERE product_id = $prod_id";
//         $result3 = mysqli_query($connection, $query3);
//         if ($result3) {
//             unset($_SESSION['cart']);
//             echo "Database succesfully updated";
//         }
//         else{
//             echo "Update Failed";
//         }
//     }
// }
foreach ($_SESSION['cart'] as $product) {
if(isset($_POST['update'])) {
    // Validate and sanitize input
    $prod_id = (int)$_POST['tran_id'];
    $qty = (int)$_POST['qty'];

    // Prepare and execute a SELECT query to get the current product quantity
    $query2 = "SELECT product_quantity FROM product WHERE product_id = ?";
    $stmt = mysqli_prepare($connection, $query2);
    mysqli_stmt_bind_param($stmt, "i", $prod_id);
    mysqli_stmt_execute($stmt);
    $result2 = mysqli_stmt_get_result($stmt);

    if ($result2 && $row = mysqli_fetch_assoc($result2)) {
        $pqty = $row['product_quantity'];
        $new_qty = $pqty - $qty;

        // Prepare and execute an UPDATE query to update the product quantity
        $query3 = "UPDATE product SET product_quantity = ? WHERE product_id = ?";
        $stmt = mysqli_prepare($connection, $query3);
        mysqli_stmt_bind_param($stmt, "ii", $new_qty, $prod_id);
        $result3 = mysqli_stmt_execute($stmt);

        if ($result3) {
            unset($_SESSION['cart']);
            echo "Database successfully updated";
        } else {
            echo "Update Failed";
        }
    } else {
        echo "Product not found.";
    }
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

<div class ="scroll-container">
<div class="login_container">
    <div>
        <?php
        require("menu.php");
        ?>
    </div>
    <div class="login_box table_box">
        <table class="table">
            <caption>Sumak Products</caption>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Cost Price</th>
                <th>Market Price</th>
                <th>Category</th>
                <th>Supplier ID</th>
                <th>Product Quantity</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?php echo $product['product_id']; ?></td>
                    <td><?php echo $product['product_name']; ?></td>
                    <td><?php echo $product['cost_price']; ?></td>
                    <td><?php echo $product['market_price']; ?></td>
                    <td><?php echo $product['category']; ?></td>
                    <td><?php echo $product['supplier_id']; ?></td>
                    <td><?php echo $product['product_quantity']; ?></td>
                    <td>
                        <form method="post" action="transaction.php">
                            <input type="hidden" name="id" value="<?php echo $product['product_id']; ?>">
                            <input type="number" name='quantity' placeholder="Quantity">
                            <input type='submit' name='add' value="Add to Cart">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class='login_box table_box'>
        <table class="table">
            <caption>Sumak Sales</caption>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            <?php
            $totalPrice = 0;
            foreach ($_SESSION['cart'] as $product) :
                $product_id = $product['product_id'];
                $product_name = $product['product_name'];
                $market_price = $product['market_price'];
                $quantity = $_POST['quantity'];
                $total = $market_price * $quantity;
                $totalPrice += $total;
                ?>
                <tr>
                    <td><?php echo $product_id; ?></td>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo $market_price; ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td>$<?php echo number_format($total, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div>
             <p>Total Price: $<?php echo number_format($totalPrice, 2); ?></p>
             <form method='post' action='transaction.php'>
                    <input type='hidden' name="tran_id" value="<?php echo $product_id; ?>"></input>
                    <input type='hidden' name="qty" value="<?php echo $quantity; ?>"></input>
                    <input type='submit' name='update' placeholder='update'></input>
             </form>
        </div>
       
    </div>
</div>
</div>
<div class="footer_box">
    <?php
    require("footer.php")
    ?>
</div>

</body>
</html>
