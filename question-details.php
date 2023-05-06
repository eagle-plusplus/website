<?php
    session_start();

    include("database.php");

    // Retrieve the question ID from the URL parameter
    $questionID = $_GET['qid'];

    echo $questionID;

    // Perform a database query to fetch the question details based on the ID
    // Replace the following code with your own database query logic
    $sql = "SELECT * FROM QUESTIONS WHERE qid = '$questionID'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $title = $row["title"];
    $text = $row["qtext"];

    echo $text;

    // Display the question details
    echo "<h2>" . $row['title'] . "</h2>";
    echo "<p>" . $row['qtext'] . "</p>";

    mysqli_close($conn);
?>
