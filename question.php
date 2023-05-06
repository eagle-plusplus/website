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
        <textarea name="question" id="question" rows="4" cols="40"></textarea><br>
        
        <button type="submit" name="submit" value="submit">Submit Question</button>

        <a href="question.php">
            <button>Return</button>
        </a>
    </form>

</body>
</html>

<?php
    if (isset($_POST["submit"])){
        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
        $question = filter_input(INPUT_POST, "question", FILTER_SANITIZE_SPECIAL_CHARS);

        $uid = $_SESSION["id"];

        if (empty($title)||empty($question)){
            echo "You must fill both fields!";
        }else{
            $sql = "INSERT INTO QUESTIONS (uid, title, qtext)
                    VALUES ('$uid', '$title', '$question')";

            mysqli_query($conn, $sql);
        }

    }

    mysqli_close($conn);
?>