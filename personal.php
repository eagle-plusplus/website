<?php
    session_start(); // Start or resume a session

    include("database.php"); // Include the "database.php" file for establishing a database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information</title>

    <link rel="stylesheet" href="personal.css">
</head>
<body>
    <div class="edit-box">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <!-- Form to edit personal information -->
            <h1>Edit Personal Infornation</h1>
            <!-- Heading -->
            <label for="fname">First Name:</label>
            <!-- Label for first name input field -->
            <input type="text" name="fname" placeholder="<?php echo $_SESSION["first"]; ?>">
            <!-- Input field for first name -->

            <label for="lname">Last Name:</label>
            <!-- Label for last name input field -->
            <input type="text" name="lname" placeholder="<?php echo $_SESSION["last"]; ?>">
            <!-- Input field for last name -->

            <label for="username">Username:</label>
            <!-- Label for username input field -->
            <input type="text" name="username" placeholder="<?php echo $_SESSION["user"]; ?>">
            <!-- Input field for username -->

            <label for="password">Password:</label>
            <!-- Label for password input field -->
            <input type="password" name="password" placeholder="New Password">
            <!-- Input field for password -->

            <label for="email">e-mail:</label>
            <!-- Label for email input field -->
            <input type="email" name="email" placeholder="<?php echo $_SESSION["email"]; ?>">
            <!-- Input field for email -->

            <label for="notification">Simplepush ID:</label>
            <!-- Label for email input field -->
            <input type="password" name="notification" placeholder="<?php echo $_SESSION["notification"]; ?>">
            <!-- Input field for email -->

            <p>If you decide to change your personal information, you'll have to log in again.</p>
            <!-- Information message -->

            <div class="edit-buttons">
                <!-- Container for edit buttons -->
                <button type="submit" name="edit">Save changes</button>
                <!-- Button to save changes -->
                <button type="submit" name="delete">Delete Account</button>
                <!-- Button to delete account -->
                <button type="button" onclick="window.location.href = 'mainpage.php';">Go back</button>
                <!-- Button to go back to the main page -->
            </div>
        </form>
    </div>

    <script src="cookie.js"></script>
    <!-- Script for handling cookies -->
</body>
</html>


<?php
    // Check if the "delete" button is clicked
    if (isset($_POST["delete"])) {
        echo "deleting";
        // Generate a random sequence of letters
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVW';
        $randomSequence = str_shuffle($letters);

        echo $randomSequence;

        $idToDelete = $_SESSION["id"];
        // Update the user's information with the random sequence as a placeholder
        $sql = "UPDATE USERS
                SET fname = '$randomSequence', lname = '$randomSequence', username = '$randomSequence', email = '$randomSequence'
                WHERE id = '$idToDelete'";

        mysqli_query($conn, $sql);

        // Destroy the session and redirect to the index page
        session_destroy();
        header("Location: index.php");
    }

    // Check if the "edit" button is clicked
    if (isset($_POST["edit"])) {
        // Retrieve and sanitize the input values
        $fname = filter_input(INPUT_POST, "fname", FILTER_SANITIZE_SPECIAL_CHARS);
        $lname = filter_input(INPUT_POST, "lname", FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $notification = filter_input(INPUT_POST, "notification", FILTER_SANITIZE_SPECIAL_CHARS);

        $idToEdit = $_SESSION["id"];

        $edited = false;
        
        // Update the first name if it is not empty
        if (!empty($fname)) {
            $sql = "UPDATE USERS
                    SET fname = '$fname'
                    WHERE id = '$idToEdit'";

            mysqli_query($conn, $sql);

            $edited = true;
        }

        // Update the last name if it is not empty
        if (!empty($lname)) {
            $sql = "UPDATE USERS
                    SET lname = '$lname'
                    WHERE id = '$idToEdit'";

            mysqli_query($conn, $sql);

            $edited = true;
        }

        // Update the username if it is not empty
        if (!empty($username)) {
            $sql = "UPDATE USERS
                    SET username = '$username'
                    WHERE id = '$idToEdit'";

            mysqli_query($conn, $sql);

            $edited = true;
        }

        // Update the password if it is not empty
        if (!empty($password)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "UPDATE USERS
                    SET password = '$hash'
                    WHERE id = '$idToEdit'";

            mysqli_query($conn, $sql);

            $edited = true;
        }

        // Update the email if it is not empty
        if (!empty($email)) {
            $sql = "UPDATE USERS
                    SET email = '$email'
                    WHERE id = '$idToEdit'";

            mysqli_query($conn, $sql);

            $edited = true;
        }

        // Update the notification id if it is not empty
        if (!empty($notification)) {
            $sql = "UPDATE USERS
                    SET notification = '$notification'
                    WHERE id = '$idToEdit'";

            mysqli_query($conn, $sql);

            $edited = true;
        }

        // If any field is edited, destroy the session and redirect to the index page
        if ($edited == true) {
            session_destroy();
            header("Location: index.php");
        }
    }

    mysqli_close($conn);
?>
