<?php
    ob_start();


    if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(isset($_POST["fr"])){
            
            setcookie("language","fr",time() + 3600*24, "/");
            
        }
        else if(isset($_POST["en"])){
            
            setcookie("language","en",time() + 60*60*24*30, "/");
            
        }
        
        header("location:" . $_SERVER["HTTP_REFERER"]);
        exit();
        
    }
    else
    {
        header("location:../../main.php");
        exit();
    }

    ob_end_flush();