<?php
    session_start();
    $title = "Search";
    include 'init.php';
    if(isset($_GET["keyword"])){
    $keyword = $_GET['keyword'] ;

    $getResult = searchBar($keyword);

if(!empty($getResult)){
    
?>

<div class="w3-container" style="margin-top: 20px;">
        
        <button class="tablink w3-hover-white w3-hover-text-teal w3-hover-shadow" onclick="openPage('Users', this, 'red')"><?php echo lang("USERS") ?></button>
        <button class="tablink w3-hover-white w3-hover-text-teal w3-hover-shadow" onclick="openPage('Items', this, 'red')" id="defaultOpen"><?php echo lang("ITEMS") ?></button>
        <button class="tablink w3-hover-white w3-hover-text-teal w3-hover-shadow" onclick="openPage('Subjects', this, 'red')"><?php echo lang("SUBJECT-LIST") ?></button>

        <div id="Users" class="tabcontent w3-white w3-row w3-margin-bottom" style="min-height:400px">
        <?php

            foreach($getResult as $result){ 
                if($result["type"] == "user"){
                ?>
            
        <div class="w3-quarter w3-padding">
            <div class="w3-card w3-center">
            <div class="img-container">    
              <img src="uploads/profile_pictures/<?php if(!empty(trim($result["image"]))) echo $result["image"]; else echo "user.png"; ?>" alt="Profile image" style="width:100%">
                </div>
                <a href="profile.php?do=show&userID=<?php echo $result["userID"] ?>"><h1 class="w3-text-teal"><?php echo $result["username"] ?></h1></a>
              <p class="w3-text-grey"><?php echo $result["email"] ?></p>
              <p><?php echo $result["fullname"] ?></p>
                <a href="messages.php?target=<?php echo $result["username"] ?>"><p><button class="w3-button w3-block w3-teal">Message</button></p></a>                
            </div>            
        </div>
        <?php
            }
                }

                ?> 
               
        </div>

        <div id="Items" class="tabcontent w3-white w3-row  w3-margin-bottom" style="min-height:400px">
<?php            
            foreach($getResult as $result){ 
                if($result["type"] == "item"){
                ?>
            <div class="w3-quarter w3-padding w3-margin-bottom w3-center">
            <div class="w3-border w3-hover-shadow w3-animate-zoom">    
            <div class="w3-display-container" >
            <div class="img-container">    
<?php
            if(!empty(trim($result["image"]))){   ?>
                <img class="" src="uploads/items_images/<?php echo $result["image"] ?>" style="width:100%">
<?php
                                            }
                else{
                    
                    echo '<img src="uploads/items_images/ads.png" style="width:100%">';
                    
                }
            ?>
                </div>
                
<?php

                    if(strtotime($result["fullname"]) > strtotime('- 7 days')){                 
                        echo '<span class="w3-tag w3-display-topleft w3-teal">'. lang("NEW") .'</span>';
                    }
                    
                    ?>
                <span class="w3-tag w3-display-topright w3-teal"><?php echo $result["wilaya"] ?> /5</span>                 
                <h4 class="w3-padding w3-nowrap"><?php echo $result["username"] ?></h4>
                <p class="w3-text-teal"><i class="fa fa-tag fa-fw"></i><b><?php echo $result["email"] ?> DA</b></p>                  
                <p class="w3-opacity w3-nowrap"><?php echo proDate($result["fullname"]) ?></p>                 
                <div class="w3-display-middle w3-display-hover">
                    <a href="showAd.php?itemID=<?php echo $result["userID"] ?>" class="w3-button w3-teal"><?php echo lang("FULL-DETAILS") ?> <i class="fa fa-plus-circle"></i></a>
                </div>              
                
            </div>
                <div class="w3-row">                
        <?php 

                $citem = $result["userID"];
                if(isset($_SESSION["id"])) $user = $_SESSION["id"];            
                $list = getAllFrom("*","likes","WHERE itemID = '$citem' AND userID = '$user'");
                if(count($list) > 0){ ?>    
                    <a href="<?php echo $func ?>update.php?u=rlike&itemID=<?php echo $result["userID"] ?>&userID=<?php echo $user ?>"><div class="w3-third w3-text-teal w3-padding w3-hover-teal w3-nowrap"><i class="fa fa-fw fa-check"></i><?php echo countItems("*","likes",true,"itemID",$result["userID"]) ?>
                        </div>
                    </a>
<?php                    
                }
                    else {   ?>
                    
                    <a href="<?php echo $func ?>update.php?u=alike&itemID=<?php echo $result["userID"] ?>&userID=<?php echo $user ?>">
                    <div class="w3-third w3-text-grey w3-padding w3-hover-teal"><i class="far fa-fw fa-thumbs-up"></i><?php echo countItems("*","likes",true,"itemID",$result["userID"]) ?>
                        </div>
                    </a>
                    
<?php                    
                    }
                    
                ?>                         
                    
                    <div class="w3-third w3-text-grey w3-padding"><i class="fa fa-fw fa-eye"></i><?php echo countItems("*","user_likes",true,"itemID",$result["userID"]) ?></div>                    
                    <a href="showAd.php?itemID=<?php echo $result["userID"] ?>#demo"><div class="w3-third w3-text-grey w3-padding w3-hover-teal"><i class="fa fa-fw fa-comments"></i><?php echo countItems("comID","comments",true,"itemID",$result["userID"]) ?></div></a>
                </div>                  


                </div>           
        </div>            
        <?php
            }
            }
    ?>

    </div>
        <div id="Subjects" class="tabcontent w3-white w3-margin-bottom" style="min-height:400px">
<?php
                foreach($getResult as $result){ 
                if($result["type"] == "subject"){
                            echo "<div class='cat w3-border-bottom'>";
                            
                                echo "<div class='w3-hide-small w3-hide-medium hidden-buttons'>";
                                    echo "<a href='subject.php?subID=". $result["userID"] . "' class='w3-button w3-teal' >" . lang("DISPLAY") . "</a>";
                            
                                echo "</div>";
                            
                                echo "<h3><i class='fa fa-fw fa-angle-right w3-text-teal' ></i><span class='w3-nowrap'>" . $result["email"] . "</span>";
                            
                                    echo "<span class='w3-badge w3-small w3-light-blue w3-text-white w3-margin-left' style='padding: 8px 8px'><i class ='fa fa-fw fa-comments'></i>" . countItems("*","reply",true,"subID",$result["userID"]) ;
                                    echo "</span>";
                                    echo "<span class='w3-badge w3-small w3-red' style='margin: 5px; padding: 8px 8px'><i class='fa fa-eye fa-fw'></i>" . $result["fullname"] ;
                                    echo "</span>";                            
                            
                            
                            
                                echo  "</h3>";
                            
                                echo "<div class='full-view w3-animate-bottom'>";
                                    echo "<p><i class='fa fa-fw fa-calendar w3-text-teal'></i>" . $result["wilaya"] ."</p>";
                                    echo "<p ><i class='fa fa-fw fa-list-alt w3-text-teal'></i><span class='w3-indigo w3-round' style='padding: 4px 10px'>" . $result["image"] ."</span></p>";
                            
                                echo "<div class='w3-hide-large hidden-buttons'>";
                                    echo "<a href='#' class='w3-button w3-teal' >" . lang("DISPLAY") . "</a>";
                            
                                echo "</div>";
                            
                                
                                echo "</div>";
                              
                            echo "</div>";
                }
                }
    
    ?>
        </div>        
    

</div>


<?php

                }
                else {
                    echo "<div class='w3-container w3-content w3-center' style='min-height:-webkit-fill-available'>";
                    echo "<div class='alert alert-danger w3-center' style='margin-top: 50px;'>" . lang("NO-RESULT") . "</div>";
                    echo "<a href='main.php' class='w3-button w3-teal w3-round w3-margin'>BelfortCom</a>";
                    echo "</div>";
                }
        
                include $tmp . 'footer.php';
    } else{
        
        header("location:main.php");
        exit();
        
    }

?> 