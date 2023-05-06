<?php
    session_start();

    echo $_SESSION["first"];
    echo $_SESSION["last"];
    echo $_SESSION["user"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mainpage</title>
</head>
<body>
    <a href="personal.php">
        <button>Personal information</button>
    </a>
</body>
</html>