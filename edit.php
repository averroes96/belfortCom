<?php

    $title = "Edit";
    session_start();

    include "init.php";

    if(isset($_SESSION["id"])){
        
    $edit = $_GET['e'];    

    if($edit == "comment"){
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){           
           
            $comID = $_POST["comID"];
            $content = filter_var($_POST["content"],FILTER_SANITIZE_STRING);
            
            $info = getAllFrom("*","comments","WHERE comID = $comID AND userID = " . $_SESSION["id"] );
            
            if(!empty(trim($content))){
            
               $stmt = $conn->prepare("UPDATE comments SET content = '$content' WHERE comID = $comID");
               $stmt->execute();
                
           if($stmt){

               header("location:showAd.php?itemID=" . $info[0]["itemID"]);
               exit();
               
           }
           else 
               echo "DATABASE ERROR !";                
                
            }
            else {
                
                $error = lang("COM-EMPTY");
            }
            
        }         
        
        
        
                
    $comID = isset($_GET['comID']) && is_numeric($_GET['comID']) ? intval($_GET['comID']):0 ;
        
    $info = getAllFrom("*","comments","WHERE comID = $comID AND userID = " . $_SESSION["id"] );
        
    if(count($info) > 0){   
    
?>

    <div class="w3-container w3-content" style="margin-top: 40px; min-height: -webkit-fill-available;">
        <div class="w3-card w3-padding w3-white w3-center" style="width:400; margin: 20px 40px">
<?php
        if(isset($error)){  ?>
            
            <div class="w3-container">
                <span onclick='this.parentElement.style.display="none"' class="close-btn"><i class="fa fa-times w3-text-white"></i></span>
                <p class="alert-msg"><?php echo $error ?></p>
            
            </div>
            
<?php            
        }
            ?>
            
            <form action="edit.php?e=comment&comID=<?php echo $info[0]["comID"] ?>" method="post">
                <input type="hidden" value="<?php echo $info[0]["comID"] ?>" name="comID">
                <textarea required name="content" rows="5" class="w3-textarea w3-input w3-margin-bottom w3-hover-light-grey"><?php echo $info[0]["content"] ?></textarea>
                <div class="w3-row">
                    <div class="w3-half w3-margin-bottom">    
                        <button class="w3-button w3-teal w3-left " type="submit"><i class="fa fa-fw fa-edit"></i><?php echo lang("EDIT2") ?></button>
                    </div>
                    <div class="w3-half">
                        <a href="showAd.php?itemID=<?php echo $info[0]["itemID"] ?>" class="w3-button w3-red w3-hide-large w3-hide-medium w3-left"><i class="fa fa-fw fa-times"></i><?php echo lang("CANCEL") ?></a>                    
                        <a href="showAd.php?itemID=<?php echo $info[0]["itemID"] ?>" class="w3-button w3-red w3-right w3-hide-small"><i class="fa fa-fw fa-times"></i><?php echo lang("CANCEL") ?></a>
                    </div>                    

                </div>
            </form>
        
        </div>


    </div>

<?php
        
    } 
        else {
            
        header("location:main.php");
        exit();             
            
        }
    }
        
    else if($edit == "reply"){
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){           
           
            $repID = $_POST["repID"];
            $content = filter_var($_POST["rep_content"],FILTER_SANITIZE_STRING);
            
            $info = getAllFrom("*","reply","WHERE repID = $repID AND userID = " . $_SESSION["id"] );
            
            if(!empty(trim($content))){
            
               $stmt = $conn->prepare("UPDATE reply SET rep_content = '$content' WHERE repID = $repID");
               $stmt->execute();
                
           if($stmt){

               header("location:subject.php?subID=" . $info[0]["subID"]);
               exit();
               
           }
           else 
               echo "DATABASE ERROR !";                
                
            }
            else {
                
                $error = lang("COM-EMPTY");
            }
            
        }         
        
        
        
                
    $repID = isset($_GET['repID']) && is_numeric($_GET['repID']) ? intval($_GET['repID']):0 ;
        
    $info = getAllFrom("*","reply","WHERE repID = $repID AND userID = " . $_SESSION["id"] );
        
    if(count($info) > 0){   
    
?>

    <div class="w3-container w3-content" style="margin-top: 40px; min-height: -webkit-fill-available;">
        <div class="w3-card w3-padding w3-white w3-center" style="width:400; margin: 20px 40px">
<?php
        if(isset($error)){  ?>
            
            <div class="w3-container">
                <span onclick='this.parentElement.style.display="none"' class="close-btn"><i class="fa fa-times w3-text-white"></i></span>
                <p class="alert-msg"><?php echo $error ?></p>
            
            </div>
            
<?php            
        }
            ?>
            
            <form action="edit.php?e=reply&repID=<?php echo $info[0]["repID"] ?>" method="post">
                <input type="hidden" value="<?php echo $info[0]["repID"] ?>" name="repID">
                <textarea required  name="rep_content" rows="5" class="w3-textarea w3-input w3-margin-bottom w3-hover-light-grey"><?php echo $info[0]["rep_content"] ?></textarea>
                <div class="w3-row">
                    <div class="w3-half w3-margin-bottom">    
                        <button class="w3-button w3-teal w3-left " type="submit"><i class="fa fa-fw fa-edit"></i><?php echo lang("EDIT2") ?></button>
                    </div>
                    <div class="w3-half">
                        <a href="subject.php?subID=<?php echo $info[0]["subID"] ?>" class="w3-button w3-red w3-hide-large w3-hide-medium w3-left"><i class="fa fa-fw fa-times"></i><?php echo lang("CANCEL") ?></a>                    
                        <a href="subject.php?subID=<?php echo $info[0]["subID"] ?>" class="w3-button w3-red w3-right w3-hide-small"><i class="fa fa-fw fa-times"></i><?php echo lang("CANCEL") ?></a>
                    </div>                    

                </div>
            </form>
        
        </div>


    </div>

<?php
        
    }
        else {
            
        header("location:main.php");
        exit();             
            
        }
    }
        
    else if($edit == "subject"){
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){           
           
            $subID = $_POST["subID"];
            $content = filter_var($_POST["sub_content"],FILTER_SANITIZE_STRING);
            $title = filter_var($_POST["title"],FILTER_SANITIZE_STRING);
            $type = filter_var($_POST["type"],FILTER_SANITIZE_STRING);            
            
            $info = getAllFrom("*","subject","WHERE subID = $subID AND userID = " . $_SESSION["id"] );
            
            if(!empty(trim($content))){
            
               $stmt = $conn->prepare("UPDATE subject SET sub_content = '$content', title = '$title', sub_type = '$type' WHERE subID = $subID");
               $stmt->execute();
                
           if($stmt){

               header("location:subject.php?subID=" . $info[0]["subID"]);
               exit();
               
           }
           else 
               echo "DATABASE ERROR !";                
                
            }
            else {
                
                $error = lang("COM-EMPTY");
            }
            
        }         
        

            $subID = isset($_GET['subID']) && is_numeric($_GET['subID']) ? intval($_GET['subID']):0 ;
        
            $info = getAllFrom("*","subject","WHERE subID = $subID AND userID = " . $_SESSION["id"] );
        
    if(count($info) > 0){   
    
?>

    <div class="w3-container w3-content" style="margin-top: 40px; min-height: -webkit-fill-available;">
        <div class="w3-card w3-padding w3-white">
<?php
        if(isset($error)){  ?>
            
            <div class="w3-container">
                <span onclick='this.parentElement.style.display="none"' class="close-btn"><i class="fa fa-times w3-text-white"></i></span>
                <p class="alert-msg"><?php echo $error ?></p>
            
            </div>
            
<?php            
        }
            ?>
            
            <form action="edit.php?e=subject&subID=<?php echo $info[0]["subID"] ?>" method="post">
                <input type="hidden" value="<?php echo $info[0]["subID"] ?>" name="subID">
            <p class="w3-margin-bottom">
                <label class="w3-label w3-darkcyan"><?php echo lang("TITLE") ?></label>
                <div class="input-container">    
                <input value="<?php echo $info[0]["title"] ?>" class="w3-input w3-text-grey w3-margin-bottom" type="text" name="title" required>
                </div>    
            </p>
            <br>
            <label class="w3-label w3-darkcyan w3-margin-bottom">Type</label>  

            <label class="label-container w3-margin-bottom w3-text-grey"><span class='w3-blue w3-round' style="position : relative; left: 35px; padding: 8px">Recommendation</span>
              <input type="radio" name="type" value="Recommendation" <?php if($info[0]["sub_type"] == "Recommendation") echo "checked" ?> >
              <span class="checkmark w3-blue w3-circle"></span>
            </label>

            <label class="label-container w3-margin-bottom w3-text-grey"><span class='w3-green w3-round' style="position : relative; left: 35px; padding: 8px"><?php echo lang("HELP") ?></span>
              <input type="radio" name="type" value="Help" <?php if($info[0]["sub_type"] == "Help") echo "checked" ?> >
              <span class="checkmark w3-green w3-circle"></span>
            </label>

            <label class="label-container w3-text-grey w3-margin-bottom"><span class='w3-orange w3-text-white w3-round' style="position : relative; left: 35px; padding: 8px"><?php echo lang("OTHER") ?></span>
              <input type="radio" name="type" value="Other" <?php if($info[0]["sub_type"] == "Other") echo "checked" ?>>
              <span class="checkmark w3-orange w3-text-white w3-circle"></span>
            </label>
            <br>
                <textarea  name="sub_content" rows="5" class="w3-textarea w3-input w3-margin-bottom w3-hover-light-grey"><?php echo $info[0]["sub_content"] ?></textarea>
                <div class="w3-row">
                    <div class="w3-half w3-margin-bottom">    
                        <button class="w3-button w3-teal w3-left " type="submit"><i class="fa fa-fw fa-edit"></i><?php echo lang("EDIT2") ?></button>
                    </div>
                    <div class="w3-half">
                        <a href="subject.php?subID=<?php echo $info[0]["subID"] ?>" class="w3-button w3-red w3-hide-large w3-hide-medium w3-left"><i class="fa fa-fw fa-times"></i><?php echo lang("CANCEL") ?></a>                    
                        <a href="subject.php?subID=<?php echo $info[0]["subID"] ?>" class="w3-button w3-red w3-right w3-hide-small"><i class="fa fa-fw fa-times"></i><?php echo lang("CANCEL") ?></a>
                    </div>                    

                </div>
            </form>
        
        </div>


    </div>

<?php
        
    }
        else {
            
        header("location:main.php");
        exit();             
            
        }        
        
    }
        
    }
    else{
        
        header("location:login.php");
        exit();

    }

    include $tmp . "footer.php";

?>