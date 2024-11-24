<!doctype HTML>
<html>
<?php
    session_start();
    if(!$_SESSION['freelanceloggedin'] === true){
        header("location: /freelance/login");
    }
    $id = $_GET['id'];
    require_once "../assets/php/db/config.php";
    $cond = "SELECT * FROM `gigs` WHERE `id` = '$id'";
    $chck = mysqli_query($link, $cond);
    if($chck){
        $row = mysqli_fetch_array($chck);
        $views = (int)$row['views'] + 1;
        $cond = "UPDATE `gigs` SET `views`='$views'  WHERE `id` = '$id'";
        $chck = mysqli_query($link, $cond);
        $cond = "SELECT * FROM `gigs` WHERE `id` = '$id'";
        $chck = mysqli_query($link, $cond);
        $row = mysqli_fetch_array($chck);
        $img_data = 'data:image/' . $row['preview type'] . ';base64,' . $row['preview'];
        $name = $row['title'];
        $category = $row['category'];
        $description = $row['description'];
        $user_id = $row['user_id'];
        $contact = $row['contact']; 
        $price = $row['price'];
        $cond = "SELECT * FROM `user` WHERE `id` = '$user_id'";
        $user_chck = mysqli_query($link, $cond);
        $user_data = mysqli_fetch_array($user_chck);
        $author = $user_data['name'];
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
            <br/>
            <center><div class="jumbotron" style="width:70%">
                <img src="<?php echo $img_data; ?>" width="400" />
                <div style="width:50%;height:200px;float:right">
                    <h2><?php echo $name; ?></h2>
                    <i style="font-size: 15px"><?php echo $category; ?> | <?php echo $views; ?> Views<br/>Posted by <b><?php echo $author; ?></b></i><br/>phno<?php echo $contact; ?>
                   
                    <br/><br/>
                    <p style="font-size: 18px">
                        <?php echo $description; ?>
                         </p>
                    <h5>Price : ₹ <?php echo $price; ?></h5>
                    <?php
                        if($row['user_id'] != $_SESSION['id']){
                    ?>
                            <a href="/freelance/payment/?id=<?php echo $_GET['id']; ?>&status=initial" class="btn btn-success">Proceed to Pay</a>
                    <?php
                        }else{
                    ?>
                            <a href="#" class="btn btn-success disabled">Proceed to Pay</a>
                    <?php
                        }
                    ?>
                </div>
            </div></center>
            <?php
                require_once "../assets/php/db/config.php";
                $user_id = $_SESSION['id'];
                $id = $_GET['id'];
                $cond = "SELECT * FROM `gigs` WHERE `user_id` = '$user_id' AND `id` = '$id'";
                $chck = mysqli_query($link, $cond);
                if($chck){
                    if(mysqli_num_rows($chck)>0){
                        echo '<h2 style="padding:20px">Orders</h2>';
                        $cond = "SELECT * FROM `orders` WHERE `freelancer_id` = '$user_id' ORDER BY `id` DESC";
                        $chck = mysqli_query($link, $cond);
                        if($chck){
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
                                    echo '<img src="'.$img_data.'" width="100"/>';
                                    echo '<div style="width:50%;height:100%;float:right">';
                                        echo '<h6>'.$name.'</h6>';
                                        echo 'Price : ₹'.$price.'<br/>';
                                        echo 'Paid Amount : ₹'.$paid.'<br/>';
                                        echo 'Order Status : '.ucwords(strtolower($status)).'<br/>';
                                        if($status != "complete" && $status != "delivered"){
                                            echo '<a href="/freelance/gig/update_status.php?id='.$order_id.'" class="btn btn-success">Update Status</a><br/><br/>';
                                        }elseif($status === "delivered"){
                                            echo '<b style="color:green">Order Delivered!!</b>';
                                        }else{
                                            echo '<b style="color:red">Final payment Pending!!</b>';
                                        }
                                    echo '</div>';
                                echo '</div></center>';

                                
                            }
                        }
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