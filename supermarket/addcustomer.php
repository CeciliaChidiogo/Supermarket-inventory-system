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
                $Fname = mysqli_real_escape_string($connection, $_POST['Fname']);
                $Lname = mysqli_real_escape_string($connection, $_POST['Lname']);
                $gen = mysqli_real_escape_string($connection, $_POST['gen']);
                $add = mysqli_real_escape_string($connection, $_POST['add']);
                $cph = mysqli_real_escape_string($connection, $_POST['cph']);
            
            $query = "INSERT INTO customer (FirstName, LastName, Gender, Address, cphone) VALUES('$Fname', '$Lname', '$gen', '$add', '$cph')";
            $result = mysqli_query($connection, $query);
                if($result)  {
                    echo "Customer added successfully.";
                    header('Location: customerlist.php');
            
                }
                else{
                     echo "Customer not added.";
                    header('Location: addcustomer.php');
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
    
            <form method="post" action='addcustomer.php'>
                
                <div class="user">
                     <label>FirstName</label>
                     <input type="text" name= "Fname" placeholder= "FirstName" required></input>
                 </div>    
                 <div class="user">
                    <label>LastName</label>
                    <input type="text" name= "Lname" placeholder= "LastName" required></input>
                 </div>
                 <div class="user">
                    <label>Gender</label>
                    <input type="text" name= "gen" placeholder= "Gender" required></input>
                 </div>
                 <div class="user">
                    <label>Address</label>
                    <input type="text" name= "add" placeholder= "Address" required></input>
                 </div>
                 <div class="user">
                    <label>cphone</label>
                    <input type="text" name= "cph" placeholder= "cphone" required></input>
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