<?php
/**
 * Created by PhpStorm.
 * User: MokhtarKH
 * Date: 04-05-2019
 * Time: 9:30
 */

    session_start();

    include "init.php";

    $user1=$_SESSION["username"];
    $user2=$_SESSION["other_user"];
    $id = $_SESSION["id"];

    if(isset($_POST["send_message"])){
        $_POST["txtmessage"]= trim($_POST["txtmessage"]);
        if(!empty($_POST["txtmessage"])){
                $sender=$_SESSION["username"];
                $new_message= $_POST["txtmessage"];
                if(strcmp($user1,$user2)>0)
                {
                        $user2=$_SESSION["username"]; $user1=$_SESSION["other_user"];
                };

                $stmt = $conn->prepare("insert into messages (`user1`, `user2`, `sender`, `message`, `Time`, `lue`) values('$user1','$user2','$sender','$new_message',CURRENT_TIMESTAMP,0)");
                $stmt->execute();


        };
    };

    header("location:messages.php?target=" . $_SESSION["other_user"]);
    exit(); 

?>