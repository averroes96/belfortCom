<?php 
    if(isset($_SESSION["username"])){
ob_start();        
        ?>
    
<!-- Navbar -->
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="settings.php"><i class="fa fa-fw fa-cog"></i><?php echo lang('SETTINGS') ?></a>
    <a href="profile.php?do=show&userID=<?php echo $_SESSION['id'] ?>"><i class="fa fa-fw fa-user"></i><?php echo lang('PROFILE') ?></a>
    <?php
            if($_SESSION["group"] == 1){ ?>
    <a href="admin/homepage.php"><i class="fa fa-fw fa-tachometer-alt"></i><?php echo lang('DASHBOARD') ?></a>
    <?php } ?>
    <a href="logout.php"><i class="fa fa-fw fa-sign-out-alt"></i><?php echo lang('LOGOUT') ?></a>
    
</div>

<div class="upper-bar w3-animate-top">
    
<div class="w3-container">
    
  <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large log-sign"  onclick="openNav()"><i class="fa fa-bars"></i></a>
     
  <a href="main.php" class="w3-bar-item"><img class="w3-hover-shadow w3-padding" src="uploads/site_images/logo6.0.png" style="max-height:55px"></a>
  <a class="w3-bar-item w3-button w3-padding-large log-sign w3-hide-small w3-center " title="Account" onclick="openSideNav()">
<?php
    if(!empty(trim($_SESSION["image"]))){
        echo "<img class='w3-circle' src='uploads/profile_pictures/" . $_SESSION["image"] . "' alt='avatar' style='height:23px;width:23px' />";
    }
    else {
        echo "<img class='w3-circle' src='uploads/profile_pictures/user.png' alt='avatar' style='height:23px;width:23px' />"; 
        }
                        ?>        
  </a>    
<?php if($title != "Store") { ?>    
    <a href="store.php" class="w3-bar-item w3-hide-small w3-right w3-padding-large log-sign"><i class="fa fa-tablet-alt w3-margin-right"></i><?php echo lang("ADS") ?></a>
<?php } ?>
    
<?php if($title != "Forum") { ?>     
    <a href="forum.php" class="w3-bar-item w3-hide-small w3-right w3-padding-large log-sign"><i class="fa fa-comments fa-fw"></i>Forum</a>
<?php } ?>
    
<?php if($title != "Profile" && $title != "New AD") { ?>    
    <a href="newad.php" class="w3-bar-item w3-hide-small w3-right w3-padding-large log-sign"><i class="fa fa-ad fa-fw"></i><?php echo lang("NEW-AD") ?></a>
<?php } ?>

<div class="w3-dropdown-hover w3-hide-small notifications">      
        
    <a href="messages.php"><button class="w3-button w3-padding-large log-sign w3-hide-small" title="Messgaes"><i class="fa fa-envelope"></i>
<?php
        $nbrMessages = getNewMessagesCount($_SESSION["username"]) ;
        if($nbrMessages[0]["nbr"] != 0){ ?>
        <span class="w3-badge w3-right w3-small w3-red"><?php echo $nbrMessages[0]["nbr"] ?></span>
<?php } ?>       
        </button>
    </a>
<?php 
    $connectedUser = $_SESSION["username"];   /*user*/
    $user_array=array();
                                 
    $getMessages = getUnreadMessages($connectedUser);

    foreach($getMessages as $message){
            if(strcmp($connectedUser,$message["user1"])==0){
                array_push($user_array,$message["user2"]);              
            }else{
                array_push($user_array,$message["user1"]);
            };
    }

    $user_array=array_unique($user_array);
        

        
        echo '<div class="w3-dropdown-content w3-card-4 w3-bar-block" style="width:320px">';
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
        $infos = getAllFrom("*","users","WHERE username = '$username'");
        
        if(!empty(trim($infos[0]["image"])))
            $user_img = $infos[0]["image"];
        else
            $user_img = "user.png";
        echo '<a href="' . $func .'updateLue.php?username=' . $_SESSION["username"] . '&target=' . $username . '" class="w3-bar-item w3-button w3-text-dark-grey w3-border-bottom" ><img class="w3-circle w3-margin-right" style="width:30px; height: 30px" src="uploads/profile_pictures/' . $user_img . '"><span><b>' . $username . '</b></span><p class="w3-padding" style="margin:0"><span>';
        
        if(strlen($rows[0]["message"] ) > 60)
        echo substr($rows[0]["message"],0,55) . "...";
        else
        echo $rows[0]["message"];    
        echo '<span><span class="w3-right w3-text-grey" style="font-size:10px; position: relative;right: -20px;top: 5px;">' . date("F j Y, g:i a", strtotime($rows[0]["time"])) . '</span></p></a>';
            
        
    }
        echo '</div>';        

      ?>
    
