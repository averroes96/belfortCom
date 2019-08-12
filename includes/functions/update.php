<?php
    ob_start();
    session_start();
    include "../../init.php";

if(isset($_SESSION["id"])){
    
    if(isset($_GET['u']) && isset($_SERVER["HTTP_REFERER"]) ){
        

        $action = $_GET['u'];
        $link = $_SERVER["HTTP_REFERER"];

        
       if($action == "unsub"){
           
        if(isset($_GET['userID']) && isset($_GET['followerID'])){           
           
        $user1 = $_GET['userID'];
        $user2 = $_GET['followerID'];
            
           $stmt = $conn->prepare("DELETE FROM follower WHERE userID = $user1 AND followerID = $user2 ");
           $stmt->execute();
           
           
           if($stmt){
               
               header("location:" . $link);
               exit();
               
           }
           else 
               echo "DATABASE ERROR !";
            
        }
        else {
            
            header("location:../../main.php");
            exit();
        }            
       }
        else if( $action == "sub"){
            
        if(isset($_GET['userID']) && isset($_GET['followerID'])){           
           
        $user1 = $_GET['userID'];
        $user2 = $_GET['followerID'];            
            
            $check = getAllFrom("*","follower","WHERE userID = $user1 AND followerID = $user2 ");
            
            if(count($check) == 0){
            
               $stmt = $conn->prepare("INSERT INTO follower(userID, followerID, follow_date) VALUES (:zuser, :zfollower, now())");
               $stmt->execute(array(
               
               "zuser" => $user1,
               "zfollower" => $user2
               
               ));
                
           if($stmt){
                deleteNotification("user-plus", $user2, 0, $user1);   
                $fr_message = $_SESSION["username"] . " " . "a commencé à te suivre" ;
                $en_message = $_SESSION["username"] . " " . "started following you" ;               
                $url = "profile.php?userID=".$user2 ;
                notify("user-plus", $fr_message, en_message, $user1, $user2, "", $url);

               
               header("location:" . $link);
               exit(); 
               
           }
           else 
               echo "DATABASE ERROR !";                
                
            }
            else {
                
                header("Location:" . $link);
                exit();
            }
            
        }        else {
            
            header("location:../../main.php");
            exit();
        }
        }
        else if( $action == "alike"){
            
        if(isset($_GET['itemID']) && isset($_GET['userID'])){              
            
        $item = $_GET['itemID'];
        $user = $_GET['userID'];
            
            $check = getAllFrom("*","likes","WHERE itemID = $item AND userID = $user ");
            
            if(count($check) == 0){
            
               $stmt = $conn->prepare("INSERT INTO likes(itemID, userID, like_date) VALUES (:zitem, :zuser, now())");
               $stmt->execute(array(
               
               "zitem" => $item,
               "zuser" => $user
               
               ));
                
           if($stmt){
               
               $row = getAllFrom("*","items","WHERE itemID = " . $item);
               
               if($_SESSION["id"] != $row[0]["userID"]){
                   
                deleteNotification("thumbs-up", $_SESSION["id"], $item, $row[0]["userID"]);   
                $fr_message = $_SESSION["username"] . " " . "a aimé votre annonce" ;
                $en_message = $_SESSION["username"] . " " . "liked your ad" ;   
                $url = "showAd.php?itemID=".$item ;
                notify("thumbs-up", $fr_message, en_message, $row[0]["userID"], $_SESSION["id"], $item, $url);
               }
               
                    if(countItems("*","likes","WHERE itemID = " . $item) % 10 == 0 && countItems("*","likes","WHERE itemID = " . $item) != 0){
                        $likes = countItems("*","likes","WHERE itemID = " . $item);
                        $notif_message = $likes . " " . lang("LIKES-MSG") ;
                        $url = "showAd.php?itemID=".$item;
                        notify("thumbs-up", $notif_message, $row[0]["userID"], $_SESSION["id"], $item, $url);

                    }
               
               header("location:" . $link . "#" . $item);
               exit(); 
               
           }
           else 
               echo "DATABASE ERROR !";                
                
            }
            else {
                
                header("Location:" . $link); 
                exit();
            }            
            
        }
        }
        else if( $action == "rlike"){
           
        if(isset($_GET['itemID']) && isset($_GET['userID'])){           
           
        $item = $_GET['itemID'];
        $user = $_GET['userID'];
            
           $stmt = $conn->prepare("DELETE FROM likes WHERE itemID = $item AND userID = $user");
           $stmt->execute();
           
           if($stmt){


               header("location:" . $link . "#" . $item);
               exit();
               
           }
           else 
               echo "DATABASE ERROR !";
            
        }
        else {
            
            header("location:../../main.php");
            exit();
        }             
            
            
            
        }
        else {
            
                header("Location:../../main.php");
                exit();            
        }
        

        
    }
    else {
    
    header("location:../../main.php");
    exit();
    }
}
else {
    
    header("location:../../login.php");
    exit();    
    
}
    ob_end_flush();

?>