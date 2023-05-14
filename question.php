<?php
    session_start();

    include("database.php");
    require('Simplepush.php');

    if (isset($_POST["submit"])){
        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
        $question = filter_input(INPUT_POST, "question", FILTER_SANITIZE_SPECIAL_CHARS);

        $uid = $_SESSION["id"];
        $not = $_SESSION["notification"];

        if (empty($title)||empty($question)){
            echo "You must fill both fields!";
        }else{
            $sql = "INSERT INTO QUESTIONS (uid, title, qtext)
                    VALUES ('$uid', '$title', '$question')";

            mysqli_query($conn, $sql);

            $qid = mysqli_insert_id($conn);

            $url = "http://localhost/website/question-details.php?qid=" . $qid;

            //echo $url;

            $ret = Simplepush::send($not, "Your question was submited: " . $title, "Use this link to accsess it: " . $url);

            header("Location: mainpage.php");
        }

    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a question</title>

    <link rel="stylesheet" href="question.css">
</head>
<body>

    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <label for="title">Title:</label><br>
        <textarea name="title" id="title" rows="1" cols="40"></textarea><br>
        
        <label for="message">Message:</label><br>
        <textarea name="question" id="question" rows="8" cols="40"></textarea><br>
        
        <button type="submit" name="submit" value="submit">Submit Question</button>
    </form>

    <button id="ret" type="button" onclick="window.location.href = 'mainpage.php';">Go Back</button>

    <script src="cookie.js"></script>
</body>
</html>