</div>    
<div class="w3-dropdown-hover w3-hide-small notifications">
    <a href="notifications.php?userID=<?php echo $_SESSION["id"] ?>" class="w3-button w3-padding-large log-sign w3-hide-small" title="Notifications"><i class="fa fa-bell"></i>
<?php
        if(getNotifCount($_SESSION["id"]) != 0){ ?>
        <span class="w3-badge w3-right w3-small w3-red"><?php echo getNotifCount($_SESSION["id"]) ?></span>
<?php } ?>      
      </a>
<?php if(!empty(getNotifications($_SESSION["id"]))){ 
    echo '<div class="w3-dropdown-content w3-card-4 w3-bar-block" style="width:350px">';
        foreach(getNotifications($_SESSION["id"]) as $notification){
        echo '<a href="' . $func .'updateSeen.php?notifID=' . $notification["notifID"] . '&link=' . $notification["url"] . '" class="w3-bar-item w3-button w3-text-dark-grey"  ><i class="fa fa-fw fa-' . $notification["type_notif"] . '"></i>';
                        if($language == "fr")
                            $notification["fr_content"];
                            else
                            $notification["en_content"];    
                                
            echo    '</a>';
        }
      echo '</div>';
      }
      
      ?>
    
</div>
            <form class="w3-hide-small w3-hide-medium" action="search.php" style="display: inline">
                <div class="input-container" style="display:inline">
                    <input name="keyword" pattern=".{3,}" title="<?php echo lang("MIN-CHAR") ?>" required type="text" class="w3-bar-item w3-input w3-border-teal" style="width: 25%; display: inline" placeholder="<?php echo lang("SEARCH-PLACEHOLDER") ?>">
                </div>    
                <button class="w3-button w3-white w3-text-teal" type="submit" style="position: relative; top: -1px;"><i class="fa fa-search"></i></button>
            </form>    
                
<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-hide w3-hide-large w3-hide-medium w3-large">
<div class="w3-row-padding">
<?php
        if($title != "Profile") {
        echo '<div class="w3-quarter w3-padding">';
    
        echo   '<a href="profile.php?do=show&userID=1" class="w3-bar-item w3-button w3-padding-large log-sign w3-center" title="My Account">';

        if(!empty(trim($_SESSION["image"]))){
        echo '<img class="w3-circle" src="uploads/profile_pictures/'. $_SESSION["image"] .'" alt="avatar" style="height:23px; width:23px" />';
            }
        else
        {
      
        echo '<img class="w3-circle" src="uploads/profile_pictures/user.png" alt="avatar" style="height:23px; width:23px" />';     
            
        }
        echo " Profile";
        
        echo '</a>';
               
        echo '</div>';
                }
        if($title != "Store") {
        echo '<div class="w3-quarter w3-padding">
                <a href="Store.php" class="w3-bar-item w3-padding-large w3-center log-sign"><i class="fa fa-tablet fa-fw"></i>' . lang("ADS") . '</a>
            </div>';
        }
        
        if($title != "Profile") {
        echo '<div class="w3-quarter w3-padding">
                <a href="Store.php" class="w3-bar-item w3-padding-large w3-center log-sign"><i class="fa fa-ad fa-fw"></i>' . lang("NEW-AD") . '</a>
            </div>';
        }           
        
        if($title != "Forum") {
        echo '<div class="w3-quarter w3-padding">
                <a href="forum.php" class="w3-bar-item w3-padding-large w3-center log-sign"><i class="fa fa-comments fa-fw"></i>Forum</a>
            </div>';
        }
            
                    echo '<div class="w3-quarter w3-padding ">    
                        <form class="" action="search.php" style="display: inline">    
                            <input name="keyword" pattern=".{3,}" required type="text" class="w3-bar-item w3-input w3-border-teal " style="width: 100%; display: inline" placeholder="' . lang("SEARCH-PLACEHOLDER") . '">
                        </form>
                    </div>            

