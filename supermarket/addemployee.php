<?php
    session_start();
    
    require("header.php");

    $host = "localhost";
    $db_username = "root";
    $db_Lastname = "";
    $database = "supermarket";

// Establish a database connection
$connection = mysqli_connect($host, $db_username, $db_Lastname, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
    
    if(isset($_POST['submit'])) {
        $firstname = mysqli_real_escape_string($connection, $_POST['Fname']);
        $lastname = mysqli_real_escape_string($connection, $_POST['Lname']);
        $dept_id = mysqli_real_escape_string($connection, $_POST['dept_id']);
        $salary = mysqli_real_escape_string($connection, $_POST['salary']);
        $dob = mysqli_real_escape_string($connection, $_POST['dob']);
        $address = mysqli_real_escape_string($connection, $_POST['addr']);
        $phone = mysqli_real_escape_string($connection, $_POST['emp_phone']);
        $join_date = mysqli_real_escape_string($connection, $_POST['join_date']);
        $query = "INSERT INTO employee(F_name, L_name, dept_id, salary, dob, address, cphone, join_date) VALUES('$firstname', '$lastname', '$dept_id', '$salary', '$dob', '$address', '$phone', '$join_date')";
       $result = mysqli_query($connection, $query);
        if($result) {
            echo "Employee successfully added.";
            header('Location: employeelist.php');
        
           }
           else{
           echo "Error: " . mysqli_error($connection);
            header('Location: addemployee.php');
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
            <div class='emp_container' >
    
            <form method="post" action='addemployee.php'>
                <div class=" emp_box">
                <div class="user emp">
                     <label>Firstname</label>
                     <input type="text" name= "Fname" placeholder= "Firstname" required></input>
                 </div>    
                 <div class="user emp">
                    <label>Lastname</label>
                    <input type="text" name= "Lname" placeholder= "Lastname" required></input>
                 </div>
                 <div class="user emp">
                     <label>Dept ID</label>
                     <input type="text" name= "dept_id" placeholder= "dept id" required></input>
                 </div> 
                 <div class="user emp">
                     <label>Salary</label>
                     <input type="text" name= "salary" placeholder= "salary" required></input>
                 </div> 
                 <div class="user emp">
                     <label>Date of birth</label>
                     <input type="date" name= "dob" placeholder= "dob" required></input>
                 </div> 
                 <div class="user emp">
                     <label>address</label>
                     <input type="text" name= "addr" placeholder= "address" required></input>
                 </div> 
                 <div class="user emp">
                     <label>phone no</label>
                     <input type="text" name= "emp_phone" placeholder= "phone no" required></input>
                 </div> 
                 <div class="user emp">
                     <label>join date</label>
                     <input type="date" name= "join_date" placeholder= "join date" required></input>
                 </div> 
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