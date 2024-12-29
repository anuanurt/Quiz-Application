<?php
session_start();

// Store user information
$usinfo = $_SESSION["useml"] ?? 'Guest';

class qset {
    private $db = "quiz";
    private $table = "question";

    // Fetch a question from the database
    function fetch_question($qn) {
        $con = mysqli_connect("localhost", "root", "", $this->db);
        if (!$con) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        // Fetch the question by qno
        $qr = mysqli_query($con, "SELECT * FROM $this->table WHERE qno = '$qn'");
        return mysqli_fetch_assoc($qr) ?? null;
    }

    // Get the total number of questions
    function total_questions() {
        $con = mysqli_connect("localhost", "root", "", $this->db);
        if (!$con) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        $qry = mysqli_query($con, "SELECT COUNT(*) as total FROM $this->table");
        $row = mysqli_fetch_assoc($qry);
        return $row['total'];
    }

    // Get the correct answer for a specific question
    function get_correct_answer($qnn) {
        $con = mysqli_connect("localhost", "root", "", $this->db);
        $qry = mysqli_query($con, "SELECT ca FROM $this->table WHERE qno = '$qnn'");
        $row = mysqli_fetch_assoc($qry);
        return $row ?? null;
    }
}

if (!isset($_SESSION['QNO'])) {
    $_SESSION['QNO'] = 1; // Initialize question number
}
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0; // Initialize score
}

$ob = new qset();
$totalQuestions = $ob->total_questions(); // Get total questions

// Handle "Previous" button
if (isset($_POST['previous'])) {
    $_SESSION['QNO'] = max(1, $_SESSION['QNO'] - 1); // Ensure question number does not go below 1
}

// Handle "Next" button
if (isset($_POST['next'])) {
    if (isset($_POST['answer'])) { // Check if an answer is selected
        $selectedAnswer = $_POST['answer'];
        $correctAnswer = $ob->get_correct_answer($_SESSION['QNO']); // Get correct answer
        echo " $selectedAnswer";
        echo  $correctAnswer['ca'];
        
        if ($selectedAnswer == $correctAnswer['ca']) {
            $_SESSION['score'] += 1; // Increment score for correct answer
            echo "<script>alert('Correct Answer');</script>";
        } else {
            echo "<script>alert('Incorrect Answer');</script>";
        }
    } else {
        echo "<script>alert('Please select an answer before proceeding.');</script>";
    }
    $_SESSION['QNO'] = min($totalQuestions, $_SESSION['QNO'] + 1); // Ensure question number doesn't exceed total questions
}

// Redirect to score page if "CheckScore" is clicked
if (isset($_POST['CheckScore'])) {
    header("Location: score.php");
    exit();
}

$aqs = $ob->fetch_question($_SESSION['QNO']); // Fetch current question
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
                    <?php if ($aqs): ?>
                        <h2>Question <?php echo $_SESSION['QNO']; ?>: <?php echo htmlspecialchars($aqs['Ques']); ?>?</h2>
                        <label class="answer">
                            <input type="radio" name="answer" value="<?php echo $correctAnswer['a1']   ?>" required> A. <?php echo htmlspecialchars($aqs['a1']); ?>
                        </label>
                        <label class="answer">
                            <input type="radio" name="answer" value="<?php echo $correctAnswer['a2']   ?>" required> B. <?php echo htmlspecialchars($aqs['a2']); ?>
                        </label>
                        <label class="answer">
                            <input type="radio" name="answer" value="<?php echo $correctAnswer['a3']   ?>" required> C. <?php echo htmlspecialchars($aqs['a3']); ?>
                        </label>
                        <label class="answer">
                            <input type="radio" name="answer" value="<?php echo $correctAnswer['a4']   ?>" required> D. <?php echo htmlspecialchars($aqs['a4']); ?>
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
</html>
