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

    <div class="top-bar">
        <h1>
            My Forum
        </h1>
    </div>
    <div class="main" style="border: 10px solid;">
        <button onclick="addLinks()">Add Links</button>
        <script>
            function addLinks() {
                <?php
                $sql = "SELECT * FROM QUESTIONS";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $title = $row["title"];
                        echo "var link = document.createElement('a');";
                        echo "link.href = 'question-details.php?qid=" . $row["qid"] . "';";
                        echo "link.textContent = '" . $title . "';";
                        echo "document.body.appendChild(link);";
                        echo "document.body.appendChild(document.createElement('br'));";
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
    mysqli_close($conn);
?>