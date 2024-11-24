<!doctype HTML>
<html>
    <head>
        <title>Creative Hotspot</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../../assets/css/style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- <link rel="icon" href="assets/img/favicon.jpg"> -->
    </head>
    <body>
        <?php $logo_img = "../../assets/img/logo.gif" ?>
        <?php require('../../navigation.php'); ?>
        <?php if($msg){require('../../modal.php');} ?>

        <div id="content">
            <?php
                require_once "../../assets/php/db/config.php";
                echo '<br/><br/>';
                $cond = "SELECT * FROM `message` WHERE 1";
                $chck = mysqli_query($link, $cond);
                if($chck){
                    if(mysqli_num_rows($chck)>0){
                        while($row = mysqli_fetch_array($chck)){
                            echo '<center><div class="jumbotron" style="width:50%;">';
                                echo '<b>'.$row['name'].'</b>';
                                echo '<br/>';
                                echo $row['message'];
                                echo '<br/><br/>';
                                echo '<a href="tel:'.$row['contact'].'" class="btn btn-success">Call Now</a>';
                                echo '<a href="mailto:'.$row['mail'].'" class="btn btn-primary ml-3">Reply Now</a>';
                            echo'</div></center>';
                        }
                        
                    }else{
                        echo 'No messages found!';
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