<?php 

    ob_start();

    session_start();

    $title = "Dashboard";

    if(isset($_SESSION["user"])){
        
        include "init.php";
        
        $do = isset($_GET["do"]) ? $_GET["do"] : "manage" ;
        
        ?>

            <div class="w3-main w3-container" style="margin-left:300px;margin-top:43px;">

<?php
        
        if($do == "manage"){ 
            
            $stmt = $conn->prepare("SELECT items.*, category.name, users.username FROM items INNER JOIN category ON category.catID = items.catID INNER JOIN users ON users.userID = items.userID ORDER BY add_date DESC ");
            $stmt-> execute();
            $rows = $stmt->fetchAll();  
            
            if(!empty($rows)){

            ?>



                
                <div class="table-responsive w3-white w3-padding w3-margin-top">
                    
                    <h2 class="w3-center w3-text-dark-grey w3-margin-bottom"><?php echo lang("MANAGE-AD") ?></h2>
                    
                        <div class="w3-section w3-padding-16 w3-center" id="myBtnContainer">

                          <a href="#result" class="filter-link w3-padding w3-teal" data-filter="all" style="font-size:initial; text-decoration:none" >All</a>
                          <a href="#result" class="filter-link w3-padding w3-light-grey" data-filter="smartphone" style="font-size:initial; text-decoration:none" ><i class="fa fa-fw fa-mobile" ></i><span class="w3-hide-small">Phones</span></a>
                          <a href="#result" class="filter-link w3-padding w3-light-grey" data-filter="tablet" style="font-size:initial; text-decoration:none" ><i class="fa fa-fw fa-tablet w3-margin-right"></i><span class="w3-hide-small">Tablet</span></a>
                          <a href="#result" class="filter-link w3-padding w3-light-grey" data-filter="pending" style="font-size:initial; text-decoration:none" ><i class="fa fa-fw fa-tablet w3-margin-right"></i><span class="w3-hide-small">Pending</span></a>                            
                            
                        </div>                    
                    <p style="margin: 0 20%"><input class="w3-input w3-border w3-margin-bottom" id="myInput" type="text" placeholder="<?php echo lang("SEARCH") ?>.."></p>
                    <table class='main-table text-center table table-bordered w3-table w3-card' id="result">
                        <tr>
                        
                        <td class="w3-teal"> # </td>
                        <td class="w3-teal"><?php echo lang("NAME-AD") ?></td>
                        <td class="w3-hide-small w3-teal"><?php echo lang("DATE-AD") ?></td>
                        <td class="w3-teal"><?php echo lang("PRICE") ?></td>
                        <td class="w3-teal"><?php echo lang("NAME") ?></td>
                        <td class="w3-teal"><?php echo lang("USERNAME") ?></td>    
                        <td class="w3-teal"><?php echo lang("CONTROL") ?></td>  
                        
                        </tr>
                        <?php 
                        
                        foreach($rows as $record){
                            echo "<tr class='all filtered ";
                            if($record["pending"] == 0) echo "pending " ;
                            if($record["type"] == 0){ echo "smartphone";} else { echo "tablet";}
                            echo " '>";
                            if(strtotime($record["add_date"]) > strtotime('- 7 days')){
                                
                            echo "<td class='w3-light-grey'>" . $record["itemID"] . "</td>";
                            echo "<td class='w3-light-grey'>" . $record["item_name"] . "</td>";
                            echo "<td class='w3-hide-small w3-light-grey'>" . $record["add_date"] . "</td>";
                            echo "<td class='w3-light-grey'>" . $record["price"] . " DA" . "</td>";
                            echo "<td class='w3-light-grey'>" . $record["name"] . "</td>";
                            echo "<td class='w3-light-grey'>" . $record["username"] . "</td>";
                            
                            echo "<td class='w3-light-grey'>";
                            
                            if($_SESSION["id"] == $record["userID"]){
                            echo '<a href="../editAd.php?itemID='. $record["itemID"] . '" class="w3-padding w3-green w3-circle"><i class="fa fa-edit"></i></a>';
                            }
                            echo '<a style="margin: 3px; vertical-align:middle; display: inline-block" href="annonces.php?do=delete&itemID='. $record["itemID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-red w3-circle confirm"><i class="fa fa-trash"></i></a>';
                            
                            echo '<a style="margin: 3px; vertical-align:middle; display: inline-block" href="../showAd.php?itemID='. $record["itemID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-teal w3-circle"><i class="fa fa-eye"></i></a>';
                                
                            if($record["pending"] == 0){
                                
                            echo '<a style="margin: 3px; vertical-align:middle; display: inline-block" href="annonces.php?do=approve&itemID='. $record["itemID"] . '" class="w3-padding w3-blue w3-circle confirm"><i class="fa fa-check"></i></a>';                                
                                
                            }    
                            
                            echo '</td>';                                 
                                
                            }
                            else{
                            echo "<td>" . $record["itemID"] . "</td>";
                            echo "<td>" . $record["item_name"] . "</td>";
                            echo "<td class='w3-hide-small'>" . $record["add_date"] . "</td>";
                            echo "<td>" . $record["price"] . " DA" . "</td>";
                            echo "<td>" . $record["name"] . "</td>";
                            echo "<td>" . $record["username"] . "</td>";
                            
                            echo "<td>";
                            
                            if($_SESSION["id"] == $record["userID"]){
                            echo '<a href="../editAd.php?itemID='. $record["itemID"] . '" class="w3-padding w3-green w3-circle"><i class="fa fa-edit"></i></a>';
                            }
                            echo '<a style="margin: 3px; vertical-align:middle; display: inline-block" href="annonces.php?do=delete&itemID='. $record["itemID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-red w3-circle confirm"><i class="fa fa-trash"></i></a>';
                            
                            echo '<a style="margin: 3px; vertical-align:middle; display: inline-block" href="../showAd.php?itemID='. $record["itemID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-teal w3-circle"><i class="fa fa-eye"></i></a>';
                                
                            if($record["pending"] == 0){
                                
                            echo '<a style="margin: 3px; vertical-align:middle; display: inline-block" href="annonces.php?do=approve&itemID='. $record["itemID"] . '" class="w3-padding w3-blue w3-circle confirm"><i class="fa fa-check"></i></a>';                                
                                
                            }
                                
                            }
                            
                            echo"</tr>";

                        }
                    ?> 

                    </table>
                    
                    <div class="pagination"></div>
                
                </div>  
                
                <a href='../newAd.php' class="w3-button w3-teal w3-hover-text-white w3-margin-bottom" style="text-decoration:none"><i class="fa fa-plus"></i><?php echo " " . lang("NEW-AD") ?></a>
                

    
    <?php
            }
            else
            {
            echo "<div class='w3-container'>";
                echo "<div class='alert alert-info text-center'>" . lang("NO-ADS") . "</div>"  ;
                echo "<a href='?do=add' class='btn btn-primary'><i class='fa fa-plus'></i>" . lang("NEW-AD") . "</a>" ;
            echo "</div>";    
            }
 
        }
        
        else if($do == "approve"){
            
             // check if the item ID is a number
                
                $itemID = isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']):0 ;
                
                // Select data
                
                
                $count = checkItem('itemID','items',$itemID);

                if($count > 0){
                    
                    $user = getAllFrom("*","items","WHERE itemID = $itemID");
                    
                    $stmt = $conn->prepare("UPDATE items SET pending = 1 , add_date = now() WHERE itemID = :zitem"); // to avoid SQL injection
                    $stmt->bindParam(":zitem",$itemID);
                    $stmt->execute();
                    
                    $notif_message = lang("AD-APPROVED") ;
                    $url = "showAd.php?itemID=" . $itemID;
                    notify("check", $notif_message, $user[0]["userID"], $_SESSION["id"], $itemID, $url);                    
                    
                    header("location:annonces.php");
                    exit();
                    
                }
                else
                {
                    $message = "<div class='alert-msg w3-padding w3-margin'>" . lang("ILLEGAL-BROWSING") . "</div>";
                    redirection($message,5);
                    
                }
                
                echo "</div>";            
            
            
        }
        
        else if ($do == "delete"){
            
             // check if the item ID is a number
                
                $itemID = isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']):0 ;
                
                // Select data
                
                
                $count = checkItem('itemID','items',$itemID);
                
                echo "<div class='w3-container w3-white'>";

                if($count > 0){
                    
                    $stmt = $conn->prepare("DELETE FROM items WHERE itemID = :zitem"); // to avoid SQL injection
                    $stmt->bindParam(":zitem",$itemID);
                    $stmt->execute();
                    
                    $message = "<div class='success-msg w3-padding w3-margin'>" . $stmt->rowCount() . " record deleted" . "</div>";
                    redirection($message,'back');
                    
                }
                else
                {
                    $message = "<div class='alert-msg w3-padding w3-margin'>" . lang("ILLEGAL-BROWSING") . "</div>";
                    redirection($message,5);
                    
                }
                
                echo "</div>";
                
            
            
            
        }
        
        ?>
                 </div>           
<?php                
        include $tmp . 'footer.php';
    }
    else
    {
        header("location: login.php");
        exit();
    }

    ob_end_flush();