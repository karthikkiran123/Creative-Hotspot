<!doctype HTML>
<?php
    session_start();
    $msg = null;
    if(!$_SESSION['freelanceloggedin'] === true){
        header("location: /freelance/login");
    }
    if(isset($_POST['create'])){
        $file_path = $_FILES['pp']['tmp_name'] . $_FILES['pp']['name'];
        $file_type = strtolower(pathinfo($file_path,PATHINFO_EXTENSION));
        $pp_base = base64_encode(file_get_contents($_FILES['pp']['tmp_name']));
        $title = $_POST['title'];
        $desp = $_POST['desp'];
        // $days = $_POST['days'];
        $price = $_POST['price'];
        $id = $_SESSION['id'];
        require_once "assets/php/db/config.php";
        $cond = "SELECT * FROM `freelancer` WHERE `user_id` = '$id'";
        $chck = mysqli_query($link, $cond);
        $data = mysqli_fetch_array($chck);
        $category = $data['category'];
        $cond = "INSERT INTO `gigs`(`user_id`, `title`, `category`, `description`, `price`, `views`, `preview type`, `preview`) VALUES ('$id','$title','$category','$desp','$price','0','$file_type','$pp_base')";
        $chck = mysqli_query($link, $cond);
        if($chck){
            $msg = 'Gig "'.$title.'" posted successfully!';
        }else{
            $msg = "something went wrong";
        }
    }
?>
<html>
    <head>
        <title>Creative Hotspot</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="assets/css/style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- <link rel="icon" href="assets/img/favicon.jpg"> -->
    </head>
    <body>
        <?php $logo_img = "assets/img/logo.gif" ?>
        <?php include('navigation.php'); ?>
        <?php if($msg){include('modal.php');} ?>
        <div id="content" class="d-flex justify-content-center align-items-center">
            <div class="jumbotron">
                <center><h2>Post Gig</h2></center>
                <form method="POST" action="" style="width: 400px; padding: 20px;" class="" enctype="multipart/form-data">
                    <div class="mb-3 input-group">
                        <label class="input-group-text">Title</label>
                        <input type="text" class="form-control" name="title" required />
                    </div>
                    <div class="mb-3 input-group">
                        <label class="input-group-text">Description</label>
                        <textarea class="form-control" name="desp" required row="4"></textarea>
                    </div>
                    <!-- <div class="mb-3 input-group">
                        <label class="input-group-text">No of days</label>
                        <input type="text" class="form-control" name="days" required />
                    </div> -->
                    <div class="mb-3 input-group">
                        <label class="input-group-text">Price</label>
                        <input type="number" min='1' class="form-control" name="price" required />
                    </div>
                    <div class="mb-3 input-group">
                    <input class="form-control" type="file" id="formFile" name="pp" required />
                    </div>
                    <div class="mb-3 input-group">
                    <span style="color: red">Select your Preview picture *</span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Post" name="create" />
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        
        <div class="footer"><center>Copyrights &copy; 2022 Proudly Developed by <b>Karthik Kiran</b></center></div>
    </body>
</html>