<!doctype HTML>
<html>
<?php
    session_start();
    if(!$_SESSION['freelanceloggedin'] === true){
        header("location: /freelance/login");
    }
    $msg = null;
    if($_GET['id']){
        $id = $_GET['id'];
        $status = $_GET['status'];
        require_once "../../assets/php/db/config.php";
        $cond = "UPDATE `freelancer` SET `status`='$status' WHERE `id` = '$id'";
        $chck = mysqli_query($link, $cond);
        if($chck && ($status === "approved")){
            $msg = "Approved";
        }
        if($chck && ($status === "rejected")){
            $msg = "Rejected";
        }
    }
?>
    <head>
        <title>Creative Hotspot</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../../assets/css/style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <!-- <link rel="icon" href="assets/img/favicon.jpg"> -->
    </head>
    <body>
        <?php $logo_img = "../../assets/img/logo.gif" ?>
        <?php require('../../navigation.php'); ?>
        <?php if($msg){require('../../modal.php');} ?>

        <div id="content">
            <?php
                session_start();
                require_once "../../assets/php/db/config.php";
                $cond = "SELECT * FROM `freelancer` WHERE `status` = 'pending' ORDER BY `id` DESC";
                $chck = mysqli_query($link, $cond);
                if($chck){
                    if(mysqli_num_rows($chck)>0){
                        $count = mysqli_num_rows($chck);
                        $i = 1;
                        echo '<div class="container text-center">';
                        echo '<br />';
                        echo '<div class="row">';
                        while ($row = mysqli_fetch_array($chck)) {
                            $id = $row['user_id'];
                            $cond = "SELECT * FROM `user` WHERE `id` = '$id'";
                            $userchck = mysqli_query($link, $cond);
                            $user_data = mysqli_fetch_array($userchck);
                            $img_data = 'data:image/' . $user_data['file type'] . ';base64,' . $user_data['picture'];
                            $name = $user_data['name'];
                            
                            echo '<div class="col">';
                                echo '<div class="card" style="width: 18rem;">';
                                    echo '<img src="'.$img_data.'" class="card-img-top" alt="...">';
                                    echo '<div class="card-body">';
                                        echo '<h5 class="card-title">'.$name.'</h5>';
                                        echo '<p class="card-text">'.$row['category'].'<br />'.$row['about'].'<br />'.$row['status'].'</p>';
                                        echo '<a href="?id='.$row['id'].'&status=approved" class="btn btn-success">Approve</a>';
                                        echo '<a href="?id='.$row['id'].'&status=rejected" class="btn btn-danger">Reject</a>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                            // echo '</div>';
                            if($i%4 === 0){
                                echo '</div>';
                                echo '<br />';
                                echo '<div class="row">';
                            }
                            $i++;
                        }
                        echo '</div>';
                        echo '</div>';
                    }else{
                        echo '<h6 style="padding: 50px">No Pending Freelancer</h6>';
                    }
                }
            ?>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
        
        <div class="footer"><center>Copyrights &copy; 2022 Proudly Developed by <b>Karthik Kiran</b></center></div>
    </body>
</html>