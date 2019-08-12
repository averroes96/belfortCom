<?php
        session_start();


        $title = "Show";

        include 'init.php';

                    // check if the item ID is a number
                
                $itemID = isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']):0 ;
                
                // Select data
                
                $stmt = $conn->prepare("SELECT items.*, category.name, users.* FROM items INNER JOIN category ON category.catID = items.catID INNER JOIN users ON users.userID = items.userID WHERE items.itemID = ?");
                
                // execute query 
                
                $stmt->execute(array($itemID));
                
                // Fetch the data 
                
                $row = $stmt->fetch();  
                
                $count = $stmt->rowCount();

            if(isset($_SESSION["id"])){
                
                if($row["pending"] == 1 || $_SESSION["group"] == 1 || $_SESSION["id"] == $row["userID"]);
                
                $viewer = 1;
                
            }
            else if($row["pending"] == 1){
                
            $viewer = 1;    
                
            }
            else
            $viewer = 0; 
                if($viewer == 1){   

                if($count > 0){
                    
                    $countView = countItems("*","user_likes",true,"itemID",$row["itemID"]);                    
                      
                if(isset($_SESSION["id"])){
                    
                    if($_SESSION["id"] != $row["userID"] || $countView == 0){
                        
                        $countViews = getAllFrom("*","user_likes","WHERE userID = " . $_SESSION["id"] . " AND itemID = " . $row["itemID"]);
                        
                        if(empty($countViews)){
                            
                            $stmt = $conn->prepare("INSERT INTO user_likes(userID, itemID) VALUES(:zuser, :zitem)");
                            $stmt->execute(array(
                            
                                "zuser" => $_SESSION["id"],
                                "zitem" => $row["itemID"]
                            
                            ));
                            
                        }
                                       
                        
                    }
                    
                }    
                    


                    if($countView % 10 == 0 && $countView != 0){

                        $fr_message = "Votre annonce vient d'atteindre " . $countView . " vues" ;
                        $en_message = "Your ad just reached " . $countView . " views" ;                        
                        $url = "showAd.php?itemID=".$row["itemID"];
                        notify("eye", $fr_message, $en_message, $row["userID"], $_SESSION["id"], $row["itemID"], $url);

                    }

       ?>
<div class="w3-container w3-content" style="margin-top: 20px;">
<div class="w3-card w3-round w3-main w3-white w3-margin-top w3-margin-bottom w3-padding">
    
<!-- Header -->
<?php                  
           $images = getItemImages($itemID);       
            $i = 0;        
                             
            ?>    
  <div class="w3-container" id="showcase">
    <h1 class="w3-xxxlarge w3-text-red w3-margin-top w3-margin-bottom"><b><?php echo " " . $row["item_name"] ?></b></h1>
  </div>
<div class="w3-row-padding w3-padding-32">    
<?php
                
    if(!empty($images)) {
                
        foreach($images as $image){   
                ?>
    
  <!-- Photo grid (modal) -->

    <div class="w3-half w3-center">      
        <div class="w3-twothird w3-center slideshow-container">
    <?php 

        if(!empty(trim($image[0]))){              
                echo    '<div class="img-container mySlides fade-in">
                                <img class="w3-hover-shadow w3-border" src="uploads/items_images/'. $image[0] . '" onclick="onClick(this)" style="width:75%; cursor:pointer">
                                </div>';
}
        if(!empty(trim($image[1]))){              
                echo    '<div class="img-container mySlides fade-in">
                                <img class="w3-hover-shadow w3-border" src="uploads/items_images/'. $image[1] . '" onclick="onClick(this)" style="width:75%;cursor:pointer">
                                </div>';
}
        if(!empty(trim($image[2]))){              
                echo    '<div class="img-container mySlides fade-in">
                                <img class="w3-hover-shadow w3-border" src="uploads/items_images/'. $image[2] . '" onclick="onClick(this)" style="width:75%;cursor:pointer">
                                </div>';
}
        if(!empty(trim($image[3]))){              
                echo    '<div class="img-container mySlides fade-in">
                                <img class="w3-hover-shadow w3-border" src="uploads/items_images/'. $image[3] . '" onclick="onClick(this)" style="width:75%;cursor:pointer">
                                </div>';
}             
            ?>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                <div class="w3-row w3-margin">
        <?php 

                $citem = $row["itemID"];
                if(isset($_SESSION["id"])) $user = $_SESSION["id"];            
                $list = getAllFrom("*","likes","WHERE itemID = '$citem' AND userID = '$user'");
                if(count($list) > 0){ ?>    
                    <a href="<?php echo $func ?>update.php?u=rlike&itemID=<?php echo $row["itemID"] ?>&userID=<?php echo $user ?>"><div class="w3-half w3-text-teal w3-padding w3-hover-teal w3-nowrap"><i class="fa fa-fw fa-check"></i><?php echo countItems("*","likes",true,"itemID",$row["itemID"]) ?>
                        </div>
                    </a>
<?php                    
                }
                    else {   ?>
                    
                    <a href="<?php echo $func ?>update.php?u=alike&itemID=<?php echo $row["itemID"] ?>&userID=<?php echo $user ?>">
                    <div class="w3-half w3-text-grey w3-padding w3-hover-teal"><i class="far fa-fw fa-thumbs-up"></i><?php echo countItems("*","likes",true,"itemID",$row["itemID"]) ?>
                        </div>
                    </a>
                    
<?php                    
                    }
                    
                ?>                         
                    
                    <div class="w3-half w3-text-grey w3-padding"><i class="fa fa-fw fa-eye"></i><?php echo $countView ?></div>   
                </div>             
<?php
        if(isset($_SESSION["id"])){
            if($_SESSION["id"] == $row["userID"]){ ?>
    <div class="w3-row">
        <div class="w3-half">
        <a href="editAd.php?itemID=<?php echo $row["itemID"] ?>" class="w3-button w3-teal w3-center w3-margin-bottom"><i class="fa fa-fw fa-edit"></i><span><b><?php echo lang("EDIT2") ?></b></span></a>
        </div>
        <div class="w3-half">
        <a href="delete.php?d=item&itemID=<?php echo $row["itemID"] ?>&user=<?php echo $row["username"] ?>" class="w3-button w3-red w3-hover-grenad w3-center w3-margin-bottom confirm"><i class="fa fa-fw fa-times"></i><span><b><?php echo lang("DELETE") ?></b></span></a>
        </div>          
    </div>    
                
<?php                
            }
            
        }
                ?>

            
        </div>
    
    </div>
    <div class="w3-half w3-border">
        <div class="w3-container w3-margin-bottom w3-teal">
          <h4 class="w3-center"><i class="fa fa-info-circle"></i><?php echo lang("INFOS") ?></h4>
        </div>
        
        <p>
            <i class="fa fa-fw fa-dollar-sign" style="color:darkcyan"></i>
            <strong class="w3-text-dark-grey"><?php echo ": " . $row["price"] . " " . lang("CURRENCY") ?></strong>
        </p>
        <p>
            <i class="fa fa-fw fa-globe" style="color:darkcyan"></i>
            <a href="store.php?wilaya=<?php echo $row["wilaya"] ?>"><strong class="w3-text-dark-grey"><?php echo ": " . $row["wilaya"] ?></strong></a>
        </p>
        <p>
            <i class="fa fa-fw fa-calendar-plus w3-darkcyan"></i>
            <strong class="w3-text-dark-grey"><?php echo ": " .  proDate($row["add_date"]) ?></strong>
        </p>
        <p><i class="fa fa-fw fa-flag w3-darkcyan"></i><strong class="w3-text-dark-grey"><?php echo ": " .  $row["status"] ?>/5</strong></p>      
        <a href="store.php?catID=<?php echo $row["catID"] . "&name=" . $row["name"] ?>">
            <p><i class="fa fa-fw fa-list-alt w3-darkcyan"></i> 
                <strong><?php echo " : " . $row["name"] ?></strong>
            </p>
        </a> 
        <p class="w3-hide-small w3-nowrap"><i class="fa fa-fw fa-tag" style="color:darkcyan"></i><strong class="w3-text-dark-grey">
                                <?php
                            $allTags = explode(" ",$row["tags"]);
                            if(!(empty($allTags))){
                                echo ": ";
                                foreach($allTags as $tag){
                                    if(!empty(trim($tag))){
                                    $tag = strtolower($tag);
                                    echo "<a class='tag-link' href='tags.php?tag={$tag}'>" . "#" . $tag . "</a> ";
                                    }
                                }
                                
                            }
                            
                                ?>
        </strong></p>    
       
      </div>
      
</div>  

  <!-- Modal for full size images on click-->
  <div id="modal01" class="w3-modal w3-black" style="padding-top:0" >
    <span class="w3-button w3-black w3-xxlarge w3-display-topright" onclick="this.parentElement.style.display='none'">×</span>
    <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
      <img id="img01" class="w3-image">
      <p id="caption"></p>
    </div>
  </div>    
<?php  
            }
        }
    else {
        
        
    }                
                    ?>

<!-- End page content -->

        <button class="tablink w3-hover-white w3-teal w3-hover-text-teal w3-hover-shadow" onclick="openPage('Users', this, 'teal')" id="defaultOpen"><?php echo lang("CHARACTERISTICS") ?></button>
        <button class="tablink w3-hover-white w3-teal w3-hover-text-teal w3-hover-shadow" onclick="openPage('Items', this, 'teal')" ><?php echo lang("DESCRIPTION") ?></button>
        <button class="tablink w3-hover-white w3-teal w3-hover-text-teal w3-hover-shadow" onclick="openPage('Subjects', this, 'teal')"><?php echo lang("ADVERTER") ?></button>
    
        <div id="Users" class="tabcontent w3-white w3-row">
            
  <div class="w3-card w3-padding w3-center" style="min-height:300px">
        <p>
            <strong class="w3-darkcyan" style="font-size:small">RAM : </strong>
            <span class="w3-text-dark-grey" style="font-size: small"><?php if(!empty(trim($row["RAM"]))) { echo $row["RAM"] . " GB"; } else echo lang("NOT-DEFINED"); ?></span>
          </p>
          <p class="w3-nowrap">
              <strong class="w3-darkcyan" style="font-size:small">CPU : </strong>
              <span class="w3-text-dark-grey" style="font-size: small"><?php if(!empty(trim($row["CPU"]))) { echo $row["CPU"]; } else echo lang("NOT-DEFINED"); ?></span>
          </p>
          <p>
              <strong class="w3-darkcyan" style="font-size:small"><?php echo lang("SIM-CARD") . " : " ?></strong>
              <span class="w3-text-dark-grey" style="font-size: small"><?php if($row["sim_card"] == 1) { echo lang("UNIQUE-SIM"); } else if($row["sim_card"] == 2) echo lang("DUAL-SIM"); else echo lang("NOT-DEFINED"); ?></span>
          </p>      
          <p>
              <strong class="w3-darkcyan" style="font-size:small"><?php echo lang("SCREEN") . " : " ?></strong>
              <span class="w3-text-dark-grey" style="font-size: small"><?php if(!empty(trim($row["Screen"]))) { echo $row["Screen"]; } else echo lang("NOT-DEFINED"); ?></span>
          </p>
          <p>
              <strong class="w3-darkcyan" style="font-size:small"><?php echo lang("FRONT-CAMERA") ?></strong>
              <span class="w3-text-dark-grey" style="font-size: small"><?php if(!empty(trim($row["front_camera"]))) { echo $row["front_camera"]; } else echo lang("NOT-DEFINED"); ?></span>
          </p>
          <p>
              <strong class="w3-darkcyan" style="font-size:small"><?php echo lang("REAR-CAMERA") ?></strong>
              <span class="w3-text-dark-grey" style="font-size: small"><?php if(!empty(trim($row["back_camera"]))) { echo $row["back_camera"]; } else echo lang("NOT-DEFINED"); ?></span>
          </p>        
          <p>
              <strong class="w3-darkcyan" style="font-size:small"><?php echo lang("STORAGE") . " : " ?></strong>
              <span class="w3-text-dark-grey" style="font-size: small"><?php if(!empty(trim($row["Capacity"]))) { echo $row["Capacity"] . " GB"; } else echo lang("NOT-DEFINED"); ?></span>
          </p>
          <p>
              <strong class="w3-darkcyan" style="font-size:small"><?php echo lang("OS") . " : " ?></strong>
              <span class="w3-text-dark-grey" style="font-size: small"><?php if(!empty(trim($row["OS"]))) { echo $row["OS"]; } else echo lang("NOT-DEFINED"); ?></span>
          </p>      
  </div>            
          
        </div>
    
        <div id="Items" class="tabcontent w3-white w3-row-padding w3-center">
            <div class="w3-card w3-padding w3-center" style="min-height:300px">      

                <p class="w3-text-dark-grey w3-margin"><?php if(!empty(trim($row["item_description"]))) 
                            echo $row["item_description"];
                        else
                            echo lang("NO-DESC-ITEM");
            ?>.
                </p>

            </div>
        </div>
        <div id="Subjects" class="tabcontent w3-white">
          <div class="w3-card w3-container w3-center" style="min-height:300px">
                <h4 class="w3-darkcyan w3-margin-bottom"><strong><?php echo lang("ADDED-BY") ?></strong></h4>

        <?php    
            if(!empty(trim($row["image"]))){

                echo '<img src="uploads/profile_pictures/'. $row["image"] .'" alt="" style="width:60px;height:60px" class="w3-circle">';

            }
            else {

                echo '<img src="uploads/profile_pictures/user.png" alt="" style="width:60px;height:60px" class=" w3-circle">';
            }

                ?>
          <h3><?php echo $row["username"] ?></h3>
        <?php if(!empty(trim($row["telephone"]))) { ?>    <h5 class="w3-text-grey"><?php echo $row["telephone"] ?></h5>  <?php } ?>
        <?php if(!empty(trim($row["email"]))) { ?>    <p class="w3-text-grey"><?php echo $row["email"] ?></p>  <?php } ?>      
          <p><a class="w3-button w3-teal" href="profile.php?userID=<?php echo $row["userID"] ?>"><?php echo lang("SEE-PROFILE") ?></a></p>
          </div>
        </div>        
    
<?php 
            if($row["pending"] == 1){
                    
                    if(isset($_SESSION["username"])) { ?>
                        <div class="row w3-margin-left">
                            <div class="w3-col s8 ">
                                <div class="add-comment">
                                <form action="<?php echo $_SERVER["PHP_SELF"] ."?itemID=" . $row["itemID"] . "#demo" ?>" method="post">
                                    <div class="w3-row">
                                        <div class="w3-col m2 w3-center w3-margin-bottom w3-hide-small">
<?php
                                if(!empty(trim($_SESSION["image"]))){

                                    echo '<img src="uploads/profile_pictures/' . $_SESSION["image"] .'" class="w3-circle" style="width:60px;height:60px">';
                                        }
                                        else {

                                            echo "<img src='uploads/profile_pictures/user.png' alt='' class='w3-circle' style='width:60px; height:60px' />";  
                                        }                        
                            ?>

                                        </div>
                                        <div class="w3-col m10 w3-margin-bottom">    
                                            <p><textarea id="add-comment" class="w3-input w3-padding-16 w3-text-grey w3-hover-light-grey w3-textarea" type="text" placeholder="<?php echo lang("YOUR-COMMENT") ?>..." required name="contenu" maxlength="800" rows="3"></textarea></p>
                                            <p><input class="w3-button w3-teal" type="submit" value="<?php echo lang("COMMENT") ?>"></p>
                                        </div>    
                                    </div>
                                </form>
<?php
                        if($_SERVER["REQUEST_METHOD"] === "POST"){
 
                            $contenu = filter_var($_POST["contenu"],FILTER_SANITIZE_STRING);
                            $userID = $_SESSION["id"];
                            $itemID = $row["itemID"];
                            
                            if(!empty($contenu)){
                                
                                $stmt = $conn->prepare("INSERT INTO comments(content,comDate,itemID,userID) VALUES(:zcontent,now(), :zitemID, :zuserID)");
                                $stmt->execute(array(
                                    ":zcontent" => $contenu,
                                    ":zitemID" => $itemID,
                                    ":zuserID" => $userID));
                                
                                if($stmt){
                                    
                                    echo "<div class='alert alert-success container text-center'>" . lang("COM-ADDED") . "</div>";
                                if($_SESSION["id"] != $row["userID"]){    
                                    $fr_message = $_SESSION["username"] . " a commenté votre annonce";
                                    $en_message = $_SESSION["username"] . " commented on your ad";                                    
                                    $url = "showAd.php?itemID=". $row["itemID"]."#demo";
                                    notify("comment", $fr_message, en_message, $row["userID"], $_SESSION["id"], $row["itemID"], $url); 
                                }
                                }
                                
                                
                            }
                            else{
                                
                                echo "<div class='alert alert-danger container text-center'>" . lang("COM-EMPTY") . "</div>";
                                
                            }
                            
                        }            
                                                      ?>

                                    </div>                                

                            </div>
                            <div class="w3-col s4">
                            
                                <a href="#demo">
                                    <p class="w3-center w3-margin-top"><button class="w3-button w3-teal" onclick="myFunction('demo')"><i class="fa fa-comments"></i> <b class="w3-hide-small"><?php echo lang("COMMENTS") ?>  </b> <span class="w3-tag w3-white w3-circle w3-text-teal"><?php echo countItems("comID","comments",true,"itemID",$itemID) ?></span></button></p>
                                </a>
                            
                            </div>
                        </div>
                <?php 
                 }
                    else { 
                        
                        echo "<div class='alert alert-info container text-center'><a href='login.php'>" . lang("LOGIN-MSG") . "</a>";
                        echo "</div>";    
                    }
                }
                    ?> 
    
    
                    <?php
                       
                        $stmt = $conn->prepare("SELECT comments.*, users.* FROM comments INNER JOIN users ON users.userID = comments.userID WHERE comments.itemID = ? ORDER BY comDate DESC");
                        $stmt-> execute(array($itemID));
                        $rows = $stmt->fetchAll();
                    
                    ?>
    
      
  <div class="w3-container w3-margin-top" id="demo" <?php if(isset($_SESSION["username"]) && $_SESSION["id"] != $row["userID"]) { echo 'style="display:none"'; } ?>>
            <hr>      
            <?php 
            
                    if(!empty($rows)){

                        foreach($rows as $comment){
                            echo '<div class="w3-row" id="' . $comment["comID"] . '">';
                            echo '<div class="w3-col m2 text-center w3-margin-bottom">';
                            
                            if(!empty(trim($comment["image"]))){
                                            
                                echo '<img src="uploads/profile_pictures/' . $comment["image"] .'" class="w3-circle" style="width:60px;height:60px">';
                                    }
                                    else {
                                            
                                        echo "<img src='uploads/profile_pictures/user.png' alt='' class='w3-circle' style='width:60px; height:60px' />";  
                                    }
                            echo '</div>';
                            echo '<div class="w3-col m10 w3-margin-bottom">
                                    <h4 class="w3-darkcyan"><a href="profile.php?userID=' . $comment["userID"] . '">'. $comment["username"] .'</a><span class="w3-opacity w3-medium w3-text-grey">'. " " . proDate($comment["comDate"]) .'</span></h4>
                                    <p class="w3-text-dark-grey"><span>'. $comment["content"] .'</span></p><br>';
                                                        
                            if(isset($_SESSION["id"])){
                            if($_SESSION["id"] == $comment["userID"]){
                                
                                echo '<a href="edit.php?e=comment&comID=' . $comment["comID"] . '" class="w3-grey w3-text-white w3-hover-green w3-round w3-padding" style="padding: 6px;" href="#"><i class="fa fa-fw fa-edit"></i></a>';
                                echo '<a href="delete.php?d=comment&comID=' . $comment["comID"] . '&user=' . $comment["username"] .'" class="w3-grey w3-text-white w3-hover-red w3-round w3-padding" style="margin-left:3px; padding: 6px;" href="#"><i class="fa f-fw fa-times"></i></a>';                                
                                  
                            }                                  
                            }
                            echo      '</div>';
                            echo '</div>';

                                            }
                    } else {
                                        
                            echo "<div class='alert alert-info text-center'>" . lang("NO-COM") . "</div>"  ;
                                        
                            }

                ?>     
    
  </div>
    

    
</div>    
</div>                    
<?php

                    ?>


<?php
                }
                    else{
                        
                        header("location:main.php");
                        exit();
                        
                    }

                }
                else {
                    

                    
                }
        
                include $tmp . 'footer.php';


?> 