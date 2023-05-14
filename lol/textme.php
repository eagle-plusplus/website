<?php 

    require('Simplepush.php');
    // Send notification
    $ret = Simplepush::send("BNmu2w", $_POST['title']??"No title", $_POST['msg']??"Empty message");
    echo $ret;

?>

<html>
    <body>
        <form action="textme.php" method="post">
            <input name="title" placeholder="Title"/><br/>
            <textarea name="message" placeholder="Message"></textarea><br/>
            <input type="submit" value="Text me!"/>
        </form>        
    </body>
</html>

