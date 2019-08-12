<?php 
    ob_start();
    session_start();

        $LogSign ="";
        $title = "Login";
        if(isset($_SESSION['username'])){
            header('location: main.php'); // redirection to the homepage
        }
        include "init.php";

        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
        if(isset($_SESSION['username'])){
            header('location: main.php'); // redirection to the homepage
        }
            
            if(isset($_POST["login"])){
            
            $username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
            $pass = $_POST['password'];
            
           $hpass = sha1($pass);
            
        // Check if user exists
            
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ? LIMIT 1");
            $stmt->execute(array($username,$hpass));
            $row = $stmt->fetch();    
            $count = $stmt->rowCount();

            if($count > 0){

                $_SESSION['username'] = $row['username']; // register session name
                $_SESSION['id'] = $row['userID'];
                $_SESSION['group'] = $row['groupID'];
                $_SESSION['fullname'] = $row['fullname'];
                $_SESSION["image"] = $row["image"];// register user id
                $_SESSION["interests"] = $row["interests"];
                header('location: profile.php?do=show&userID='. $_SESSION['id'] ); // redirection to the homepage
                exit();
                
            }
                else {
                    
                $formErrors = array();
                    
                $formErrors[] = lang("LOGIN-ERROR");    
                    
                }
            }
            
            
            else{
                
                $formErrors = array();
                
                $username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
                $hpass = sha1($_POST['password']);
                $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                $fullname = filter_var($_POST['fullname'],FILTER_SANITIZE_STRING);;
                
                if(isset($_POST['username'])){
                    
                    $filteredUser = filter_var(($_POST['username']),FILTER_SANITIZE_STRING);
                    
                    if(strlen($filteredUser) < 8 || empty(trim($filteredUser))) $formErrors[] = lang('STRLEN') ;
                    
                    if(strlen($filteredUser) > 30) $formErrors[] = lang('STRLEN1') ;
                    
                    if(!preg_match("/^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/", $filteredUser))
                        $formErrors[] = lang("USERNAME-JS");
                    
                }
                
                if(!preg_match("/^[a-zA-Z]+(([' -][a-zA-Z])?[a-zA-Z]+)*$/", $fullname))
                    $formErrors[] = lang("FULLNAME-JS");
                
                if(isset($_POST['password']) && isset($_POST['password-confirm'])){
                    
                    
                    $password = $_POST["password"];
                    
                    // Validate password strength
                    $uppercase = preg_match('@[A-Z]@', $password);
                    $lowercase = preg_match('@[a-z]@', $password);
                    $number    = preg_match('@[0-9]@', $password);
                    $specialChars = preg_match('@[^\d\w]@', $password);                        

                    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                        $formErrors[] = lang("WEAK-PASS");
                    }
                  
                    
                    $pass1 = sha1($_POST['password']);
                    $pass2 = sha1($_POST['password-confirm']);
                    
                    if($pass1 !== $pass2){
                        
                        $formErrors[] = lang("PASS-ERROR") ;
                        
                    }
                    
                }                
                
                if(isset($_POST['email'])){
                    
                    $filteredEmail = filter_var(($_POST['email']),FILTER_SANITIZE_EMAIL);
                    
                    if(filter_var($filteredEmail, FILTER_SANITIZE_EMAIL) != true){
                        
                        $formErrors[] = lang("EMAIL-ERROR") ;
                    }
                    
                    include_once 'data/files/class.verifyEmail.php';

                    $vmail = new verifyEmail();
                    $vmail->setStreamTimeoutWait(20);
                    $vmail->Debug= FALSE;
                    $vmail->setEmailFrom('viska@viska.is');

                    if ($vmail->check($email)) {
                        echo 'email &lt;' . $email . '&gt; exist!';
                    } elseif (verifyEmail::validate($email)) {
                        $formErrors[] = 'email &lt;' . $email . '&gt; valid, but not exist!';
                    } else {
                        $formErrors[] = 'email &lt;' . $email . '&gt; not valid and not exist!';
                    }                    
                    
                }
                
                if(empty($formErrors)){
                        
                    $checkUsername = checkItem("username","users",$username);
                    $checkEmail = checkItem("email","users",$email);    
                    if($checkUsername == 0 && $checkEmail == 0 ){
                       
                    
                    $stmt = $conn->prepare("INSERT INTO users(username, password, email, fullname, regDate) VALUES (:zuser, :zpass, :zemail, :zname, now())");
                    $stmt->execute(array(
                        "zuser" => $username,
                        "zpass" => $hpass,
                        "zemail" => $email,
                        "zname" => $fullname          
                    ));
                    
                    $successMsg = "<div class='alert alert-success'>" . lang("SUCCESS-SIGNUP") . "</div>"; 

                    // Check if user exists

                        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ? LIMIT 1");
                        $stmt->execute(array($username,$hpass));
                        $row = $stmt->fetch();    
                        $count = $stmt->rowCount();

                        if($count > 0){

                            $_SESSION['username'] = $row['username']; // register session name
                            $_SESSION['id'] = $row['userID'];
                            $_SESSION['group'] = $row['groupID'];
                            $_SESSION['fullname'] = $row['fullname'];// register user id
                            $_SESSION["image"] = $row["image"];
                            $_SESSION["interests"] = $row["interests"];
                            $_SESSION["success"] = lang("SIGNUP-MSG");
                            header('location: profile.php?userID='.$row['userID']); // redirection to the profile page
                            exit();


                        }                        
                        
                    }
                        else{
                            
                        $formErrors[] = lang("USER-EXIST") ;    
                            
                        }
                    }
                    
                
            }
        }
      
