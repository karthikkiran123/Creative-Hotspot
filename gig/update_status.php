<?php
    $id = $_GET['id'];
    require_once "../assets/php/db/config.php";
    $cond = "SELECT * FROM `orders` WHERE `id` = '$id'";
    $chck = mysqli_query($link, $cond);
    if($chck){
        $row = mysqli_fetch_array($chck);
        $status = $row['status'];
        $new_status = null;
        if($status === "initial_payment"){
            $new_status = "complete";
        }elseif($status === "complete"){
            $new_status = "final_payment";
        }elseif($status === "final_payment"){
            $new_status = "delivered";
        }
        $gig_id = $row['gig_id'];
        echo $new_status;
        $cond = "UPDATE `orders` SET `status`='$new_status' WHERE `id` = '$id'";
        $chck = mysqli_query($link, $cond);
        if($chck){
            header("location: /freelance/gig/?id=$gig_id");
        }
    }
?>