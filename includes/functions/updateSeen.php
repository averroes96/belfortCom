<?php
    session_start();
    include "../../init.php";

    if(isset($_SERVER["HTTP_REFERER"])){
    if(isset($_GET['notifID']) && isset($_GET['link'])){
    $notif = $_GET['notifID'];
    $link = $_GET['link'];
    $userID = $_SESSION["id"];        

        $stmt = $conn->prepare("UPDATE notification SET seen = 1 WHERE notifID = $notif AND userID = $userID");
        $stmt-> execute();

        header("location:../../" . $link);
        exit();
    }
    else {
        
        header("location: ../../main.php");
        exit();
    }
    }
    else {
        
        header("location: ../../main.php");
        exit();
    }        

?>