<?php

    ob_start();
    session_start();

    $title = "Contact";
    
    include "init.php";


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $subject = filter_var($_POST["subject"],FILTER_SANITIZE_STRING);
        $email = filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
        $message = filter_var($_POST["message"],FILTER_SANITIZE_STRING);
        
        $formErrors = array();
        
                if(strlen($subject) < 7 || empty(trim($subject))) $formErrors[] = lang('SUBJECT-NAME-ERROR') ;
                    
                if(strlen($subject) > 50) $formErrors[] = lang('SUBJECT-NAME-ERROR1') ;
            
                if(empty(trim($message)) || strlen($message) < 20) $formErrors[] = lang('SUBJECT-CONTENT-ERROR') ;  
        
        if(empty($formErrors)){
            
            
            mail('addavigner@gmail.com',$subject, $message );


        }
        
    }

?>
    <div class="w3-container w3-content">
        
<?php
        if(!empty($formErrors)){
            
            foreach($formErrors as $error){
                
                echo $error;                
                
            }
            
            
        }
        ?>

            <div class="w3-card w3-animate-zoom w3-margin-top w3-white">

                <div class="w3-container w3-padding w3-teal">
                    <h2><?php echo lang("CONTACT-US") ?></h2>
                </div>
                <div class="w3-panel">
                    <form class="w3-container w3-padding" action="" method="post">                   
                    <div class="w3-section">
                        <label><?php echo lang("TITLE") ?></label>
                        <input id="title" class="w3-input" style="width:100%;" type="text" required name="subject">
                        <div class="alert alert-danger w3-margin alert-title"><?php echo lang('SUBJECT-NAME-ERROR')  ?></div>
                    </div>
                    <div class="w3-section">
                      <label>Email</label>
                      <input id="contEmail" class="w3-input" style="width:100%;" type="text" required name="email">
                        <div class="alert alert-danger w3-margin alert-contEmail"><?php echo lang('EMAILERROR')  ?></div>                        
                    </div>
                    <div class="w3-section">
                      <label>Message</label>
                        <textarea id="contMessage" rows="5" class="w3-textarea w3-input" required name="message"></textarea>
                        <div class="alert alert-danger w3-margin alert-contMessage"><?php echo lang('SUBJECT-CONTENT-ERROR')  ?></div>                         
                    </div>
                    <button type="submit" class="w3-button w3-teal w3-right w3-round">Send</button>
                    </form>                
                </div>

    
            </div>
        
</div>

<?php

    include $tmp ."footer.php";

?>
