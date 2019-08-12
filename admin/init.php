<?php
    
    include "config.php";
    
    // Routes

       $tmp = "includes/templates/"; // templates directory
       $css = "layout/css/"; // css directory
       $js = "layout/js/"; // js directory
       $lang = "includes/languages/"; // languages directory
       $func = "includes/functions/"; // functions directory

        if(isset($_COOKIE["language"]))
            $language = $_COOKIE["language"];
        else
            $language = "fr";

       // Include the important files
       include $func . 'functions.php';
       include $lang . $language. '.php';
       include $tmp . 'header.php';
    echo "<body class='" . $title . "'>";   
   
    if($title == "Dashboard"){
       
       include $tmp . 'dashNav.php';
       
        }