<?php
        session_start();

        $title = "Subject";

        include 'init.php';

                

          

                $subID = isset($_GET['subID']) && is_numeric($_GET['subID']) ? intval($_GET['subID']):0 ;
                
                // Select data
                
                $stmt = $conn->prepare("SELECT subject.*, users.* FROM subject INNER JOIN users ON users.userID = subject.userID WHERE subject.subID = ?");
                
                // execute query 
                
                $stmt->execute(array($subID));
                
                // Fetch the data 
                
                $row = $stmt->fetch();  
                
                $count = $stmt->rowCount();

                if($count > 0){
                    
                if(isset($_SESSION["id"])){
                    
                    if($_SESSION["id"] != $row["userID"] || $row["sub_views"] == 0){
                        
                        updateViews2($subID);                
                        
                    }
                    
                }
                    
                        if($_SERVER["REQUEST_METHOD"] === "POST"){
 
                            $contenu = filter_var($_POST["contenu"],FILTER_SANITIZE_STRING);
                            $userID = $_SESSION["id"];
                            $subID = $row["subID"];
                            
                            if(!empty(trim($contenu))){
                                
                                $stmt = $conn->prepare("INSERT INTO reply(rep_content,rep_date,subID,userID) VALUES(:zcontent,now(), :zsubID, :zuserID)");
                                $stmt->execute(array(
                                    ":zcontent" => $contenu,
                                    ":zsubID" => $subID,
                                    ":zuserID" => $userID));
                                
                                if($stmt){
                                    
                                    if($_SESSION["id"] != $row["userID"]){ 
                                    $fr_message = $_SESSION["username"] . " " . "a répondu à votre sujet";
                                    $en_message = $_SESSION["username"] . " " . "replied to your subject";                                        
                                    $url = "subject.php?subID=". $row["subID"]."#replies";
                                    notify("reply", $fr_message, en_message, $row["userID"], $_SESSION["id"], $row["subID"], $url); 
                                }            
                
                
                $rep_added = "<div class='success-msg w3-center'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>" . lang("REP-ADDED") . "</div>" ; 
                                }
                                
                                
                            }
                            else{
                                
                                $empty_com = "<div class='alert alert-danger w3-container text-center'>" . lang("COM-EMPTY") . "</div>";
                                
                            }
                            
                        }                     

?>

<div class="w3-container w3-content">
    <div class="w3-card w3-round w3-white w3-main w3-margin-bottom w3-padding" style="margin-top:32px" >

        <div id="Borge" class="w3-container">
          <br>
        <div class="w3-row">
                <div class="w3-quarter w3-padding">           
                <div class="w3-card w3-padding w3-animate-zoom w3-center">       
<?php    
                    if(!empty(trim($row["image"]))){

                        echo '<img src="uploads/profile_pictures/'. $row["image"] .'" alt="" style="width:35%" class="w3-round">';

                    }
                    else {

                        echo '<img src="uploads/profile_pictures/user.png" alt="" style="width:35%" class=" w3-round">';
                    }

                        ?>
                  <h3><?php echo $row["username"] ?></h3>
<?php 
                            if(!empty(trim($row["telephone"]))) { ?>    <h5 class="w3-text-grey"><?php echo $row["telephone"] ?></h5><?php } 
                    ?>
<?php 
                    if(!empty(trim($row["email"]))) { 
                    ?>    
                    <p class="w3-text-grey w3-hide-medium"><?php echo $row["email"] ?></p>
<?php } ?>      
                  <p><a class="w3-button w3-teal w3-round" href="profile.php?userID=<?php echo $row["userID"] ?>"><?php echo lang("SEE-PROFILE") ?></a></p>                    

                    </div>
                    
                
                   
                    
            </div>
            <div class="w3-threequarter w3-center">
              <h1 class="w3-text-teal"><?php echo $row["title"] ?></h1>
                <span class="w3-opacity"><?php echo $row["sub_date"] ?></span> 
<?php
            if($row["sub_type"] == "Help")
                echo '<span class="w3-green w3-round w3-margin" style="padding:5px">' . lang("HELP") . '</span>';
            else if($row["sub_type"] == "Recommendation")
                echo '<span class="w3-blue w3-round w3-margin" style="padding:5px">' . $row["sub_type"] . '</span>';
            else
                echo '<span class="w3-orange w3-text-white w3-margin w3-round" style="padding:5px">' . lang("OTHER") . '</span>';
            
            ?>                
          <hr>
          <p class="w3-margin-bottom w3-padding w3-light-grey w3-round" style="letter-spacing: 1px ;font-family: Raleway, sans-serif;"><?php echo $row["sub_content"] ?></p>

                <div class="w3-row">
                <div class="w3-half">
                    <h3 class="w3-center "><b><?php echo countItems("repID", "reply", true, "subID", $subID) . " " . lang("REPLIES") ?></b></h3>
                </div>
                <div class="w3-half">
<?php if(isset($_SESSION["id"]))
                if($_SESSION["id"] == $row["userID"]){    ?>
                <a class="w3-button w3-green w3-round" href="edit.php?e=subject&subID=<?php echo $row["subID"] ?>"><?php echo lang("EDIT2") ?><i class="fa-fw fa fa-edit"></i></a>                    
<?php   } else {    ?>                    
                <a class="w3-button w3-teal w3-round" href="#add-comment"><?php echo lang("REPLY") ?><i class="fa-fw fa fa-arrow-right"></i></a>
<?php   }   ?>                    
                    </div>
                </div>
              
             

            </div>
            </div>
          
        <br> 
            <div class="w3-threequarter w3-padding" id="replies">
                
    
<?php
                    if(isset($rep_added))
                        echo $rep_added;
                    if(isset($empty_com))
                        echo $empty_com;

                        $stmt = $conn->prepare("SELECT reply.*, users.* FROM reply INNER JOIN users ON users.userID = reply.userID WHERE reply.subID = ? ORDER BY rep_date DESC");
                        $stmt-> execute(array($subID));
                        $rows = $stmt->fetchAll();
                    
                    ?>                

                <br>
            <?php 
            
                    if(!empty($rows)){

                        foreach($rows as $reply){
                            echo '<div class="w3-row">';
                            echo '<div class="w3-col m2 w3-center w3-margin-bottom">';
                            
                            if(!empty(trim($reply["image"]))){
                                            
                                echo '<img src="uploads/profile_pictures/' . $reply["image"] .'" class="w3-circle" style="width:60px;height:60px">';
                                    }
                                    else {
                                            
                                        echo "<img src='uploads/profile_pictures/user.png' alt='' class='w3-circle' style='width:60px; height:60px' />";  
                                    }
                            echo '</div>';
                            echo '<div class="w3-col m10 w3-margin-bottom">
                                    <h4 class="w3-darkcyan">'. $reply["username"] .'<span class="w3-opacity w3-medium w3-text-grey">'. " " . proDate($reply["rep_date"]).'</span></h4>
                                    <p class="w3-text-dark-grey"><b>'. $reply["rep_content"] .'</b></p><br>';
                                                        
                            if(isset($_SESSION["id"])){
                            if($_SESSION["id"] == $reply["userID"]){
                                
                                echo '<a class="w3-grey w3-text-white w3-hover-teal w3-round w3-padding" style="padding: 6px;" href="edit.php?e=reply&repID=' . $reply["repID"] . '"><i class="fa fa-fw fa-edit"></i></a>';
                            }
                            if($_SESSION["id"] == $row["userID"] || $_SESSION["id"] == $reply["userID"] || $_SESSION["group"] == 1){                                
                                echo '<a href="delete.php?d=reply&repID=' . $reply["repID"] . '&user=' . $reply["username"] .'" class="w3-grey w3-text-white w3-hover-red w3-round w3-padding" style="margin-left:3px; padding: 6px;" href="#"><i class="fa f-fw fa-times"></i></a>';                                
                            }                                  
                            }
                            echo      '</div>';
                            echo '</div>';

                                            }
                    }

                ?>
                
<?php 
                    
                    if(isset($_SESSION["username"])) { ?>
                        <div class="w3-row-padding w3-margin-left">
                                <div class="add-comment">
                                <form action="<?php echo $_SERVER["PHP_SELF"] ."?subID=" . $row["subID"] . "#replies" ?>" method="post">
                                    
                                    <h3 class="w3-center w3-margin-bottom w3-text-teal"><b><?php echo lang("PUBLISH-REPLY") ?> !</b></h3>
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
                                            <p><textarea id="add-comment" class="w3-input w3-padding-16 w3-text-grey w3-hover-light-grey w3-textarea" type="text" placeholder="Votre réponse..." required name="contenu" maxlength="800" rows="3"></textarea></p>
                                            <p><input class="w3-button w3-teal" type="submit" value="<?php echo lang("REPLY") ?>"></p>
                                        </div>    
                                    </div>
                                </form>


                                    </div>

                        </div>
                <?php 
                 }
                    else { 
                        
                        echo "<div class='alert alert-info container text-center'><a href='login.php'>" . lang("LOGIN-MSG") . "</a>";
                        echo "</div>";    
                    }
                    ?>                 
            
            </div>            

            
        </div>    
        

  <!-- End Contact Section -->
    </div>


</div>

  
<?php

        include $tmp . 'footer.php';
                    
                }
    else{
        
        header("location: main.php");
        exit();
        
    }


?>