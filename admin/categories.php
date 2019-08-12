<?php 
    ob_start();
     session_start();
        
        $title = "Dashboard";
        
        if(isset($_SESSION['user'])){
            
            include 'init.php';
            updatePercentage();
            $do = isset($_GET['do']) ? $_GET['do'] : 'manage'; 
            
?>            

            <div class="w3-main categories w3-container" style="margin-left:300px;margin-top:43px;">
                
<?php                

            if( $do == 'manage'){ 
            $sort = 'DESC';    
                
            $sortArray = array('ASC','DESC');
                
            if( isset($_GET['sort']) && in_array( $_GET['sort'], $sortArray) ){
                
             $sort = $_GET['sort'];   
                
            }    
                
            $stmt = $conn->prepare("SELECT * FROM category ORDER BY ordering $sort");
            $stmt-> execute();
            $rows = $stmt->fetchAll();
                
            ?>



                <div class="table-responsive w3-white w3-padding w3-margin-top ">    
                <h2 class="w3-center w3-text-dark-grey w3-margin"><?php echo lang("MANAGE-CATEGORIES") ?></h2>
                <div class="panel panel-default w3-card">
                
                <div class="panel-heading">
                    <div class="order-type pull-right" style="position:relative; top:10px;">
                        <a class = "w3-padding <?php if($sort == 'ASC'){ echo "active";} ?>" href="?sort=ASC"><i class="fa fa-arrow-up"></i><span class="w3-hide-small"> <?php echo lang("ASC") ?></span></a> |
                        <a class = "w3-padding <?php if($sort == 'DESC'){ echo "active";} ?>" href="?sort=DESC"><i class="fa fa-arrow-down"></i><span class="w3-hide-small"> <?php echo lang("DESC") ?></span></a>
                        
                    </div>
                    <h2><i class="fa fa-edit fa-xs"> </i><?php echo " " . lang("CAT-LIST") ?></h2>
                    
                        </div>
                    <div class="panel-body">
                    <?php 
                
                        foreach($rows as $row){
                            echo "<div class = 'cat w3-hover-light-grey'>";
                            
                                echo "<div class ='hidden-buttons'>";
                            
                                echo "<a href='categories.php?do=edit&catID=" . $row['catID'] . "' class = 'w3-padding w3-grey w3-text-white w3-hover-teal'><i class = 'fa fa-edit'></i>" ;
                                echo "</a>";
                                echo "<a href='categories.php?do=delete&catID=" . $row['catID'] . "' class = 'confirm w3-padding w3-grey w3-text-white w3-hover-red'><i class = 'fa fa-times'></i>" ;
                                echo "</a>";
                            
                                echo "</div>";
                            
                                echo "<h3><img class='w3-circle w3-margin' style='width:50px; height:50px' src='uploads/cat_images/" . $row["cat_image"] ."' >"  . $row["name"] . "</h3>";
                            
                                echo "<div class='full-view'>";
                                echo "<p>";
                                    if(empty(trim($row["description"]))){
                                    
                                        echo lang("NO-DESC");
                                    
                                        }
                                        else
                                        {
                                            echo $row["description"];     

                                        }
                                echo "</p>";
                            

                            
                            if($row["visibility"] == 1){
                                
                                echo "<span class='w3-text-dark-grey w3-large'>" . lang("VISIBLE") . " : <span><span><i class='fa fa-check w3-text-red'></i></span>";
                                
                            }
                            else
                            {
                                
                                echo "<span class='w3-text-dark-grey w3-large'>" . lang("VISIBLE") . " : <span><span><i class='fa fa-check w3-text-teal'></i></span>";                                
                                
                            }
                            
                            echo "<br>";
                            echo "<span>" . lang("ITEMS-NUM") . " : </span><span class='w3-text-teal'>" . countItems("*","items",true,"catID", $row["catID"]) ."</span>";
                            
                                
                          echo "</div>";
                              
                            echo "</div>";
                            echo "<hr>";
                            

                        }
                
                ?>
                        
                    
                    </div>
                    
                </div>
                    
                
                <a class = "add-category w3-button w3-teal w3-hover-text-white" style="text-decoration:none" href="?do=add"><i class="fa fa-plus"></i><?php echo "  " . lang("ADD-NEW-CATEGORY") ?></a>
                 
                
    
            </div>
   
            <?php    
                
            }
            
            else if($do == 'edit'){
                
                 // check if the user ID is a number
                
                $catID = isset($_GET['catID']) && is_numeric($_GET['catID']) ? intval($_GET['catID']):0 ;
                
                // Select data
                
                $stmt = $conn->prepare("SELECT * FROM category WHERE catID = ?");
                
                // execute query 
                
                $stmt->execute(array($catID));
                
                // Fetch the data 
                
                $row = $stmt->fetch();    
                $count = $stmt->rowCount();

                if($count > 0){


        ?>

                <div class="w3-container">
                <div class="w3-card w3-white w3-margin-top">    
                    <a href="categories.php" class="w3-button w3-teal w3-margin"><i class="fa fa-fw fa-arrow-left"></i></a>

                    <form class="form-horizontal w3-white " action="?do=update" method="post" enctype="multipart/form-data">
                        
                        <h3 class="w3-center w3-text-dark-grey"><?php echo lang('EDIT-CAT') ?></h3>
                        <input type="hidden" name="catID" value="<?php echo $catID ?>"> <!-- to get user's ID --> 
                        
                                            <!-- NAME -->
                            <p class="w3-margin-bottom">
                            <label class="w3-label w3-darkcyan"><?php echo lang('NAME')?></label>                                
                            <input type="text" name="name" class="w3-input w3-text-grey w3-margin-bottom" autocomplete="off" value="<?php if(!empty(trim($row["name"]))) echo $row['name']; else lang("DESC") ?>"  required="required">    
                            </p>
                                            <!-- DESCRIPTION -->
                            <p class="w3-margin-bottom">
                            <label class="w3-label w3-darkcyan"><?php echo lang('DESCRIPTION')?></label>                                 
                            <textarea rows="5" type="text" name="description" class="w3-input w3-text-grey"  ><?php if(empty(trim($row['description']))){
                                    echo lang("DESC-MSG");
                                        } else { echo $row['description']; } ?>                
                                </textarea>
                            </p>
        <div class="w3-row-padding">                       
                                            <!-- VISIBILITY-->
                        
            <div class="w3-half">   
                        <div class="w3-margin-bottom form-group form-group-lg w3-padding">
                            
                            <label class="w3-label w3-darkcyan w3-margin-bottom "><?php echo lang('VISIBLE') ?></label>
                            
                            <label for="yes-vis" class="label-container w3-text-grey w3-margin-left"><?php echo lang('YES') ?>
                              <input class="w3-input" id=yes-vis type="radio" name="visibility" value="0" <?php if($row["visibility"] == 0){ echo "checked"; } ?>>
                              <span class="checkmark"></span>
                            </label>

                            <label class="label-container w3-text-grey w3-margin-left"><?php echo lang('NO') ?>
                              <input  id=no-vis type="radio" name="visibility" value="1" class="w3-input" <?php if($row["visibility"] == 1){ echo "checked"; } ?>>
                              <span class="checkmark"></span>
                            </label>                             

                        </div>                      
            </div> 
            <div class="w3-half w3-margin-top w3-center">             
            <div class="input-container2 w3-margin w3-white w3-center">
                <input type="file" id="file-input" name="cat_image" accept="image/*" >
                <input type=hidden  name="old_image" value="<?php if(!empty(trim($row["cat_image"]))){ echo $row["cat_image"]; } ?>" >
                <div class="browse-btn">
                    Image
                </div>
                <span class="file-info"><?php if(!empty(trim($row["cat_image"]))){ echo $row["cat_image"]; } ?></span>
            </div>  
            </div>                         
                        </div>                        
                                            <!-- SAVE -->     
                        <input type="submit"  class="w3-button w3-teal w3-padding-large w3-margin-top" value="<?php echo lang('SAVE') ?>">  
                    
                    
                    
                    </form>
                    
</div>
                </div>
                
                <?php
            
                }
                else
                {
                    $message = "<div class='alert alert-danger'>" . lang("CAT-EXIST") . "</div>";;
                    echo "<div class = 'container'>";
                    redirection($message);
                    echo "</div>";    
                    
                }
                
                
            }
            
            else if($do =='update'){
                
                echo "<div class='w3-container'>";
                
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    
                    
                    // Get the variables from the form
                    
                    $catID = $_POST["catID"];
                    $name = $_POST["name"];
                    $description = $_POST["description"];
                    $visibility = $_POST["visibility"];
                    echo $_POST["old_image"];
                    
                    $picName = $_FILES["cat_image"]["name"];
                    $picSize = $_FILES["cat_image"]["size"];
                    $picTmp = $_FILES["cat_image"]["tmp_name"];
                    $picType = $_FILES["cat_image"]["type"];                    
                    // Validation
                    
                    $allowedExt = array("jpeg","png","jpg","");
                    $avExt = explode(".",$picName);
                    
                    $extension = strtolower(end($avExt));  
                    
                  
                    
                    $formErrors = array();
                    
                    if(strlen($name) < 2 || empty(trim($name))) $formErrors[] = lang('CATEGORY-NAME-ERROR') ;
                    
                    if(strlen($name) > 30) $formErrors[] = lang('CATEGORY-NAME-ERROR1') ;

                    if(empty(trim($_FILES["cat_image"]["name"])) && !(in_array($extension, $allowedExt))){
                
                        $formErrors[] = lang("NOT-ALLOWED-EXT");
                
                    }
            
                    if($picSize > 4194304) lang("BIG-SIZE");
                                      
                    
                    foreach ($formErrors as $error){
                        
                        echo "<div class='alert-msg w3-card w3-text-white'>" . $error . "</div>"  ;
                        
                    }
                    
                    // Update 
                    
                    if(empty($formErrors)){
                        
                    if(isset($_FILES["cat_image"]["name"]) && !empty($_FILES["cat_image"]["name"])){    
                    $image = rand(0,100000) . "_" . $picName ;
                    }
                    else
                    $image = $_POST["old_image"] ;   
                    
                    move_uploaded_file($picTmp, "uploads/cat_images/" . $image) ;  
                                            
                        
                    $stmt2 = $conn->prepare("SELECT name FROM category WHERE name = ? AND catID != ?");
                    $stmt2->execute(array($name,$catID));
                    $cpt = $stmt2->rowCount();
                    if($cpt == 0){       
                    
                    $stmt = $conn->prepare("UPDATE category SET name = ?, description = ?, visibility = ?, cat_image = ? WHERE catID = ?");
                    $stmt->execute(array($name, $description, $visibility, $image, $catID));
                    
                    header("location:categories.php");
                    exit();
                    }
                        else {
                            $message = "<div class='alert-msg w3-text-white'>" . lang("CAT-EXIST") . "</div>"; 
                            redirection($message, 'back');
                        }
                    }
                        
                }
                else{
                    
                    $message = "<div class='alert-msg w3-card'>" . lang("ILLEGAL-BROWSING") . "</div>";
                    redirection($message,5);
                    
                }
                
                
            }
            
            else if($do == 'add'){
                
                ?>
                
                
                <div class="w3-container">

                    <form class="form-horizontal w3-card w3-white w3-margin-top" action="?do=insert" method="post" enctype="multipart/form-data">
                        
                        <h3 class="w3-center w3-text-dark-grey"><i class="fa fa-fw fa-list-alt"></i><?php echo lang('ADD-CATEGORY') ?></h3>
                        <input type="hidden" name="catID" value="<?php echo $catID ?>"> <!-- to get user's ID --> 
                        
                                            <!-- NAME -->
                            <p class="w3-margin-bottom">
                                <label class="w3-label w3-darkcyan"><?php echo lang('NAME')?> <span class="w3-text-red">*</span></label>                                
                                <input id="brand" type="text" name="name" class="w3-input w3-text-grey w3-margin-bottom" autocomplete="off"  required="required">
                                
                            </p>
                        <div class="alert alert-danger alert-brand w3-center"><?php echo lang('CATEGORY-NAME-ERROR') ?></div>
                        
                                            <!-- DESCRIPTION -->
                        
                            <p class="w3-margin-bottom">
                            <label class="w3-label w3-darkcyan"><?php echo lang('DESCRIPTION')?></label>                                 
                            <textarea rows="5" type="text" name="description" class="w3-input w3-text-grey">              
                                </textarea>
                            </p>
              
                        
                        <div class="w3-row-padding"> 
                            
                                            <!-- VISIBILITY-->
                        
                            <div class="w3-half">   
                                        <div class="w3-margin-bottom form-group form-group-lg w3-padding">

                                            <label class="w3-label w3-darkcyan w3-margin-bottom "><?php echo lang('VISIBLE') ?></label>

                                            <label for="yes-vis" class="label-container w3-text-grey w3-margin-left"><?php echo lang('YES') ?>
                                              <input class="w3-input" checked id=yes-vis type="radio" name="visibility" value="0">
                                              <span class="checkmark"></span>
                                            </label>

                                            <label class="label-container w3-text-grey w3-margin-left"><?php echo lang('NO') ?>
                                              <input  id=no-vis type="radio" name="visibility" value="1" class="w3-input" >
                                              <span class="checkmark"></span>
                                            </label>                             

                                        </div>                      
                            </div> 
                            <div class="w3-half w3-margin-top w3-center">             
                                <div class="input-container2 w3-margin w3-white w3-center">
                                    <input type="file" id="file-input" required name="cat_image" accept="image/*" >
                                    <div class="browse-btn">
                                        Photo
                                    </div>
                                    <span class="file-info"></span>
                                </div>
                            <div class="alert alert-danger alert-photo w3-center"><?php echo lang('SELECT-PHOTO') ?></div>                                
                            </div>                         
                        </div>                        
                                            <!-- SAVE --> 
                        <p class="w3-center">
                        <input id="newbrand" type="submit"  class="w3-button w3-teal w3-padding-large w3-margin-top w3-center" value="<?php echo lang('ADD') ?>">  
                        </p>
                    
                    </form>
                    

                </div>
                
                
    <?php            
            }
            
            else if($do == 'insert'){
                
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                    echo "<div class='w3-container'>";
                    
                    // Get the variables from the form
                    
                    $name = $_POST["name"];
                    $description = $_POST["description"];
                    $visibility = $_POST["visibility"];
                    
                    $picName = $_FILES["cat_image"]["name"];
                    $picSize = $_FILES["cat_image"]["size"];
                    $picTmp = $_FILES["cat_image"]["tmp_name"];
                    $picType = $_FILES["cat_image"]["type"];                    
                    // Validation
                    
                    $allowedExt = array("jpeg","png","jpg");
                    $avExt = explode(".",$picName);
                    
                    $extension = strtolower(end($avExt));  
                    
                    // Validation
                    
                    $formErrors = array();
                    
                    if(strlen($name) < 2 || empty(trim($name)) || strlen($name) > 30) $formErrors[] = lang('CATEGORY-NAME-ERROR') ;
                    
                  if(empty(trim($_FILES["cat_image"]["name"])) && !(in_array($extension, $allowedExt))){
                
                        $formErrors[] = lang("NOT-ALLOWED-EXT");
                
                    }
            
                    if($picSize > 4194304) lang("BIG-SIZE");
                                                                            
                    
                    foreach ($formErrors as $error){
                        
                        $message = "<div class='alert-msg w3-center'>" . $error . "</div>"  ;
                        redirection($message,'back',5); 
                    }
                    
                    // Update 
                    
                    if(empty($formErrors)){
                        
                    $check = checkItem("name","category",$name);
                        
                    if($check == 0){
                        
                    $image = rand(0,100000) . "_" . $picName ;
                    
                    move_uploaded_file($picTmp, "uploads/cat_images/" . $image) ;      
                    
                    $stmt = $conn->prepare("INSERT INTO category(name, description, ordering, visibility, cat_image) VALUES (:zname, :zdescription, 0 , :zvisibility, :zimage)");
                    $stmt->execute(array(
                        "zname" => $name,
                        "zdescription" => $description,
                        "zvisibility" => $visibility,
                        "zimage" => $image
                    ));
                    
                    header("location:categories.php");
                    exit();    
                        
                    }
                        else{
                            
                        $message = "<div class='alert-msg w3-center'>" . lang("CATEGORY-EXIST") . "</div>";
                        redirection($message,'back');      
                            
                        }
                    }
                    
                    echo "</div>";
                }
                
                else{
                    $message = "<div class='alert-msg w3-center'>" . lang("ILLEGAL-BROWSING") . "</div>";
                    redirection($message,5);
                    
                }
                    
                    echo "</div>";
                
                
            }
            
            else if($do == 'delete'){
                
                // check if the category ID is a number
                
                $catID = isset($_GET['catID']) && is_numeric($_GET['catID']) ? intval($_GET['catID']):0 ;
                
                // Select data
                
                
                $count = checkItem('catID','category',$catID);
                
                echo "<div class='w3-container'>";

                if($count > 0){
                    
                    $stmt = $conn->prepare("DELETE FROM category WHERE catID = :zcat"); // to avoid SQL injection
                    $stmt->bindParam(":zcat",$catID);
                    $stmt->execute();
                    
                    header("location:categories.php");
                    exit();
                    
                }
                else
                {
                    $message = "<div class='alert-msg'>" . lang("ILLEGAL-BROWSING") . "</div>";
                    redirection($message,5);
                    
                }
                
                echo "</div>";
                
                
            }
            
            echo "</div>";
            
        include $tmp . 'footer.php';
            
        }
        
                
        else{
            
            header('location: login.php');
            exit();
            
            
        }

    ob_end_flush();
?>