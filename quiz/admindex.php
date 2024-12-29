<?php 
session_start();
 $det = $_SESSION["usrinfo"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Form</title>
    <link rel="stylesheet" href="adm.css">
</head>
<body>
    <div class="form-container">
        <form action="#" method="POST">
            <h4>Hello <?php echo $det;  ?></h4>
            
            <div class="input-group">
                <label for="input1">Question Number</label>
                <input type="number" id="qsn" name="qsn" placeholder="Enter Question Number" required>
            </div>
            
            <div class="input-group">
                <label for="input2">Enter Your Question here </label>
                <input type="text" id="qs" name="qs" placeholder="Enter The Question" required>
            </div>
            
            <div class="input-group">
                <label for="input3">Anwser 1</label>
                <input type="text" id="a1" name="a1" placeholder="Enter the Anwser 1" required>
            </div>
            
            <div class="input-group">
                <label for="input4">Anwser 2</label>
                <input type="text" id="a2" name="a2" placeholder="Enter The Anwser 2" required>
            </div>
            
            <div class="input-group">
                <label for="input5">Anwser 3</label>
                <input type="text" id="a3" name="a3" placeholder="Enter The Anwser 3" required>
            </div>
            
            <div class="input-group">
                <label for="input6">Anwser 4</label>
                <input type="text" id="a4" name="a4" placeholder="Enter The Anwser 4" required>
            </div>
            
            <div class="input-group">
                <label for="input7">Correct Anwser</label>
                <input type="text" id="ca" name="ca" placeholder="Enter The Correct Anwser " required>
            </div>
            
            <button type="submit" class="submit-btn" name="b2" >Submit</button>
        </form>
    </div>
</body>
<?php
 class qins{
    private $db= "quiz";
    private $table = "question";
    function insrt($qsn,$qs,$a1,$a2,$a3,$a4,$ca){
        $con = mysqli_connect("localhost","root","",$this->db);
        $ans = mysqli_query($con,"insert into $this->table values('$qsn','$qs','$a1','$a2','$a3','$a4','$ca')");
      
    }
 }
 if(isset($_POST['b2'])){
    $obj = new qins();
    $obj->insrt($_POST['qsn'],$_POST['qs'],$_POST['a1'],$_POST['a2'],$_POST['a3'],$_POST['a4'],$_POST['ca']);
    echo "<script>alert('Question Inserted Successfully')</script>";
 }

?>
</html>
