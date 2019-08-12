        <nav class="w3-sidebar w3-bar-block w3-white w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
          <div class="w3-container w3-display-container w3-padding-16">
            <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
            <a href="main.php" class="w3-bar-item w3-button w3-padding"><h3 class="w3-wide"><b>Tabula</b></h3></a>
          </div>
          <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
        <?php
              
            $i = 1;
            
            foreach(getCategories() as $cat){

                $subCategories = getSubCategories($cat["catID"]);
                            
                if(!empty($subCategories)){
                    
                echo '<a onclick="myAccFunc'. $i . '()" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="myBtn">' . $cat["name"] . '<i class="fa fa-caret-down"></i>
                </a>';
                echo '<div id="demoAcc'. $i . '" class="w3-bar-block w3-hide w3-padding-large w3-medium">';    
                    foreach($subCategories as $subcat){
                        
                              echo '<a href="store.php?catID='. $subcat["catID"] . '&name='. $subcat["name"] . '" class="w3-bar-item w3-button">' . $subcat["name"] . '</a>';                                 
                        
                                }
                    echo '</div>';
                    
                    
                        }
                else
                    
                    echo '<a href="store.php?catID='. $cat["catID"] . '&name='. $cat["name"] . '" class="w3-bar-item w3-button">' . $cat["name"] . '</a>';
              
              $i++;
            }
                ?>
          </div>
          <a href="newAd.php" class="w3-bar-item w3-button w3-padding"><?php echo lang("NEW-AD") ?></a> 
          <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding" onclick="document.getElementById('newsletter').style.display='block'">Newsletter</a> 
          <a href="#footer"  class="w3-bar-item w3-button w3-padding">Subscribe</a>
        </nav>

<!-- Top menu on small screens -->
<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
  <a href="main.php" style="text-decoration:none" class="w3-bar-item w3-padding-24 w3-wide">Tabula</a>
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:250px">

  <!-- Push down content on small screens -->
    <div class="w3-hide-large" style="margin-top:83px"></div>