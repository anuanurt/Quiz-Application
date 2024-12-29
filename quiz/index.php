<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Form</title>
    <link rel="stylesheet" href="us.css">
</head>
<body>
    <div class="form-container">
        <form action="index.php" method="POST">
            <h2>Registration Form </h2>
            
            <div class="input-group">
                <label for="inputBox">Enter Email</label>
                <input type="text" id="ueml" name="ueml" placeholder="Enter Your Email" required>
            </div>
            
            <button type="submit" class="submit-btn" name="reg">Register</button>
        </form>
    </div>
</body>
<?php
  error_reporting(0);
    class ureg{
        private $eml ;
       private $db = "quiz";
       private $table = "reg";
       function regchk($emli){
        $con = mysqli_connect("localhost","root","",$this->db);
        $data = mysqli_query($con,"select * from $this->table where email = '$emli'");
        $adata = mysqli_fetch_assoc( $data );
        return $adata;
       }
       function regusr($eml,$sc){
        $con = mysqli_connect("localhost","root","",$this->db);
        mysqli_query($con,"insert into $this->table values('$eml','$sc')");
       }

    }
    if(isset($_POST['reg'])){
        $obj = new ureg();
       $gdata =  $obj->regchk($_POST['ueml']);
     if($_POST['ueml']==$gdata['email']){
        echo "<script>alert('Email Already Registered')</script>";

     }   
     else{
        $obj1 = new ureg();
        $obj1->regusr($_POST['ueml'],0);
        echo "<script>alert('User Registered Sucessfully')</script>";
        session_start();
        $_SESSION["useml"] = $_POST['ueml'];
        header("Location: usrindex.php");

     }
    }

?>
</html>
