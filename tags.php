<?php 

    $title = "Tags" ;
    session_start();
    include 'init.php';
    if(isset($_GET["tag"])){
    ?>

    <div class="w3-container w3-margin">
        
<div class="w3-main w3-white w3-margin w3-padding">           
    <h1 class= "w3-center w3-text-grey" ><?php echo "#" . str_replace("-"," ",$_GET["tag"]) ?></h1>
        
<?php 
        $tag = $_GET["tag"];
        $allTags = getAllFrom("*", "items", "WHERE tags LIKE '%$tag%' AND pending = 1","ORDER BY add_date","");
        
        ?>
        
<hr>    
<div class="w3-row-padding w3-padding-16">
        <?php 
            if(!empty($allTags)){

                foreach($allTags as $item){

                    ?>
            <div class="w3-quarter w3-margin-bottom w3-center">
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
<?php if(strtotime($item["add_date"]) > strtotime('- 7 days')){                 
                echo '<span class="w3-tag w3-display-topleft w3-teal">'. lang("NEW") .'</span>';
            }
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
                    <a href="<?php echo $func ?>update.php?u=rlike&itemID=<?php echo $item["itemID"] ?>&userID=<?php echo $user ?>"><div class="w3-third w3-text-teal w3-padding w3-hover-teal w3-nowrap"><i class="fa fa-fw fa-check"></i><?php echo countItems("*","likes",true,"itemID",$item["itemID"]) ?>
                        </div>
                    </a>
<?php                    
                }
                    else {   ?>
                    
                    <a href="<?php echo $func ?>update.php?u=alike&itemID=<?php echo $item["itemID"] ?>&userID=<?php echo $user ?>">
                    <div class="w3-third w3-text-grey w3-padding w3-hover-teal"><i class="far fa-fw fa-thumbs-up"></i><?php echo countItems("*","likes",true,"itemID",$item["itemID"]) ?>
                        </div>
                    </a>
                    
<?php                    
                    }
                    
                ?>                         
                    
                    <div class="w3-third w3-text-grey w3-padding"><i class="fa fa-fw fa-eye"></i><?php echo countItems("*","user_likes",true,"itemID",$item["itemID"]) ?></div>                    
                    <a href="showAd.php?itemID=<?php echo $item["itemID"] ?>#demo"><div class="w3-third w3-text-grey w3-padding w3-hover-teal"><i class="fa fa-fw fa-comments"></i><?php echo countItems("comID","comments",true,"itemID",$item["itemID"]) ?></div></a>
                </div>                


                </div>
            
            </div>
                      
                                        
        <?php                                

                }
                echo "</div>";
            }
            else {

                echo  "<div class='alert alert-info text-center'>" . lang("NOTHING");
                
                echo "<a href='newad.php'>". " " . lang("CREATE-NEW-AD") ."</a></div>";

            }

            ?>  
                            
</div>          
    
    </div>

</div>

<?php include $tmp . 'footer.php'; 
    }
    else {
        
        header("location: main.php");
        exit();
        
    }

?> 