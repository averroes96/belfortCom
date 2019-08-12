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
                                 
            $stmt = $conn->prepare("SELECT * FROM users WHERE groupID = 1 AND super != 1 ORDER BY regDate DESC ");
            $stmt-> execute();
            $rows = $stmt->fetchAll(); 

                
            if(!empty($rows)){    

            ?>

                <div class="table-responsive w3-white w3-margin w3-padding">
                    
                    <h1 class="w3-center w3-text-dark-grey w3-margin-bottom"><?php echo lang("ADMINS") ?></h1>
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
                                
                            echo '<a href="members.php?do=downgrade&userID='. $record["userID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-purple w3-circle confirm" style="margin: 3px; vertical-align:middle; display: inline-block"><i class="fa fa-arrow-down"></i></a>';                                
                            
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
                                
                            echo '<a href="members.php?do=downgrade&userID='. $record["userID"] . '" class="w3-padding w3-grey w3-text-white w3-hover-purple w3-circle confirm" style="margin: 3px; vertical-align:middle; display: inline-block"><i class="fa fa-arrow-down"></i></a>';                                 
                            
                            echo '</td>';                                
                                
                                
                                
                            }
                            
                            echo"</tr>";
                            
                            
                        }
                    ?> 

                    </table>
                    
                    <a href='?do=add' class="w3-teal w3-button" style="text-decoration:none"><i class="fa fa-plus"></i><?php echo " " . lang("ADD-ADMIN") ?></a>
                
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
            else if($do == 'add'){?>

                <div class="w3-container">
                    
                    
                    
                    <form class="w3-card w3-white w3-margin-top " action="?do=insert" method="post">
                        
                        <h1 class="w3-center w3-text-dark-grey"><?php echo lang('ADD-ADMIN') ?></h1>
                        
                        <!-- Username -->
                        <p class="w3-padding">
                            <label class="w3-label w3-darkcyan"><?php echo lang('USERNAME') ?>  <span class="w3-text-red">*</span></label>
                            <input id="username" type="text" name="username" class="w3-input w3-text-grey" autocomplete="off"s  required="required">    
                        
                        </p>
                        <div class="alert alert-danger alert-username w3-center"><?php echo lang('USERERROR') ?></div>
                                            <!-- Password -->
                        <p class="w3-margin-bottom w3-padding">
                            <label class="w3-label w3-darkcyan"><?php echo lang('PASSWORD') ?> <span class="w3-text-red">*</span></label>
                            <input id="password" type="password" name="password" class=" w3-input w3-text-grey password" autocomplete="new-password" required="required">
                            <i class="show-pass fa fa-eye fa-1x"></i>                           
                        </p>
                        <div class="alert alert-danger alert-password w3-center"><?php echo lang('PASSERROR') ?></div>                         
                                            <!-- E-mail -->
                        <div class="form-group form-group-lg w3-padding">
                            <label class="w3-label w3-darkcyan"><?php echo lang('EMAIL') ?>  <span class="w3-text-red">*</span></label>
                            <input id="email" type="email" name="email" class="w3-input w3-text-grey" required="required">
                            <div class="alert alert-danger alert-email w3-center w3-margin"><?php echo lang('EMAILERROR') ?></div>
                        </div>
                        
                        <div class="w3-row">
                            <div class="w3-half w3-padding">
                                                <!-- Full name -->
                                <div class="form-group form-group-lg">
                                    <label class="w3-label w3-darkcyan"><?php echo lang('FULLNAME') ?>  <span class="w3-text-red">*</span></label>
                                    <input id="fullname" type="text" name="fullname" class="w3-input w3-text-grey" >   

                                </div>
                                <div class="alert alert-danger alert-fullname w3-margin w3-center"><?php echo lang('FULLNAMERROR') ?></div>                                

                            </div>                    
                            
                                                <!-- Telephone -->
                            <div class="w3-half w3-padding">
                                <div class="form-group form-group-lg">
                                    <label class="w3-label w3-darkcyan"><?php echo lang('PHONE-NUM') ?></label>
                                    <input type="tel" name="telephone" class="w3-input w3-text-grey" >   

                                </div>
                            </div>
                                                <!-- Birth -->
                            <div class="w3-half w3-padding">
                                <div class="form-group form-group-lg">
                                    <label class="w3-label w3-darkcyan"><?php echo lang('BIRTH-DATE') ?></label>
                                    <input type="date" name="birth_date" class="w3-input w3-text-grey" >   

                                </div>
                            </div>
                            
                            <div class="w3-half w3-padding">
                                                        <!-- WILAYA -->        
                              <p class="w3-margin-bottom">
                                <label class="w3-label w3-darkcyan"><?php echo lang('WILAYA') ?></label>          
                                  <select class="w3-select live-wilaya w3-text-grey" name="wilaya" required>
                                    <?php
                                        $stmt1 = $conn->prepare("SELECT * FROM wilayas");
                                        $stmt1->execute();
                                        $cats = $stmt1->fetchAll();

                                        foreach($cats as $cat){

                                            echo "<option value = '" . $cat["wilaya"] . "'>" . $cat["wilaya"] . "</option>" ;

                                                                                    }

                                                ?>

                                    </select>
                                </p>
                            </div>                            
                        
                        </div>    
                                                <!-- SAVE -->
                        <div class="form-group form-group-lg w3-center">
                            <input type="submit"  class="w3-button w3-teal w3-center" value="<?php echo lang('ADD') ?>">
                        
                        </div>
                    
                    </form>
                    

                </div>
                
               <?php 
                
            }
               
            else if($do=='insert'){
                
                    echo "<div class='w3-container'>";                    
                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    // Get the variables from the form
                    
                    $pass = $_POST["password"];
                    $user = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
                    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
                    $fullname = filter_var($_POST["fullname"], FILTER_SANITIZE_STRING);
                    $telephone = $_POST["telephone"];
                    $birth = $_POST["birth_date"];  
                    $wilaya = $_POST["wilaya"];                     
                    
                    $hpass = sha1($pass);
                    // Validation
                    
                    $formErrors = array();
                    
                    if(empty(trim($user)) || strlen($user) < 8 || !preg_match("/^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/", $user)) $formErrors[] = lang('USERERROR') ;
                    
                    
                    // Validate password strength
                    $uppercase = preg_match('@[A-Z]@', $pass);
                    $lowercase = preg_match('@[a-z]@', $pass);
                    $number    = preg_match('@[0-9]@', $pass);
                    $specialChars = preg_match('@[^\d\w]@', $pass);                        

                    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pass) < 8 || empty(trim($pass))) {
                        $formErrors[] = lang('PASSERROR');
                    }
                    
                    if(empty(trim($email))) $formErrors[] = lang('EMAILERROR') ;
                    
                    if(empty(trim($fullname)) || !preg_match("/^[a-zA-Z]+(([' -][a-zA-Z ])?[a-zA-Z]+)*$/", $fullname))  $formErrors[] =  lang('FULLNAMERROR') ;
                                       
                    
                    foreach ($formErrors as $error){
                        
                        echo "<div class='alert-msg w3-margin'>" . $error . "</div>"  ;
                        
                    }
                    
                    echo "<a href='" . $_SERVER["HTTP_REFERER"] . "' class='w3-button w3-teal w3-margin'><i class='fa fa-fw fa-arrow-left'></i></a>" ;                      

                    
                    // Update 
                    
                    if(empty($formErrors)){
                        
                    $check = checkItem("username","users",$user);
                        
                    if($check == 0){    
                    
                    $stmt = $conn->prepare("INSERT INTO users(username, password, email, fullname, groupID, regDate, telephone, birthDate, wilaya) VALUES (:zuser, :zpass, :zemail, :zname, 1, now(), :ztel, :zbirth, :zwilaya)");
                    $stmt->execute(array(
                        "zuser" => $user,
                        "zpass" => $hpass,
                        "zemail" => $email,
                        "zname" => $fullname,
                        "ztel" => $telephone,
                        "zbirth" => $birth,
                        "zwilaya" => $wilaya
                    ));
                    
                    $message = "<div class='success-msg'>" . $stmt->rowCount() . " record inserted" . "</div>";
                    redirection($message,'back',3);    
                        
                    }
                        else{
                            
                        $message = "<div class='alert-msg'>" . lang("USER-EXIST") . "</div>";
                        redirection($message,'back');      
                            
                        }
                    }
                    
                    
                }
                
                else{
                    $message = "<div class='alert-msg'>" . lang("ILLEGAL-BROWSING") . "</div>";
                    redirection($message,5);
                    
                }
                    
                    echo "</div>";
            }
            
            else if($do == 'downgrade'){
                
                // check if the user ID is a number
                
                $userId = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']):0 ;
                
                // Select data
                
                
                $count = checkItem('userID','users',$userId);
                
                echo "<div class='w3-container'>";

                if($count > 0){
                    
                    $stmt = $conn->prepare("UPDATE users SET groupID = 0 WHERE userID = :zuser"); // to avoid SQL injection
                    $stmt->bindParam(":zuser",$userId);
                    $stmt->execute();
                    
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