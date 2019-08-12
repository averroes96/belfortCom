<?php
        session_start();

        $title = "Edit ad";

        include 'init.php';
    

        $itemID = isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']):0 ;

                // Select data
                
                $stmt = $conn->prepare("SELECT * FROM items WHERE itemID = ? AND userID = ?");
                
                // execute query 
                
                $stmt->execute(array($itemID,$_SESSION["id"]));
                
                // Fetch the data 
                
                $row = $stmt->fetch();    
                $count = $stmt->rowCount();

                if($count > 0 && isset($_SERVER["HTTP_REFERER"])){

        if(isset($_SESSION["username"]) == $row["userID"]){
            
            if($_SERVER["REQUEST_METHOD"] == "POST"){
            
            $formErrors = array();
            
            $name = filter_var($_POST["item_name"],FILTER_SANITIZE_STRING);
            $desc = filter_var($_POST["description"],FILTER_SANITIZE_STRING);
            $price = filter_var($_POST["price"],FILTER_SANITIZE_NUMBER_INT);
            $wilaya = filter_var($_POST["wilaya"],FILTER_SANITIZE_STRING);
            $status = filter_var($_POST["status"],FILTER_SANITIZE_NUMBER_INT);
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
                
                
                $allowedExt = array("jpeg","png","jpg","");
                $avExt = explode(".",$picName);
                $avExt1 = explode(".",$picName1);
                $avExt2 = explode(".",$picName2);
                $avExt3 = explode(".",$picName3);
                
                $extension = strtolower(end($avExt));
                $extension1 = strtolower(end($avExt1));
                $extension2 = strtolower(end($avExt1));
                $extension3 = strtolower(end($avExt2));
            
                if(strlen($name) < 3 || empty(trim($name))) $formErrors[] = lang('AD-NAME-ERROR') ;
                    
                if(strlen($name) > 50) $formErrors[] = lang('AD-NAME-ERROR1') ;
            
                if(empty($price)) $formErrors[] = lang('AD-NAME-ERROR2') ;
            
                if($price <= 0) $formErrors[] = lang('AD-NAME-ERROR2') ;
            
                    if(empty(trim($_FILES["image"]["name"])) && !(in_array($extension, $allowedExt))){
                
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
            
                    if($picSize3 > 4194304) $formErrors[] = lang("BIG-SIZE");                
                    
                
                if(empty($formErrors)){
                    
                    
                    $image1 = "";
                    $image2 = "";
                    $image3 = "";
                    
                if(!empty($picName)){    
                    $image = rand(0,100000) . "_" . $picName ;
                    
                    move_uploaded_file($picTmp, "uploads/items_images/" . $image) ;
                }
                    else{
                        $image = $row["image"];
                        move_uploaded_file($picTmp, "uploads/items_images/" . $image) ;                        
                    }
                    
                    if(!empty(trim($picName1))){
                        
                    $image1 = rand(0,100000) . "_" . $picName1 ;
                    
                    move_uploaded_file($picTmp1, "uploads/items_images/" . $image1) ;                        
            
                    }
                    else if(!empty(trim($_POST["current_image_1"])))
                    {
                        $image1 = $row["image1"];
                        move_uploaded_file($picTmp1, "uploads/items_images/" . $image1) ;                        
                    }
                    else
                    {
                        move_uploaded_file($picTmp1, "uploads/items_images/" . $image1) ;  
                    }
                    
                    if(!empty(trim($picName2))){
                        
                    $image2 = rand(0,100000) . "_" . $picName2 ;
                    
                    move_uploaded_file($picTmp2, "uploads/items_images/" . $image2) ;                        
            
                    }
                    else if(!empty(trim($_POST["current_image_2"])))
                    {
                        $image2 = $row["image2"];
                        move_uploaded_file($picTmp2, "uploads/items_images/" . $image2) ;                        
                    }
                    else
                    {
                        move_uploaded_file($picTmp2, "uploads/items_images/" . $image2) ;  
                    }                    
                    
                    if(!empty(trim($picName3))){
                        
                    $image3 = rand(0,100000) . "_" . $picName3 ;
                    
                    move_uploaded_file($picTmp3, "uploads/items_images/" . $image3) ;                        
            
                    }
                    else if(!empty(trim($_POST["current_image_3"])))
                    {
                        $image2 = $row["image3"];
                        move_uploaded_file($picTmp2, "uploads/items_images/" . $image3) ;                        
                    }
                    else
                    {
                        move_uploaded_file($picTmp3, "uploads/items_images/" . $image3) ;  
                    }                       

                    $stmt = $conn->prepare("UPDATE items SET item_name = ?, item_description = ?, price = ?, wilaya = ?, image = ?, image1 = ?, image2 = ?, image3 = ?,status = ?, tags = ?, type = ?, RAM = ?, CPU = ?, Capacity = ?, Screen = ?, front_camera = ?, back_camera = ?, OS = ?, catID = ? WHERE itemID = ? ");
                    $stmt->execute(array($name,$desc,$price,$wilaya,$image,$image1,$image2,$image3,$status,$tags,$type,$ram,$cpu,$capacity,$screen,$front_camera,$rear_camera,$os,$catID,$itemID));
            
                    if($stmt){
                    header("location:showAd.php?itemID=".$itemID);
                    exit();
                            }
                    }
                    
                
            }

       ?>
<div class="w3-container w3-content" style="margin-top:40px">
<div class="w3-card w3-round w3-white w3-main w3-margin-bottom w3-padding" style="margin-top:32px" >
    <h3 class="w3-text-dark-grey w3-padding"><i class="fa fa-tablet-alt"></i> <?php echo lang("NEW-AD") ?>
    <a style="padding: 4px 16px;" href="<?php if(isset($_SERVER["HTTP_REFERER"])){ echo $_SERVER["HTTP_REFERER"]; } else{ ?>categories.php <?php } ?>" class="w3-button w3-teal w3-right"><i class="fa fa-fw fa-arrow-left"></i></a>
    </h3>

    <hr>
<div class="w3-row-padding w3-margin w3-light-grey w3-card">
    
    <form action="<?php echo $_SERVER["PHP_SELF"] . "?itemID=" . $itemID ?>" method="post" enctype="multipart/form-data" id="edit_form">    
<div class="w3-half w3-padding w3-round ">
    <p class="w3-text-red"><?php echo lang("FILL-INFO") ?> !</p>

        <div class="input-container">
            <p>
              <input id="adname" class="w3-input w3-padding-16" type="text" value="<?php if(!empty(trim($row["item_name"]))) echo $row["item_name"] ; ?>" placeholder="<?php echo lang('NAME-AD') ?>" required name="item_name" maxlength="50">
            </p>
            <div class="alert alert-danger w3-margin alert-adname"><?php echo lang("AD-NAME-ERROR") ?></div>            
        </div>
        
    <p><textarea rows="5" class="w3-input w3-padding-16" name="description" maxlength="800" placeholder="<?php echo lang("DESC-MSG") ?>" ><?php if(!empty(trim($row["item_description"]))) echo $row["item_description"] ; ?></textarea></p>
        
        <div class="input-container">
            <p>
              <input id="price" class="w3-input w3-padding-16  w3-margin-bottom" value="<?php if(!empty(trim($row["price"]))) echo $row["price"] ; ?>" placeholder="<?php echo lang("PRICE") ?>" required type="number" name="price">
            </p>
            <div class="alert alert-danger w3-margin alert-price"><?php echo lang("AD-NAME-ERROR2") ?></div>             
        </div>
<div class="w3-row-padding">
    <div class="w3-half ">
                <!-- WILAYA -->        
      <p class="w3-margin-bottom">
        <label class="w3-label w3-darkcyan"><?php echo lang('WILAYA') ?></label>          
          <select class="w3-select  w3-text-grey" name="wilaya" required>
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
                <!-- STATUS -->
        <p class="w3-margin-bottom">
            <label class="w3-label w3-darkcyan"><?php echo lang('STATUS')?></label>            
            <select class="w3-select w3-text-grey " name="status">
                <option value="5" <?php if($row["status"] == 5){ echo "selected"; } ?>>5 <?php echo "'" . lang("VERY-GOOD") . "'" ?></option>
                <option value="4" <?php if($row["status"] == 4){ echo "selected"; } ?>>4 <?php echo "'" .lang("GOOD"). "'" ?></option> 
                <option value="3" <?php if($row["status"] == 3){ echo "selected"; } ?>>3 <?php echo "'" .lang("NORMAL"). "'" ?></option> 
                <option value="2" <?php if($row["status"] == 2){ echo "selected"; } ?>>2 <?php echo "'" .lang("OLD"). "'" ?></option> 
                <option value="1" <?php if($row["status"] == 1){ echo "selected"; } ?>>1 <?php echo "'" .lang("DAMAGED"). "'" ?></option> 

            </select>
        </p>
    </div>
    <div class="w3-half">
                <!-- CATEGORY -->        
        <p class="w3-margin-bottom">
            <label class="w3-label w3-darkcyan"><?php echo lang('NAME') ?></label>
            <select class="w3-select w3-text-grey" name="catID" required>

                <?php
                    $stmt1 = $conn->prepare("SELECT * FROM category WHERE visibility = 0");
                    $stmt1->execute();
                    $cats = $stmt1->fetchAll();

                    foreach($cats as $cat){
                        
                            echo "<option value = '" . $cat["catID"] . "'";
                                if($row["catID"] == $cat["catID"]){ echo "selected" ; };
                                    echo ">" . $cat["name"] . "</option>" ;
                                           

                                        }

                    ?>

            </select>
        </p>
    
                <!-- TYPE -->
        <p class="w3-margin-bottom">
            <label class="w3-label w3-darkcyan">Type</label>            
            <select class="w3-select  w3-text-grey " required name="type">
                <option value="0" <?php if($row["type"] == 0){ echo "selected"; } ?>>Telephone</option>
                <option value="1" <?php if($row["type"] == 1){ echo "selected"; } ?>><?php echo lang("TABLET") ?></option> 

            </select>
        </p>
        </div>
</div>
    <br>
        <p class="w3-center" >
          <input type="text" name="tags" class="w3-input w3-padding-16" value="<?php if(!empty(trim($row["tags"]))) echo $row["tags"] ; ?>" placeholder="<?php echo lang("TAGS") ?>">
        </p> 

</div>

    
<div class="w3-half w3-margin-bottom w3-padding">
    
         <p class="w3-darkcyan"><strong><?php echo lang("CHARACTERISTICS") . " : "  ?></strong></p>
    <p><input class="w3-input w3-padding-16" type="text" placeholder="CPU" name="CPU" maxlength="50" value="<?php  if(!empty(trim($row["CPU"]))) echo $row["CPU"] ?>"></p>    
    <p><input class="w3-input w3-padding-16" type="text" value="<?php  if(!empty(trim($row["OS"]))) echo $row["OS"] ?>" placeholder="<?php echo lang("OS")  ?>" name="OS" maxlength="27"></p>
    <br/>
    <div class="w3-row-padding">
        <div class="w3-third">
        <p class="w3-margin-bottom">
            <label class="w3-label w3-darkcyan">RAM</label>            
            <select class="w3-select w3-text-grey " name="RAM">
                <option value=""></option>                
                <option value="1" <?php if($row["RAM"] == 1){ echo "selected"; } ?>>1 GB</option>
                <option value="2" <?php if($row["RAM"] == 2){ echo "selected"; } ?>>2 GB</option> 
                <option value="4" <?php if($row["RAM"] == 4){ echo "selected"; } ?>>4 GB</option> 
                <option value="6" <?php if($row["RAM"] == 6){ echo "selected"; } ?>>6 GB</option> 
                <option value="8" <?php if($row["RAM"] == 8){ echo "selected"; } ?>>8 GB</option> 

            </select>
        </p>
        </div>
        <div class="w3-third">
        <p class="w3-margin-bottom">
            <label class="w3-label w3-darkcyan"><?php echo lang("SCREEN") ?></label>            
            <select class="w3-select  w3-text-grey " name="Screen">
                <option value=""></option>
                <option value="828 x 1792" <?php if($row["Screen"] == "828 x 1792"){ echo "selected"; } ?>>828 x 1792</option> 
                <option value="1125 x 2436" <?php if($row["Screen"] == "1125 x 2436"){ echo "selected"; } ?>>1125 x 2436</option> 
                <option value="1242 x 2688" <?php if($row["Screen"] == "1242 x 2688"){ echo "selected"; } ?>>1242 x 2688</option> 
                <option value="1080 x 1920" <?php if($row["Screen"] == "1080 x 1920"){ echo "selected"; } ?>>1080 x 1920</option> 
                <option value="750 x 1334" <?php if($row["Screen"] == "750 x 1334"){ echo "selected"; } ?>>750 x 1334</option>
                <option value="2048 x 2732" <?php if($row["Screen"] == "2048 x 2732"){ echo "selected"; } ?>>2048 x 2732</option>
                <option value="1536 x 2048" <?php if($row["Screen"] == "1536 x 2048"){ echo "selected"; } ?>>1536 x 2048</option>
                <option value="768 x 1024" <?php if($row["Screen"] == "768 x 1024"){ echo "selected"; } ?>>768 x 1024</option>              
            </select>
        </p>
        </div>
        <div class="w3-third">
        <p class="w3-margin-bottom">
            <label class="w3-label w3-darkcyan"><?php echo lang("STORAGE") ?></label>            
            <select class="w3-select  w3-text-grey " name="capacity">
                <option value=""></option>
                <option value="1" <?php if($row["Capacity"] == 1){ echo "selected"; } ?>>1 GB</option> 
                <option value="2" <?php if($row["Capacity"] == 2){ echo "selected"; } ?>>2 GB</option> 
                <option value="4" <?php if($row["Capacity"] == 4){ echo "selected"; } ?>>4 GB</option> 
                <option value="8" <?php if($row["Capacity"] == 8){ echo "selected"; } ?>>8 GB</option> 
                <option value="16" <?php if($row["Capacity"] == 16){ echo "selected"; } ?>>16 GB</option>
                <option value="32" <?php if($row["Capacity"] == 32){ echo "selected"; } ?>>32 GB</option>
                <option value="64" <?php if($row["Capacity"] == 64){ echo "selected"; } ?>>64 GB</option>
                <option value="128" <?php if($row["Capacity"] == 128){ echo "selected"; } ?>>128 GB</option>
                <option value="256" <?php if($row["Capacity"] == 256){ echo "selected"; } ?>>256 GB</option>
                <option value="512" <?php if($row["Capacity"] == 512){ echo "selected"; } ?>>512 GB</option>  
                <option value="1024" <?php if($row["Capacity"] == 1024){ echo "selected"; } ?>>1 TB</option>                 
            </select>
        </p> 
        </div>    
      </div>
        <label class="w3-label w3-darkcyan">Camera</label>
    <div class="w3-row-padding">
        <div class="w3-half">
        <p><input class="w3-input w3-padding-16 " type="text" placeholder="Front camera" name="front_camera" maxlength="50" value="<?php  if(!empty(trim($row["front_camera"]))) echo $row["front_camera"] ?>"></p>
        </div>
        <div class="w3-half">        
        <p><input class="w3-input w3-padding-16 " type="text" placeholder="Back camera" name="back_camera" maxlength="50" value="<?php  if(!empty(trim($row["back_camera"]))) echo $row["back_camera"] ?>"></p>
        </div>            
    </div>    
    <br>
    
    <div class="w3-row">
         <p class="w3-darkcyan"><strong>Images :</strong></p>        
    <div class="w3-half">        
            <div class="input-container2 w3-white w3-center">
                <input type="file" id="file-input" name="image" accept="image/*"  >
                <div class="browse-btn">
                    <?php echo lang("MAIN-PHOTO")   ?>
                </div>
                <span class="file-info"><?php  if(!empty(trim($row["image"]))) echo $row["image"] ?></span>
                
            </div>
            <div class="input-container2 w3-white w3-center w3-margin-top">
                
                <input type="file" id="file-input1" name="image1" accept="image/*">
                <div class="browse-btn1">
                    Photot 2                    
                </div>
                <span class="file-info1"><?php  if(!empty(trim($row["image1"]))) echo $row["image1"] ?>
                </span>
                <input type="hidden" id="hidden_input1" name="current_image_1" value=""><br>                
                <span class="remove1 w3-red w3-button w3-circle" <?php if(empty($row["image1"])) echo "style='display:none'" ?> ><i class="fa fa-times"></i></span>                
            </div>
        
 

    </div>
    <div class="w3-half">     
        <div class="input-container2 w3-white w3-center">
            <input type="file" id="file-input2" name="image2" accept="image/*">
            <div class="browse-btn2">
                Photo 3
            </div>
            <span class="file-info2"><?php  if(!empty(trim($row["image2"]))) echo $row["image2"] ?></span>
                <input type="hidden" id="hidden_input2" name="current_image_2" value=""><br>
                <span class="remove2 w3-red w3-button w3-circle" <?php if(empty($row["image2"])) echo "style='display:none'" ?>><i class="fa fa-times"></i></span>            
        </div>
        
        <div class="input-container2 w3-margin-top w3-white w3-center">
            <input type="file" id="file-input3" name="image3" accept="image/*">
            <div class="browse-btn3">
                Photo 4
            </div>
            <span class="file-info3"><?php  if(!empty(trim($row["image3"]))) echo $row["image3"] ?></span>
                <input type="hidden" id="hidden_input3" name="current_image_3" value=""><br>
                <span class="remove3 w3-red w3-button w3-circle" <?php if(empty($row["image3"])) echo "style='display:none'" ?>><i class="fa fa-times"></i></span>            
        </div>        
    </div> 
        
   
</div> 
</div>
    <p class="w3-center">      
        <input type="submit" class="w3-button w3-teal w3-padding-large w3-margin-top" value="<?php echo lang('SAVE') ?>">  
      </p>
        
            </form>
    </div>
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
            
    ?>
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
                } 
    else {
        
            header("location: main.php");
            exit();        
        
    }


?> 
