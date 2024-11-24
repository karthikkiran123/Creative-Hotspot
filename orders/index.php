<!doctype HTML>
<html>
<?php
    session_start();
    if(!$_SESSION['freelanceloggedin'] === true){
        header("location: /freelance/login");
    }
?>
    <head>
        <title>Creative Hotspot</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../assets/css/style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- <link rel="icon" href="assets/img/favicon.jpg"> -->
    </head>
    <body>
        <?php $logo_img = "../assets/img/logo.gif" ?>
        <?php require('../navigation.php'); ?>
        <?php if($msg){require('../modal.php');} ?>

        <div id="content">
            <?php
                $id = $_SESSION['id'];
                require_once "../assets/php/db/config.php";
                $cond = "SELECT * FROM `orders` WHERE `client_id` = '$id' ORDER BY `id` DESC";
                $chck = mysqli_query($link, $cond);
                if($chck){
                    if(mysqli_num_rows($chck)>0){
                        while($row = mysqli_fetch_array($chck)){
                            echo '<center><div class="jumbotron" style="width:50%">';
                                $gig_id = $row['gig_id'];
                                $gig_cond = "SELECT * FROM `gigs` WHERE `id` = '$gig_id'";
                                $gig_chck = mysqli_query($link, $gig_cond);
                                $order_id = $row['id'];
                                if($gig_chck){
                                    $gig_data = mysqli_fetch_array($gig_chck);
                                    $img_data = 'data:image/' . $gig_data['preview type'] . ';base64,' . $gig_data['preview'];
                                    $name = $gig_data['title'];
                                    $price = $gig_data['price'];
                                    $status = str_replace('_', ' ', (string)$row['status']);
                                }
                                $paid = $row['paid'];
                                echo '<img src="'.$img_data.'" width="150"/>';
                                echo '<div style="width:50%;height:100%;float:right">';
                                    echo '<h6>'.$name.'</h6>';
                                    echo 'Price : ₹'.$price.'<br/>';
                                    echo 'Paid Amount : ₹'.$paid.'<br/>';
                                    echo 'Order Status : '.ucwords(strtolower($status)).'<br/>';
                                    if($status === "complete"){
                                        echo '<a href="/freelance/payment/?id='.$order_id.'&status=final" class="btn btn-success">Pay Now</a><br/><br/>';
                                    }
                                echo '</div>';
                            echo '</div></center>';
    
                            
                        }
                    }else{
                        echo '<h5 style="padding:50px">No order placed!!</h5>';
                    }
                }
            ?>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        
        <div class="footer"><center>Copyrights &copy; 2022 Proudly Developed by <b>Karthik Kiran</b></center></div>
    </body>
</html>