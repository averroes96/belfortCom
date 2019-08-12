<div class="w3-bar w3-top w3-teal w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <a href="../main.php"> <span class="w3-bar-item w3-right">BelfortCom</span> </a>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row w3-margin-bottom">
    <div class="w3-col s4">
<?php
    if(!empty($_SESSION["image"])) {   ?>        
        <img src="../uploads/profile_pictures/<?php echo $_SESSION["image"] ?>" class="w3-circle" style="width:46px; height:46px">
<?php   } else   { ?>
        <img src="../uploads/profile_pictures/user.png" class="w3-circle" style="width:46px; height:46px"> 
<?php   }   ?>        
        
    </div>
    <div class="w3-col s8 w3-bar">
      <span class="w3-nowrap w3-small" style="color:darkcyan;"><?php echo lang("WELCOME") ?>, <strong><?php echo $_SESSION["username"] ?></strong></span><br>
      <a href="../messages.php" class="w3-bar-item w3-button" style="color:darkcyan;"><i class="fa fa-envelope"></i></a>
      <a href="../profile.php?do=show&userID=<?php echo $_SESSION["id"] ?>" class="w3-bar-item w3-button" style="color:darkcyan;"><i class="fa fa-user"></i></a>

  
      <a href="../settings.php" class="w3-bar-item w3-button" style="color:darkcyan;"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <div class="w3-bar-block navLinks">
    <a href="homepage.php#overview" class="w3-bar-item w3-button w3-padding w3-teal w3-hover-black" style="text-decoration: none;"><i class="fa fa-users fa-fw"></i> Overview</a>
    <a href="categories.php" class="w3-bar-item w3-button w3-padding w3-teal w3-hover-black" style="text-decoration: none;"><i class="fa fa-list-alt fa-fw"></i>   <?php echo  "  " . lang('CATEGORIES') ?></a>
    <a href="annonces.php" class="w3-bar-item w3-button w3-padding w3-teal w3-hover-black" style="text-decoration: none;"><i class="fa fa-bullhorn fa-fw"></i>   <?php echo lang('ITEMS') ?></a>
    <a href="members.php" class="w3-bar-item w3-button w3-padding w3-teal w3-hover-black" style="text-decoration: none;"><i class="fa fa-users fa-fw"></i>  <?php echo lang('MEMBERS') ?></a>
    <a href="forum.php" class="w3-bar-item w3-button w3-padding w3-teal w3-hover-black" style="text-decoration: none;"><i class="fa fa-comment fa-fw"></i>  Forum</a>
    <a href="comments.php" class="w3-bar-item w3-button w3-padding w3-teal w3-hover-black" style="text-decoration: none;"><i class="fa fa-comments fa-fw"></i>  <?php echo lang("COMMENTS") ?></a>
<?php
        if($_SESSION["super"] == 1){    ?>
    <a href="admins.php" class="w3-bar-item w3-button w3-padding w3-teal w3-hover-black" style="text-decoration: none;"><i class="fa fa-user fa-fw"></i>  <?php echo lang("ADMINS") ?></a>            
          
<?php            
        }
         ?> 
  </div>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>