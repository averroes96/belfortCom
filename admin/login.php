<?php
        
        session_start();
if(isset($_SESSION["username"])){        
        $navbar = "";
        $title = "Login";
        if(isset($_SESSION['user'])){
            header('location: homepage.php'); // redirection to the homepage
        }
        include 'init.php';
        
        
        // Check if the user is coming using POST method
        
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $pass = $_POST['pass'];
            $hpass = sha1($pass);
            
        // Check if user exists
            
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ? AND groupID = 1 LIMIT 1");
            $stmt->execute(array($_SESSION["username"],$hpass));
            $row = $stmt->fetch();    
            $count = $stmt->rowCount();
            
            
            if($count > 0){

                $_SESSION['user'] = $_SESSION["username"];
                $_SESSION["super"] = $row["super"];
                header('location: homepage.php'); // redirection to the homepage
                exit();
                
            }
                else {
                    
                $formErrors = array();
                    
                $formErrors[] = lang("LOGIN-ERROR");    
    
                }
        }
      
        ?>
<body>
    <form class="login w3-white w3-animate-top" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<h3 class="w3-center w3-margin-bottom">Admin Login</h3>
		<input class="w3-input w3-light-grey" type="password" name="pass" placeholder="<?php echo lang("PASSWORD") ?>" />
		<input class="w3-button w3-block w3-teal" type="submit" value="<?php echo lang("LOGIN") ?>" />
        <div class="errors w3-center">
            <?php
    
            if(!empty($formErrors)){
                
                foreach($formErrors as $error){
                    
                    echo "<div class='alert-msg'>" . $error . "</div>"  ;
                }
                
            }
            
            ?>
        
        </div>
	</form>
        <?php
        include $tmp . 'footer.php';
    
}
    else{
        
        header("location:../login.php");
        exit();
    }
        ?> 
