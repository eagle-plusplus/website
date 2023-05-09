<?php
    session_start();

    include("database.php");

    // Retrieve the question ID from the URL parameter
    $questionID = $_GET['qid'];

    // Perform a database query to fetch the question details based on the ID
    // Replace the following code with your own database query logic
    $sql = "SELECT * FROM QUESTIONS WHERE qid = '$questionID'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $title = $row["title"];
    $text = $row["qtext"];

    // Display the question details
    echo "<h2>" . $row['title'] . "</h2>";
    echo "<p>" . $row['qtext'] . "</p>";
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
    <hr>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
    
        <label for="answer">Give an answer:</label><br>
        <textarea name="answer" rows="4" cols="40"></textarea><br>
        
        <button type="submit" name="submit" value="submit">Submit Answer</button>

        <a href="question.php">
            <button>Return</button>
        </a>
    </form>
</body>
</html>

<?php

    if (isset($_POST["submit"])){
        $answer = filter_input(INPUT_POST, "answer", FILTER_SANITIZE_SPECIAL_CHARS);

        $uid = $_SESSION["id"];

        if (empty($answer)){
            echo "You must fill the answer field!";
        }else{
            $sql = "INSERT INTO ANSWERS (atext, qid, uid)
                    VALUES ('$answer', '$questionID', '$uid')";

            mysqli_query($conn, $sql);
        }

    }

    mysqli_close($conn);
?>
