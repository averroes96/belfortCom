<?php 
    ob_start();
    session_start();
    $title = "Store";
    include 'init.php';
    $name = isset($_GET["name"]) ? $_GET['name'] : 'all';

if($_SERVER["REQUEST_METHOD"] == "GET"){
    
    $status = "" ;
    $catID = isset($_GET["catID"]) ? $_GET['catID'] : 0;
    if(isset($_GET["wilaya"])) { $wilaya = $_GET["wilaya"]; } else $wilaya = ""; 
    if(isset($_GET["prix_min"])) { $minPrice = $_GET["prix_min"]; } else $minPrice = "";
    if(isset($_GET["prix_max"])) { $maxPrice = $_GET["prix_max"]; } else $maxPrice = "";
    if(isset($_GET["ram_min"])) { $minRam = $_GET["ram_min"]; } else $minRam = "";
    if(isset($_GET["ram_max"])) { $maxRam = $_GET["ram_max"]; } else $maxRam = "";
    if(isset($_GET["cap_min"])) { $minCap = $_GET["cap_min"]; } else $minCap = "";
    if(isset($_GET["cap_max"])) { $maxCap = $_GET["cap_max"]; } else $maxCap = "";
    if(isset($_GET["order"])) { $order = $_GET["order"]; } else $order = "";    
    if(!empty($_GET["status"])){  foreach ($_GET["status"] as $selected) {  $status = $status . $selected . "," ;  }   }
    
    $allStatus = rtrim($status,",");
    
    $query = "";
    
    if($catID != 0 ) $query = "WHERE catID = $catID ";
    if(!empty(trim($wilaya))){
        
        if(!empty($query))  $query = $query . "AND wilaya = '$wilaya' ";
        else    $query = "WHERE wilaya = '$wilaya' ";
        
    }
    
    if(!empty($minPrice)){
        
        if(!empty($query))  $query = $query . "AND price >= $minPrice ";
        else    $query = "WHERE price >= $minPrice ";
        
    }
    
    if(!empty($maxPrice)){
        
        if(!empty($query))  $query = $query . "AND price <= $maxPrice ";
        else    $query = "WHERE price <= $maxPrice ";
        
    } 
    
    if(!empty($minRam)){
        
        if(!empty($query))  $query = $query . "AND RAM >= $minRam ";
        else    $query = "WHERE RAM >= $minRam ";
        
    } 
    
    if(!empty($maxRam)){
        
        if(!empty($query))  $query = $query . "AND RAM <= $maxRam ";
        else    $query = "WHERE RAM <= $maxRam ";
        
    }
    
    if(!empty($minCap)){
        
        if(!empty($query))  $query = $query . "AND Capacity >= $minCap ";
        else    $query = "WHERE Capacity >= $minCap ";
        
    }
    
    if(!empty($maxCap)){
        
        if(!empty($query))  $query = $query . "AND Capacity <= $maxCap ";
        else    $query = "WHERE Capacity <= $maxCap ";
        
    }  
    
    if(!empty($_GET["status"])){
        
        if(!empty($query))  $query = $query . "AND status IN ($allStatus) ";
        else    $query = "WHERE status IN ($allStatus) ";
        
    }
    

        
        if(!empty($query))  $query = $query . "AND pending = 1 ";
        else    $query = "WHERE pending = 1 ";
    
    
    if(!empty($_GET["order"])){
        
        $query = $query . " ORDER BY $order DESC ";
      
        
    }

    
}

    ?>
<div class="w3-container w3-margin-bottom " style="margin-top: 40px; min-height: -webkit-fill-available;">
    
<div class="preview w3-row-padding " id="myForm">

  <form action="" method="get" class="w3-card w3-white w3-padding-32 w3-center" style="max-width:fit-content; margin:auto; margin-top:100px; margin-bottom:20px">
      
      <p class="w3-margin-bottom">
        <label class="w3-label w3-darkcyan"><?php echo lang("ORDER") ?></label>          
          <select class="w3-select live-wilaya w3-text-grey" name="order">
                        <option value =""><?php echo lang("CHOSE") ?></option>
                        <option value="add_date">Date</option>
                        <option value="views"><?php echo lang("VIEWS") ?></option>

            </select>
        </p>      
      

        <p class="w3-margin-bottom">
            <label class="w3-label w3-darkcyan"><?php echo lang('NAME') ?></label>
            <select class="w3-select w3-text-grey" name="catID" >
                        <option value =""><?php echo lang("CHOSE") ?></option> 
                <?php
                    $stmt1 = $conn->prepare("SELECT * FROM category WHERE visibility = 0");
                    $stmt1->execute();
                    $cats = $stmt1->fetchAll();

                    foreach($cats as $cat){

                        echo "<option value = '" . $cat["catID"] . "'>" . $cat["name"] . "</option>" ;

                                        }

                    ?>

            </select>
        </p>      
      
                <!-- WILAYA -->        
      <p class="w3-margin-bottom">
        <label class="w3-label w3-darkcyan"><?php echo lang('WILAYA') ?></label>          
          <select class="w3-select live-wilaya w3-text-grey" name="wilaya">
                        <option value =""><?php echo lang("CHOSE") ?></option>              
            <?php
                $stmt1 = $conn->prepare("SELECT * FROM wilayas");
                $stmt1->execute();
                $cats = $stmt1->fetchAll();

                foreach($cats as $cat){

                    echo "<option value = '" . $cat["wilaya"] . "'>" . $cat["wilaya"] . "</option>" ;

                                                            }

                        ?>

            </select>
        </p>         
      
    <label class="w3-label w3-darkcyan w3-center"><?php echo lang('PRICE')?></label>  
    <div class="w3-row-padding w3-margin-bottom">

        <div class="w3-half">
            <p><input class="w3-input" type="number" placeholder="Minimum" name="prix_min" ></p>
        </div>
        <div class="w3-half">
        <p><input class="w3-input" type="number" placeholder="Maximum" name="prix_max" ></p>
        </div>  

    </div>


    <label class="w3-label w3-darkcyan w3-center">RAM [GB]</label>  
    <div class="w3-row-padding w3-margin-bottom">

        <div class="w3-half">
            <p><input class="w3-input" type="number" placeholder="Minimum" name="ram_min" ></p>
        </div>
        <div class="w3-half">
        <p><input class="w3-input" type="number" placeholder="Maximum" name="ram_max" ></p>
        </div>  

    </div>

    <label class="w3-label w3-darkcyan w3-center w3-margin-bottom"><?php echo lang('STORAGE')?> [GB]</label>  
    <div class="w3-row-padding">

        <div class="w3-half">
            <p><input class="w3-input" type="number" placeholder="Minimum" name="cap_min" ></p>
        </div>
        <div class="w3-half">
        <p><input class="w3-input" type="number" placeholder="Maximum" name="cap_max" ></p>
        </div>  

    </div>
      
        <label class="w3-label w3-darkcyan w3-margin-bottom"><?php echo lang('STATUS') ?></label>  
      
        <label class="label-container w3-text-grey"><?php echo lang("VERY-GOOD") ?>
          <input class="w3-input" type="checkbox" name="status[]" value="5" >
          <span class="checkmark"></span>
        </label>

        <label class="label-container w3-text-grey"><?php echo lang("GOOD") ?>
          <input type="checkbox" name="status[]" value="4">
          <span class="checkmark"></span>
        </label>

        <label class="label-container w3-text-grey"><?php echo lang("NORMAL") ?>
          <input type="checkbox" name="status[]" value="3">
          <span class="checkmark"></span>
        </label>

        <label class="label-container w3-text-grey"><?php echo lang("OLD")  ?>
          <input type="checkbox" name="status[]" value="2">
          <span class="checkmark" ></span>
        </label>
        <label class="label-container w3-text-grey"><?php echo lang("DAMAGED") ?>
          <input type="checkbox" name="status[]" value="1">
          <span class="checkmark"></span>
        </label>      
      <br>
        <p>      
        <input type="submit"  class="w3-button w3-block w3-teal w3-padding-large w3-round" value="<?php echo lang('FILTER') ?>">    
        </p>
        <button type="submit" class="w3-input w3-block w3-red w3-round" onclick="closeForm()"><?php echo lang('CANCEL') ?></button>

  </form>
