<?php
    $data= $_POST['val'];

        error_log("L7a9t hna ?");

        $stmt = $conn->prepare("UPDATE notification SET seen = 1 WHERE notifID = $data");
        $stmt-> execute();

?>