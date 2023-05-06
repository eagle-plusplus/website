<?php

    include("database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <label for="username">name</label>
        <input type="text" name="username" placeholder="Username">
        <br>

        <label for="password">password</label>
        <input type="password" name="password" placeholder="Password" maxlength="30">

        <input type="radio" name="pay" value="visa">
        visa
        <input type="radio" name="pay"value="cash">
        cash
        <input type="radio" name="pay" value="bitcoin">
        bitcoin

        <input type="submit" name="login" value="log in">

    </form>

</body>
</html>

<?php
    echo "{$_POST["username"]} <br>";
    echo "{$_POST["password"]} <br>";

    $word = "pizza";

    $hash = password_hash($word, PASSWORD_DEFAULT);

    echo $hash;

    if (isset($_POST["login"])){
        $password = $_POST["password"];

        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);


        echo "{$_POST["username"]} <br>";
        echo "{$_POST["password"]} <br>";

        if (empty($username)){
            echo "missing";
        }

    }

    /*
        abs()  absolute
        round($x, 2)  
        floor()  down
        ceil()  up
        pow($x, $y)
        sqrt($x)
        max($x, $y, $z)
        pi()   π
        rand(1, 6);
    */

    /*
    $food = array("banana", "apple", "pussy");
    array_push($food, "dick", "steak");
    array_pop($food);
    array_shift($food);
    $food = array_reverse($food);
    echo count($food);


    $food[0] = "pinapple";

    foreach($food as $f){
        echo $f . "<br>";
    }

    */

    /*-------------$date = date("l");*/

    /*
    $grade = "ad";

    switch($grade){
        case "a":
            echo "good";
            break;
        case "b":
            echo "good";
            break;
        default:
            echo "what";
    }
    */

    /* && and || or !not */

    /*
    $age = 0;

    if ($age >= 18){
        echo "good";
    }elseif ($age == 0){
        echo "what";
    }else{
        echo "bad";
    }
    */

    /*echo"sexcckkx <br>";

    $name = "ektoras gay <br>";
    echo $name;

    echo"hello {$name} <br>";

    //echo"djd", $name;

    $age = 19;
    echo $age, "<br>";

    $grade = 5.9;
    echo $grade;

    $price = 9.99;
    echo"hello  \${$price} <br>";

    $pass = true;

    // ** power
    */
?>