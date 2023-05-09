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

    <br>

    <a href="xmlmaker.php">
        <button>Download data in XML</button>
    </a>

    <div class="top-bar">
        <h1>
            My Forum
        </h1>
    </div>
    <div class="main" style="border: 10px solid;">
        <script>
            window.onload = function() {
            <?php
                $sql = "SELECT * FROM QUESTIONS";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $title = $row["title"];
                        echo "var link = document.createElement('a');";
                        echo "link.href = 'question-details.php?qid=" . $row["qid"] . "';";
                        echo "link.textContent = '" . $title . "';";
                        echo "document.querySelector('.main').appendChild(link);";
                        echo "document.querySelector('.main').appendChild(document.createElement('br'));";
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
    
    <div class="search">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="get">
            <h3>Search Questions</h3>
            <input type="text" name="content" placeholder="Search a question title or main body">
            <input type="text" name="users" placeholder="Search a a name of a user">
            <label for="dates">Search a date of a question's submition:</label>
            <input type="date" name="dates" placeholder="Search a date of a question's submition">
            <button type="submit" name="search" value="search">Search</button>
        </form>
    </div>

</body>
</html>

<?php
    if (isset($_GET["search"])){
        $content = filter_input(INPUT_GET, "content", FILTER_SANITIZE_SPECIAL_CHARS);
        $users = filter_input(INPUT_GET, "users", FILTER_SANITIZE_SPECIAL_CHARS);
        $dates = filter_input(INPUT_GET, "dates", FILTER_SANITIZE_SPECIAL_CHARS);

        // Start building the SQL query
        $sql = "SELECT * FROM QUESTIONS t JOIN USERS u ON t.uid = u.id WHERE";

        // Check if $content is provided
        if (!empty($content)) {
            $sql .= " t.qtext LIKE '%$content%' OR t.title LIKE '%$content%'";
        }

        // Check if $users is provided
        if (!empty($users)) {
            // Add appropriate logic to match the user's name in the USERS table
            if (!empty($content)) {
            $sql .= " AND";
            }
            $sql .= " (u.username LIKE '%$users%' OR u.fname LIKE '%$users%' OR u.lname LIKE '%$users%' OR u.email LIKE '%$users%')";
        }

        // Check if $dates is provided
        if (!empty($dates)) {
            if (!empty($content) || !empty($users)) {
            $sql .= " AND";
            }
            $sql .= " t.qdate LIKE '%$dates%'";
        }

        echo $sql . "<br>";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>";
            echo "var mainDiv = document.querySelector('.main');";
            echo "mainDiv.innerHTML = '';"; // Clear existing content
        
            while ($row = mysqli_fetch_assoc($result)) {
                $title = $row["title"];
                echo "var link = document.createElement('a');";
                echo "link.href = 'question-details.php?qid=" . $row["qid"] . "';";
                echo "link.textContent = '" . $title . "';";
                echo "mainDiv.appendChild(link);";
                echo "mainDiv.appendChild(document.createElement('br'));";
            }
        
            echo "</script>";
        } else {
            echo "No results";
        }

        /*
        } else {
            echo "var paragraph = document.createElement('p');";
            echo "paragraph.textContent = 'No results';";
            echo "document.body.appendChild(paragraph);";
        }*/

    }

    mysqli_close($conn);
?>