
<?php
    session_start();
    include "../../init.php";

    if(isset($_SERVER["HTTP_REFERER"])){
    if(isset($_GET['username']) && isset($_GET['target'])){
    $user1 = $_GET['username'];
    $user2 = $_GET['target'];
    $other_user = $_GET['target'];
        
        updateLue($user1, $user2, $other_user);
        
        header("location:../../messages.php?target=" . $other_user);
        exit();
    }
    else {
        
        header("location:" . $_SERVER["HTTP_REFERER"]);
        exit();
    }        
    }
    else {
        
        header("location: ../../main.php");
        exit();
    }

?>