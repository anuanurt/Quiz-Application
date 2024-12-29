<?php
session_start();
$usinfo = $_SESSION["useml"] ?? 'Guest';

class fetch_question {
    private $db = "quiz";
    private $table = "question";

    function total_questions() {
        $con = mysqli_connect("localhost", "root", "", $this->db);
        if (!$con) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        $qry = mysqli_query($con, "SELECT COUNT(*) as total FROM $this->table");
        $row = mysqli_fetch_assoc($qry);
        return $row['total'];
    }

    function fq($qn) {
        $con = mysqli_connect("localhost", "root", "", $this->db);
        if (!$con) {
            die("Database connection failed: " . mysqli_connect_error());
        }
        
        $qs = mysqli_query($con, "SELECT * FROM $this->table WHERE qno = $qn");
        $nq = mysqli_fetch_assoc($qs);
        return $nq;
    }
}

$ob = new fetch_question();
$totalQuestions = $ob->total_questions(); 

if (!isset($_SESSION['QNO'])) {
    $_SESSION['QNO'] = 1; // Initialize question number
}

if (isset($_POST['next'])) {
    anchk($_SESSION['QNO']);
    $_SESSION['QNO'] = min($totalQuestions, $_SESSION['QNO'] + 1); // Ensure question number doesn't exceed total questions
   
    
}

if (isset($_POST['previous'])) {
    anchk($_SESSION['QNO']);
    $_SESSION['QNO'] = max(1, $_SESSION['QNO'] - 1); // Ensure question number does not go below 1
    
}

$currentQuestion = $ob->fq($_SESSION['QNO']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>COCO QUIZ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Online Quiz</h1>
        </header>
        
        <section class="quiz-section">
            <div class="quiz-card">
                <h4>Hello <?php echo htmlspecialchars($usinfo); ?></h4><br>
                <form action="" method="POST">
                    <?php if ($currentQuestion): ?>
                        <h2>Question <?php echo $_SESSION['QNO']; ?>: <?php echo htmlspecialchars($currentQuestion['Ques']); ?>?</h2>
                        <label class="answer">
                            <input type="radio" name="answer" value="<?php echo htmlspecialchars($currentQuestion['a1']); ?>" required> A. <?php echo htmlspecialchars($currentQuestion['a1']); ?>
                        </label>
                        <label class="answer">
                            <input type="radio" name="answer" value="<?php echo htmlspecialchars($currentQuestion['a2']); ?><?php echo htmlspecialchars($currentQuestion['a2']); ?>" required> B. <?php echo htmlspecialchars($currentQuestion['a2']); ?>
                        </label>
                        <label class="answer">
                            <input type="radio" name="answer" value="<?php echo htmlspecialchars($currentQuestion['a3']); ?>" required> C. <?php echo htmlspecialchars($currentQuestion['a3']); ?>
                        </label>
                        <label class="answer">
                            <input type="radio" name="answer" value=" <?php echo htmlspecialchars($currentQuestion['a4']); ?>" required> D. <?php echo htmlspecialchars($currentQuestion['a4']); ?>
                        </label>
                        <div class="button-group">
                            <button type="submit" class="prev-button" name="previous">Previous</button>
                            <button type="submit" class="next-button" name="next">Next</button>
                            <button type="submit" class="next-button" name="CheckScore">Check Score</button>
                        </div>
                    <?php else: ?>
                        <p>No question available or you have reached the end of the quiz.</p>
                    <?php endif; ?>
                </form>
            </div>
        </section>
    </div>
</body>
<?php

    function anchk($qn){
        $con = mysqli_connect("localhost","root","","quiz");
        $cdata = mysqli_query($con,"select * from question where qno = $qn");
        $gdata = mysqli_fetch_assoc($cdata);
       if($gdata['ca']==$_POST['answer']){
            $_SESSION['score']++;
    }
        else{
            $_SESSION['score']--;
        }
    }
    if(isset($_POST['CheckScore'])){
        header("Location: score.php");
    }
?>
</html>
