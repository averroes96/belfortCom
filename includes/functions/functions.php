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
        
        $stmt = $conn->prepare("SELECT * FROM category WHERE name != 'Autre' AND visibility = 0 ORDER BY ordering DESC LIMIT 7 ");
        $stmt-> execute();
        
        $row = $stmt->fetchAll();
        
        return $row;
        
        }


        function getItemsBy($attr, $val){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT items.*, category.name, users.username FROM items INNER JOIN category ON category.catID = items.catID INNER JOIN users ON users.userID = items.userID WHERE items.$attr = ? ORDER BY items.add_date DESC");
        $stmt-> execute(array($val));
        
        $row = $stmt->fetchAll();
        
        return $row;
        
        }



        function getAllItems(){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT items.*, category.name, users.username FROM items INNER JOIN category ON category.catID = items.catID INNER JOIN users ON users.userID = items.userID ORDER BY items.add_date DESC LIMIT 12");
        $stmt-> execute(array());
        
        $row = $stmt->fetchAll();
        
        return $row;
        
        }

        function getUserComments($username){
            
            global $conn;
            
            $stmt = $conn->prepare("SELECT comments.*, items.item_name, users.username FROM comments INNER JOIN items ON items.itemID = comments.itemID INNER JOIN users ON users.userID = comments.userID WHERE username = ? ORDER BY comDate DESC LIMIT 5");
            $stmt-> execute(array($username));
            $rows = $stmt->fetchAll(); 
            
            return $rows;
            
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

        function updateViews($itemID){
        
        global $conn;
        
        $stmt = $conn->prepare("UPDATE items SET views = (select count(*)) FROM user_likes WHERE user_likes.itemID = items.itemID");
        $stmt-> execute(array());
        
        }

        function updateViews2($subID){
        
        global $conn;
        
        $stmt = $conn->prepare("UPDATE subject SET sub_views = sub_views + 1 WHERE subID = ?");
        $stmt-> execute(array($subID));
        
        }

// Function to get the most viewed item per category !

    function getMostViewed($catID){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM items WHERE catID = $catID AND views = (SELECT MAX(views) FROM items WHERE catID = $catID)  LIMIT 1 ");
        $stmt-> execute();
        
        $row = $stmt->fetchAll();
        
        return $row;
        
    }

    function getMostViewed2(){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM items WHERE pending = 1 ORDER BY views DESC LIMIT 6 ");
        $stmt-> execute();
        
        $row = $stmt->fetchAll();
        
        return $row;
        
    }

    function getItemImages($itemID){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT image, image1,image2,image3 FROM items WHERE itemID = $itemID");
        $stmt-> execute();
        
        $row = $stmt->fetchAll();
        
        return $row;
        
    }

    function getInterest($interest, $userID){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM items WHERE tags LIKE '%$interest%' AND userID != $userID AND pending = 1");
        $stmt-> execute();
        
        $row = $stmt->fetchAll();
        
        return $row;  
        
        
    }

    function filterResult($query){
        
        global $conn;
                
        $stmt = $conn->prepare("SELECT * FROM items $query LIMIT 16");
        $stmt-> execute();
        $row = $stmt->fetchAll();                         
        
        return $row;          
        
    }

    function notify($type, $fr_content, $en_content, $userID, $triggeur, $concerned, $url){
        
        global $conn;
                
        $stmt = $conn->prepare("INSERT INTO notification (type_notif, fr_content, en_content, notif_date, userID, triggeur, concerned, url) VALUES ( :ztype, :zfcontent, :zecontent, now(), :zuser, :ztriggeur, :zconcerned, :zurl)");
        $stmt-> execute(array(
            "ztype" => $type,             
            "zfcontent" => $fr_content, 
            "zecontent" => $en_content,            
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

    function getNotifications($userID){
        
        global $conn;
                
        $stmt = $conn->prepare("SELECT * FROM Notification WHERE userID = $userID AND seen = 0");
        $stmt-> execute();
        $row = $stmt->fetchAll();                         
        
        return $row;           
        
    }

    function getNotifCount($userID){
        
        global $conn;
                
        $stmt = $conn->prepare("SELECT * FROM Notification WHERE userID = $userID AND seen = 0");
        $stmt-> execute();
        $row = $stmt->rowCount();                         
        
        return $row;           
        
    }

    function searchBar($keyword){
        
        global $conn;
                
        $stmt = $conn->prepare("(SELECT userID, username, email, image,fullname,wilaya, 'user' as type FROM users WHERE username LIKE '%" . 
           $keyword . "%' OR email LIKE '%" . $keyword ."%' OR fullname LIKE '%" . $keyword ."%') 
           UNION
           (SELECT itemID, item_name, price, image, add_date,status, 'item' as type FROM items WHERE item_name LIKE '%" . 
           $keyword . "%' OR wilaya LIKE '%" . $keyword ."%' OR tags LIKE '%" . $keyword ."%') 
           UNION
           (SELECT subID,sub_content, title, sub_type,sub_views, sub_date, 'subject' as type FROM subject WHERE sub_content LIKE '%" . 
           $keyword . "%' OR title LIKE '%" . $keyword ."%' OR sub_type LIKE '%" . $keyword ."%')");
        
        $stmt-> execute();
        $row = $stmt->fetchAll();                         
        
        return $row;          
        
    }

    function getMessages($username){
        
        global $conn;
                
        $stmt = $conn->prepare("SELECT * FROM messages WHERE user2 = '$username' OR user1 = '$username'ORDER BY ID DESC ");
        $stmt-> execute();
        $row = $stmt->fetchAll();                         
        
        return $row;           
        
    }

    function getUnreadMessages($username){
        
        global $conn;
                
        $stmt = $conn->prepare("SELECT * FROM messages WHERE user2 = '$username' OR user1 = '$username' AND sender != '$username' AND lue = 0 ORDER BY ID DESC ");
        $stmt-> execute();
        $row = $stmt->fetchAll();                         
        
        return $row;           
        
    }

    function getLatestMessage($user1, $user2){
        
        global $conn;
                
        $stmt = $conn->prepare("SELECT * FROM messages WHERE user1 = '$user1' AND user2 = '$user2' ORDER BY ID DESC LIMIT 1 ");
        $stmt-> execute();
        $row = $stmt->fetchAll();                         
        
        return $row;           
                  
    }

    function getPersonalMessages($user1, $user2){
        
        global $conn;
                
        $stmt = $conn->prepare("SELECT * FROM messages WHERE user1 = '$user1' AND user2 = '$user2'");
        $stmt-> execute();
        $row = $stmt->fetchAll();                         
        
        return $row;           
                  
    }

    function updateLue($user1, $user2, $other_user){
        
        global $conn;
                
        $stmt = $conn->prepare("UPDATE messages SET lue = 1 WHERE user1='$user1' and user2 = '$user2' and sender = '$other_user'");
        $stmt-> execute();       
        
    }

    function proDate($date){
        
        if(strtotime($date) > strtotime('- 1 minute') ){
            
            return lang("JUST-NOW");
        }
        else if(strtotime($date) < strtotime('-1 minute') &&  strtotime($date) > strtotime('- 2 minutes'))
            return lang("THERE-IS") . "1" . lang("MIN-AGO");
        else if(strtotime($date) < strtotime('- 2 minutes') && strtotime($date) > strtotime('- 3 minutes'))
            return lang("THERE-IS") . "2" . lang("MIN-AGO");
        else if(strtotime($date) < strtotime('- 3 minutes') &&  strtotime($date) > strtotime('- 4 minutes'))
            return lang("THERE-IS") . "3" . lang("MIN-AGO");
        else if(strtotime($date) < strtotime('- 4 minutes') &&  strtotime($date) > strtotime('- 5 minutes'))
            return lang("THERE-IS") . "4" . lang("MIN-AGO");  
        else if(strtotime($date) < strtotime('- 5 minutes') &&  strtotime($date) > strtotime('- 6 minutes'))
            return lang("THERE-IS") . "5" . lang("MIN-AGO");  
        else if(strtotime($date) < strtotime('- 6 minutes') &&  strtotime($date) > strtotime('- 7 minutes'))
            return lang("THERE-IS") . "6" . lang("MIN-AGO");  
        else if(strtotime($date) < strtotime('- 7 minutes') &&  strtotime($date) > strtotime('- 8 minutes'))
            return lang("THERE-IS") . "7" . lang("MIN-AGO");  
        else if(strtotime($date) < strtotime('- 8 minutes') &&  strtotime($date) > strtotime('- 9 minutes'))
            return lang("THERE-IS") . "8" . lang("MIN-AGO");  
        else if(strtotime($date) < strtotime('- 9 minutes') &&  strtotime($date) > strtotime('- 10 minutes'))
            return lang("THERE-IS") . "9" . lang("MIN-AGO");
        else if(strtotime($date) < strtotime('- 10 minutes') &&  strtotime($date) > strtotime('- 20 minutes'))
            return lang("THERE-IS") . "10" . lang("MIN-AGO");
        else if(strtotime($date) < strtotime('- 20 minutes') &&  strtotime($date) > strtotime('- 30 minutes'))
            return lang("THERE-IS") . "20" . lang("MIN-AGO");
        else if(strtotime($date) < strtotime('- 30 minutes') &&  strtotime($date) > strtotime('- 40 minutes'))
            return lang("THERE-IS") . "30" . lang("MIN-AGO");
        else if(strtotime($date) < strtotime('- 40 minutes') &&  strtotime($date) > strtotime('- 50 minutes'))
            return lang("THERE-IS") . "40" . lang("MIN-AGO");
        else if(strtotime($date) < strtotime('- 50 minutes') &&  strtotime($date) > strtotime('- 60 minutes'))
            return lang("THERE-IS") . "50" . lang("MIN-AGO");
        else if(strtotime($date) < strtotime('- 60 minutes') && strtotime($date) > strtotime('- 2 hours'))
            return lang("THERE-IS") . "1" . lang("HOURS-AGO");
        else if(strtotime($date) < strtotime('- 2 hours') && strtotime($date) > strtotime('- 3 hours'))
            return lang("THERE-IS") . "2" . lang("HOURS-AGO");
        else if(strtotime($date) < strtotime('- 3 hours') && strtotime($date) > strtotime('- 4 hours'))
            return lang("THERE-IS") . "3" . lang("HOURS-AGO");
        else if(strtotime($date) < strtotime('- 4 hours') && strtotime($date) > strtotime('- 5 hours'))
            return lang("THERE-IS") . "4" . lang("HOURS-AGO");
        else if(strtotime($date) < strtotime('- 5 hours') && strtotime($date) > strtotime('- 6 hours'))
            return lang("THERE-IS") . "5" . lang("HOURS-AGO");
        else if(strtotime($date) < strtotime('- 6 hours') && strtotime($date) > strtotime('- 7 hours'))
            return lang("THERE-IS") . "6" . lang("HOURS-AGO");
        else if(strtotime($date) < strtotime('- 7 hours') && strtotime($date) > strtotime('- 8 hours'))
            return lang("THERE-IS") . "7" . lang("HOURS-AGO");
        else if(strtotime($date) < strtotime('- 8 hours') && strtotime($date) > strtotime('- 9 hours'))
            return lang("THERE-IS") . "8" . lang("HOURS-AGO");
        else if(strtotime($date) < strtotime('- 9 hours') && strtotime($date) > strtotime('- 10 hours'))
            return lang("THERE-IS") . "9" . lang("HOURS-AGO");
        else if(strtotime($date) < strtotime('- 10 hours') && strtotime($date) > strtotime('- 11 hours'))
            return lang("THERE-IS") . "10" . lang("HOURS-AGO");
        else if(strtotime($date) < strtotime('- 11 hours') && strtotime($date) > strtotime('- 12 hours'))
            return lang("THERE-IS") . "11" . lang("HOURS-AGO");
        else if(strtotime($date) < strtotime('- 12 hours') && strtotime($date) > strtotime('- 15 hours'))
            return lang("THERE-IS") . "12" . lang("HOURS-AGO");    
        else if(strtotime($date) < strtotime('- 15 hours') && strtotime($date) > strtotime('- 18 hours'))
            return lang("THERE-IS") . "15" . lang("HOURS-AGO");
        else if(strtotime($date) < strtotime('- 18 hours') && strtotime($date) > strtotime('- 21 hours'))
            return lang("THERE-IS") . "18" . lang("HOURS-AGO");
        else if(strtotime($date) < strtotime('- 21 hours') && strtotime($date) > strtotime('- 24 hours'))
            return lang("THERE-IS") . "21" . lang("HOURS-AGO");
        else if(strtotime($date) < strtotime('- 1 day') && strtotime($date) > strtotime('- 2 days'))
            return lang("THERE-IS") . "1" . lang("DAYS-AGO");
        else if(strtotime($date) < strtotime('- 2 days') && strtotime($date) > strtotime('- 3 days'))
            return lang("THERE-IS") . "2" . lang("DAYS-AGO");
        else if(strtotime($date) < strtotime('- 3 days') && strtotime($date) > strtotime('- 4 days'))
            return lang("THERE-IS") . "3" . lang("DAYS-AGO");
        else if(strtotime($date) < strtotime('- 4 days') && strtotime($date) > strtotime('- 5 days'))
            return lang("THERE-IS") . "4" . lang("DAYS-AGO");
        else if(strtotime($date) < strtotime('- 5 days') && strtotime($date) > strtotime('- 6 days'))
            return lang("THERE-IS") . "5" . lang("DAYS-AGO");        
        else
            return date("d M Y | h:s a", strtotime($date));
           
        
        
    }

    function getNewMessagesCount($username){
        
        global $conn;
                
        $stmt = $conn->prepare("SELECT COUNT(DISTINCT sender) AS nbr FROM messages WHERE ( user1 = '$username' OR user2 = '$username' ) AND sender != '$username' AND lue = 0  ");
        $stmt-> execute();          
        
        $row = $stmt->fetchAll();                         
        
        return $row;         
    }

    function getAverage($userID){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT AVG(value) as average FROM rating WHERE target = $userID");
        $stmt-> execute();         
        
        $row = $stmt->fetch();
        
        return $row;
        
    }
    function countValues($userID, $value){
        
        global $conn;
        
        $stmt = $conn->prepare("SELECT count(*) FROM rating WHERE target = $userID AND value = $value");
        $stmt-> execute();         
        
        $row = $stmt->fetchColumn();
        
        return $row;        
        
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }