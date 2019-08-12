<?php 

        session_start();
        
        $title = "Dashboard";
        
        if(isset($_SESSION['user'])){
            
            include 'init.php';
            
            $do = isset($_GET['do']) ? $_GET['do'] : 'manage';   ?>

                <div class="w3-main w3-container" style="margin-left:300px;margin-top:43px;">
<?php

            if( $do == 'manage'){ 

             // Get the users 
                                 
            $stmt = $conn->prepare("SELECT * FROM users WHERE groupID = 0 ORDER BY regDate DESC ");
            $stmt-> execute();
            $rows = $stmt->fetchAll(); 

                
            if(!empty($rows)){    

            ?>

                <div class="table-responsive w3-white w3-margin w3-padding">
                    
                    <h1 class="w3-center w3-text-dark-grey w3-margin-bottom"><?php echo lang("MANAGE-MEMBERS") ?></h1>
                    <p style="margin: 0 20%"><input class="w3-input w3-border w3-margin-bottom"  id="myInput" type="text" placeholder="<?php echo lang("SEARCH") ?>.."></p>
                    <table class='main-table text-center table table-bordered w3-card' id="result">
                        <tr>
                        
                        <td class="w3-teal">#</td>
                        <td class="w3-teal w3-nowrap"><?php echo lang("USERNAME") ?></td>
                        <td class="w3-teal w3-nowrap"><?php echo lang("EMAIL") ?></td>
                        <td class="w3-hide-small w3-hide-medium w3-teal"><?php echo lang("FULLNAME") ?></td>
                        <td class="w3-teal w3-nowrap"><?php echo lang("REGDATE") ?></td>
                        <td class="w3-teal w3-nowrap"><?php echo lang("PROFILE-PIC") ?></td>    
                        <td class="w3-teal w3-nowrap"><?php echo lang("CONTROL") ?></td>  
                        
                        </tr>
                        <?php 
                        
                        foreach($rows as $record){
                            echo "<tr class='filtered'>";                             
                            if(strtotime($record["regDate"]) > strtotime('- 7 days')){             

                            echo "<td class='w3-light-grey'>" . $record["userID"] . "</td>";
                            echo "<td class='w3-light-grey'>" . $record["username"] . "</td>";
                            echo "<td class='w3-light-grey'>" . $record["email"] . "</td>";
                            echo "<td class='w3-hidde-small w3-hide-medium w3-light-grey'>" . $record["fullname"] . "</td>";
                            echo "<td class='w3-light-grey'>" . $record["regDate"] . "</td>";
                            echo "<td class='w3-light-grey'>";
                                
                                if(!empty(trim($record["image"]))){
                                echo "<img class='img-circle' src='../uploads/profile_pictures/" . $record["image"] . "' alt='' />";
                                }
                                else {
                                echo "<img class='img-circle' src='../uploads/profile_pictures/user.png' alt='' />";    
                                }
                                echo "</td>";                            
                            echo "<td class='w3-light-grey'>";
                            
                        if($_SESSION["id"] == $record["userID"]){
                            echo '<a href="members.php?do=edit&userID='. $record["userID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-green w3-circle " style="margin: 3px; vertical-align:middle; display: inline-block"><i class="fa fa-edit"></i></a>';
                        }
                         
                            echo '<a href="../profile.php?userID='. $record["userID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-teal w3-circle " style="margin: 3px; vertical-align:middle; display: inline-block"><i class="fa fa-eye"></i></a>';    

                            echo '<a href="members.php?do=delete&userID='. $record["userID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-red w3-circle confirm" style="margin: 3px; vertical-align:middle; display: inline-block"><i class="fa fa-times"></i></a>';
                                
                            echo '<a href="members.php?do=upgrade&userID='. $record["userID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-purple w3-circle confirm" style="margin: 3px; vertical-align:middle; display: inline-block"><i class="fa fa-arrow-up"></i></a>';                                
                            
                            echo '</td>';
                            }
                            else {    
                            echo "<td>" . $record["userID"] . "</td>";
                            echo "<td>" . $record["username"] . "</td>";
                            echo "<td>" . $record["email"] . "</td>";
                            echo "<td class='w3-hidde-small w3-hide-medium'>" . $record["fullname"] . "</td>";
                            echo "<td>" . $record["regDate"] . "</td>";
                            echo "<td>";
                                
                                if(!empty(trim($record["image"]))){
                                echo "<img class='img-circle' src='../uploads/profile_pictures/" . $record["image"] . "' alt='' />";
                                }
                                else {
                                echo "<img class='img-circle' src='../uploads/profile_pictures/user.png' alt='' />";    
                                }
                                echo "</td>";                            
                            echo "<td>";
                            
                        if($_SESSION["id"] == $record["userID"]){
                            echo '<a href="members.php?do=edit&userID='. $record["userID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-green w3-circle " style="margin: 3px; vertical-align:middle; display: inline-block"><i class="fa fa-edit"></i></a>';
                        }
                         
                            echo '<a href="../profile.php?userID='. $record["userID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-teal w3-circle " style="margin: 3px; vertical-align:middle; display: inline-block"><i class="fa fa-eye"></i></a>';    

                            echo '<a href="members.php?do=delete&userID='. $record["userID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-red w3-circle confirm" style="margin: 3px; vertical-align:middle; display: inline-block"><i class="fa fa-times"></i></a>';
                                
                            echo '<a href="members.php?do=upgrade&userID='. $record["userID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-purple w3-circle confirm" style="margin: 3px; vertical-align:middle; display: inline-block"><i class="fa fa-arrow-up"></i></a>';                                 
                            
                            echo '</td>';                                
                                
                                
                                
                            }
                            
                            echo"</tr>";
                            
                            
                        }
                    ?> 

                    </table>
                
                </div>    
                
            

            <?php
                        
            }
                else {
                    
                    echo "<div class='alert alert-info text-center'>" . lang("NO-MEMBERS") . "</div>"  ;
                    echo "<a href='?do=add' class='btn btn-primary'><i class='fa fa-plus'></i> " . lang("ADD") . "</a>";
                    
                }
                
                ?>
                


    <?php
            } 

            
            else if($do == 'upgrade'){
                
                // check if the user ID is a number
                
                $userId = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']):0 ;
                
                // Select data
                
                
                $count = checkItem('userID','users',$userId);
                
                echo "<div class='w3-container'>";

                if($count > 0){
                    
                    $stmt = $conn->prepare("UPDATE users SET groupID = 1 WHERE userID = :zuser"); // to avoid SQL injection
                    $stmt->bindParam(":zuser",$userId);
                    $stmt->execute();
                    
                    $fr_message = $_SESSION["username"] . " vous a attribué un administrateur de ce site" ;
                    $en_message = $_SESSION["username"] . " assigned you as an admin of this site" ;                    
                    $url = "admin/login.php";
                    notify("arrow-up", $fr_message, en_message, $userId, $_SESSION["id"], "", $url);
                    
                    header("location:members.php");
                    exit();
                    
                }
                else
                {
                    $message = "<div class='alert-msg w3-center w3-padding'>" . lang("ILLEGAL-BROWSING") . "</div>";
                    redirection($message,5);
                    
                }
                
                
            }           
            
                           
            else if($do == 'delete'){
                
                // check if the user ID is a number
                
                $userId = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']):0 ;
                
                // Select data
                
                
                $count = checkItem('userID','users',$userId);
                
                echo "<div class='w3-container'>";

                if($count > 0){
                    
                    
                
                    echo "<h1 class='text-center'>" . lang('DELETEMEMBER') . "</h1>";
                    
                    $stmt = $conn->prepare("DELETE FROM users WHERE userID = :zuser"); // to avoid SQL injection
                    $stmt->bindParam(":zuser",$userId);
                    $stmt->execute();
                    
                    $message = "<div class='alert alert-success w3-center'>" . lang("MEMBER-DELETED") . "</div>";
                    redirection($message,'back');
                    
                }
                else
                {
                    $message = "<div class='alert alert-danger'>" . lang("ILLEGAL-BROWSING") . "</div>";
                    redirection($message,5);
                    
                }
                
                echo "</div>";
                
                
            }
            echo "</div>";
            
            echo "</div>";
            
            include $tmp . 'footer.php';
            
        }
        
                
        else{
            
            header('location: login.php');
            exit();
            
            
        }

        

?>