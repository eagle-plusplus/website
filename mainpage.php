<?php
    session_start();

    include("database.php");

    $sid = $_SESSION["id"];

    if (isset($_POST["newq"])){
        if ($sid > 0){
            header("Location: question.php");
        }else{
            echo "<script>";
            echo "alert('You cannot ask a question as a visitor. Please Sign in.');";
            echo "</script>";
        }
    }

    if (isset($_POST["personal"])){
        if ($sid > 0){
            header("Location: personal.php");
        }else{
            echo "<script>";
            echo "alert('You cannot edit personal information as a visitor. Please Sign in.');";
            echo "</script>";
        }
    }

    if (isset($_POST["xml"])){
        if ($sid > 0){
            header("Location: xmlmaker.php");
        }else{
            echo "<script>";
            echo "alert('You cannot download data in XML form as a visitor. Please Sign in.');";
            echo "</script>";
        }
    }

    if (isset($_POST["logout"])) {
        session_destroy(); // Destroy the session
        header("Location: index.php");
        exit(); // Terminate the script execution
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mainpage</title>

    <link rel="stylesheet" href="mainpage3.css">
</head>
<body>

    <div class="mainb">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <button type="submit" name="newq" >Make a question</button>
        </form>

        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="get">
            <button type="submit" name="myquestion" value="myquestion" >My questions</button>
        </form>
    
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <button type="submit" name="personal" >Personal information</button>
        </form>

        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <button type="submit" name="xml" >Download data in XML</button>
        </form>

        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <button type="submit" name="logout" >Logout</button>
        </form>
    </div>

    <div class="top-bar">
        <h1>
            HyperDialogue
        </h1>
    </div>
    <div class="main">
        <?php if(empty($_GET["search"]) && empty($_GET["myquestion"])) : 
            $sql = "SELECT * FROM QUESTIONS t JOIN USERS u ON t.uid = u.id";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo "<script>";
                echo "window.onload = function() {";
                echo "var mainDiv = document.querySelector('.main');";
                echo "mainDiv.innerHTML = '';"; // Clear existing content
                
                $i = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $username = $row["username"];
                    $title = $row["title"];
                    $date = $row["qdate"];
                    
                    echo "var link = document.createElement('a');";
                    echo "link.href = 'question-details.php?qid=" . $row["qid"] . "';";
                    echo "link.textContent = '" . $i . ") (" . $date . ") The user " . $username . " asked: " . $title . "';";
                    echo "mainDiv.appendChild(link);";
                    echo "mainDiv.appendChild(document.createElement('br'));";

                    $i += 1;
                }

                echo "}";
                echo "</script>";
            } else {
                echo "No results";
            }
        endif; ?>
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

    <script src="cookie.js"></script>
</body>
</html>

<?php
    if (isset($_GET["myquestion"])){
        if ($sid > 0){

            $sql = "SELECT * FROM QUESTIONS t JOIN USERS u ON t.uid = u.id WHERE u.id = '$sid'";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                echo "<script>";
                echo "var mainDiv = document.querySelector('.main');";
                echo "mainDiv.innerHTML = '';"; // Clear existing content
                
                $i = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $username = $row["username"];
                    $title = $row["title"];
                    $date = $row["qdate"];
                    
                    echo "var link = document.createElement('a');";
                    echo "link.href = 'question-details.php?qid=" . $row["qid"] . "';";
                    echo "link.textContent = '" . $i . ") (" . $date . ") The user " . $username . " asked: " . $title . "';";
                    echo "mainDiv.appendChild(link);";
                    echo "mainDiv.appendChild(document.createElement('br'));";
    
                    $i += 1;
                }
            
                echo "</script>";
            } else {
                echo "No results";
            }
        }else{
            echo "<script>";
            echo "alert('If you would like to see your questions please Sign in.');";
            echo "</script>";
        }
    }    

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

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>";
            echo "var mainDiv = document.querySelector('.main');";
            echo "mainDiv.innerHTML = '';"; // Clear existing content
            
            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $username = $row["username"];
                $title = $row["title"];
                $date = $row["qdate"];
                
                echo "var link = document.createElement('a');";
                echo "link.href = 'question-details.php?qid=" . $row["qid"] . "';";
                echo "link.textContent = '" . $i . ") (" . $date . ") The user " . $username . " asked: " . $title . "';";
                echo "mainDiv.appendChild(link);";
                echo "mainDiv.appendChild(document.createElement('br'));";

                $i += 1;
            }
        
            echo "</script>";
        } else {
            echo "No results";
        }

    }

    mysqli_close($conn);
?>