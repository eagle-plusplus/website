<?php
    session_start();

    include("database.php");
    require('Simplepush.php');

    // Check if the form is submitted
    if (isset($_POST["submit"])){
        // Sanitize and retrieve the title and question inputs
        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
        $question = filter_input(INPUT_POST, "question", FILTER_SANITIZE_SPECIAL_CHARS);

        // Retrieve the user ID and notification from the session
        $uid = $_SESSION["id"];
        $not = $_SESSION["notification"];

        // Check if the title or question fields are empty
        if (empty($title) || empty($question)){
            echo "<p style='color: red';>You must fill both fields!</p>";
        }else{
            // Insert the question into the database
            $sql = "INSERT INTO QUESTIONS (uid, title, qtext)
                    VALUES ('$uid', '$title', '$question')";

            mysqli_query($conn, $sql);

            // Retrieve the generated question ID
            $qid = mysqli_insert_id($conn);

            $url = "http://localhost/website/question-details.php?qid=" . $qid;

            // Send a notification to the user about the submitted question
            $ret = Simplepush::send($not, "Your question was submitted: " . $title, "Use this link to access it: " . $url);

            // Redirect the user to the main page
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

    <!-- Question Form -->
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <!-- Title Input -->
        <label for="title">Title:</label><br>
        <textarea name="title" id="title" rows="1" cols="40"></textarea><br>
        
        <!-- Question Input -->
        <label for="question">Message:</label><br>
        <textarea name="question" id="question" rows="8" cols="40"></textarea><br>
        
        <!-- Submit Button -->
        <button type="submit" name="submit" value="submit">Submit Question</button>
    </form>

    <!-- Go Back Button -->
    <button id="ret" type="button" onclick="window.location.href = 'mainpage.php';">Go Back</button>

    <script src="cookie.js"></script>
</body>
</html>
