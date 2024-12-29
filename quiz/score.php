<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>

    <?php
session_start();
$scor =  $_SESSION['score'];

echo "Your Score: ". $scor;
session_destroy()
?>
    </h2>
</body>
</html>