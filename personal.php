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
</head>
<body>
    <h2> <?php echo $_SESSION["id"]; ?> </h2>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <h1>Edit Personal Infornation</h1>
        <input type="text" name="fname" placeholder="First Name">
        <input type="text" name="lname" placeholder="Last Name">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="email" name="email" placeholder="email">
        <p>If you decide to change your personal information, you'll have to log in again.</p>
        <button type="submit" name="edit">Save changes</button>
        <button type="submit" name="delete">Delete Account</button>
    </form>
</body>
</html>

<?php 

    if (isset($_POST["delete"])) {
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
    }else{
        echo "Something  wrong!";
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

?>