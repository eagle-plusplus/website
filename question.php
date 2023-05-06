<?php
    session_start();

    include("database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <label for="title">Title:</label><br>
        <textarea name="title" id="title" rows="1" cols="40"></textarea><br>
        
        <label for="message">Message:</label><br>
        <textarea name="message" id="message" rows="4" cols="40"></textarea><br>
        
        <button type="submit" name="submit">Submit</button>
    </form>

</body>
</html>