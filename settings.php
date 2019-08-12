<?php
    
    ob_start();
    session_start();
    $title = "Settings";
    include "init.php";

    if(isset($_SESSION["id"])){

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        
        if(isset($_POST["pass-change"])){
            
            $oldpassword = getAllFrom("*","users","WHERE userID = ". $_SESSION["id"]);
            
            if(sha1($_POST["current"]) == $oldpassword[0]["password"]){
                
                if($_POST["password1"] == $_POST["password2"]){
                    
                    $password = $_POST["password1"];
                    
                    // Validate password strength
                    $uppercase = preg_match('@[A-Z]@', $password);
                    $lowercase = preg_match('@[a-z]@', $password);
                    $number    = preg_match('@[0-9]@', $password);
                    $specialChars = preg_match('@[^\w]@', $password);                        

                    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                        $weak = lang("WEAK-PASS");
                    }
                    else{
                        $password = sha1($password);
                        
                        $stmt = $conn->prepare("UPDATE users SET password = '$password' WHERE userID = " . $_SESSION["id"]);
                        $stmt->execute();
                        if($stmt)
                        $strong = lang("PASS-CHANGED1");
                        
                    }

                    
                }
                else
                    $notMatched = lang("PASS-ERROR");
                
                
            }
            else{
                
                $wrongPassword = lang("PASS-ERROR1");
                
            }
        
            
        }
        
        
    }
?>
<div class="w3-container" style="min-height: -webkit-fill-available;">
        
    <div class="w3-margin w3-card w3-white">
    <h1 class="w3-text-grey w3-center w3-padding"><?php echo lang("SETTINGS") ?></h1> 
<?php
        if(isset($weak)){   ?>
            
            <div class="w3-container">
                <span onclick='this.parentElement.style.display="none"' class='close-btn'><i class='fa fa-times'></i></span>                 
                <div class='alert-msg w3-center'><?php echo $weak ?>
                </div>
            </div>
<?php            
        }
        
        if(isset($strong)){ ?>
            
            <div class="w3-container">
                <span onclick='this.parentElement.style.display="none"' class='close-btn'><i class='fa fa-times'></i></span>           
                <div class='success-msg w3-center'><?php echo $strong ?>
                </div>
            </div>
<?php            
        }
        
        if(isset($wrongPassword)){  ?>
            
            <div class="w3-container" >
                <span onclick='this.parentElement.style.display="none"' class='close-btn'><i class='fa fa-times'></i></span>                 
                <div class='alert-msg w3-center'><?php echo $wrongPassword ?>
                </div>
            </div>
<?php            
        }
        
        if(isset($notMatched)){ ?>
            
            <div class="w3-container">
                <span onclick='this.parentElement.style.display="none"' class='close-btn'><i class='fa fa-times'></i></span>     
                <div class='alert-msg w3-center'><?php echo $notMatched ?>
                </div>
            </div>
<?php            
        }
        
        if(isset($_GET["message"])){        
        ?>
            <div class="w3-container">
                <span onclick='this.parentElement.style.display="none"' class='close-btn'><i class='fa fa-times'></i></span>     
                <div class='alert-msg w3-center'><?php echo $_GET["message"] ?>
                </div>
            </div>        
<?php   }   ?>        
        <div class="tab w3-white w3-border">
          <button class="tablinks" onclick="openCity(event, 'change-pass')" style="font-size:1.5vw"><?php echo lang("CHANGE-PASSWORD") ?></button>
          <button class="tablinks" onclick="openCity(event, 'delete-account')" style="font-size:1.5vw"><?php echo lang("DELETE-ACCOUNT") ?></button>
        </div>

        <div id="change-pass" class="tabcontent2 w3-white w3-padding">

            <form  action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
            <input required name="current" type="password" class="w3-input w3-light-grey w3-margin-bottom" placeholder="<?php echo lang("CURRENT-PASSWORD") ?>">
            <input required name="password1" type="password" class="w3-input w3-light-grey w3-margin-bottom" placeholder="<?php echo lang("NEW-PASSWORD") ?>">
            <input required name="password2" type="password" class="w3-input w3-light-grey w3-margin-bottom" placeholder="<?php echo lang("REPEAT-PASSWORD") ?>">                
            <button name="pass-change" type="submit" class="w3-button w3-teal w3-right"><i class="fa fa-fw fa-save"></i><?php echo lang("SAVE") ?></button>
            </form>
        </div>

        <div id="delete-account" class="tabcontent2 w3-white w3-padding w3-center">

          <p class="w3-text-red w3-center"><?php echo lang("DCM") ?></p>
            <a href="delete.php?d=account&userID=<?php echo $_SESSION["id"] ?>" class="w3-button w3-teal confirm"><i class="fa fa-fw fa-trash"></i><?php echo lang("DELETE") ?></a>    
        </div>

    
    </div>

</div>

<?php
    }
    else{
        
        header("location:login.php");
        exit();
        
    }
    include $tmp . "footer.php";
    ob_end_flush();
?>
