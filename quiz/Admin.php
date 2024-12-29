<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
    <link rel="stylesheet" href="log.css">
</head>
<body>
<form action="Admin.php" method="POST" >
    <div class="container">
   
        <label for="username">UserName:</label><input type="text" name="eml" placeholder="enter your UserName" required >
        <label for="password">Password:</label><input type="text" name="pass" placeholder="enter your password" required >
       <br><br> <input type="submit" value="Login" name="login">
       </div>
   </form> 
   
</body>
<?php 
    class admin_info{
         private $db = "quiz";
         private $table = "admin";
        function dbwrk($email){
            $con= mysqli_connect("localhost","root","",$this->db);
            $ans = mysqli_query($con,"select * from $this->table where email = '$email' ");
            $fans = mysqli_fetch_assoc($ans);
   
            return $fans;
        }
    }

    if(isset($_POST['login'])){
        $unm = $_POST['eml'];
        $pw = $_POST['pass'];  
          $obj = new admin_info();
          $apas= $obj->dbwrk($unm);
          

        if($pw==$apas['pasw']){
            session_start();
            $_SESSION["usrinfo"] = $apas['email'];
header("Location: admindex.php");
        }
        else{
            echo "<script>alert('Invalid UserName or Password')</script>";
        }
    

    }
?>
</html>


