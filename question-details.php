<?php
    session_start();

    // Include the database connection file
    include("database.php");

    // Include the Simplepush library file
    require('Simplepush.php');

    // Retrieve the question ID from the URL parameter
    $questionID = $_GET['qid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question and Answers</title>

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
                // Perform a database query to fetch the answers for the question
                $sql = "SELECT * FROM ANSWERS a JOIN USERS u ON a.uid = u.id WHERE a.qid = '$questionID' ORDER BY a.aid DESC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // Iterate over the result set and display each answer
                    while ($row = mysqli_fetch_assoc($result)) {
                        $aid = $row["aid"];
                        $text = $row["atext"];
                        $username = $row["username"];

                        // Create a paragraph element to display the answer
                        echo "var paragraph = document.createElement('p');";
                        echo "paragraph.textContent = 'User $username answered: $text';";
                        echo "paragraph.setAttribute('id', '$aid');"; 
                        echo "document.querySelector('.answers').appendChild(paragraph);";
                        echo "document.querySelector('.answers').appendChild(document.createElement('br'));";
                    }
                } else {
                    // Display a message if no answers are found
                    echo "var paragraph = document.createElement('p');";
                    echo "paragraph.textContent = 'No results';";
                    echo "document.body.appendChild(paragraph);";
                }
            ?>
        }
    </script>
</div>

<script src="cookie.js"></script>
</body>
</html>

<?php
    // Check if the form has been submitted
    if (isset($_POST["submit"])) {
        $answer = filter_input(INPUT_POST, "answer", FILTER_SANITIZE_SPECIAL_CHARS);

        $uid = $_SESSION["id"];

        //check if user is connected
        if ($uid == -1) {
            echo "<script>";
            echo "alert('If you would like to answer this question, sign in first');";
            echo "</script>";
        }

        // Validate the answer field
        if (empty($answer)) {
            echo "<p style='color: red';>You must fill the answer field!</p>";
        } else {
            // Insert the answer into the database
            $sql = "INSERT INTO ANSWERS (atext, qid, uid)
                    VALUES ('$answer', '$questionID', '$uid')";

            mysqli_query($conn, $sql);

            $aid = mysqli_insert_id($conn);

            $sql1 = "SELECT u.notification FROM USERS u JOIN QUESTIONS q ON u.id = q.uid WHERE q.qid = '$questionID'";

            $result = mysqli_query($conn, $sql1);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            
                $not = $row["notification"];
            
                // Construct the URL to the question details page with the answer ID as a fragment
                $url = "http://localhost/website/question-details.php?qid=" . $questionID . "#" . $aid;
            
                // Send a notification to the user with the reply link
                $ret = Simplepush::send($not, "REPLY", "Use this link to access the reply: " . $url);
            }

            // Redirect to the URL after sending the notification
            header("Location: $url");
            exit(); // Make sure to exit after the redirect
        }
    }

    mysqli_close($conn);
?>