?>

    <div class="w3-container forms w3-content" style="min-height:-webkit-fill-available;">
        
        <div class="w3-card w3-round w3-white w3-padding-32 w3-animate-zoom" style="margin: 10% 20%">     
        <h1 class="text-center w3-text-red" style="margin-bottom: 20px;"><span class="active " data-class="login"><i class="fa fa-fw fa-sign-in-alt"></i></span> | <span data-class="signup"><i class="fa fa-fw fa-user-plus"></i></span>
            </h1>
        
                          <!-- LOGIN FORM -->
        <form class="login w3-padding" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            
            <input class="w3-input w3-hover-shadow w3-text-grey" type="text" name="username" placeholder="<?php echo lang("USERNAME") ?>" autocomplete="off">
            <i class="fa fa-user"></i>             
            <input class="w3-input w3-hover-shadow w3-text-grey " type="password" name="password" placeholder="<?php echo lang("PASSWORD") ?>" autocomplete="new-password">
            <i class="fa fa-key"></i>             
            <p><input class="w3-button w3-block w3-teal" name="login" type="submit" value="<?php echo lang("LOGIN") ?>"></p>
                <p class="w3-center"><a href="forget-password.php" class="w3-text-teal w3-hover-text-red" style="cursor: pointer"><?php echo lang("FORGOT-PASS") ?></a></p>            
        
        </form>
        
                                <!-- SIGNUP FORM -->
        
        <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="input-container">
            <input class="w3-input w3-hover-shadow w3-text-grey" id="username" type="text" name="username" placeholder="<?php echo lang("USERNAME") ?>" autocomplete="off" required="required" maxlength="30" value="<?php if(isset($_POST["username"])) echo $_POST["username"] ?>">
            <i class="fa fa-user"></i>
                <div class="alert alert-danger w3-margin alert-username"><?php echo lang("USERNAME-JS") ?></div>                
            </div>         
            <div class="input-container">
            <input class="w3-input w3-hover-shadow w3-text-grey" type="password" id="password" name="password" placeholder="<?php echo lang("PASSWORD") ?>" autocomplete="new-password" required="required" maxlength="50">
            <i class="fa fa-key"></i>
                <div class="alert alert-danger w3-margin alert-password"><?php echo lang("WEAK-PASS") ?></div>                   
            </div>    
            <input class="w3-input w3-hover-shadow w3-text-grey" type="password" name="password-confirm" placeholder="<?php echo lang("PASSWORD-CONFIRM") ?>" autocomplete="new-password" >
            <i class="fa fa-key"></i>            
            <div class="input-container">
            <input class="w3-input w3-hover-shadow w3-text-grey" type="email" name="email" placeholder="<?php echo lang("EMAIL") ?>" autocomplete="off" required="required" maxlength="80" minlength="5" value="<?php if(isset($_POST["email"])) echo $_POST["email"] ?>">
            <i class="fa fa-envelope"></i>                
            </div>
            <div class="input-container">
            <input class="w3-input w3-hover-shadow w3-text-grey" type="text" name="fullname" id="fullname" placeholder="<?php echo lang("FULLNAME") ?>" autocomplete="off" maxlength="80" required value="<?php if(isset($_POST["fullname"])) echo $_POST["fullname"] ?>">
            <i class="fa fa-id-card"></i>
                <div class="alert alert-danger w3-margin alert-fullname"><?php echo lang("FULLNAME-JS") ?></div>                
            </div>                
            <input class="w3-button w3-block w3-teal" style="background-color:darkcyan" name="signup" type="submit" value="<?php echo lang("SIGNUP") ?>">
            <p class="w3-text-red w3-center">* : <b><?php echo lang("REQUIRED") ?></b></p>
        </form>

        <div class="errors w3-center">
            <?php
    
            if(!empty($formErrors)){
                
                
                foreach($formErrors as $error){
                    echo "<div class='w3-container'>";
            ?><span onclick='this.parentElement.style.display="none"' class='close-btn'><i class='fa fa-times'></i></span>
                <?php
                    echo "<div class='alert-msg'>" . $error . "</div>"  ;
                    echo '</div>';
                }
                
            }
            
            if(isset($successMsg)){
                
                echo $successMsg;
                header('location: profile.php?userID='.$row['userID']); // redirection to the profile page
                exit();
                
            }
            if(isset($_GET["success"])){
                if($_GET["success"] == lang("PASS-CHANGED"))
                echo "<p class='alert alert-info'>" . lang("PASS-CHANGED") . "</p>";
                
            }              
            
            ?>
        
        </div>
            
            
            </div>
        </div> 


<?php
        
    include $tmp ."footer.php";

    ob_end_flush();
?>