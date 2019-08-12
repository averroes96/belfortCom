<?php

    ob_start();
    session_start();

    $title = "Notifications";

    include "init.php";

    if(isset($_SESSION["id"])){
        
        $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']):0 ;         
        
        if($_SESSION["id"] == $userID ){    
        
        $stmt = $conn->prepare("SELECT * FROM notification WHERE userID = ?");
        $stmt->execute(array($userID));
        $notif = $stmt->fetchAll(); 
        $count = $stmt->rowCount();         
        
    if($count > 0){ ?>
 <div class="w3-container w3-content" style="min-height: -webkit-fill-available;">
    <h5 class="w3-margin"><?php echo lang("RECENT-NOTIF") ?></h5>
    <ul class="w3-ul w3-hoverable w3-margin w3-padding w3-card-4 w3-white">
<?php   foreach ($notif as $notification){  ?>      
      <a class="" href="<?php echo $func .'updateSeen.php?notifID=' . $notification["notifID"] . '&link=' . $notification["url"] ?>">
          <li class="w3-padding-16">
            <i class="fa fa-fw fa-<?php echo $notification["type_notif"] ?>"></i>
            <span class="w3-large">
                <?php if($language == "fr") echo $notification["fr_content"]; else echo $notification["en_content"];
                ?>
              </span><br>
            <span class="w3-right w3-text-grey w3-small"><?php echo proDate($notification["notif_date"]) ?></span>  
          </li>
        </a>
        
<?php   }   ?>        
    </ul>
  </div>

<?php
    }
        else{   ?>

            <div class="w3-container" style="min-height: -webkit-fill-available;">    
                <div class='alert-msg w3-center w3-margin-left w3-margin-right' style='margin-top:40px'><?php echo lang("NO-NOTIF") ?>
                </div>
            </div>
<?php   }   ?>

<?php
            
        }
        else{
            
            header("location:main.php");
            exit();
            
        }
            
    }
    else
    {
        
            header("location:login.php");
            exit();        
        
    }

    include $tmp . "footer.php";

    ob_end_flush();

?>