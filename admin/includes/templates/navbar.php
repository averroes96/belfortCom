
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
        
      <a class="navbar-brand" href="homepage.php"><i class = "fa fa-chart-line"></i><?php echo " " . lang('DASHBOARD') ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
          <?php 
            if($_SESSION['group'] == 1) {
        echo "<li><a href='categories.php'><strong>" . lang('CATEGORIES') . "</strong></a></li>";
            }
          ?>
          <li><a href="annonces.php"><strong><?php echo lang('ITEMS') ?></strong></a></li>
          <li><a href="members.php"><strong><?php echo lang('MEMBERS') ?></strong></a></li>
          <li><a href="../main.php"><strong>Shop</strong></a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong><?php echo $_SESSION['user'] ?></strong><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="members.php?do=edit&userID=<?php echo $_SESSION['id'] ?>"><?php echo lang('EDIT') ?></a></li>
            <li><a href="#"><?php echo lang('SETTINGS') ?></a></li>
            <li><a href="logout.php"><?php echo lang('LOGOUT') ?></a></li>

          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav>