<?php

        ob_start();
        session_start();

        $title = "New";

        include 'init.php';

        if(isset($_SESSION["username"])){
            
            if($_SERVER["REQUEST_METHOD"] == "POST"){
            
            $formErrors = array();
            
            $name = filter_var($_POST["item_name"],FILTER_SANITIZE_STRING);
            $desc = filter_var($_POST["description"],FILTER_SANITIZE_STRING);
            $price = filter_var($_POST["price"],FILTER_SANITIZE_NUMBER_INT);
            $wilaya = filter_var($_POST["wilaya"],FILTER_SANITIZE_STRING);
            $status = filter_var($_POST["status"],FILTER_SANITIZE_NUMBER_INT);
            $sim = filter_var($_POST["sim"],FILTER_SANITIZE_NUMBER_INT);                
            $catID = filter_var($_POST["catID"],FILTER_SANITIZE_NUMBER_INT);
            $tags =  filter_var($_POST["tags"],FILTER_SANITIZE_STRING);
            $type =  filter_var($_POST["type"],FILTER_SANITIZE_STRING);                
            $cpu =  filter_var($_POST["CPU"],FILTER_SANITIZE_STRING);
            $os =  filter_var($_POST["OS"],FILTER_SANITIZE_STRING);
            $ram =  filter_var($_POST["RAM"],FILTER_SANITIZE_NUMBER_INT);  
            $screen =  filter_var($_POST["Screen"],FILTER_SANITIZE_STRING);
            $capacity =  filter_var($_POST["capacity"],FILTER_SANITIZE_NUMBER_INT);
            $front_camera =  filter_var($_POST["front_camera"],FILTER_SANITIZE_STRING);
            $rear_camera =  filter_var($_POST["back_camera"],FILTER_SANITIZE_STRING);
            if($_SESSION["group"] == 1) $pending = "1" ; else $pending = "0" ;    
                
            $picName = $_FILES["image"]["name"];
            $picSize = $_FILES["image"]["size"];
            $picTmp = $_FILES["image"]["tmp_name"];
            $picType = $_FILES["image"]["type"];
                
            $picName1 = $_FILES["image1"]["name"];
            $picSize1 = $_FILES["image1"]["size"];
            $picTmp1 = $_FILES["image1"]["tmp_name"];
            $picType1 = $_FILES["image1"]["type"];
                
            $picName2 = $_FILES["image2"]["name"];
            $picSize2 = $_FILES["image2"]["size"];
            $picTmp2 = $_FILES["image2"]["tmp_name"];
            $picType2 = $_FILES["image2"]["type"];
                
                
            $picName3 = $_FILES["image3"]["name"];
            $picSize3 = $_FILES["image3"]["size"];
            $picTmp3 = $_FILES["image3"]["tmp_name"];
            $picType3 = $_FILES["image3"]["type"];                
                
                $allowedExt = array("jpeg","png","jpg");
                $avExt = explode(".",$picName);
                $avExt1 = explode(".",$picName1);
                $avExt2 = explode(".",$picName2);
                $avExt3 = explode(".",$picName3);
                
                $extension = strtolower(end($avExt));
                $extension1 = strtolower(end($avExt1));
                $extension2 = strtolower(end($avExt2));
                $extension3 = strtolower(end($avExt3));
            
                if(strlen($name) < 3 || empty(trim($name)) || strlen($name) > 50) $formErrors[] = lang('AD-NAME-ERROR') ;
                    
                if(strlen($name) > 50) $formErrors[] = lang('AD-NAME-ERROR1') ;
            
                if(empty($price)) $formErrors[] = lang('AD-NAME-ERROR2') ;
            
                if($price <= 0) $formErrors[] = lang('AD-NAME-ERROR2') ;
            
                    if(!empty(trim($_FILES["image"]["name"])) && !(in_array($extension, $allowedExt))){
                
                        $formErrors[] = lang("NOT-ALLOWED-EXT");
                
                    }
            
                    if($picSize > 4194304) lang("BIG-SIZE");
                
                
                    if(!empty(trim($picName1)) && !(in_array($extension1, $allowedExt))){
                
                        $formErrors[] = lang("NOT-ALLOWED-EXT");
                
                    }
            
                    if($picSize1 > 4194304) lang("BIG-SIZE");
                
                    if(!empty(trim($picName2)) && !(in_array($extension2, $allowedExt))){
                
                        $formErrors[] = lang("NOT-ALLOWED-EXT");
                
                    }
            
                    if($picSize2 > 4194304) lang("BIG-SIZE");
                
                
                    if(!empty(trim($picName3)) && !(in_array($extension3, $allowedExt))){
                
                        $formErrors[] = lang("NOT-ALLOWED-EXT");
                
                    }
            
                    if($picSize3 > 4194304) lang("BIG-SIZE");                
                    
                
                if(empty($formErrors)){
                    $image1 = "";
                    $image2 = "";
                    $image3 = "";
                    $image = rand(0,100000) . "_" . $picName ;
                    
                    move_uploaded_file($picTmp, "uploads/items_images/" . $image) ;  
                    
                    if(!empty(trim($picName1))){
                        
                    $image1 = rand(0,100000) . "_" . $picName1 ;
                    
                    move_uploaded_file($picTmp1, "uploads/items_images/" . $image1) ;                        
            
                    }
                    
                    if(!empty(trim($picName2))){
                        
                    $image2 = rand(0,100000) . "_" . $picName2 ;
                    
                    move_uploaded_file($picTmp2, "uploads/items_images/" . $image2) ;                        
            
                    }
                    
                    if(!empty(trim($picName3))){
                        
                    $image3 = rand(0,100000) . "_" . $picName3 ;
                    
                    move_uploaded_file($picTmp3, "uploads/items_images/" . $image3) ;                        
            
                    }                    

                    $stmt = $conn->prepare("INSERT INTO items(item_name, item_description, price, add_date, wilaya, image, image1, image2, image3, status, sim_card, tags, type, RAM, CPU, Capacity, Screen, front_camera, back_camera, OS, pending, catID, userID) VALUES (:zname, :zdescription, :zprice, now(), :zwilaya, :zimage, :zimage1, :zimage2, :zimage3, :zstatus, :zsim, :ztags, :ztype, :zRAM, :zCPU, :zCapacity, :zScreen, :zfront_camera, :zback_camera, :zOS, :zpending, :zcatID, :zuserID)");
                    $stmt->execute(array(
                        "zname" => $name,
                        "zdescription" => $desc,
                        "zprice" => $price,
                        "zwilaya" => $wilaya,
                        "zimage" => $image,
                        "zimage1" => $image1,
                        "zimage2" => $image2,
                        "zimage3" => $image3,                        
                        "zstatus" => $status,
                        "zsim" => $sim,                        
                        "ztags" => $tags,                        
                        "ztype" => $type,
                        "zRAM" => $ram,
                        "zCPU" => $cpu,
                        "zCapacity" => $capacity,
                        "zScreen" => $screen,
                        "zfront_camera" => $front_camera,
                        "zback_camera" => $rear_camera,
                        "zOS" => $os,
                        "zpending" => $pending,
                        "zcatID" => $catID,
                        "zuserID" => $_SESSION["id"]
                        
                    ));
                    
                    if($stmt){
                    $successMsg = lang("AD-ADDED") ;
                    header("location: profile.php?do=show&userID=".$_SESSION["id"]);
                    exit();    
                            }
                    }
                    
                
            }

       ?>
<div class="w3-container w3-content">
<div class="w3-card w3-round w3-white w3-main w3-margin-bottom w3-padding" style="margin-top:32px" >
    <h3 class="w3-text-dark-grey w3-padding"><i class="fa fa-tablet-alt"></i> <?php echo lang("NEW-AD") ?>
    <a class="w3-button w3-teal w3-text-white w3-right" id="myBtn" style="font-size:small"><i class="fa fa-fw fa-eye w3-hide-large"></i><span class="w3-hide-small"><?php echo lang("PREVIEW") ?></span></a>
    
    </h3>
    
    <div class="messages w3-center">
<?php        
        if(!empty($formErrors)){
            
            foreach($formErrors as $error){
                
                ?>
                <div class="alert-msg">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <?php echo $error ?>
                </div>
        
<?php        
                
            }
            
            
        }
            
        if(isset($successMsg)) { ?>
            
                <div class="success-msg">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <?php echo $successMsg ?>
                </div>
<?php            
        }    
    ?>
    </div>    

<!-- The Modal -->
<div id="myModal" class="preview">

  <!-- Modal content -->
<div class="w3-margin-bottom live-preview w3-padding preview-content" style="max-width:fit-content">    
    
            <div class="w3-border w3-hover-shadow w3-animate-zoom caption w3-center">
    <span  onclick="this.parentElement.style.display='none';" class="close-btn"></span>                
            <div class="w3-display-container" >
            <div class="img-container">
                
            <img class='item-img img-responsive' src='uploads/items_images/ads.png' alt='' />
                
            </div>
                <span class="w3-tag w3-display-topright w3-teal status"> /5</span> 
                <h3 class="w3-padding w3-nowrap"><?php echo lang("NAME-AD") ?></h3>
                <p class="w3-text-teal"><i class="fa fa-tag fa-fw"></i><b class="price-tag">0 DA</b></p>                
                <p class="w3-opacity w3-nowrap"><?php echo date("d M Y | h:s a", time()) ?></p>                 
                <div class="w3-display-middle w3-display-hover">
                    <a href="#" class="w3-button w3-teal"><?php echo lang("FULL-DETAILS") ?> <i class="fa fa-plus-circle"></i></a>
                </div>
                
            </div> 


                </div>    
  </div>

</div>
    <hr>
<div class="w3-row-padding w3-margin w3-light-grey w3-card">
    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
        
<div class="w3-half w3-padding w3-round ">
    <p class="w3-text-red"><?php echo lang("FILL-INFO") . " ! (* : " . lang("REQUIRED") .")" ?> </p>

    <div class="input-container">    
        <p><input class="w3-input w3-padding-16 live-name w3-text-grey" id="adname" type="text" placeholder="<?php echo lang('NAME-AD') ?>" required name="item_name" maxlength="50">
        </p>
    <div class="alert alert-danger w3-margin alert-adname"><?php echo lang("AD-NAME-ERROR") ?></div>         
    </div>    
        
    <p><textarea rows="5" class="w3-input w3-padding-16 w3-text-grey" name="description" maxlength="800" placeholder="<?php echo lang('DESCRIPTION') ?>"></textarea></p>
        
    <div class="input-container">   
        <p><input class="w3-input w3-padding-16 live-price w3-margin-bottom w3-text-grey" placeholder="<?php echo lang('PRICE') ?>" required type="number" id="price" name="price">
        </p>
    <div class="alert alert-danger w3-margin alert-price"><?php echo lang("AD-NAME-ERROR2") ?></div>         
    </div>     
<div class="w3-row-padding">
    <div class="w3-half ">
                <!-- WILAYA -->        
      <p class="w3-margin-bottom">
        <label class="w3-label w3-darkcyan"><?php echo lang('WILAYA') ?> <span class="w3-text-red">*</span></label>          
          <select class="w3-select live-wilaya w3-text-grey" name="wilaya" required>
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
                <!-- STATUS -->
        <p class="w3-margin-bottom">
            <label class="w3-label w3-darkcyan"><?php echo lang('STATUS')?></label>            
            <select class="w3-select live-status w3-text-grey " name="status">
                <option value="5">5 <?php echo "'" . lang("VERY-GOOD") . "'" ?></option>
                <option value="4">4 <?php echo "'" .lang("GOOD"). "'" ?></option> 
                <option value="3">3 <?php echo "'" .lang("NORMAL"). "'" ?></option> 
                <option value="2">2 <?php echo "'" .lang("OLD"). "'" ?></option> 
                <option value="1">1 <?php echo "'" .lang("DAMAGED"). "'" ?></option> 

            </select>
        </p>
    </div>
    <div class="w3-half">
                <!-- CATEGORY -->        
        <p class="w3-margin-bottom">
            <label class="w3-label w3-darkcyan"><?php echo lang('NAME') ?> <span class="w3-text-red">*</span></label>
            <select class="w3-select w3-text-grey" name="catID" required>

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
    
                <!-- TYPE -->
        <p class="w3-margin-bottom">
            <label class="w3-label w3-darkcyan">Type <span class="w3-text-red">*</span></label>            
            <select class="w3-select  w3-text-grey " required name="type">
                <option value="0">Telephone</option>
                <option value="1"><?php echo lang("TABLET") ?></option> 

            </select>
        </p>
        </div>
</div>
    <br>
        <p class="w3-center" >
          <input type="text" name="tags" class="w3-input w3-padding-16" placeholder="<?php echo lang("TAGS") ?>">
        <span class="w3-small w3-text-red">*<?php echo lang("TAGS-MSG") ?>*</span>    
        </p> 

</div>

    
<div class="w3-half w3-margin-bottom live-preview w3-padding">
    
         <p class="w3-darkcyan"><strong><?php echo lang("CHARACTERISTICS") . " : "  ?></strong></p>
    <p><input class="w3-input w3-padding-16 live-name w3-text-grey" type="text" placeholder="CPU" name="CPU" maxlength="50"></p>    
    <p><input class="w3-input w3-padding-16 live-name w3-text-grey" type="text" placeholder="<?php echo lang("OS") ?>" name="OS" maxlength="27"></p>
    <br/>
    <div class="w3-row-padding">
        <div class="w3-half">
        <p class="w3-margin-bottom">
            <label class="w3-label w3-darkcyan">RAM</label>            
            <select class="w3-select live-status w3-text-grey " name="RAM">
                <option value=""><?php echo lang("CHOSE") ?></option>                
                <option value="1">1 GB</option>
                <option value="2">2 GB</option>
                <option value="2">3 GB</option>                 
                <option value="4">4 GB</option> 
                <option value="6">6 GB</option> 
                <option value="8">8 GB</option> 

            </select>
        </p>
        </div>
        <div class="w3-half">
        <p class="w3-margin-bottom">
            <label class="w3-label w3-darkcyan"><?php echo lang("SCREEN") ?></label>            
            <select class="w3-select live-status w3-text-grey " name="Screen">
                <option value=""><?php echo lang("CHOSE") ?></option>
                <option value="480 x  800">480 x  800</option>
                <option value="768 x 1024">768 x 1024</option>
                <option value="720 x 1280">720 x 1280</option>
                <option value="768 x 1280">768 x 1280</option>
                <option value="800 x 1280">800 x 1280</option>                
                <option value="750 x 1334">750 x 1334</option>
                <option value="1080 x 1920">1080 x 1920</option>                
                <option value="828 x 1792">828 x 1792</option>
                <option value="1536 x 2048">1536 x 2048</option>                
                <option value="1125 x 2436">1125 x 2436</option>
                <option value="1600 x  2560">1600 x  2560</option>                
                <option value="1242 x 2688">1242 x 2688</option> 
                <option value="2048 x 2732">2048 x 2732</option>

                
            </select>
        </p>
        </div>
        <div class="w3-half">
        <p class="w3-margin-bottom">
            <label class="w3-label w3-darkcyan"><?php echo lang("STORAGE") ?></label>            
            <select class="w3-select live-status w3-text-grey " name="capacity">
                <option value=""><?php echo lang("CHOSE") ?></option>
                <option value="1">1 GB</option> 
                <option value="2">2 GB</option> 
                <option value="4">4 GB</option> 
                <option value="8">8 GB</option> 
                <option value="16">16 GB</option>
                <option value="32">32 GB</option>
                <option value="64">64 GB</option>
                <option value="128">128 GB</option>
                <option value="256">256 GB</option>
                <option value="512">512 GB</option>  
                <option value="1024">1 TB</option>                 
            </select>
        </p> 
        </div>
        <div class="w3-half">
        <p class="w3-margin-bottom">
            <label class="w3-label w3-darkcyan"><?php echo lang("SIM-CARD") ?></label>            
            <select class="w3-select w3-text-grey " name="sim">
                <option value=""><?php echo lang("CHOSE") ?></option>
                <option value="1"><?php echo lang("UNIQUE-SIM") ?></option> 
                <option value="2"><?php echo lang("DUAL-SIM") ?></option> 
                
            </select>
        </p> 
        </div>         
      </div>
        <label class="w3-label w3-darkcyan">Camera</label>
    <div class="w3-row-padding">
        <div class="w3-half">
        <p><input class="w3-input w3-padding-16 w3-text-grey" type="text" placeholder="<?php echo lang("FRONT-CAMERA") ?>" name="front_camera" maxlength="50"></p>
        </div>
        <div class="w3-half">        
        <p><input class="w3-input w3-padding-16  w3-text-grey" type="text" placeholder="<?php echo lang("REAR-CAMERA") ?>" name="back_camera" maxlength="50"></p>
        </div>            
    </div>    
    <br>
    
    <div class="w3-row">      
         <p class="w3-darkcyan"><strong>Photos :</strong></p>        
    <div class="w3-half">        
            <div class="input-container2 w3-margin w3-white">
                <input type="file" id="file-input" required name="image" accept="image/*" >
                <div class="browse-btn">
                    <i class="fa fa-fw fa-image"></i>
                    <?php echo lang("MAIN-PHOTO") ?>
                </div>
                <span class="file-info"></span>
                
            </div>
            <div class="input-container2 w3-margin w3-white">
                <input type="file" id="file-input1" name="image1" accept="image/*">
                <div class="browse-btn1">
                    <i class="fa fa-fw fa-image"></i>
                    Photo 2
                </div>
                <span class="file-info1"></span>
            </div>
    </div>
    <div class="w3-half">        
        <div class="input-container2 w3-margin w3-white">
            <input type="file" id="file-input2" name="image2" accept="image/*">
            <div class="browse-btn2">
                <i class="fa fa-fw fa-image"></i>
                Photo 3
            </div>
            <span class="file-info2"></span>
        </div>
        <div class="input-container2 w3-margin w3-white">
            <input type="file" id="file-input3" name="image3" accept="image/*">
            <div class="browse-btn3">
                <i class="fa fa-fw fa-image"></i>
                Photo 4
            </div>
            <span class="file-info3"></span>
        </div>
    </div>    
   
</div>
        <div class="alert alert-danger w3-margin alert-photo"><?php echo lang("SELECT-PHOTO") ?></div>    
</div>
    <p class="w3-center">      
        <input id="newad" type="submit" class="w3-button w3-teal w3-padding-large w3-margin-top" value="<?php echo lang('PUB') ?>">  
      </p>
        
            </form>
    </div>

  <!-- End Contact Section -->
  </div>


    </div>

  
<?php

        include $tmp . 'footer.php';
            
        }

        else {
            
            header("location: login.php");
            exit();
        }

    ob_end_flush();
?> 
