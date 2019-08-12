<?php 

 session_start();
        
        $title = "Dashboard";
        
        if(isset($_SESSION['user']) && $_SESSION['group'] == 1){
            
            include 'init.php';
            
            $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
            
?>
            <div class="w3-main w3-container" style="margin-left:300px; margin-top:43px;">

<?php

            if( $do == 'manage'){ 

             // Get the comments
                   
                                 
            $stmt = $conn->prepare("SELECT comments.*, items.*, users.* FROM comments INNER JOIN items ON items.itemID = comments.itemID INNER JOIN users ON users.userID = comments.userID ORDER BY comDate DESC");
            $stmt-> execute();
            $rows = $stmt->fetchAll(); 
                
            if(!empty($rows)){    

            ?>

                
                <div class="table-responsive w3-white w3-margin-top w3-padding">
                    
                    <h1 class="w3-center w3-text-dark-grey w3-margin-bottom"><?php echo lang("MANAGE-COM") ?></h1>
                    <p style="margin: 0 20%"><input class="w3-input w3-border w3-margin-bottom"  id="myInput" type="text" placeholder="<?php echo lang("SEARCH") ?>.."></p>                 
                    <table class='main-table text-center table table-bordered w3-table w3-card' id="result">
                        <tr >
                        
                        <td class="w3-teal w3-nowrap"> # </td>
                        <td class="w3-teal w3-nowrap"><?php echo lang("CONTENT") ?></td>
                        <td class="w3-teal w3-nowrap"><?php echo lang("COM-DATE") ?></td>
                        <td class="w3-teal w3-nowrap"><?php echo lang("NAME-AD") ?></td>
                        <td class="w3-teal w3-nowrap"><?php echo lang("USERNAME") ?></td>    
                        <td class="w3-teal w3-nowrap"><?php echo lang("CONTROL") ?></td>  
                        
                        </tr>
                        <?php 
                        
                        foreach($rows as $record){
                            echo "<tr class='filtered'>"; 
                            if(strtotime($record["comDate"]) > strtotime('- 7 days')){
                                
                            echo "<td class='w3-light-grey'>" . $record["comID"] . "</td>";
                            echo "<td class='w3-light-grey'>" . $record["content"] . "</td>";
                            echo "<td class='w3-hide-small w3-light-grey'>" . $record["comDate"] . "</td>";
                            echo "<td class='w3-light-grey'><a href='../showAd.php?itemID=" . $record["itemID"] . "'>" . $record["item_name"] ."<a></td>";
                            echo "<td class='w3-light-grey'><a href='../profile.php?do=show&userID=" . $record["userID"] . "'>" . $record["username"] . "</a></td>";
                            
                            echo "<td class='w3-light-grey'>";
                            
                            if($_SESSION["id"] == $record["userID"]){
                            echo '<a href="../edit.php?e=comment&comID=' . $record["comID"] . '" style="margin: 3px; vertical-align:middle; display: inline-block" class="w3-padding w3-green w3-circle"><i class="fa fa-edit"></i></a>';
                            }
                            echo '<a style="margin: 3px; vertical-align:middle; display: inline-block" href="annonces.php?do=delete&comID='. $record["comID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-red w3-circle confirm"><i class="fa fa-trash"></i></a>';
                            
                            echo '<a style="margin: 3px; vertical-align:middle; display: inline-block" href="../showAd.php?itemID='. $record["comID"] . '#' . $record["comID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-teal w3-circle"><i class="fa fa-eye"></i></a>';
                            
                            echo '</td>';                                
   
                            }
                            else
                            {
                            echo "<td>" . $record["comID"] . "</td>";
                            echo "<td>" . $record["content"] . "</td>";
                            echo "<td class='w3-hide-small'>" . $record["comDate"] . "</td>";
                            echo "<td><a href='../showAd.php?itemID=" . $record["itemID"] . "'>" . $record["item_name"] ."<a></td>";
                            echo "<td><a href='../profile.php?do=show&userID=" . $record["userID"] . "'>" . $record["username"] . "</a></td>";
                            
                            echo "<td>";
                                
                            if($_SESSION["id"] == $record["userID"]){
                                echo $_SESSION["id"] ;
                                echo $record["userID"];
                            echo '<a href="../edit.php?e=comment&comID=' . $record["comID"] . '" style="margin: 3px; vertical-align:middle; display: inline-block" class="w3-padding w3-green w3-circle"><i class="fa fa-edit"></i></a>';
                            }
                            echo '<a style="margin: 3px; vertical-align:middle; display: inline-block" href="annonces.php?do=delete&comID='. $record["comID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-red w3-circle confirm"><i class="fa fa-trash"></i></a>';
                            
                            echo '<a style="margin: 3px; vertical-align:middle; display: inline-block" href="../showAd.php?itemID='. $record["comID"] . '#' . $record["comID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-teal w3-circle"><i class="fa fa-eye"></i></a>';
                            
                            echo '</td>';
                            }                            
                            
                            echo"</tr>";
                            
                            
                        }
                
            }
                else
            {
            echo "<div class='w3-container'>";
                echo "<div class='alert-msg text-center'>" . lang("NO-COM") . "</div>"  ;
            echo "</div>";    
            }
                    ?> 

                    </table>
                
                </div>    
                


            <?php
            } 
                                                                        
            else if($do == 'delete'){
                
                // check if the user ID is a number
                
                $comID = isset($_GET['comID']) && is_numeric($_GET['comID']) ? intval($_GET['comID']):0 ;
                
                // Select data
                
                
                $count = checkItem('comID','comments',$comID);

                if($count > 0){
                    
                    $stmt = $conn->prepare("DELETE FROM comments WHERE comID = :zcom"); // to avoid SQL injection
                    $stmt->bindParam(":zcom",$comID);
                    $stmt->execute();
                    
                    header("location:comments.php");
                    exit();
                    
                }
                else
                {
                    $message = "<div class='alert-msg'>" . lang("ILLEGAL-BROWSING") . "</div>";
                    redirection($message,5);
                    
                }
                
                
            }
            ?>
    
                </div>
    
<?php            
            include $tmp . 'footer.php';
            
        }
        
                
        else{
            
            header('location: login.php');
            exit();
            
            
        }

        

?>
    