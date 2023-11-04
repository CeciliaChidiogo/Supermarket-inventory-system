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
        $manager_id = mysqli_real_escape_string($connection, $_POST['mid']);
        $dept_id = mysqli_real_escape_string($connection, $_POST['deptid']);
        $dept_name = mysqli_real_escape_string($connection, $_POST['deptname']);

        $query = "INSERT INTO department(manager_id, dept_id, dept_name) VALUES ('$manager_id', '$dept_id', '$dept_name')";
       $result = mysqli_query($connection, $query);
        if($result) {
            echo "Department added successfully";
            header('Location: deptlist.php');
        
           }
           else{
            echo "Department not added",
            header('Location: adddept.php');
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
    
            <form method="post" action='adddept.php'>
                
                <div class="user">
                     <label>Manager ID</label>
                     <input type="text" name= "mid" placeholder= "managerid" required></input>
                 </div>    
                 <div class="user">
                    <label>Dept ID</label>
                    <input type="text" name= "deptid" placeholder= "deptid" required></input>
                 </div>
                 <div class="user">
                    <label>Dept Name</label>
                    <input type="text" name= "deptname" placeholder= "deptname" required></input>
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