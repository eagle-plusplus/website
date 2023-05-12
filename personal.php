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
    <title>Personal Information</title>

    <link rel="stylesheet" href="personal.css">
</head>
<body>
    <div class="edit-box">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <h1>Edit Personal Infornation</h1>
            <label for="fname">First Name:</label>
            <input type="text" name="fname" placeholder="<?php echo $_SESSION["first"]; ?>">

            <label for="lname">Last Name:</label>
            <input type="text" name="lname" placeholder="<?php echo $_SESSION["last"]; ?>">

            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="<?php echo $_SESSION["user"]; ?>">

            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="New Password">

            <label for="email">e-mail:</label>
            <input type="email" name="email" placeholder="<?php echo $_SESSION["email"]; ?>">

            <p>If you decide to change your personal information, you'll have to log in again.</p>

            <div class="edit-buttons">
                <button type="submit" name="edit">Save changes</button>
                <button type="submit" name="delete">Delete Account</button>
                <button type="button" onclick="window.location.href = 'mainpage.php';">Go back</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php 

    if (isset($_POST["delete"])) {
        echo "deleting";
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVW';
        $randomSequence = str_shuffle($letters);

        echo $randomSequence;

        $idToDelete = $_SESSION["id"];
        $sql = "UPDATE USERS
                SET fname = '$randomSequence', lname = '$randomSequence', username = '$randomSequence', email = '$randomSequence'
                WHERE id = '$idToDelete'";

        mysqli_query($conn, $sql);

        session_destroy();
        header("Location: index.php");
    }

    if (isset($_POST["edit"])){

        $fname = filter_input(INPUT_POST, "fname", FILTER_SANITIZE_SPECIAL_CHARS);
        $lname = filter_input(INPUT_POST, "lname", FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);

        $idToEdit = $_SESSION["id"];

        $edited = false;
        
        if (!empty($fname)){
            $sql = "UPDATE USERS
                    SET fname = '$fname'
                    WHERE id = '$idToEdit'";

            mysqli_query($conn, $sql);

            $edited = true;
        }

        if (!empty($lname)){
            $sql = "UPDATE USERS
                    SET lname = '$lname'
                    WHERE id = '$idToEdit'";

            mysqli_query($conn, $sql);

            $edited = true;
        }

        if (!empty($username)){
            $sql = "UPDATE USERS
                    SET username = '$username'
                    WHERE id = '$idToEdit'";

            mysqli_query($conn, $sql);

            $edited = true;
        }

        if (!empty($password)){
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "UPDATE USERS
                    SET password = '$hash'
                    WHERE id = '$idToEdit'";

            mysqli_query($conn, $sql);

            $edited = true;
        }

        if (!empty($email)){
            $sql = "UPDATE USERS
                    SET email = '$email'
                    WHERE id = '$idToEdit'";

            mysqli_query($conn, $sql);

            $edited = true;
        }

        if ($edited == true){
            session_destroy();
            header("Location: index.php");
        }
    }

    mysqli_close($conn);

?>