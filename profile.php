<?php
        ob_start();
        session_start();

        $title = "Profile";

        include 'init.php';
            
        $do = isset($_GET['do']) ? $_GET['do'] : 'show';    

        $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']):0 ;          
            
    if($do == "show"){  
        
        $getUser = $conn->prepare("SELECT * FROM users WHERE userID = ?");
        $getUser->execute(array($userID));
        $info = $getUser->fetch(); 
        $count = $getUser->rowCount(); 
        

    if($count > 0){
        
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $user = $_SESSION["id"];
        $target = $info["userID"];
        $value = $_POST["rate"];
        
        $check = getAllFrom("*","rating","WHERE user = $user AND target = $target");
        
        if(count($check) == 0){
        $stmt = $conn->prepare("INSERT INTO rating (user, target, value) VALUES (:zuser, :ztarget, :zval)");
        $stmt->execute(array(
        
            "zuser" => $user,
            "ztarget" => $target,
            "zval"=> $value,
        
        ));
        }
        else{
            
        $stmt = $conn->prepare("UPDATE rating SET value = $value WHERE user = $user AND target = $target");
        $stmt->execute();            
            
            
        }

    }        
       ?>

<div class="w3-container w3-margin-bottom w3-margin" style="min-height: -webkit-fill-available;">
<?php 
        if(isset($_SESSION["success"]) && !empty($_SESSION["success"])){    ?>    
    <div class="success-msg w3-margin w3-center">
<?php
                              
            echo $_SESSION["success"];
            $_SESSION["success"] = "";
                                        
        ?>
    
    </div>
    
<?php   }   ?>    
  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m3 w3-margin-bottom">
      <!-- Profile -->
      <div class="w3-card w3-round w3-white">
        <div class="w3-container info-panel">
         <h4 class="w3-center w3-text-dark-grey"><?php echo $info["username"] ?></h4>
         <p class="w3-center">
             
                <?php
                    
                                    if(!empty(trim($info["image"]))){
                                        echo "<img class='w3-border w3-circle' src='uploads/profile_pictures/" . $info["image"] . "' style='height:106px;width:106px; cursor:pointer' alt='Avatar' onclick='onClick(this)' />";
                                        }
                                    else {
                                        echo "<img class='w3-circle' src='uploads/profile_pictures/user.png' style='height:106px;width:106px' alt='' />"; 
                                    }
                 ?>               
        </p>
        <?php 
            if(isset($_SESSION["id"])){
                if($_SESSION["id"] != $info["userID"]){
                ?>
            <div class="w3-container">
                <div class="w3-center w3-margin-bottom">
                    <a href="messages.php?target=<?php echo $info["username"] ?>" class="w3-button w3-teal w3-round"><i class="fa fa-fw fa-paper-plane"></i>Message</a>
                </div>
                <div class="w3-center">
<?php   $user1 = $info["userID"];
        $user2 = $_SESSION["id"];            
                    $flist = getAllFrom("*","follower","WHERE followerID = '$user2' AND userID = '$user1'");
                if(count($flist) > 0){    
                    echo '<a href="' . $func . 'update.php?u=unsub&userID=' . $user1 . '&followerID=' . $user2 . '" class="w3-button w3-light-grey w3-text-teal w3-round">' . lang("UNSUB") .'</a>';
                }
                    else{
                        
                        echo '<a href="' . $func . 'update.php?u=sub&userID=' . $user1 . '&followerID=' . $user2 . '" class="w3-button w3-teal w3-round">' . lang("SUBSCRIBE") .'</a>';
                    }
                    
                ?>    
                </div>
            
            </div>
            
        <?php
                }
            }
        else {
            echo "<div class='w3-center alert alert-info'>";
            echo "<a href='login.php' >" . lang("LOG-OR-SIGN") . "</a>";
            echo "</div>";
        }
        
        ?>
         <hr>
         <p class="w3-text-dark-grey">
             <i class="fa fa-id-card fa-fw w3-margin-right w3-text-theme w3-darkcyan"></i>
             <strong>
             <?php 
                if(!empty(trim($info["fullname"]))) 
                    echo $info["fullname"];
             ?>
            </strong>
            </p>
         <p class="w3-text-dark-grey">
             <i class="fa fa-home fa-fw w3-margin-right  w3-darkcyan"></i>
             <strong>
             <?php 
                if(!empty(trim($info["wilaya"]))) 
                    echo $info["wilaya"];
             ?>             
            </strong>
        </p>
         <p class="w3-text-dark-grey">
             <i class="fa fa-birthday-cake fa-fw w3-margin-right w3-darkcyan"></i>
             <strong>
             <?php 
                if(!empty(trim($info["birthDate"]) && $info["birthDate"] != "0000-00-00" )) 
                    echo date("d-m-Y",strtotime($info["birthDate"]));
             ?>
            </strong>
        </p>
         <p class="w3-text-dark-grey">
             <i class="fa fa-phone fa-fw w3-margin-right w3-darkcyan"></i>
             <strong>
             <?php 
                if(!empty(trim($info["telephone"]) && $info["telephone"] != "0" )) 
                    echo $info["telephone"];
             ?>
            </strong>
        </p>            
<?php 
        if(isset($_SESSION["id"])){
           if($_SESSION["id"] == $info["userID"]){
                                
                            echo '<a class="w3-button w3-round w3-teal edit-btn w3-center" style = "margin-bottom: 10px;padding: 5px; display" href="profile.php?do=modify&userID='.$_SESSION["id"].'">'. lang("EDIT2") .'</a>';
           }
        }
        
                $stmt = $conn->prepare("SELECT follower.*, users.username as user, users.image as img FROM follower INNER JOIN users ON users.userID = follower.userID WHERE follower.followerID = ? ORDER BY follower.follow_date DESC");
                $stmt-> execute(array($info["userID"]));
        
                $following = $stmt->fetchAll();
                $folCount1 = $stmt->rowCount();        
                
?>
            
        </div>
      </div>
      <br>
      
      <!-- Accordion -->
      <div class="w3-card w3-round">
        <div class="w3-white">
            <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-teal w3-left-align"><?php echo lang("FOLLOWERS") . " ( " . $folCount1 . " )" ?>
            </button>
          <div id="Demo1" class="w3-hide w3-container" style="padding:10px;">            
          <?php
            

                
                if(!empty($following)){
                    
                    foreach($following as $follower){
                        

                                        echo "<a class='w3-margin-bottom' href='profile.php?do=show&userID=".$follower["userID"] . "' style='text-decoration: none; margin-bottom:10px;'>";
                                        
                                        if(!empty(trim($follower["img"]))){
                                            
                                            echo '<img src="uploads/profile_pictures/' . $follower["img"] .'" class="w3-left w3-circle w3-margin-right" style="width:20px; height:20px;">';
                                        }
                                        else {
                                            
                                            echo "<img src='uploads/profile_pictures/user.png' alt='' class='w3-left w3-circle w3-margin-right' style='width:20px' />";  
                                        }
                                        
                                        echo '<span class="w3-large">'. $follower["user"] . '</span><br>';
                                        
                                        echo "</a>";      
                    
            
                ?>

<?php } 
                }  
              
                $stmt = $conn->prepare("SELECT follower.*, users.username as user, users.image as img FROM follower INNER JOIN users ON users.userID = follower.followerID WHERE follower.userID = ? ORDER BY follower.follow_date DESC");
                $stmt-> execute(array($info["userID"]));
        
                $following = $stmt->fetchAll();
                $folCount2 = $stmt->rowCount();
              
              
              ?>            
          </div>            
          <button onclick="myFunction('Demo2')" class="w3-button w3-block w3-teal w3-left-align"><?php echo lang("FOLLOWING") . " ( " . $folCount2 . " )" ?></button>
          <div id="Demo2" class="w3-hide w3-container" style="padding:10px;">
          <?php
            

                
                if(!empty($following)){
                    
                    foreach($following as $follower){
                        

                                        echo "<a href='profile.php?do=show&userID=".$follower["followerID"] . "' style='text-decoration: none; margin-bottom:3px;'>";
                                        
                                        if(!empty(trim($follower["img"]))){
                                            
                                            echo '<img src="uploads/profile_pictures/' . $follower["img"] .'" class="w3-left w3-circle w3-margin-right" style="width:20px; height:20px;">';
                                        }
                                        else {
                                            
                                            echo "<img src='uploads/profile_pictures/user.png' alt='' class='w3-left w3-circle w3-margin-right' style='width:20px' />";  
                                        }
                                        
                                        echo '<span class="w3-large">'. $follower["user"] . '</span><br>';
                                        
                                        echo "</a>";      
                    
            
                ?>

<?php } 
                }  ?>              
              
          </div>
          <button onclick="myFunction('Demo3')" class="w3-button w3-block w3-teal w3-left-align"><?php echo lang("RATING") . " ( " . countItems("*","rating",true,"target",$info["userID"]) . " )" ?></button>
          <div id="Demo3" class="w3-hide w3-container w3-center" style="padding:10px;">
<?php 
        $average = getAverage($info["userID"]);
        
    if($average["average"] != 0.0000){    
        
        ?>
        <span class="fa fa-star <?php if($average["average"] >= 1) echo "checked" ?> "></span>
        <span class="fa fa-star <?php if($average["average"] >= 2) echo "checked" ?>"></span>
        <span class="fa fa-star <?php if($average["average"] >= 3) echo "checked" ?>"></span>
        <span class="fa fa-star <?php if($average["average"] >= 4) echo "checked" ?>"></span>
        <span class="fa fa-star <?php if($average["average"] == 5) echo "checked" ?>"></span>
                    <br>
        <p><?php echo number_format((float)$average["average"], 2) . " " . lang("AVERAGE-MSG") . " " . count(getAllFrom("*","rating","WHERE target = ". $info["userID"])) . " " . lang("REVIEWS") ?>.</p>
              


        <div class="w3-row w3-nowrap">
          <div class="w3-quarter">
            <div>5 <span class="w3-hide-medium"><?php  echo lang("STAR") ?></span></div>
          </div>
          <div class="w3-half">
            <div class="bar-container">
              <div class="bar-5 w3-teal" style="width:<?php echo (int)(countValues($info["userID"], 5))/count(getAllFrom("*","rating","WHERE target = ". $info["userID"]))*100 ?>%"></div>
            </div>
          </div>
          <div class="w3-quarter">
            <div><?php echo countValues($info["userID"], 5) ?></div>
          </div>
          <div class="w3-quarter">
            <div>4 <span class="w3-hide-medium"><?php  echo lang("STAR") ?></span></div>
          </div>
          <div class="w3-half">
            <div class="bar-container">
              <div class="bar-4 w3-green" style="width:<?php echo (int)(countValues($info["userID"], 4))/count(getAllFrom("*","rating","WHERE target = ". $info["userID"]))*100 ?>%"></div>
            </div>
          </div>
          <div class="w3-quarter">
            <div><?php echo countValues($info["userID"], 4) ?></div>
          </div>
          <div class="w3-quarter">
            <div>3 <span class="w3-hide-medium"><?php  echo lang("STAR") ?></span></div>
          </div>
          <div class="w3-half">
            <div class="bar-container">
              <div class="bar-3 w3-blue" style="width:<?php echo (int)(countValues($info["userID"], 3))/count(getAllFrom("*","rating","WHERE target = ". $info["userID"]))*100 ?>%"></div>
            </div>
          </div>
          <div class="w3-quarter">
            <div><?php echo countValues($info["userID"], 3) ?></div>
          </div>
          <div class="w3-quarter">
            <div>2 <span class="w3-hide-medium"><?php  echo lang("STAR") ?></span></div>
          </div>
          <div class="w3-half">
            <div class="bar-container">
              <div class="bar-2" style="width:<?php echo (int)(countValues($info["userID"], 2))/count(getAllFrom("*","rating","WHERE target = ". $info["userID"]))*100 ?>%"></div>
            </div>
          </div>
          <div class="w3-quarter">
            <div><?php echo countValues($info["userID"], 2) ?></div>
          </div>
          <div class="w3-quarter">
            <div>1 <span class="w3-hide-medium"><?php  echo lang("STAR") ?></span></div>
          </div>
          <div class="w3-half">
            <div class="bar-container">
              <div class="bar-1 w3-red" style="width:<?php echo (int)(countValues($info["userID"], 1))/count(getAllFrom("*","rating","WHERE target = ". $info["userID"]))*100 ?>%"></div>
            </div>
          </div>
          <div class="w3-quarter">
            <div><?php echo countValues($info["userID"], 1) ?></div>
          </div>
        </div>
<?php
            }
        else {
            
            echo "<div class='alert alert-danger w3-center'>" . lang("NO-RATING") . "</div>";
        }
        ?>
              
                <?php 
        if(isset($_SESSION["username"])){   
          
            if($_SESSION["id"] != $info["userID"]){
          
          ?>
                    <a href="javascript:void(0)" class="w3-margin w3-small w3-teal w3-left w3-button w3-round" onclick="document.getElementById('id01').style.display='block'">
                    <i class="fa fa-star"></i>
                        <?php   echo lang("RATE")  ?>
                    </a>
                    
<?php
        }
        }
                    ?>           
              
          </div>            
        </div>      
      </div>
      <br>
      
      <!-- Interests --> 
      <div class="w3-card w3-round w3-white w3-hide-small">
        <div class="w3-container">
          <p class="w3-center"><?php echo lang("INTERESTS") ; ?></p>
          <p>
<?php
        $interests = explode(" ",$info["interests"]);

        if(!empty(trim($info["interests"]))){
        foreach($interests as $interest){
            
            if(!empty(trim($interest))){
                
                $interest = strtolower($interest);
                echo "<a href='tags.php?tag={$interest}' class='w3-tag  w3-small w3-teal' style='margin:3px;'>" . "#" . $interest . "</a>";
                
                    }
                        }
                                
                            }
            else {
                
                echo lang("NO-INTERESTS") . " !";
            }
         
              
              
              ?>
          </p>
        </div>
      </div>
      <br>
      <!-- Posts -->
<?php 
        $userSubjects = getAllFrom("*","subject","WHERE userID = " . $info["userID"]);
        
        if(!empty($userSubjects)){  ?>
        
      <div class="w3-white">
        <div class="w3-container w3-padding w3-teal">
          <h4><?php echo lang("POSTS") . $info["username"] ?></h4>
        </div>
        <ul class="w3-ul w3-hoverable w3-white">          
<?php foreach($userSubjects as $subject){  ?>        

            <a class="w3-hover-grey" href="subject.php?subID=<?php echo $subject["subID"] ?>" >
                <li class="w3-padding-16">
                    <span class="w3-large"><?php echo $subject["title"] ?></span>
                    <br>
                    <span class="w3-text-grey"><?php echo date("m-d-Y", strtotime($subject["sub_date"])) ?></span>
              </li>
            </a>
        
<?php }
        echo "</ul>";
        echo "</div>";
                                 }
          ?> 
    <!-- End Left Column -->
    </div>
          
  <!-- Modal for full size images on click-->
  <div id="modal01" class="w3-modal w3-black" style="padding-top:0" >
    <span class="w3-button w3-black w3-xxlarge w3-display-topright" onclick="this.parentElement.style.display='none'">×</span>
    <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
      <img id="img01" class="w3-image">
      <p id="caption"></p>
    </div>
  </div>          
    <!-- Middle Column -->
    <div class="w3-col m9">
<?php  
        if(isset($_SESSION["id"])){
        if($_SESSION["id"] == $info["userID"]){    ?>
      <div class="w3-row-padding w3-margin-bottom">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding w3-center">
              <a href="newad.php" class="w3-button w3-round w3-theme w3-teal"><i class="fa fa-plus"></i><?php echo lang("NEW-AD") ?></a> 
            </div>
          </div>
        </div>
      </div>      
<?php 
              }
        }
  ?>
        
<div class="w3-row-padding w3-card w3-round w3-white w3-margin-left w3-margin-right" style="min-height:297px">
<?php
        if(isset($_SESSION["id"])){
        if($_SESSION["id"] == $info["userID"])
            
            $userItems = getAllFrom("*","items","WHERE userID = " . $info["userID"], "ORDER BY add_date DESC");
            
        else
            $userItems = getAllFrom("*","items","WHERE pending = 1 AND userID = " . $info["userID"], "ORDER BY add_date DESC");    
        }
        else
            $userItems = getAllFrom("*","items","WHERE pending = 1 AND userID = " . $info["userID"], "ORDER BY add_date DESC");
        
            if(!empty($userItems)){
                ?>
<h4 class="w3-margin w3-text-dark-grey"><?php echo lang("LATEST-ADS") . $info["username"] . "..." ?></h4>    
<?php 
            foreach($userItems as $item){
                ?>
            <div class="w3-third w3-margin-bottom w3-center" id="<?php echo $item["itemID"] ?>">
            <div class="w3-border w3-hover-shadow w3-animate-zoom">    
            <div class="w3-display-container" >
            <div class="img-container">    
<?php
            if(!empty(trim($item["image"]))){   ?>
                <img class="" src="uploads/items_images/<?php echo $item["image"] ?>" style="width:100%">
<?php
                                            }
                else{
                    
                    echo '<img src="uploads/items_images/ads.png" style="width:100%">';
                    
                }
            ?>
                </div>
                
<?php 
                if( $item["pending"] == "0")
                    echo '<span class="w3-tag w3-display-topleft w3-teal">'. lang("PENDING") .'</span>';
                
                else if(strtotime($item["add_date"]) > strtotime('- 7 days')){                 
                    echo '<span class="w3-tag w3-display-topleft w3-teal">'. lang("NEW") .'</span>';
            }
                else if($item["pending"] == 1)
                ?>
                <span class="w3-tag w3-display-topright w3-teal"><?php echo $item["status"] ?> /5</span>                
                <h4 class="w3-padding w3-nowrap"><?php echo $item["item_name"] ?></h4>
                <p class="w3-text-teal"><i class="fa fa-tag fa-fw"></i><b><?php echo $item["price"] ?> DA</b></p>
                <p class="w3-opacity w3-nowrap"><?php echo proDate($item["add_date"]) ?></p>                  
                
                <div class="w3-display-middle w3-display-hover">
                    <a href="showAd.php?itemID=<?php echo $item["itemID"] ?>" class="w3-button w3-teal"><?php echo lang("FULL-DETAILS") ?> <i class="fa fa-plus-circle"></i></a>
                </div>
                
            </div>
                <div class="w3-row">
        <?php 

                $citem = $item["itemID"];
                if(isset($_SESSION["id"])) $user = $_SESSION["id"];            
                $list = getAllFrom("*","likes","WHERE itemID = '$citem' AND userID = '$user'");
                if(count($list) > 0){ ?>    
                    <a href="<?php echo $func ?>update.php?u=rlike&itemID=<?php echo $item["itemID"] ?>&userID=<?php echo $user ?>"><div class="w3-third w3-text-teal w3-padding w3-hover-teal w3-nowrap"><i class="fa fa-fw fa-check"></i><?php echo countItems("*","likes",true,"itemID",$item["itemID"]) ?> <span class="w3-hide-large w3-hide-medium"><?php echo lang("LIKED") ?></span>
                        </div>
                    </a>
<?php                    
                }
                    else {   ?>
                    
                    <a href="<?php echo $func ?>update.php?u=alike&itemID=<?php echo $item["itemID"] ?>&userID=<?php echo $user ?>">
                    <div class="w3-third w3-text-grey w3-padding w3-hover-teal w3-nowrap"><i class="far fa-fw fa-thumbs-up"></i><?php echo countItems("*","likes",true,"itemID",$item["itemID"]) ?> <span class="w3-hide-large w3-hide-medium"><?php echo lang("LIKE") ?></span>
                        </div>
                    </a>
                    
<?php                    
                    }
                    
                ?>                         
                    
                    <div class="w3-third w3-text-grey w3-padding w3-nowrap"><i class="fa fa-fw fa-eye"></i><?php echo countItems("*","user_likes",true,"itemID",$item["itemID"]) ?><span class="w3-hide-large w3-hide-medium"><?php echo lang("VIEWS") ?></span></div>                    
                    <a href="showAd.php?itemID=<?php echo $item["itemID"] ?>#demo"><div class="w3-third w3-text-grey w3-padding w3-hover-teal w3-nowrap"><i class="fa fa-fw fa-comments"></i> <?php echo countItems("comID","comments",true,"itemID",$item["itemID"]) ?><span class="w3-hide-large w3-hide-medium"><?php echo lang("COMMENTS") ?></span> </div></a>
                </div>                 


                </div>
            
            </div>
<?php } 
            }
        else {
            
            echo '<h4 class="w3-margin w3-text-dark-grey w3-center">' . lang("NO-ADS") . " !" . '</h4>';   
        }
        ?>

</div>
<?php
        if(isset($_SESSION["id"])){
        
        if($_SESSION["id"] == $info["userID"]){
            
            $stmt = $conn->prepare("SELECT likes.*, items.*, users.userID FROM likes INNER JOIN items ON likes.itemID = items.itemID INNER JOIN users ON users.userID = likes.userID WHERE likes.userID = " . $info["userID"] . " AND items.userID != users.userID  ORDER BY like_date DESC");
            $stmt->execute();
            $likedAds = $stmt->fetchAll();
            
            if(!empty($likedAds)){            
        ?>
        <div class="w3-row-padding w3-card w3-round w3-white w3-margin-left w3-margin-right w3-margin-top" style="min-height:297px">
            <h4 class="w3-margin w3-text-teal"><?php echo lang("LIKED-ADS") . "..." ?></h4>
<?php 
            foreach($likedAds as $item){
                ?>
            <div class="w3-third w3-margin-bottom w3-center" id="<?php echo $item["itemID"] ?>">
            <div class="w3-border w3-hover-shadow w3-animate-zoom">    
            <div class="w3-display-container" >
            <div class="img-container">    
<?php
            if(!empty(trim($item["image"]))){   ?>
                <img class="" src="uploads/items_images/<?php echo $item["image"] ?>" style="width:100%">
<?php
                                            }
                else{
                    
                    echo '<img src="uploads/items_images/ads.png" style="width:100%">';
                    
                }
            ?>
                </div>
                
<?php 
                if( $item["pending"] == "0")
                    echo '<span class="w3-tag w3-display-topleft w3-teal">'. lang("PENDING") .'</span>';
                
                else if(strtotime($item["add_date"]) > strtotime('- 7 days')){                 
                    echo '<span class="w3-tag w3-display-topleft w3-teal">'. lang("NEW") .'</span>';
            }
                else if($item["pending"] == 1)
                ?>
                <span class="w3-tag w3-display-topright w3-teal"><?php echo $item["status"] ?> /5</span>                
                <h4 class="w3-padding w3-nowrap"><?php echo $item["item_name"] ?></h4>
                <p class="w3-text-teal"><i class="fa fa-tag fa-fw"></i><b><?php echo $item["price"] ?> DA</b></p>
                <p class="w3-opacity w3-nowrap"><?php echo date("Y-m-d", strtotime($item["add_date"])) ?></p>                  
                
                <div class="w3-display-middle w3-display-hover">
                    <a href="showAd.php?itemID=<?php echo $item["itemID"] ?>" class="w3-button w3-teal"><?php echo lang("FULL-DETAILS") ?> <i class="fa fa-plus-circle"></i></a>
                </div>
                
            </div>
                <div class="w3-row">
        <?php 

                $citem = $item["itemID"];
                if(isset($_SESSION["id"])) $user = $_SESSION["id"];            
                $list = getAllFrom("*","likes","WHERE itemID = '$citem' AND userID = '$user'");
                if(count($list) > 0){ ?>    
                    <a href="<?php echo $func ?>update.php?u=rlike&itemID=<?php echo $item["itemID"] ?>&userID=<?php echo $user ?>"><div class="w3-third w3-text-teal w3-padding w3-hover-teal w3-nowrap"><i class="fa fa-fw fa-check"></i><?php echo countItems("*","likes",true,"itemID",$item["itemID"]) ?>
                        </div>
                    </a>
<?php                    
                }
                    else {   ?>
                    
                    <a href="<?php echo $func ?>update.php?u=alike&itemID=<?php echo $item["itemID"] ?>&userID=<?php echo $user ?>">
                    <div class="w3-third w3-text-grey w3-padding w3-hover-teal w3-nowrap"><i class="far fa-fw fa-thumbs-up"></i><?php echo countItems("*","likes",true,"itemID",$item["itemID"]) ?>
                        </div>
                    </a>
                    
<?php                    
                    }
                    
                ?>                         
                    
                    <div class="w3-third w3-text-grey w3-padding w3-nowrap"><i class="fa fa-fw fa-eye"></i><?php echo countItems("*","user_likes",true,"itemID",$item["itemID"]) ?></div>                    
                    <a href="showAd.php?itemID=<?php echo $item["itemID"] ?>#demo"><div class="w3-third w3-text-grey w3-padding w3-hover-teal w3-nowrap"><i class="fa fa-fw fa-comments"></i><?php echo countItems("comID","comments",true,"itemID",$item["itemID"]) ?></div></a>
                </div>                 


                </div>
            
            </div>
<?php } 
                ?>
        
        
        </div>
            
<?php 
            }
        }
        }
        ?>            
      
    <!-- End Middle Column -->
    </div>
    
  <!-- End Grid -->
  </div>
        
            <div id="id01" class="w3-modal" style="z-index:4">
            <form action="<?php echo $_SERVER["PHP_SELF"] ?>?userID=<?php echo $info["userID"] ?>" method="post" enctype="multipart/form-data">    
              <div class="w3-modal-content w3-animate-zoom" style="width:400px">
                <div class="w3-container w3-teal">
                   <span onclick="document.getElementById('id01').style.display='none'"
                   class="w3-button w3-teal w3-right w3-xlarge"><i class="fa fa-times"></i></span>
                  <h2><?php echo lang("RATING2") . $_SESSION["username"] ?></h2>
                </div>
                <div class="w3-panel">
                  <div class="rate">
                    <input type="radio" id="star5" name="rate" value="5" />
                    <label for="star5" title="text">5 stars</label>
                    <input type="radio" id="star4" name="rate" value="4" />
                    <label for="star4" title="text">4 stars</label>
                    <input type="radio" id="star3" name="rate" value="3" />
                    <label for="star3" title="text">3 stars</label>
                    <input type="radio" id="star2" name="rate" value="2" />
                    <label for="star2" title="text">2 stars</label>
                    <input type="radio" id="star1" name="rate" value="1" />
                    <label for="star1" title="text">1 star</label>
                  </div>
                  </div>
                  <div class="w3-section w3-padding">
                    <input type="submit" class="w3-button w3-teal" value="<?php echo lang("RATE") ?>">
                  </div>    

              </div>
            </form>    
            </div>        
  
</div>


<?php
        
    }        
        else
            {   ?>
            <div class="w3-container" style="min-height: -webkit-fill-available;">    
                <div class='alert-msg w3-center w3-container w3-margin-left w3-margin-right' style='margin-top:70px'><?php echo lang("USER-NOT-EXIST") ?>
                </div>
            </div>
<?php
            }
    
    
    }
    else if ($do == "modify"){
        
        if($_SESSION["id"] == $_GET["userID"]){    
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $formErrors = array(); 
            
            $picName = $_FILES["image"]["name"];
            $picSize = $_FILES["image"]["size"];
            $picTmp = $_FILES["image"]["tmp_name"];
            $picType = $_FILES["image"]["type"];
            
            $id = $_POST["userid"];
            
            $user = filter_var($_POST["username"],FILTER_SANITIZE_STRING);
            $email = filter_var($_POST["email"],FILTER_SANITIZE_STRING);
            $fullname = filter_var($_POST["fullname"],FILTER_SANITIZE_STRING);
            $telephone = 0 . filter_var($_POST["telephone"],FILTER_SANITIZE_NUMBER_INT);
            if(!empty($_POST["birth_date"])){
            $birth = $_POST["birth_date"];
            $birth = date("Y-m-d", strtotime($birth));
            }
            else
            $birth = date("00-00-0000");
            $wilaya = filter_var($_POST["wilaya"],FILTER_SANITIZE_STRING);               
            $interests = filter_var($_POST["interests"],FILTER_SANITIZE_STRING);
            $pass = sha1($_POST["password"]);
            // Treating password
            
                    $allowedExt = array("jpeg","png","jpg","");
                    $avExt = explode(".",$picName);
                    $extension = strtolower(end($avExt));
            
                    if(empty(trim($_FILES["image"]["name"])) && !in_array($extension, $allowedExt)){
                
                        $formErrors[] = lang("NOT-ALLOWED-EXT");
                
                    }
            
                    if($picSize > 4194304) lang("BIG-SIZE");
                    
                    // Validation
            
                    if(strlen($user) < 5) $formErrors[] = lang('STRLEN') ;
                    
                    if(strlen($user) > 30) $formErrors[] = lang('STRLEN1') ;
                    
                    if(empty(trim($user))) $formErrors[] = lang('USERERROR') ;
                    
                    if($pass != $_POST["oldpassword"]) $formErrors[] = lang('PASS-ERROR') ;
                    
                    if(empty($email)) $formErrors[] = lang('EMAILERROR') ;
                    
                    if(empty(trim($fullname)))  $formErrors[] =  lang('FULLNAMERROR') ;
                    
                    // Update 
                    
                    
                    if(empty($formErrors)){
                        
                    $stmt2 = $conn->prepare("SELECT username FROM users WHERE username = ? AND userID != ?");
                    $stmt2->execute(array($user,$id));
                    $cpt = $stmt2->rowCount();
                    if($cpt == 0){
                        
                        $stmt3 = $conn->prepare("SELECT email FROM users WHERE email = ? AND userID != ?");
                        $stmt3->execute(array($email,$id));
                        $cpt3 = $stmt2->rowCount();                        
                        
                        if($cpt == 0){                    
                        if(!empty(trim($picName))){       
                        $image = rand(0,100000) . "_" . $picName ;
                        }
                        else
                        {
                            $image = $_SESSION["image"];
                            
                        }
                        move_uploaded_file($picTmp, "uploads/profile_pictures/" . $image) ;
                    
                        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, fullname = ?, password = ?, image = ?, telephone = ?, birthDate = ?, wilaya = ?, interests = ? WHERE userID = ?");
                        $stmt->execute(array($user,$email,$fullname,$pass,$image,$telephone,$birth,$wilaya,$interests,$id));
                        
                        if($stmt){
                        
                        $_SESSION["image"] = $image;
                        $_SESSION["interests"] = $interests;    
                        header("location: profile.php?do=show&userID=". $_SESSION["id"]);
                        exit();
                    }    
                            
                        }
                        else {
                            
                            $failMsg = "<div class='alert-msg w3-container w3-center'>" . lang("EMAIL-EXIST") . "</div>";                            
                            
                        }
                    }
                        else{
                            $failMsg = "<div class='alert-msg w3-container w3-center'>" . lang("USER-EXIST") . "</div>"; 
                        }
                    }
            
        }
    
                $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']):0 ;
                
                // Select data
                
                $stmt = $conn->prepare("SELECT * FROM users WHERE userID = ? LIMIT 1");
                
                // execute query 
                
                $stmt->execute(array($userID));
                
                // Fetch the data 
                
                $row = $stmt->fetch();    
                $count = $stmt->rowCount();

                if($count > 0){
        ?>

                <div class="w3-container w3-content w3-margin-bottom">
                    
                    
                    <form class="form-horizontal w3-card w3-white w3-margin-top"  action="" method="post" enctype="multipart/form-data">
                        
                        <h1 class="w3-center w3-text-dark-grey"><?php echo lang('EDIT') ?></h1>
                        <input type="hidden" name="userid" value="<?php echo $userID ?>">  <!-- to get user's ID -->
                        
                <div class="w3-row-padding ">        
                

                                                                    <!-- Profile pic -->
                        <div class="form-group form-group-lg w3-margin-bottom w3-center">
  
                            <div class="image-upload">
                                <label for="file-input">
                                    <?php
                                    if(!empty(trim($row["image"]))){
                                        echo "<img class='profile-pic img-responsive img-thumbnail  img-circle' src='uploads/profile_pictures/" . $row["image"] . "' alt='' />";
                                        }
                                    else {
                                        echo "<img class='profile-pic img-responsive img-thumbnail img-circle' src='uploads/profile_pictures/user.png' alt='' />"; 
                                    }
                    ?>
                                </label>

                                <input id="file-input" type="file" name="image" class="form-control"/>
                            </div>
                            
                <?php                    
                    if(!empty($formErrors)){ 
                    
                    foreach ($formErrors as $error){
                        
                        echo "<div class='alert alert-danger container text-center'>" . $error . "</div>"  ;
                        
                    }
                    
                }
                    
                    if(isset($failMsg)){
                        
                        echo $failMsg;
                    }
                    
                
                    ?>                             
                        
                        </div>
                    
                    <hr>
                        <div class="w3-half w3-padding">
                        
                        <!-- Username -->
                        <div class="form-group form-group-lg w3-margin-bottom w3-padding">
                            <label class="w3-label w3-darkcyan"><?php echo lang("USERNAME") ?></label>
                            <input type="text" name="username" class="w3-input w3-text-grey " autocomplete="off" value="<?php echo $row['username'] ?>"  required="required">    
                        
                        </div>
                        

                                            <!-- E-mail -->
                        <div class="form-group form-group-lg w3-margin-bottom w3-padding">
                            <label class="w3-label w3-darkcyan"><?php echo lang("EMAIL") ?></label>                              
                            <input type="email" name="email" class="w3-input w3-text-grey" value="<?php echo $row['email'] ?>" required="required">
                        
                        </div>
                        
                                            <!-- Full name -->
                        <div class="form-group form-group-lg w3-margin-bottom w3-padding">
                            <label class="w3-label w3-darkcyan"><?php echo lang("FULLNAME") ?></label>
                            <input type="text" name="fullname" class="w3-input w3-text-grey" value="<?php echo $row['fullname'] ?>" required="required">   

                        </div>
                            
                        </div>
                        <div class="w3-half w3-padding">
                    
                                                                    <!-- Telephone -->
                                <div class="form-group form-group-lg w3-margin-bottom w3-padding">
                            <label class="w3-label w3-darkcyan"><?php echo lang("PHONE-NUM") ?></label>
                                    <input type="tel" id="phone" name="telephone" class="w3-input w3-text-grey" value="<?php echo $row['telephone'] ?>" >   

                                </div>
                            
                                                <!-- Birth -->
                                <div class="form-group form-group-lg w3-margin-bottom w3-padding">
                            <label class="w3-label w3-darkcyan"><?php echo lang("BIRTH-DATE") ?></label>                                    
                                    <input type="date" name="birth_date" class="w3-input w3-text-grey" value="<?php echo $row['birthDate'] ?>" >   
                                </div>

                                    <!-- WILAYA -->        
                          <p class="form-group form-group-lg w3-margin-bottom w3-padding">
                            <label class="w3-label w3-darkcyan"><?php echo lang("WILAYA") ?></label>                               
                              <select class="w3-select w3-text-grey w3-border" name="wilaya">
                              <option value=""></option>
                                <?php
                                    $stmt1 = $conn->prepare("SELECT * FROM wilayas");
                                    $stmt1->execute();
                                    $cats = $stmt1->fetchAll();

                                    foreach($cats as $cat){  ?>

                                        <option value = '<?php echo $cat["wilaya"] ?>' <?php if($row["wilaya"] == $cat["wilaya"] ){ echo "selected"; } ?> ><?php echo $cat["wilaya"] ?></option>

                    <?php                                                            }

                                            ?>

                                </select>
                            </p>                             
                    
                        </div>
                        <p class="form-group form-group-lg w3-margin-bottom w3-padding w3-center">
                            <label class="w3-label w3-darkcyan"><?php echo lang("INTERESTS") ?></label>                                 
                                <input class="w3-input w3-padding-16 w3-text-grey w3-border" name="interests" maxlength="800" placeholder="<?php echo lang("INTERESTS") ?>" value="<?php if(!empty(trim($row["interests"]))) echo $row["interests"] ; ?>" >
                        </p>                    
                    
                        
                    </div>
                    <hr>    
                                                <!-- SAVE -->
                        <div class="form-group form-group-lg w3-center">
                            
                        <a href="javascript:void(0)" class="w3-large w3-margin w3-button w3-teal w3-button w3-round" onclick="document.getElementById('id01').style.display='block'">
                        <i class="fa fa-fw fa-save"></i>                        
                        <?php echo "  " . lang("SAVE") ?>
                        
                        </a>

                        
                        </div>
                    
<div id="id01" class="w3-modal" style="z-index:4">  
  <div class="w3-modal-content w3-animate-zoom">
    <div class="w3-container w3-padding w3-teal">
       <span onclick="document.getElementById('id01').style.display='none'"
       class="w3-button w3-teal w3-right w3-large"><i class="fa fa-times"></i></span>
      <h4 class="w3-center"><?php echo lang("ENTER-PASSWORD") ?></h4>
    </div>
    <div class="w3-panel">
                                            <!-- Password -->
        <div class="w3-center form-group form-group-lg w3-margin-bottom w3-padding">                            
            <input type="password" name="password" class="w3-input w3-text-grey" autocomplete="new-password" placeholder="<?php echo lang("PASSWORD-CONFIRM")?>"  >
            <input type="hidden" name="oldpassword" value="<?php echo $row['password'] ?>" >
        </div>
        
       
      <div class="w3-section w3-center">
        <input type="submit"  class="w3-button w3-teal w3-large" value="<?php echo lang('CONFIRM') ?>">
      </div>    
    </div>
  </div>    
</div>
                        
   
                        
                    </form>

                </div>
                
                <?php
            
                }
        
    }
        
        else {
            
            header("location: main.php");
            exit();
        }
        
    }        

        include $tmp . 'footer.php';
    ob_end_flush();

?> 
