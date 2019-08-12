<?php

    $dbn = "mysql:host=localhost;dbname=shop";
    $user = "root";
    $pass = "";
    $options = array(
        
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            
        );
    
    try{
        
    $conn = new PDO($dbn, $user, $pass, $options);
        } catch (PDOException $pe){
    echo 'Connection failed!' . $pe->getMessage();
        }

