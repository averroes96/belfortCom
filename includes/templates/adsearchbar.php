<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-light-grey w3-collapse w3-top" style="z-index:3;width:260px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright"></i>
    <h3>Rental</h3>
    <h3>from $99</h3>
    <h6>per night</h6>
    <hr>
    <form action="/action_page.php" target="_blank">
      <p><label><i class="fa fa-calendar-check-o"></i> Check In</label></p>
      <input class="w3-input w3-border" type="text" placeholder="DD MM YYYY" name="CheckIn" required>          
      <p><label><i class="fa fa-calendar-o"></i> Check Out</label></p>
      <input class="w3-input w3-border" type="text" placeholder="DD MM YYYY" name="CheckOut" required>         
      <p><label><i class="fa fa-male"></i> Adults</label></p>
      <input class="w3-input w3-border" type="number" value="1" name="Adults" min="1" max="6">              
      <p><label><i class="fa fa-child"></i> Kids</label></p>
      <input class="w3-input w3-border" type="number" value="0" name="Kids" min="0" max="6">
      <p><button class="w3-button w3-block w3-green w3-left-align" type="submit"><i class="fa fa-search w3-margin-right"></i> Search availability</button></p>
    </form>
  </div>
  <div class="w3-bar-block">
    <a href="#apartment" class="w3-bar-item w3-button w3-padding-16"><i class="fa fa-building"></i> Apartment</a>
    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-16" onclick="document.getElementById('subscribe').style.display='block'"><i class="fa fa-rss"></i> Subscribe</a>
    <a href="#contact" class="w3-bar-item w3-button w3-padding-16"><i class="fa fa-envelope"></i> Contact</a>
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
  <span class="w3-bar-item">Rental</span>
  <a href="javascript:void(0)" class="w3-right w3-bar-item w3-button" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>