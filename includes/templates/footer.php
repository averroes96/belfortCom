  <!-- Site footer -->
    <footer class="site-footer">

      <div class="w3-container">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <p class="copyright-text w3-small"><a href="main.php" class="w3-bar-item w3-margin-right w3-small w3-hover-text-light-grey">BelfortCom</a>
            Copyright &copy; 2019 Made by Meceffeuk & Larbi & Khiat.             <a href="javascript:void(0)" class="w3-margin w3-grey w3-text-white w3-button w3-round log-sign" onclick="document.getElementById('idlanguage').style.display='block'">
                        <?php   echo $language  ?>
                </a>             <a href="contact.php" class="w3-margin w3-large w3-center w3-hover-text-light-grey"><?php echo lang("CONTACT-US") ?></a></p>
            
             
        </div>            

      </div>
            <div id="idlanguage" class="w3-modal" style="z-index:4" onclick="this.style.display='none'">
            <form action="includes/functions/rememberme.php" method="post" >    
              <div class="w3-animate-zoom">

                <div class="w3-panel w3-center">                 
                    <button value="fr" class="w3-button w3-teal" type="submit" name="fr"><img class="w3-margin-right" src="uploads/site_images/flag-round-250.png" alt="fr" style="width:16px">Français</button>
                    <button value="en" class="w3-button w3-teal" name="en" type="submit"><img class="w3-margin-right" src="uploads/site_images/flag-round-250 (1).png" alt="en" style="width:16px">English</button>
                  </div>
 

              </div>
            </form>    
            </div>         
        
    </footer>

    <script src="<?php echo $js ?>jquery-3.3.1.min.js" ></script>  
    <script src="<?php echo $js ?>jquery-ui.min.js" ></script> 
    <script src="<?php echo $js ?>front.js"></script>
    <script src="<?php echo $js ?>bootstrap.min.js"></script>
    <script src="<?php echo $js ?>login.js"></script>
    <script src="<?php echo $js ?>store.js"></script>
    <script src="<?php echo $js ?>show.js"></script>
    <script src="<?php echo $js ?>main.js"></script>
    <script src="<?php echo $js ?>ajout.js"></script>
    <script src="<?php echo $js ?>tagsinput.js"></script>
    <script src="<?php echo $js ?>search.js"></script>
    <script src="<?php echo $js ?>messages.js"></script>
    <script src="<?php echo $js ?>settings.js"></script>
    <script src="layout/intl-tel-input-master/build/js/intlTelInput.js"></script>
    <script>
      var input = document.querySelector("#phone");
      window.intlTelInput(input);
    </script>
    </body>
</html>
