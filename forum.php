<?php

session_start();

$title = "Forum";

include "init.php";


            if($_SERVER["REQUEST_METHOD"] == "POST"){
            
            $formErrors = array();
            
            $title = filter_var($_POST["title"],FILTER_SANITIZE_STRING);
            $type = $_POST["type"];
            $content = filter_var($_POST["content"],FILTER_SANITIZE_STRING);             

            
                if(strlen($title) < 5 || empty(trim($title))) $formErrors[] = lang('SUBJECT-NAME-ERROR') ;
                    
                if(strlen($title) > 80) $formErrors[] = lang('SUBJECT-NAME-ERROR1') ;
            
                if(empty(trim($content)) || strlen($content) < 20) $formErrors[] = lang('SUBJECT-CONTENT-ERROR') ;               
                    
                
                if(empty($formErrors)){                      

                    $stmt = $conn->prepare("INSERT INTO subject(title, sub_content, sub_type, sub_date, userID) VALUES (:ztitle, :zcontent, :ztype, now(), :zuser)");
                    $stmt->execute(array(
                    
                    "ztitle" => $title,
                    "zcontent" => $content,
                    "ztype" => $type,
                    "zuser" => $_SESSION["id"]    
                    ));
            

            if($stmt){
                
                $success_msg = lang("SUBJECT-ADDED") ;
                
            }
                    
                }
                
                
            }

            $sort = 'DESC';    
                
            $sortArray = array('ASC','DESC');
                
            if( isset($_GET['sort']) && in_array( $_GET['sort'], $sortArray) ){
                
             $sort = $_GET['sort'];   
                
            }    
                
            $stmt = $conn->prepare("SELECT * FROM subject INNER JOIN users ON users.userID = subject.userID ORDER BY sub_date $sort ");
            $stmt-> execute();
            $rows = $stmt->fetchAll();
                
            ?>

    <div class="w3-container">
        
<!-- Header -->
        <header class="w3-container w3-center site-header w3-round" style="padding:32px 16px">
          <h1 class="w3-margin w3-text-white w3-center forum-head w3-animate-left" style="font-size: -webkit-xxx-large;"><?php echo lang("FORUM") ?></h1>
          <p class="w3-xlarge w3-padding w3-text-white w3-animate-left" style="background-color: #008080b0; border-radius:8px"><?php echo lang("FORUM-HEAD") ?></p>
        </header>         
        <div class="w3-row-padding w3-white w3-padding">
           
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
            if(isset($success_msg)){    ?>
                
                <div class="success-msg">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <?php echo $success_msg ?> 
                </div>
<?php                
            }    
                

            ?>
                
                
            </div>              
            
                    <p class="<?php if(!isset($_SESSION["id"])) echo "w3-center" ; ?>"><input style="width:50%; display:inline" class="w3-input w3-border w3-margin-bottom"  id="forum_search" type="text" placeholder="<?php echo lang("SEARCH") ?>..">
                <?php 
        if(isset($_SESSION["username"])){   ?>
                    <a href="javascript:void(0)" class="w3-large w3-right w3-teal w3-button w3-round" onclick="document.getElementById('id01').style.display='block'">
                    <i class="fa fa-file"></i>                        
                        <?php echo lang("ADD-NEW-SUBJECT") ?>
                        
                    </a>
                    
<?php
                                        }
                    ?>          
                    </p>            
           
                <div class="w3-col m9 w3-white ">    

                <div class="w3-card">
                
                <div class="w3-container w3-padding w3-teal">
 
                    <div class="w3-row">
                        <div class="w3-half">    
                            <h2>
                                <i class="fa fa-fw fa-list-ul"></i>

                                <?php echo lang("SUBJECT-LIST") ?>
                            </h2>
                        </div>
                        <div class="w3-half w3-hide-small">
                            <div class="order-type w3-right w3-margin-top" >
                                <a style="text-decoration: none" class = "<?php if($sort == 'DESC'){ echo "activated";} ?>" href="?sort=DESC"><i class="fa fa-arrow-up"></i><span class="w3-hide-small"> <?php echo lang("NEWEST") ?></span></a> |                                
                                <a style="text-decoration: none" class = "<?php if($sort == 'ASC'){ echo "activated";} ?>" href="?sort=ASC"><i class="fa fa-arrow-down"></i><span class="w3-hide-small"> <?php echo lang("OLDEST") ?></span></a>

                            </div>                         
                        
                        </div>
                    </div>
                </div>
                    <div class="panel-body w3-hoverable w3-margin-bottom" style="padding: 0">
                    <?php 
                if(!empty($rows)){
                        foreach($rows as $row){
                            echo "<div class='cat'>";
                            
                                echo "<div class='w3-hide-small w3-hide-medium hidden-buttons'>";
                                    echo "<a href='subject.php?subID=". $row["subID"] . "' class='w3-button w3-teal' >" . lang("DISPLAY") . "</a>";
                            
                                echo "</div>";
                            
                                echo "<h3><i class='fa fa-fw fa-angle-right w3-text-teal' ></i><span class='w3-nowrap'>" . $row["title"] . "</span>";
                            
                                    echo "<span class='w3-badge w3-small w3-light-blue w3-text-white w3-margin-left' style='padding: 8px 8px'><i class ='fa fa-fw fa-comments'></i>" . countItems("*","reply",true,"subID",$row["subID"]) ;
                                    echo "</span>";
                                    echo "<span class='w3-badge w3-small w3-grey w3-text-white' style='margin: 5px; padding: 8px 8px'><i class='fa fa-eye fa-fw'></i>" . $row["sub_views"] ;
                                    echo "</span>";                            
                            
                            
                            
                                echo  "</h3>";
                            
                                echo "<div class='full-view w3-animate-bottom'>";
                                echo "<a href='profile.php?userID=" . $row["userID"] . "'<p class='w3-text-dark-grey'><i class='fa fa-fw fa-user w3-text-teal'></i>" . $row["username"] ."</p></a>";
                                echo "<p><i class='fa fa-fw fa-calendar w3-text-teal'></i>" . date("d-m-Y", strtotime($row["sub_date"])) ."</p>";
                            
                                if($row["sub_type"] == "Help")
                                echo '<span class="w3-green w3-round" style="padding:8px">' . lang("HELP") . '</span>';
                                else if($row["sub_type"] == "Recommendation")
                                echo '<span class="w3-blue w3-round" style="padding:8px">' . $row["sub_type"] . '</span>';
                                else
                                echo '<span class="w3-orange w3-text-white w3-round" style="padding:8px">' . lang("OTHER") . '</span>';

                            
                                echo "<div class='w3-hide-large hidden-buttons'>";
                                    echo "<a href='subject.php?subID=". $row["subID"] . "' class='w3-button w3-teal' >" . lang("DISPLAY") . "</a>";
                            
                                echo "</div>";
                            
                                
                                echo "</div>";
                              
                            echo "</div>";
                            echo "<hr style = 'margin: 0 '>";
                            

                        }
                }
                            else {   ?>
                        <div class="alert alert-info w3-center"><span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span><span><?php echo lang("NO-SUB") ?></span>
                        </div>
<?php
                                 }
                ?>
                        
                    
                    </div>
                    
                    </div>
                 

    
            </div>
            <div class="w3-col m3">
          <!-- Posts -->
          <div class="w3-white">
            <div class="w3-container w3-padding w3-teal">
              <h5><?php echo lang("POPULAR-SUBJECTS") ?></h5>
            </div>
