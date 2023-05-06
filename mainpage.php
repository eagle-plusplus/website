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
    <title>mainpage</title>
</head>
<body>
    <a href="personal.php">
        <button>Personal information</button>
    </a>

    <br>

    <a href="question.php">
        <button>Make a question</button>
    </a>

    <button onclick="addParagraph()">Add Paragraph</button>
    <script>
        function addParagraph() {
            // Create a new <p> element
            var paragraph = document.createElement("p");

            // Set the PHP code as the content of the <p> element
            paragraph.textContent = "<?php echo 'This is a PHP code'; ?>";

            // Append the <p> element to the <body> element
            document.body.appendChild(paragraph);
        }
    </script>
</body>
</html>

<?php
    mysqli_close($conn);
?>