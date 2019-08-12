<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        
      <a class="navbar-brand" href="main.php"><i class = "fa fa-home"></i><?php echo " " . lang('HOME') ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
          <?php
                foreach(getCategories() as $cat){
                    
                    echo "<li><a href='store.php?catID=" . $cat["catID"] . "&name=" . str_replace(" ","-",$cat["name"]) ."'><strong>" . $cat["name"] . "</strong></a></li>" ;
                    
                }
          
          
          ?>
      </ul>
        
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav>