<?php
    ob_start();
    $title = "Forgot password";
    session_start();
    include "init.php";

    if (isset($_SESSION['username'])){
        header('Location: profile.php?userID=' . $_SESSION["id"]);
        exit;
    }

        
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require 'C:\xampp\composer\vendor\autoload.php';

    // Instantiation and passing `true` enables exceptions

    require 'C:\xampp\composer\vendor\phpmailer\phpmailer\src\Exception.php';
    //require 'C:\xampp\composer\vendor\phpmailer\phpmailer\src\PHPMailer.php';
    require 'C:\xampp\composer\vendor\phpmailer\phpmailer\src\SMTP.php';
    // Import PHPMailer classes into the global namespace

$mail = new PHPMailer(true);        

    if($_SERVER["REQUEST_METHOD"]){
        $valid = true;


        if (isset($_POST['oublie'])){
            $mail1 = filter_var($_POST['mail'],FILTER_SANITIZE_EMAIL); // On récupère le mail afin d envoyer le mail pour la récupèration du mot de passe 
            
            // Si le mail est vide alors on ne traite pas
            if(empty(trim($mail1))){
                $valid = false;
                $er_mail = lang("EMAILERROR");
            }

            if($valid){
                
                    $stmt = $conn->prepare("SELECT * FROM users WHERE email = '$mail1'");
                    $stmt-> execute();
                    $result = $stmt->fetch();
                if(!empty($result)){

                        $new_pass = generateRandomString();
                        $real_pass = sha1($new_pass);
                        
                    $stmt1 = $conn->prepare("UPDATE users SET password = '$real_pass' WHERE email = '$mail1'");
                    $stmt1->execute();
                          //echo($verification_mail['mail']);
                          $succes_msg = lang("PASS-CHANGED") ;
                        
                            if($stmt1){
                            try {
                               /* Set the mail sender. */
                               $mail->setFrom("addavigner@gmail.com");

                               /* Add a recipient. */
                               $mail->addAddress($mail1);

                               /* Set the subject. */
                               $mail->Subject = "New Password";

                               /* Set the mail message body. */
                               $mail->Body = "votre nouveau mot passe est : $new_pass . Vous pouvez changer se mot de passe dans les parametres";

                               /* Finally send the mail. */
                               $mail->send();
                                
                            ?>
<?php
                                header("location:login.php?success=" . $succes_msg);
                                exit();
                            }
                            catch (Exception $e)
                            {
                               /* PHPMailer exception. */
                               echo $e->errorMessage();
                            }
                            catch (\Exception $e)
                            {
                               /* PHP exception (note the backslash to select the global namespace Exception class). */
                               echo $e->getMessage();
                            }
                            }
                            else
                                echo "DATABASE ERROR";
                          
 
                }
                else{
                    
                    $fail_msg = lang("NO-EMAIL");
                }
            }
        }
    }
?>

    <div class="w3-container w3-content w3-margin-top" style="min-height:-webkit-fill-available; ">
    <div class="w3-main w3-white w3-card w3-padding">    
        <h3 class="w3-center w3-text-red"><?php echo lang("LOST-INFO") ?> !</h3>
        <div class="w3-center alert alert-info">
            <p><b><?php echo lang("FORGOT-PASS1") ?></b> </p>
           <p> <?php echo lang("FORGOT-PASS2") ?> </p>
        </div>
        <br>
        <form style="margin:0 20%" method="post" class="" action="">
            <?php
                if (isset($er_mail)){
            ?>
                <div class="alert alert-danger"><?php echo $er_mail ?></div>
            <?php   
                }
            ?>
           <p class="input-container">
               <input id="contEmail" class="w3-input w3-text-grey" type="email" placeholder="Email" name="mail" required value="<?php if (isset($_POST["mail"])) echo $_POST["mail"] ?>">
            </p>
            <div class="alert alert-danger w3-margin alert-contEmail"><?php echo lang('EMAILERROR')  ?></div>
            
            <p class="w3-center"><button type="submit" name="oublie" class="w3-teal w3-button w3-block"><?php echo lang("SEND") ?></button></p>
            <?php if (isset($succes_msg)){   ?>            
                        <p class="alert alert-success"><?php echo $succes_msg ?></p>
            <?php   }   ?>

            <?php if (isset($fail_msg)){   ?>            
                        <p class="alert alert-danger"><?php echo $fail_msg ?></p>
            <?php   }   ?>           
        </form>         
        
    </div>
               
    </div>
<?php
        include $tmp . 'footer.php';
    ob_end_flush();

?>