<?php
    
    $most_consulted = getAllFrom("*","subject","","ORDER BY sub_views","DESC","LIMIT 5");
    if(!empty($most_consulted)){
        foreach($most_consulted as $subject){
        ?>    
            <ul class="w3-ul w3-hoverable w3-white w3-card">
              <a href='subject.php?subID=<?php echo $row["subID"] ?>'><li class="w3-padding-16">
                <p class="w3-text-dark-grey"><b><?php echo $subject["title"] ?></b></p>
                <span class="w3-text-grey w3-margin"><?php echo date("d-m-Y", strtotime($subject["sub_date"])) ?></span>
<?php
            if($subject["sub_type"] == "Help")
                echo '<span class="w3-green w3-round" style="padding:8px">' . lang("HELP") . '</span>';
            else if($subject["sub_type"] == "Recommendation")
                echo '<span class="w3-blue w3-round" style="padding:8px">Recommendation</span>';
            else
                echo '<span class="w3-orange w3-text-white w3-round" style="padding:8px">' . lang("OTHER") . '</span>';
            
            ?>
                  </li>
                </a>
            </ul>
<?php
    }
    }
                  ?>
              
          </div>
          <hr>

            </div>
            </div>
            <div id="id01" class="w3-modal" style="z-index:4">
            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">    
              <div class="w3-modal-content w3-animate-zoom">
                <div class="w3-container w3-padding w3-teal">
                   <span onclick="document.getElementById('id01').style.display='none'"
                   class="w3-button w3-teal w3-right w3-xlarge"><i class="fa fa-times"></i></span>
                  <h2><?php echo lang("NEW-SUBJECT") ?></h2>
                </div>
                <div class="w3-panel">
                    <p class="w3-margin-bottom">
                        <label class="w3-label w3-darkcyan"><?php echo lang("TITLE") ?></label>
                        <div class="input-container">    
                        <input class="w3-input w3-text-grey w3-margin-bottom" type="text" name="title" required>
                        </div>    
                    </p>

                    <label class="w3-label w3-darkcyan w3-margin-bottom">Type</label>  

                    <label class="label-container w3-margin-bottom w3-text-grey"><span class='w3-blue w3-round' style="position : relative; left: 35px; padding: 8px">Recommendation</span>
                      <input type="radio" name="type" value="Recommendation">
                      <span class="checkmark w3-blue w3-circle"></span>
                    </label>

                    <label class="label-container w3-margin-bottom w3-text-grey"><span class='w3-green w3-round' style="position : relative; left: 35px; padding: 8px"><?php echo lang("HELP") ?></span>
                      <input type="radio" name="type" value="Help">
                      <span class="checkmark w3-green w3-circle"></span>
                    </label>

                    <label class="label-container w3-text-grey w3-margin-bottom"><span class='w3-orange w3-text-white w3-round' style="position : relative; left: 35px; padding: 8px"><?php echo lang("OTHER") ?></span>
                      <input type="radio" name="type" value="Other">
                      <span class="checkmark w3-orange w3-text-white w3-circle"></span>
                    </label>        


                  <label class="w3-margin-top w3-darkcyan"><?php echo lang("CONTENT") ?></label>
                <p>
                    <textarea rows="5" class="w3-input w3-padding-16 w3-text-grey w3-border" name="content" maxlength="1000" placeholder="<?php echo lang('DESCRIPTION') . "..." ?>" required></textarea>
                    </p>        
                  <div class="w3-section w3-center">
                    <input type="submit" class="w3-button w3-teal" value="<?php echo lang("PUB") ?>">
                  </div>    
                </div>
              </div>
            </form>    
            </div>
        
        
</div>

<?php
    
        include $tmp . 'footer.php';    
                    
                    ?>