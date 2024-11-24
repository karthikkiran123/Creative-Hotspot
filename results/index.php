<!doctype HTML>
<html>
    <head>
        <title>Creative Hotspot</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../assets/css/style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <!-- <link rel="icon" href="assets/img/favicon.jpg"> -->
    </head>
    <body>
        <?php $logo_img = "../assets/img/logo.gif" ?>
        <?php require('../navigation.php'); ?>

        <div id="content">
        <h2 style="padding: 50px">Search results for "<?php echo $_GET['q']; ?>"</h2>
        <?php
            session_start();
            require_once "../assets/php/db/config.php";
            $cond = "SELECT * FROM `gigs` WHERE `title` LIKE '%".$_GET['q']."%' OR `category` LIKE '%".$_GET['q']."%' OR `description` LIKE '%".$_GET['q']."%'";
            $chck = mysqli_query($link, $cond);
            if($chck){
                if(mysqli_num_rows($chck)>0){
                    $count = mysqli_num_rows($chck);
                    $i = 1;
                    echo '<div class="container text-center">';
                    echo '<br />';
                    echo '<div class="row">';
                    while ($row = mysqli_fetch_array($chck)) {
                        $img_data = 'data:image/' . $row['preview type'] . ';base64,' . $row['preview'];
                        $name = $row['title'];
                        $desp = strlen((string)$row['description'])>30 ? substr((string)$row['description'], 0, 30)." ..." : (string)$row['description'];
                        
                        echo '<div class="col">';
                            echo '<div class="card" style="width: 18rem;">';
                                echo '<img src="'.$img_data.'" class="card-img-top" alt="...">';
                                echo '<div class="card-body">';
                                    echo '<h5 class="card-title">'.$name.'</h5>';
                                    echo '<p class="card-text">'.$row['category'].'<br/>'.$desp.'<br/>₹ '.$row['price'].' /-</p>';
                                    echo '<a href="/freelance/gig/?id='.$row['id'].'" class="btn btn-primary">View Gig</a>';
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
                    echo '<h6 style="padding: 50px">No result found for "'.$_GET['q'].'".</h6>';
                }
            }
        ?>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
        
        <div class="footer"><center>Copyrights &copy; 2022 Proudly Developed by <b>Karthik Kiran</b></center></div>
    </body>
</html>