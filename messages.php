<?php
    ob_start();
    session_start();
    $title = "Messages";
    include "init.php";

if(isset($_SESSION["username"])){
    if(isset($_GET["target"]) && !empty(trim($_GET["target"]))){
        $tmp0 = $_GET["target"];
        $tmp1 = strtolower($_SESSION["username"]);
        $checkTarget = getAllFrom("username","users","WHERE username = '$tmp0' AND username != '$tmp1'");
        if(!empty($checkTarget))
        $_SESSION["other_user"] = $_GET["target"];
        else
        {
        $user1=$_SESSION["username"];
        $user_array=array();

        $other_user_selected = getMessages($user1);
    
        foreach($other_user_selected as $row){
                if(strcmp($user1,$row["user1"])==0){
                        array_push($user_array,$row["user2"]);
                }else{
                        array_push($user_array,$row["user1"]);
                }
        }

        $user_array=array_unique($user_array);
        $_SESSION["user_array"]=$user_array;
        $user= array_shift($user_array);
        array_unshift($user_array,$user);
        $_SESSION["other_user"]=$user;
    }    
    }
    else{
        $user1=$_SESSION["username"];
        $user_array=array();

        $other_user_selected = getMessages($user1);
    
        foreach($other_user_selected as $row){
                if(strcmp($user1,$row["user1"])==0){
                        array_push($user_array,$row["user2"]);
                }else{
                        array_push($user_array,$row["user1"]);
                }
        }

        $user_array=array_unique($user_array);
        $_SESSION["user_array"]=$user_array;
        $user= array_shift($user_array);
        array_unshift($user_array,$user);
        $_SESSION["other_user"]=$user;
    }
        
    $target = $_SESSION["other_user"];
    
?>
    <div id="frame" class="w3-margin-bottom w3-card">
         <div id="sidepanel">

            <div id="search">
                <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
                <input id="search_input" type="text" placeholder="Rechercher contacts..." />
            </div>           
             
            <div id="contacts">
                <ul id="ul_messages" style="padding:2px;">
<?php
   
    $connectedUser = $_SESSION["username"];   /*user*/

    $user_array=array();
                                 
    $getMessages = getMessages($connectedUser);

    foreach($getMessages as $message){
            if(strcmp($connectedUser,$message["user1"])==0){
                array_push($user_array,$message["user2"]);              
            }else{
                array_push($user_array,$message["user1"]);
            };
    }


    $user_array=array_unique($user_array);                         
                                 
    if(!empty($user_array)){
    foreach($user_array as $user){
        
        if (strcmp($_SESSION["username"], $user) > 0) {
                $user1 = $user;
                $user = $_SESSION["username"];
        }
        else 
        {
                $user1 = $_SESSION["username"];
        }

        $rows = getLatestMessage($user1, $user);
        if (strcmp($_SESSION["username"], $rows[0]["user1"]) == 0) {
        $username = $user;
        }
        else
        {
        $username = $rows[0]["user1"];
        };
        $image = getAllFrom("*","users","WHERE username ='$username'");
        
    echo "<a class='li-messages' class='w3-hover-text-white' style='text-decoration:none' href='messages.php?target=" . $username . "' ><li id='li_messages' name=\"". $username ."\" class=\"contact"; echo"\" >
                        
                             <div class='wrap'>";
        if(isset($image[0]["image"]) && !empty(trim($image[0]["image"])))
                                echo "<img src='uploads/profile_pictures/".$image[0]["image"]."' alt=\"\" />";
            else
                                echo "<img src='uploads/profile_pictures/user.png' alt=\"\" />";
                                echo "<div class=\"meta\">
                                    <p class=\"name\">".$username."</p>";
                                    if(($rows[0]["lue"]==0) && $user ==$rows[0]["sender"]){echo "<p class=\"previews\" style='font-weight: bolder;font-size: 18px'>".$rows[0]['message']."</p>";}
                                    else {echo"<p class=\"previews\">".$rows[0]['message']."</p>";};
                                echo"                                    
                                </div>
                             </div>
                         
           </li><a>";
    };
}

?>
                </ul>
            </div>

        </div>
        <div class="content w3-white">
<?php  $userImage = getAllFrom("*","users","WHERE username = '$target'");
    
    if(!empty($userImage)){
                ?>             
            <div class="contact-profile">
                <a href="profile.php?do=show&userID=<?php echo $userImage[0]["userID"] ?>"><img src="uploads/profile_pictures/<?php if(!empty($userImage[0]["image"])){ echo $userImage[0]["image"];} else echo "user.png" ?>" alt="profile picture" />
                    <p><?php echo $_SESSION["other_user"];?></p></a>

            </div>
<?php   }   ?>            
            
        <div class="messages" style="width:100%">
            <ul>
<?php
        $user1=$_SESSION["username"];
        $user2=$_SESSION["other_user"];
        $other_user=$_SESSION["other_user"];
        if(strcmp($user1,$user2)>0){
                $user2=$_SESSION["username"];
                $user1=$_SESSION["other_user"];
        };
                                        
        updateLue($user1, $user2, $other_user);            

        $rows = getPersonalMessages($user1, $user2);
    
    
if(!empty($rows)){
        foreach($rows as $row){
        if($row['message_type']==0){
              if($row['sender'] == $_SESSION['username']){
                  if(!empty(trim($_SESSION['image'])))
                  echo " <li class=\"sent\"> <img src=\"uploads/profile_pictures/".$_SESSION['image']."\" alt='me'/> <p class=\"chat-message\">".$row["message"]."</p> </li>";
                  else
                    echo " <li class=\"sent\"> <img src=\"uploads/profile_pictures/user.png\" alt='me'/> <p class=\"chat-message\">".$row["message"]."</p> </li>";      
                          
              }
                else{
                  if(!empty(trim($userImage[0]["image"])))   
                  echo " <li class=\"replies\"> <img src=\"uploads/profile_pictures/".$userImage[0]["image"]."\" alt='him'/> <p class=\"chat-message\">".$row["message"]."</p> </li>";
                    else
                    echo " <li class=\"replies\"> <img src=\"uploads/profile_pictures/user.png\" alt='him'/> <p class=\"chat-message\">".$row["message"]."</p> </li>";     
              }
        }
        else
            {
              if($row['sender'] == $_SESSION['username']){
                  if(!empty(trim($_SESSION['image'])))
                  echo " <li class=\"sent\"> <img src=\"uploads/profile_pictures/".$_SESSION['image']."\" alt='me'/> <p class=\"chat-message\"><img id='chat_image' style='cursor: pointer;border-radius:0;width: -webkit-fill-available; height: -webkit-fill-available;' src='uploads/sent_pictures/".$row["message"]."' alt='me'></p> </li>";
                  else
                    echo " <li class=\"sent\"> <img src=\"uploads/profile_pictures/user.png\" alt='me'/> <p class=\"chat-message\"><img id='chat_image' style='cursor: pointer;border-radius:0;width: -webkit-fill-available; height: -webkit-fill-available;' src='uploads/sent_pictures/".$row["message"]."' alt='me'></p> </li>";      
                          
              }
                else{
                  if(!empty(trim($userImage[0]["image"])))   
                  echo " <li class=\"replies\"> <img src=\"uploads/profile_pictures/".$userImage[0]["image"]."\" alt='him'/> <p class=\"chat-message\"><img id='chat_image' style='cursor: pointer;border-radius:0;width: -webkit-fill-available; height: -webkit-fill-available;' src='uploads/sent_pictures/".$row["message"]."' alt='me'></p> </li>";
                    else
                    echo " <li class=\"replies\"> <img src=\"uploads/profile_pictures/user.png\" alt='him'/> <p class=\"chat-message\"><img id='chat_image' style='cursor: pointer;border-radius:0;width: -webkit-fill-available; height: -webkit-fill-available;' src='uploads/sent_pictures/".$row["message"]."' alt='me'></p> </li>";     
              }            
            
     
                
            }
        }

   }
            else {  ?>
            
        <div class="w3-container w3-white">
            
            <div class="alert alert-info"><?php echo lang("NO-CONV") ?></div>
                    
        </div>               
            
<?php           }
            ?>
                </ul>
            </div>
            <div class="message-input w3-card w3-light-grey">
                <form method="post" action="save_chat.php" class="wrap" enctype="multipart/form-data" >
                    <input type="text" placeholder="Write your message..." name="txtmessage"/>
                    <input type="file" name="file" id="file" hidden="hidden">
                    <i id="uploadBTN" class="fa fa-paperclip attachment" aria-hidden="true">
                    </i>                    
                    <button type="submit" name="send_message" class="submit">
                        <i class="fa fa-paper-plane" aria-hidden="true" >
                        </i>
                    </button>
                </form>

            </div>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>          
            <script type="text/javascript">
                const realFileBtn=document.getElementById("file");
                const fakeBtn=document.getElementById("uploadBTN");

                fakeBtn.addEventListener("click",function () {
                   realFileBtn.click();
                });

                $(document).ready(function () {
                    $(document).on('change','#file',function () {
                        var property=document.getElementById("file").files[0];
                        var image_ex=property.name.split(".").pop().toLowerCase();
                        if(jQuery.inArray(image_ex,["jpg","png","gif","jpeg"]) == -1) {
                            alert("<?php echo lang("NOT-ALLOWED-EXT") ?>");
                        }else {
                            var image_size = property.size;
                            if (image_size > 200000) {
                                alert("<?php echo lang("BIG-SIZE") ?>");
                            }else{

                                var form_data=new FormData();
                                form_data.append("file",property);
                                $.ajax({
                                    url:"save_image.php",
                                    method:"POST",
                                    data:form_data,
                                    contentType:false,
                                    cache:false,
                                    processData:false,
                                    success:function () {
                                        
                                        window.location.href = '<?php echo "messages.php?target=" . $_SESSION["other_user"] ?>' ;  

                                    }

                                });

                            }
                        }
                    });
                });               
            </script>
            <script>

        $(document).ready(function () {
            $(document).on("click","#chat_image",function () {
                var img=$(this).attr('src');
                var appear_image="<div id='modal' class='w3-modal w3-black' style='display:block'><div class='w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64' id='appear_image_div' onclick='closeImage()'><img class='w3-image' alt='image' id='appear_image' src='"+img+"'></div></div>";

                $('body').append(appear_image);

            });
        });
        function closeImage() {
            $('#modal').remove();
            $('#appear_image_div').remove();
            $('#appear_image').remove();
        }
                
            </script>
        </div>
    </div>

<?php
                                
}
    else
    {
        header("location:login.php");
        exit();
        
    }

    include $tmp . "footer.php";

    ob_end_flush();

?>
                                