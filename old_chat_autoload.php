<?php
session_start();

include"database_connection.php";



$user1=$_SESSION["self_user"];
$user2=$_SESSION["other_user"];
$other_user=$_SESSION["other_user"];
if(strcmp($user1,$user2)>0){
    $user2=$_SESSION["self_user"];
    $user1=$_SESSION["other_user"];
};



$change_lue_value="UPDATE messages SET LUE = 1 WHERE user1='$user1' and user2 = '$user2' and sender = '$other_user'";
$execute_query=mysqli_query($link,$change_lue_value);

$chat_query="select * from messages where user1='$user1' and user2 = '$user2'";
$execute_chat_query=mysqli_query($link,$chat_query);

while($rows = mysqli_fetch_array($execute_chat_query)) :
    echo"<ul>";
    if($rows['type_message']==0){
    	if($rows['sender'] == $_SESSION['self_user']){
        	echo "<li class=\"sent\"> <img class=\"profile_image\" src=\"pictures/".$_SESSION['self_user'].".png\" alt='me'/> <p class=\"chat-message\">".$rows["message"]."</p> </li> ";
    	}else{
        	echo " <li class=\"replies\"> <img class=\"profile_image\" src=\"pictures/".$_SESSION['other_user'].".png\" alt='him'/> <p class=\"chat-message\">".$rows["message"]."</p> </li>  ";
    	}
    }
    else{
        
        if($rows['sender'] == $_SESSION['self_user']){
            echo "<li class=\"sent\"> <img class=\"profile_image\" src=\"pictures/".$_SESSION['self_user'].".png\" alt='me'/> <p class=\"chat-message\"><img id='chat_image' style='cursor: pointer' src='".$rows["message"]."' alt='me'></p> </li> ";
        }else{
            echo " <li class=\"replies\"> <img class=\"profile_image\"  src=\"pictures/".$_SESSION['self_user'].".png\" alt='me'/> <p  class=\"chat-message\"><img id='chat_image' style='cursor: pointer' src='".$rows["message"]."' alt='me'></p> </li> ";
        }

    }
    echo"</ul>";

endwhile;


?>

