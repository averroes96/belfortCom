<?php


        $stmt = $conn->prepare("SELECT count(*) as nbr, EXTRACT(MONTH FROM regDate) mois FROM users GROUP BY mois");
        $stmt-> execute();
        
        $row = $stmt->fetchAll();

        $dates = '';
        $nombres = '';

        foreach($row as $info){
            if($info["mois"] == "1"){
            $dates = $dates . '"' . lang("JAN") . '",';
            }
            else if($info["mois"] == "2"){
            $dates = $dates . '"' . lang("FEB") . '",';                
            }
            else if($info["mois"] == "3"){
            $dates = $dates . '"' . lang("MAR") . '",';                
            }
            else if($info["mois"] == "4"){
            $dates = $dates . '"' . lang("APR") . '",';                
            }
            else if($info["mois"] == "5"){
            $dates = $dates . '"' . lang("MAY") . '",';                
            }
            else if($info["mois"] == "6"){
            $dates = $dates . '"' . lang("JUN") . '",';                
            }
            else if($info["mois"] == "7"){
            $dates = $dates . '"' . lang("JUL") . '",';                
            }
            else if($info["mois"] == "8"){
            $dates = $dates . '"' . lang("AUG") . '",';                
            }
            else if($info["mois"] == "9"){
            $dates = $dates . '"' . lang("SEP") . '",';                
            }
            else if($info["mois"] == "10"){
            $dates = $dates . '"' . lang("OCT") . '",';                
            }
            else if($info["mois"] == "11"){
            $dates = $dates . '"' . lang("NOV") . '",';                
            }
            else if($info["mois"] == "12"){
            $dates = $dates . '"' . lang("DEC") . '",';                
            }            
            $nombres = $nombres . '"' . $info["nbr"] . '",';           
        }

        

        $dates = trim($dates,",");
        $nombres = trim($nombres,",");


        $stmt = $conn->prepare("SELECT count(*) as nbr, EXTRACT(MONTH FROM add_date) mois FROM items GROUP BY mois");
        $stmt-> execute();
        
        $row = $stmt->fetchAll();

        $item_dates = '';
        $item_nombres = '';

        foreach($row as $info){
            if($info["mois"] == "1"){
            $item_dates = $item_dates . '"' . lang("JAN") . '",';
            }
            else if($info["mois"] == "2"){
            $item_dates = $item_dates . '"' . lang("FEB") . '",';                
            }
            else if($info["mois"] == "3"){
            $item_dates = $item_dates . '"' . lang("MAR") . '",';                
            }
            else if($info["mois"] == "4"){
            $item_dates = $item_dates . '"' . lang("APR") . '",';                
            }
            else if($info["mois"] == "5"){
            $item_dates = $item_dates . '"' . lang("MAY") . '",';                
            }
            else if($info["mois"] == "6"){
            $item_dates = $item_dates . '"' . lang("JUN") . '",';                
            }
            else if($info["mois"] == "7"){
            $item_dates = $item_dates . '"' . lang("JUL") . '",';                
            }
            else if($info["mois"] == "8"){
            $item_dates = $item_dates . '"' . lang("AUG") . '",';                
            }
            else if($info["mois"] == "9"){
            $item_dates = $item_dates . '"' . lang("SEP") . '",';                
            }
            else if($info["mois"] == "10"){
            $item_dates = $item_dates . '"' . lang("OCT") . '",';                
            }
            else if($info["mois"] == "11"){
            $item_dates = $item_dates . '"' . lang("NOV") . '",';                
            }
            else if($info["mois"] == "12"){
            $item_dates = $item_dates . '"' . lang("DEC") . '",';                
            }            
            $item_nombres = $item_nombres . '"' . $info["nbr"] . '",';           
        }

        

        $item_dates = trim($item_dates,",");
        $item_nombres = trim($item_nombres,",");