<?php
    session_start();

    include("database.php");

    // Retrieve the question ID from the URL parameter
    $questionID = $_GET['qid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question</title>

    <link rel="stylesheet" href="question-details.css">
</head>
<body>

    <div class="qa">
        <?php
            // Perform a database query to fetch the question details based on the ID
            // Replace the following code with your own database query logic
            $sql = "SELECT * FROM QUESTIONS WHERE qid = '$questionID'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);

            $title = $row["title"];
            $text = $row["qtext"];

            // Display the question details
            echo "<h2> Title: " . $row['title'] . "</h2> <hr>";
            echo "<p>" . $row['qtext'] . "</p>";
        ?>
    </div>

    <br>

    <div class="ans">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        
            <label for="answer">Give an answer:</label><br>
            <textarea name="answer" rows="4" cols="40"></textarea><br>
            
            <button type="submit" name="submit" value="submit">Submit Answer</button>

            <button type="button" onclick="window.location.href = 'mainpage.php';">Return Back</button>
        </form>
    </div>

    <div class="answers">
        <script>
                window.onload = function() {
                <?php
                    $sql = "SELECT * FROM ANSWERS a JOIN USERS u ON a.uid = u.id WHERE a.qid = '$questionID'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $text = $row["atext"];
                            $username = $row["username"];
                            echo "var paragraph = document.createElement('p');";
                            echo "paragraph.textContent = 'User $username answered: $text';";
                            echo "document.querySelector('.answers').appendChild(paragraph);";
                            echo "document.querySelector('.answers').appendChild(document.createElement('br'));";
                        }
                    } else {
                        echo "var paragraph = document.createElement('p');";
                        echo "paragraph.textContent = 'No results';";
                        echo "document.body.appendChild(paragraph);";
                    }
                ?>
            }
        </script>
    </div>

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
