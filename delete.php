<?php
    session_start();

    include 'init.php';

    $d = isset($_GET["d"]) ? $_GET["d"] : "nothing" ;

    if($d == "item"){
        
        if(isset($_SESSION["username"])){
        
            $itemID = isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']):0 ;
            $user = isset($_GET["user"]) ? $_GET["user"] : 0;;         

            if($_SESSION["username"] == $user || $_SESSION["group"] == 1 ){
                
                global $conn;
                
                $stmt = $conn->prepare("DELETE FROM items WHERE itemID = ?");
                
                // execute query 
                
                $stmt-> execute(array($itemID));
                
                if($stmt){
                    header("location:profile.php?userID=". $_SESSION["id"]);
                    exit();
                    
                }
                
            }
            else {
                
                    header("location:main.php");
                    exit(); 
                
            }
       
        }
            else {
                
                    header("location:login.php");
                    exit();               
                
            }        
        
    }
    else if($d == "comment") {
        
            $comID = isset($_GET['comID']) && is_numeric($_GET['comID']) ? intval($_GET['comID']):0 ;
            $user = isset($_GET["user"]) ? $_GET["user"] : 0;
                
            if(isset($_SERVER["HTTP_REFERER"])){            

            if($_SESSION["username"] == $user || $_SESSION["group"] == 1 ){

                
                global $conn;
                
                $stmt = $conn->prepare("DELETE FROM comments WHERE comID = ?");
                
                // execute query 
                
                $stmt-> execute(array($comID));
                
                if($stmt){
                    header("location:". $_SERVER["HTTP_REFERER"] . "#demo");
                    exit();
                    
                }
            }
                else {
                    
                    header("location:main.php");
                    exit();                     
                    
                }
            }
            else {
                
                    header("location:main.php");
                    exit(); 
                
            }
       
        }
    if($d == "subject"){
        
        if(isset($_SERVER["HTTP_REFERER"])){        
        
        if(isset($_SESSION["username"])){
        
            $subID = isset($_GET['subID']) && is_numeric($_GET['subID']) ? intval($_GET['subID']):0 ;
            $user = isset($_GET["user"]) ? $_GET["user"] : 0;;         

            if($_SESSION["username"] == $user || $_SESSION["group"] == 1 ){
                
                global $conn;
                
                $stmt = $conn->prepare("DELETE FROM subject WHERE subID = ?");
                
                // execute query 
                
                $stmt-> execute(array($subID));
                
                if($stmt){
                    header("location:profile.php?userID=". $_SESSION["id"]);
                    exit();
                    
                }
                
            }
            else {
                
                    header("location:main.php");
                    exit(); 
                
            }
       
        }
            else {
                
                    header("location:login.php");
                    exit();               
                
            }
    }            else {
                
                    header("location:main.php");
                    exit();               
                
            }
        
    }
    else if($d == "reply") {
        
            $repID = isset($_GET['repID']) && is_numeric($_GET['repID']) ? intval($_GET['repID']):0 ;
            $user = isset($_GET["user"]) ? $_GET["user"] : 0;
        
            if(isset($_SERVER["HTTP_REFERER"])){          

            if($_SESSION["username"] == $user || $_SESSION["group"] == 1 ){
                  
                global $conn;
                
                $stmt = $conn->prepare("DELETE FROM reply WHERE repID = ?");
                
                // execute query 
                
                $stmt-> execute(array($repID));
                
                if($stmt){
                    header("location:". $_SERVER["HTTP_REFERER"] . "#replies");
                    exit();
                    
                }
            }
                else {
                    
                    header("location:main.php");
                    exit();                     
                    
                }
            }
            else {
                
                    header("location:main.php");
                    exit(); 
                
            }
       
        }
    else if($d == "account"){
        
        if(isset($_SERVER["HTTP_REFERER"])){
            
            if(isset($_SESSION["id"]) && isset($_GET["userID"])){
                
                if($_SESSION["id"] == $_GET["userID"]){
                    
                    $userID = $_GET["userID"] ;
                    
                    if($_SESSION["group"] == 1){
                    
                    $stmt1 = $conn->prepare("SELECT * FROM users WHERE groupID = 1");
                    $stmt1->execute();
                    
                    $countAdmins -> $stmt1->rowCount();
                    if($countAdmins > 1){                    
                    $stmt = $conn->prepare("DELETE FROM users WHERE userID = ?");
                    $stmt-> execute(array($userID));
                    
                    if($stmt){
                        
                        header("location:logout.php");
                        exit();
                    }
                    }
                    else
                    {
                        $message = lang("LAST-ADMIN");
                        header("location:settings.php?message=" . $message);
                        exit();
                        
                    }
                    }
                    else{
                   
                    $stmt = $conn->prepare("DELETE FROM users WHERE userID = ?");
                    $stmt-> execute(array($userID));
                    
                    if($stmt){
                        
                        header("location:logout.php");
                        exit();
                    }                        
                        
                    }
                }
                else{
                    
                    header("location:main.php");
                    exit();
                    
                }
                
            }
            
                else{
                    
                    header("location:" . $_SERVER["HTTP_REFERER"]);
                    exit();
                    
                }            
            
        }
        else{
            
                    header("location:main.php");
                    exit();            

        }
        
        
    }
       
    else {

                    header("location:main.php");
                    exit();        
    }