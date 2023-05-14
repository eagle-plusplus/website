<?php
    // Starts a new session or resumes an existing one.
    session_start();

    // Includes the "database.php" file, which establishes a connection to a database.
    include("database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cont</title>

    <link rel="stylesheet" href="signINUP.css">
</head>

<body>
    <button id="b1" type="button" onclick="window.location.href = 'homepage.html';">Homepage</button>

    <div class="container" id="container">
        
        <div class="form-container register-container">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <h1>Register</h1>
                <input type="text" name="fname" placeholder="First Name">
                <input type="text" name="lname" placeholder="Last Name">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <input type="password" name="rpassword" placeholder="Re-type Password">
                <input type="email" name="email" placeholder="email">
                <input type="password" name="notification" placeholder="Simlepush ID">
                <button type="submit" name="register" value="register">Sign Up</button>
            </form>
        </div>
    
        <div class="form-container login-container">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <h1>Login</h1>
            <input type="text" name="user" placeholder="username">
            <input type="password" name="pass" placeholder="Password">
            <button type="submit" name="login" value="login">Sign In</button>
            <button type="submit" id ="visitor" name="visitor" value="visitor">Continue as Visitor</button>
            </form>
        </div>

        <div class="overlay"></div>
    
        <div class="overlay-panel overlay-left">
            <h1 class="title">Welcome <br> back!</h1>
            <p>If you already have an account, login here.</p>
            <button class="ghost" id="login">Login</button>
        </div>

        <div class="overlay-panel overlay-right">
            <h1 class="title">Create a new <br> account now!</h1>
            <p>If you don't have an account yet, create one here.</p>
            <button class="ghost" id="register">Register</button>
        </div>
    
    </div>
  
    <script src="signINUP.js"></script>
    <script src="cookie.js"></script>
  </body>

</html>

<?php
    // check if the register button was clicked.
    if (isset($_POST["register"])){

        // Sanitize and validate input fields.
        $fname = filter_input(INPUT_POST, "fname", FILTER_SANITIZE_SPECIAL_CHARS);
        $lname = filter_input(INPUT_POST, "lname", FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $rpassword = filter_input(INPUT_POST, "rpassword", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $notification = filter_input(INPUT_POST, "notification", FILTER_SANITIZE_SPECIAL_CHARS);

        // Check if any of the required fields are empty.
        if (empty($fname)||empty($lname)||empty($username)||empty($password)||empty($rpassword)||empty($email)){
            echo "Some required credentials are missing!";
        }else{
            // Check if the password and repeated password fields match.
            if ($password == $rpassword){

                if (empty($notification)){
                    $notification = null;
                }

                // Hash the password using the default algorithm.
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // Create a SQL statement to insert the user's information into the "USERS" table.
                $sql = "INSERT INTO USERS (fname, lname, username, password, email, notification)
                VALUES ('$fname', '$lname', '$username', '$hash', '$email', ";

                if ($notification === null) {
                    $sql .= "NULL)";
                } else {
                    $sql .= "'$notification')";
                }

                try{
                    // Execute the SQL query and display success message
                    mysqli_query($conn, $sql);
                    echo "Successful registration!";
                }catch(mysqli_sql_exception){
                    // Catch the exception and display error message
                    echo "That username is alredy taken!";
                }

            }else{
                // Notify the user that the password fields do not match.
                echo "Passwords do not match!";
            }
        }
    }

    // check if the login button was clicked
    if (isset($_POST["login"])) { 
        
        $user = filter_input(INPUT_POST, "user", FILTER_SANITIZE_SPECIAL_CHARS); // get the username from the POST request and sanitize it
        $pass = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_SPECIAL_CHARS); // get the password from the POST request and sanitize it
    
        if (empty($user) || empty($pass)) { 
            
            // check if either the username or the password is empty
            echo "Some credentials are missing!";
        } else {
            $sql = "SELECT * FROM USERS WHERE username = '$user'"; // build a SQL query to select the user with the given username
            $result = mysqli_query($conn, $sql); // execute the query on the database
    
            if (!(mysqli_num_rows($result) > 0)) { // check if there are any rows in the result
                echo "There are no users with these credentials!"; // output an error message if there are no rows in the result
            } else {
                $row = mysqli_fetch_assoc($result); // fetch the first row from the result and store it in an associative array
                $hashed_pass = $row["password"]; // extract the hashed password from the row
    
                if (password_verify($pass, $hashed_pass)) { // check if the entered password matches the hashed password in the database

                    $_SESSION["first"] = $row["fname"];
                    $_SESSION["last"] = $row["lname"];
                    $_SESSION["user"] = $row["username"];
                    $_SESSION["id"] = $row["id"];
                    $_SESSION["email"] = $row["email"];
                    $_SESSION["notification"] = $row["notification"];

                    header("Location: mainpage.php");
                } else {
                    echo "Wrong password!"; // output an error message if the password is incorrect
                }
            }
        }
    }

    // check if the continue as visitor button was clicked
    if (isset($_POST["visitor"])) {
        $_SESSION["id"] = -1;
        header("Location: mainpage.php");
    }

    // Close the database connection.
    mysqli_close($conn);
?>
