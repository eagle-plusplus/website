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
    <title>Login/Sign in</title>

    <link rel="stylesheet" href="signINUP.css">
</head>

<body>
    <button id="b1" type="button" onclick="window.location.href = 'homepage.html';">Homepage</button>

    <!-- Registration and Login Form Container -->
    <div class="container" id="container">
        
        <!-- Registration Form -->
        <div class="form-container register-container">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <h1>Register</h1>
                <input type="text" name="fname" placeholder="First Name" required>
                <input type="text" name="lname" placeholder="Last Name" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="rpassword" placeholder="Re-type Password" required>
                <input type="email" name="email" placeholder="email" required>
                <input type="password" name="notification" placeholder="Simlepush ID (optional)">
                <button type="submit" name="register" value="register">Sign Up</button>
            </form>
        </div>
    
        <!-- Login Form -->
        <div class="form-container login-container">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <h1>Login</h1>
            <input type="text" name="user" placeholder="username">
            <input type="password" name="pass" placeholder="Password">
            <button type="submit" name="login" value="login">Sign In</button>
            <button type="submit" id="visitor" name="visitor" value="visitor">Continue as Visitor</button>
            </form>
        </div>

        <!-- Overlay Div -->
        <div class="overlay"></div>
    
        <!-- Left Overlay Panel -->
        <div class="overlay-panel overlay-left">
            <h1 class="title">Welcome <br> back!</h1>
            <p>If you already have an account, login here.</p>
            <button class="ghost" id="login">Login</button>
        </div>

        <!-- Right Overlay Panel -->
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
            echo "<p style='color: red';>Some required credentials are missing!</p>";
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
                    echo "<p style='color: #194759';>Successful registration!</p>";
                }catch(mysqli_sql_exception){
                    // Catch the exception and display error message
                    echo "<p style='color: red';>That username is alredy taken!</p>";
                }

            }else{
                // Notify the user that the password fields do not match.
                echo "<p style='color: red';>Passwords do not match!</p>";
            }
        }
    }

    // check if the login button was clicked
    if (isset($_POST["login"])) {
        
        // Get the username from the POST request and sanitize it
        $user = filter_input(INPUT_POST, "user", FILTER_SANITIZE_SPECIAL_CHARS);
        
        // Get the password from the POST request and sanitize it
        $pass = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($user) || empty($pass)) {
            // Check if either the username or the password is empty
            echo "<p style='color: red';>Some credentials are missing!</p>";
        } else {
            // Build a SQL query to select the user with the given username
            $sql = "SELECT * FROM USERS WHERE username = '$user'";

            // Execute the query on the database
            $result = mysqli_query($conn, $sql);

            if (!(mysqli_num_rows($result) > 0)) {
                // Check if there are any rows in the result
                echo "<p style='color: red';>There are no users with these credentials!</p>";
            } else {
                // Fetch the first row from the result and store it in an associative array
                $row = mysqli_fetch_assoc($result);
                
                // Extract the hashed password from the row
                $hashed_pass = $row["password"];

                if (password_verify($pass, $hashed_pass)) {
                    // Check if the entered password matches the hashed password in the database

                    // Store user information in session variables
                    $_SESSION["first"] = $row["fname"];
                    $_SESSION["last"] = $row["lname"];
                    $_SESSION["user"] = $row["username"];
                    $_SESSION["id"] = $row["id"];
                    $_SESSION["email"] = $row["email"];
                    $_SESSION["notification"] = $row["notification"];

                    // Redirect the user to the mainpage.php
                    header("Location: mainpage.php");
                } else {
                    // Output an error message if the password is incorrect
                    echo "<p style='color: red';>Wrong password!</p>";
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
