<?php
        if(isset($_SESSION["id"])){
        $rand_interest = array_rand(explode(" ",$_SESSION["interests"]));
        
        $item = getInterest($rand_interest, $_SESSION["id"]);
        if(!empty($item)){ 
?>        
        
      <div class="w3-card w3-round w3-white w3-center">
        <div class="w3-container">
          <p class="w3-text-red"><?php echo lang("AD-SUGGESTIONS") ?></p>
<?php 
                if(!empty(trim($item[0]["image"]))){
                    echo "<img src='uploads/items_images/" . $item[0]["image"] . "' style='height:106px;width:106px' alt='annonce-image' />";
                                        }
                else {
                    echo "<img src='uploads/item_images/ads.png' style='height:106px;width:106px' alt='' />"; 
                                    }            
            
        ?>            
          <p><strong><?php echo $item[0]["item_name"] ?></strong></p>
          <p><?php echo $item[0]["add_date"]  ?></p>
          <p><a class="w3-button w3-block w3-teal"><?php echo lang("FULL-DETAILS") ?></a></p>
        </div>
      </div>
      <br>
<?php }
        }
        ?> 