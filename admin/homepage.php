<?php
        
        session_start();
        
        $title = "Dashboard";
        
        
        if(isset($_SESSION['user'])){
            include 'init.php';
            include 'chart.php';
            wilayaPercentage();            
            
?>
            
<div class="w3-main" style="margin-left:300px; margin-top:45px">            
            

  <div class="w3-row-padding w3-margin w3-white">
      
  <!-- Header -->
  <header class="w3-container" id="overview">
    <h3 class="w3-text-teal w3-center w3-animate-top" ><b><i class="fa fa-dashboard"></i><?php echo lang('TOTAL') ?></b></h3>
  </header>      
    <div class="w3-quarter">
    <a class="w3-animate-top" href="annonces.php" style="text-decoration:none;">         
      <div class="w3-container w3-red w3-padding-16 w3-hover-shadow w3-display-container">
        <div class="w3-left"><i class="fa fa-bullhorn w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo countItems('itemID', 'items') ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4><?php echo lang('TOTAL-ITEMS') ?></h4>
        <span class="w3-tiny w3-display-bottomright" style="padding:0 8px"><?php echo countItems("itemID","items",true,"pending", "0") . " " . lang("PENDING") ?></span>  
      </div>
        </a>
    </div>
    <div class="w3-quarter">
    <a class="w3-animate-top" href="comments.php" style="text-decoration:none;">   
      <div class="w3-container w3-blue w3-padding-16 w3-hover-shadow w3-display-container w3-nowrap">
        <div class="w3-left"><i class="fa fa-comments w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo countItems('comID', 'comments') ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4><?php echo lang('TOTAL-COMMENTS') ?></h4>
        <span class="w3-tiny w3-display-bottomright" style="padding:0 8px"><?php echo getNew("comments","comDate") . " " . lang("THIS-WEEK") ?></span>            
      </div>
        </a> 
    </div>
    <div class="w3-quarter">
<a class="w3-animate-top" href="members.php" style="text-decoration:none;">         
      <div class="w3-container w3-teal w3-text-white w3-padding-16 w3-hover-shadow w3-display-container">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo countItems('userID', 'users', true, 'groupID', 0) ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4><?php echo lang('TOTAL-MEMBERS') ?></h4>
        <span class="w3-tiny w3-display-bottomright" style="padding:0 8px"><?php echo getNew("users","regDate") . " " . lang("THIS-WEEK") ?></span>            
      </div>
    
        </a>    
    </div>
    <div class="w3-quarter">
<a class="w3-animate-top" href="forum.php" style="text-decoration:none;">         
      <div class="w3-container w3-orange w3-text-white w3-padding-16 w3-hover-shadow w3-display-container">
        <div class="w3-left"><i class="fa fa-file w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo countItems('subID', 'subject') ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4><?php echo lang('SUBJECTS') ?></h4>
        <span class="w3-tiny w3-display-bottomright" style="padding:0 8px"><?php echo getNew("subject","sub_date") . " " . lang("THIS-WEEK") ?></span>           
      </div>
        </a>    
    </div>      
      
  </div>
<div class="w3-container w3-white w3-padding w3-margin">    
    <h2 class="w3-center w3-margin w3-text-teal"><i class="fa fa-fw fa-chart-bar"></i> <?php echo lang("GENERAL-STATS") ?></h2>
    <div class="w3-row-padding w3-white w3-margin">
        <div class="w3-half">
            <canvas id="myChart"></canvas>
        </div>
        <div class="w3-half">
            <canvas id="myChart1"></canvas>
        </div>        
    </div>
    <p class="w3-text-grey"><?php echo lang("NEW-ADS") ?></p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-teal" style="width:<?php echo (integer)((getNew("items","DATE(add_date)") / getTotal("items"))*100) ?>%"><?php echo (integer)((getNew("items","DATE(add_date)") / getTotal("items"))*100) ?>%</div>
    </div>

    <p class="w3-text-grey"><?php echo lang("NEW-MEMBERS") ?></p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-teal" style="width:<?php echo (integer)((getNew("users","regDate") / getTotal("users"))*100) ?>%"><?php echo (integer)((getNew("users","regDate") / getTotal("users"))*100) ?>%</div>
    </div>    
    
</div>    
    <script>
    Chart.defaults.global.title.display = true;
    Chart.defaults.global.title.text = "pas de titre"   
    </script>
    
    <script type="">
    
        var ctx = document.getElementById("myChart").getContext("2d");
        var chart = new Chart(ctx, {
            
            type: "bar",
            data: {
                
                labels: ['',<?php echo $dates ?>],
                datasets: [{
                    
                    label: "<?php echo lang("MEMBERS") ?>",
                    backgroundColor: "rgb(0,128,128)",
                    borderColor: "rgb(0,139,139)",
                    data: ['0',<?php echo $nombres; ?>],
                    steppedLine: true
                    
                }]
                
            },
            options: {
                
                title:{
                    text:"<?php echo lang("ADS-PER-MONTH") ?>"
                }
            }
            
            
        });
    
    </script>
    <script type="">
    
        var ctx = document.getElementById("myChart1").getContext("2d");
        var chart = new Chart(ctx, {
            
            type: "bar",
            data: {
                
                labels: ['',<?php echo $item_dates ?>],
                datasets: [{
                    
                    label: "<?php echo lang("ADS") ?>",
                    backgroundColor: "rgb(0,128,128)",
                    borderColor: "rgb(0,139,139)",
                    data: ['0',<?php echo $item_nombres; ?>],
                    steppedLine: true
                    
                }]
                
            },
            options: {
                
                title:{
                    text:"<?php echo lang("USERS-PER-MONTH") ?>"
                }
            }
            
            
        });
    
    </script>    
    
    
<hr>
  <div class="w3-container w3-padding">           
    
  <div class="w3-container">
    <h3 class="w3-text-teal w3-center w3-margin"><?php echo lang("WILAYAS") ?></h3>
        <button class="w3-button w3-teal see-all w3-margin-bottom"><?php echo lang("SEE-ALL") ?>  <i class="fa fa-arrow-right"></i></button>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white w3-text-dark-grey top-6">
<?php 
    foreach(getAllFrom("*", "Wilayas","","ORDER BY percentage","DESC", "LIMIT 6") as $wilaya){  ?>            
      <tr>
        <td><?php echo $wilaya["wilaya"] ?></td>
        <td><?php 
                                                                                              
        echo (integer)perWilaya($wilaya["wilaya"], "items") ?>%</td>
        </tr>      
<?php } ?>          
    </table>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white w3-text-dark-grey all-wilayas" style="display:none">
<?php 
    foreach(getAllFrom("*", "Wilayas","","ORDER BY percentage","DESC") as $wilaya){  ?>            
      <tr>
        <td><?php echo $wilaya["wilaya"] ?></td>
        <td><?php 
                                                                                              
        echo (integer)perWilaya($wilaya["wilaya"], "items") ?>%</td>
        </tr>      
<?php } ?>          
    </table>      


  </div>
    <hr>

  <div class="w3-container w3-white">

    <h3 class="w3-center w3-margin w3-text-teal"><?php echo '  '.lang('LATEST-MEMBERS') ?></h3>
    <ul class="w3-ul w3-card-4 w3-white w3-hoverable">
                                 <?php 
                                    $latest = getLatest("*","users","userID");
            
                                    if(!empty($latest)){

                                    foreach($latest as $user){
                                        echo '<li class="w3-padding-16">';
                                        echo "<a href='../profile.php?do=show&userID=".$user["userID"] . "' style='text-decoration: none;'>";
                                        
                                        if(!empty(trim($user["image"]))){
                                            
                                            echo '<img src="../uploads/profile_pictures/' . $user["image"] .'" class="w3-left w3-circle w3-margin-right" style="width:35px; height:35px;">';
                                        }
                                        else {
                                            
                                            echo "<img src='../uploads/profile_pictures/user.png' alt='' class='w3-left w3-circle w3-margin-right' style='width:35px' />";  
                                        }
                                        
                                        echo '<span class="w3-xlarge">'. $user["username"] . '</span><br>';
                                        
                                        echo "</a>";
                                        echo "<a href='members.php?do=delete&userID=".$user["userID"]."'><span class='w3-button w3-red pull-right confirm' style='position: relative; top: -30px; padding:3px 5px'><i class='fa fa-fw fa-large fa-trash'></i></a>";
                                        
                                        echo "<a href='../profile.php?do=show&userID=".$user["userID"]."'><span class='w3-button w3-margin-right w3-blue pull-right' style='position: relative; top: -30px; padding:3px 5px'><i class='fa fa-fw fa-large fa-eye'></i></a>";                                        
                                        echo "</li>";

                                    }
                                    }
                                    else {
                    
                                        echo "<div class='alert alert-info text-center'>" . lang("NO-MEMBERS") . "</div>"  ;
                                    }

                                ?>        
        

    </ul>
  </div>
    
  <div class="w3-container w3-card w3-white">
    <h3 class="w3-margin w3-center w3-text-teal"><?php echo '  '.lang('LATEST-COMMENTS') ?></h3>
            <?php 
                    $latestComments = getLatestComments();
            
                    if(!empty($latestComments)){

                        foreach($latestComments as $comment){
                            echo '<div class="w3-row" style="margin-bottom:10px;">';
                            echo '<div class="w3-col m2 text-center">';
                            
                            if(!empty(trim($comment["image"]))){
                                            
                                echo '<img src="../uploads/profile_pictures/' . $comment["image"] .'" class="w3-circle w3-border" style="width:96px;height:96px">';
                                    }
                                    else {
                                            
                                        echo "<img src='../uploads/profile_pictures/user.png' alt='' class='w3-circle' style='width:96px; height:96px' />";  
                                    }
                            echo '</div>';
                            echo '<div class="w3-col m10 w3-container">
                                    <h4 class="w3-darkcyan"><a href = "../profile.php?do=show&userID=' . $comment["userID"] . '">'. $comment["username"] .'</a><span class="w3-medium w3-text-grey">'. " " . $comment["comDate"] .'</span></h4>
                                    <p><span>'. $comment["content"] .'</span><a class="w3-right" href = "../showAd.php?itemID=' . $comment["itemID"] . '">'. $comment["item_name"] .'</a></p><br>
                                  </div>';
                            echo '</div>';

                                            }
                    } else {
                                        
                            echo "<div class='alert alert-info text-center'>" . lang("NO-COM") . "</div>"  ;
                                        
                            }

                ?>     
    
  </div>
  <br>    
    
</div>    



<?php
            
            include $tmp . 'footer.php';
        }
        else{
            header('location: login.php');
            exit();
        }
        ?>