</div>  
    

<div id="result" class="w3-row-padding w3-white w3-card-4" style="min-height: 1000px">
    <h2 class="w3-text-dark-grey w3-white w3-margin-bottom "><b><?php echo lang("ALL-ADS") ?></b>
        <button class="w3-button w3-teal w3-right w3-round" onclick="openForm()" style="font-size:initial"><i class="fa fa-fw fa-search"></i><span class="w3-hide-small "><?php echo lang("FILTER") ?></span></button>
    </h2>
  <!-- Top header -->
  <header class="w3-xlarge w3-center">
    <div class="w3-white w3-margin-bottom">  
    <div class="w3-section w3-padding-16" id="myBtnContainer">
        
      <a href="#result" class="filter-link w3-padding w3-teal" data-filter="all" style="font-size:initial; text-decoration:none" ><?php echo lang("ALL") ?></a>
      <a href="#result" class="filter-link w3-padding w3-light-grey" data-filter="smartphone" style="font-size:initial; text-decoration:none" ><i class="fa fa-fw fa-mobile" ></i><span class="w3-hide-small"><?php echo lang("SMARTPHONE") ?></span></a>
      <a href="#result" class="filter-link w3-padding w3-light-grey" data-filter="tablet" style="font-size:initial; text-decoration:none" ><i class="fa fa-fw fa-tablet w3-margin-right"></i><span class="w3-hide-small"><?php echo lang("TABLET") ?></span></a>
   
    </div>


    </div>    
  </header>
    
  <?php
    
            if($catID == 0 && $wilaya == "" && $maxPrice == "" && $minPrice == "" && $minRam == "" && $maxRam == "" && $minCap == "" && $maxCap =="" && $allStatus == "" && $order == ""){
            if(!empty(getAllFrom("*", "items","","ORDER BY add_date", "DESC"))){    
                foreach((getAllFrom("*", "items","WHERE pending = 1","ORDER BY add_date", "DESC","","LIMIT 16")) as $item){  
                    ?>

            <div class="w3-quarter w3-padding w3-margin-bottom w3-center all <?php if($item["type"] == 0){ echo "smartphone";} else { echo "tablet";} ?>">
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
                echo '<span class="w3-tag w3-display-topleft w3-teal">'. lang("NEW") . '</span>';
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
                      
                                        
        <?php                                

                }
            }
            else {

                echo  "<div class='alert alert-info text-center'>" . lang("NO-ADS");

                echo "<a href='newad.php'>". " " . lang("CREATE-NEW-AD") ."</a></div>"; 
                

            }
            }
            else {
                $result = filterResult($query);
                if(!empty($result)){ 
                echo '<div class="row-padding">';
                foreach($result as $item){  
                    ?>
    
            <div class="w3-quarter w3-padding w3-margin-bottom w3-center all <?php if($item["type"] == 0){ echo "smartphone";} else { echo "tablet";} ?>">
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
                echo '<span class="w3-tag w3-display-topleft w3-teal">New</span>';
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
                      
                                        
        <?php                                

                }
                echo "</div>";
            }
            else {

                echo  "<div class='alert alert-info w3-center w3-margin-bottom'>" . lang("NO-ADS");

                echo "<a href='newad.php'>". " " . lang("CREATE-NEW-AD") ."</a></div>"; 
                

            }
            }

            ?>

                            
</div>
    <div class="w3-white pagination w3-center" style="width:100%">
        
    </div>    

    
</div>
    <?php include $tmp . 'footer.php'; 
    ob_end_flush();

?> 