</div>     
</div>    
</div> 
</div>';
    }
    else{
        
        ?>

            <div class="upper-bar w3-animate-top">

                <div class="w3-container">
                    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large log-sign"  onclick="openNav()"><i class="fa fa-bars"></i></a>                    

   
                <a href="main.php" class="w3-bar-item"><img class="w3-hover-shadow w3-round w3-padding" src="uploads/site_images/logo6.0.png" style="max-height:55px" alt="Acceuil"></a>
                    
                <?php if($title != "Store"){ ?>                    
                  <a href="store.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large log-sign"><i class="fa fa-tablet-alt w3-margin-right"></i><?php echo lang("ADS") ?></a>
                    <?php } ?> 
                <?php if($title != "Forum"){ ?>                     
                <a href="forum.php" class="w3-bar-item w3-hide-small w3-right w3-padding-large log-sign"><i class="fa fa-comments fa-fw"></i>Forum</a>      
                    <?php } ?>                    
                <?php if($title != "Login"){ ?>
                <a class="pull-right w3-bar-item w3-button log-sign w3-hide-small w3-right" href="login.php">
                        <span ><?php echo lang("LOGIN/SIGNUP") ?></span>
                </a>
                    <?php } ?>
                    
            <form class="w3-hide-small w3-hide-medium" action="search.php" style="display: inline">    
                <input name="keyword" pattern=".{3,}" required type="text" class="w3-bar-item w3-input w3-border-teal" style="width: 25%; display: inline" placeholder="<?php  echo lang("SEARCH-PLACEHOLDER") ?>">
                <button class="w3-button w3-white w3-text-teal" type="submit" style="position: relative; top: -1px;"><i class="fa fa-search"></i></button>
            </form>
                    
            <!-- Navbar on small screens -->
            <div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium w3-large">
                <div class="w3-row-padding">
                    <div class="w3-quarter w3-padding ">    
                    <?php if($title != "Store") { ?>

                    <a href="store.php" class="w3-bar-item w3-button w3-padding-large log-sign w3-center"><?php echo lang("ADS") ?></a> 

                    <?php } ?>
                    </div>
                    <div class="w3-quarter w3-padding ">    
                            <?php if($title != "Login") { ?>

                            <a href="login.php" class="w3-bar-item w3-button  w3-padding-large log-sign w3-center"><?php echo lang("LOGIN/SIGNUP") ?></a> 

                            <?php } ?>
                    </div>

                    <div class="w3-quarter w3-padding ">    
                            <?php if($title != "Forum") { ?>

                            <a href="forum.php" class="w3-bar-item w3-button w3-padding-large log-sign w3-center">Forum</a> 

                            <?php } ?>
                    </div>
                    <div class="w3-quarter w3-padding ">    
                        <form class="" action="search.php" style="display: inline">    
                            <input name="keyword" pattern=".{3,}" title="<?php echo lang("MIN-CHAR") ?>" required type="text" class="w3-bar-item w3-input w3-border-teal " style="width: 100%; display: inline" placeholder="<?php  echo lang("SEARCH-PLACEHOLDER") ?>">
                        </form>
                    </div>                    
                </div>    
            </div>         

                </div>
                
            </div>
<?php
               
    }
?>