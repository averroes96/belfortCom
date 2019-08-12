<?php 
    
        function getAllFrom($val, $table, $condition ="", $order = "", $ascDesc="", $join="",$limit=""){
            
            global $conn;
            $stmt = $conn->prepare("SELECT $val FROM $table $condition $order $ascDesc $join $limit");
            $stmt-> execute();
        
            $row = $stmt->fetchAll();
        
            return $row;
        }



                function getCategories(){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM category WHERE name != 'Autre' ORDER BY catID ");
        $stmt-> execute();
        
        $row = $stmt->fetchAll();
        
        return $row;
        
        }


                function getTopCategories(){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM category WHERE parent = 0 ORDER BY catID ");
        $stmt-> execute();
        
        $row = $stmt->fetchAll();
        
        return $row;
        
        }


                function getSubCategories($parent){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM category WHERE parent = $parent ORDER BY catID ");
        $stmt-> execute();
        
        $row = $stmt->fetchAll();
        
        return $row;
        
        }

    // function to get the title of the page
    
    function getTitle(){
        
        global $title;
        
     if(isset($title)){
         
         echo $title ;
     }
     
        else
         
         echo "default";

    }


    // redirect function

    function redirection($message, $target = null, $second = 3){
        
        if($target === null){
            
            $target = 'login.php';
            
        }
        else {if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '')
        {
            
            $target = $_SERVER['HTTP_REFERER'];
        }
        else{
            
            $target = 'login.php';
            
        }
             }
        echo $message;
        header("refresh:$second;url=$target");
        exit();
        
    }

    // Check items function

    function checkItem($select, $from, $value){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT $select FROM $from WHERE $select = ?");
        $stmt->execute(array($value));
        $count = $stmt->rowCount();
        
        return $count;
    }

    // Number of items count

    function countItems($item, $table, $where = false, $attr = '', $value = ''){
        
        global $conn;
        
        if($where == true){
        
        $stmt = $conn->prepare("SELECT count($item) FROM $table WHERE $attr = $value");
        $stmt->execute();
            
        }
        
        else{
        $stmt = $conn->prepare("SELECT count($item) FROM $table");
        $stmt->execute(); 
            
        }
            
        return $stmt->fetchColumn();
        
        
    }

    
    // function to get latest records 

    function getLatest($select, $table, $order, $limit = 5){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT $select FROM $table WHERE groupID = 0 ORDER BY $order DESC LIMIT $limit");
        $stmt->execute();
        
        $row = $stmt->fetchAll();
        
        return $row;

    }

    function getLatestItems (){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT items.*, category.name, users.username FROM items INNER JOIN category ON category.catID = items.catID INNER JOIN users ON users.userID = items.userID ORDER BY items.add_date DESC LIMIT 5 ");
        $stmt-> execute();
        
        $row = $stmt->fetchAll();
        
        return $row;
        
    }

    function getLatestComments (){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT comments.*, items.item_name, users.* FROM comments INNER JOIN items ON comments.itemID = items.itemID INNER JOIN users ON users.userID = comments.userID ORDER BY comments.comDate DESC LIMIT 5 ");
        $stmt-> execute();
        
        $row = $stmt->fetchAll();
        
        return $row;
        
    }


    function getNew($table,$value){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM $table WHERE $value BETWEEN DATE_SUB(CURDATE() , INTERVAL 7 DAY) AND CURDATE()");
        $stmt-> execute();
        
        $row = $stmt->rowCount();
        
        return $row; 
    }

    function getTotal($table){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM $table ");
        $stmt-> execute();
        
        $row = $stmt->rowCount();
        
        return $row; 
    }


    function getTotalWilaya($wilaya){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM items WHERE wilaya = '$wilaya'");
        $stmt-> execute();
        
        $row = $stmt->rowCount();
        
        return $row;         
        
        
    }

    function perWilaya($wilaya, $table){
        
        return (getTotalWilaya($wilaya) / getTotal($table)) * 100  ;
        
    }


    function wilayaPercentage(){
        
        global $conn;
        
        $stmt = $conn->prepare("UPDATE wilayas SET percentage = (SELECT count(itemID) FROM items WHERE items.wilaya = wilayas.wilaya )");
        $stmt-> execute();       
             
        
    }

    function updatePercentage(){
        
        global $conn;
        
        $stmt = $conn->prepare("UPDATE category SET ordering = (SELECT count(itemID) FROM items WHERE items.catID = category.catID )");
        $stmt-> execute();          
        
    }

    function notify($type, $content, $userID, $triggeur, $concerned, $url){
        
        global $conn;
                
        $stmt = $conn->prepare("INSERT INTO notification (type_notif, notif_content, notif_date, userID, triggeur, concerned, url) VALUES ( :ztype, :zcontent, now(), :zuser, :ztriggeur, :zconcerned, :zurl)");
        $stmt-> execute(array(
            "ztype" => $type,             
            "zcontent" => $content, 
            "zuser" => $userID,
            "ztriggeur" => $triggeur,             
            "zconcerned" => $concerned,           
            "zurl" => $url
        ));       
        
        
    }

    function deleteNotification($type, $triggeur, $concerned, $userID){
        
        global $conn;
        
        $stmt = $conn->prepare("DELETE FROM notification WHERE type_notif = '$type' AND triggeur = $triggeur AND concerned = $concerned AND userID = $userID");
        $stmt-> execute();
        $row = $stmt->fetchAll();                         
        
        return $row;           
        
        
    }
    