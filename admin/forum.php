<?php 
    ob_start();
     session_start();
        
        $title = "Dashboard";
        
        if(isset($_SESSION['user'])){
            
            include 'init.php';
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
                
            $stmt = $conn->prepare("SELECT subject.*, users.* FROM subject INNER JOIN users on users.userID = subject.userID ORDER BY sub_date $sort");
            $stmt-> execute();
            $rows = $stmt->fetchAll();
                
            ?>

                <div class="table-responsive w3-white w3-padding w3-margin-top ">    
                <h2 class="w3-center w3-text-dark-grey w3-margin-bottom"><?php echo lang("MANAGE-SUBJECTS") ?></h2>
                <div class="panel panel-default w3-card">
                
                <div class="panel-heading">
                    <div class="order-type pull-right" style="position:relative; top:10px;" >
                        <a class = "w3-padding <?php if($sort == 'ASC'){ echo "active";} ?>" href="?sort=ASC"><i class="fa fa-arrow-up"></i><span class="w3-hide-small"> <?php echo lang("ASC") ?></span></a> |
                        <a class = "w3-padding <?php if($sort == 'DESC'){ echo "active";} ?>" href="?sort=DESC"><i class="fa fa-arrow-down"></i><span class="w3-hide-small"> <?php echo lang("DESC") ?></span></a>
                        
                    </div>
                    <h2><i class="fa fa-edit fa-xs"> </i><?php echo " " . lang("SUBJECTS") ?></h2>
                    
                        </div>
                    <div class="panel-body">
                    <?php 
                
                        foreach($rows as $row){
                            echo "<div class = 'cat'>";
                            
                            
                                echo "<div class='w3-hide-small hidden-buttons'>";
                                    echo "<a href='subject.php?subID=". $row["subID"] . "' class='w3-padding w3-grey w3-text-white w3-hover-teal' >" . lang("DISPLAY") . "</a>";
                                echo "<a href='forum.php?do=delete&subID=" . $row["subID"] . "' class = 'confirm w3-padding w3-grey w3-text-white w3-hover-red'><i class = 'fa fa-times'></i>" ;
                                echo "</a>";
                            
                                echo "</div>";
                            
                                echo "<h3>" . $row["title"] . "</h3>";
                            
                                echo "<div class='full-view'>";
                                echo "<p>";

                                echo $row["sub_content"];     

                                echo "</p>";
                                echo "<a href='../profile.php?userID=" . $row["userID"] . "'<p class='w3-text-dark-grey'><i class='fa fa-fw fa-user w3-text-teal'></i>" . $row["username"] ."</p></a>";
                                echo "<p><i class='fa fa-fw fa-calendar w3-text-teal'></i>" . $row["sub_date"] ."</p>";
                            
                                if($row["sub_type"] == "Help")
                                echo '<span class="w3-green w3-round" style="padding:8px">' . $row["sub_type"] . '</span>';
                                else if($row["sub_type"] == "Recommendation")
                                echo '<span class="w3-indigo w3-round" style="padding:8px">' . $row["sub_type"] . '</span>';
                                else
                                echo '<span class="w3-pink w3-round" style="padding:8px">' . $row["sub_type"] . '</span>';

                            
                                echo "<div class='w3-hide-large w3-hide-medium hidden-buttons'>";
                                    echo "<a href='subject.php?subID=". $row["subID"] . "' class='w3-button w3-teal' >" . lang("DISPLAY") . "</a>";
                            
                                echo "</div>";                            
                                
                          echo "</div>";
                              
                            echo "</div>";
                            echo "<hr>";
                            

                        }
                
                ?>
                        
                    
                    </div>
                    
                </div>
 
    
            </div>
   
            <?php    
                
            }
            
            
            else if($do == 'delete'){
                
                // check if the category ID is a number
                
                $subID = isset($_GET['subID']) && is_numeric($_GET['subID']) ? intval($_GET['subID']):0 ;
                
                // Select data
                
                
                $count = checkItem('subID','subject',$subID);
                
                echo "<div class='w3-container'>";
                if($count > 0){
                    
                    $stmt = $conn->prepare("DELETE FROM subject WHERE subID = :zsub"); // to avoid SQL injection
                    $stmt->bindParam(":zsub",$subID);
                    $stmt->execute();
                    
                    header("location:forum.php");
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