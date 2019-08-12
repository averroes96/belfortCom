<?php
//upload.php
if($_FILES["file"]["name"] != '')
{   

    $image = rand(0,100000) . "_" . $_FILES["file"]["name"] ;
                    
    move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/sent_pictures/" . $image) ;

	session_start();
    include"init.php";

    $user1=$_SESSION["username"];
    $user2=$_SESSION["other_user"];
    $sender=$_SESSION["username"];

    if(strcmp($user1,$user2)>0){
                        $user2=$_SESSION["username"]; $user1=$_SESSION["other_user"];
                };
    
                $stmt = $conn->prepare("insert into messages (`user1`, `user2`, `sender`, `message`, `time`, `lue`, `message_type`) values('$user1','$user2','$sender','$image',CURRENT_TIMESTAMP,0,1)");
                $stmt->execute();
    
                if($stmt){
                    
                header("location:messages.php?target=" . $_SESSION["other_user"]);
                exit(); 

                }


}
?>