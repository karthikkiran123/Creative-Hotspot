<!doctype HTML>
<?php
    session_start();
    $msg = null;
    if(!$_SESSION['freelanceloggedin'] === true){
        header("location: /freelance/login");
    }

    if(isset($_POST['apply'])){
        $cat = $_POST["cat"];
        $about = $_POST['about'];
        $name = $_SESSION['fname'];
        require_once "../assets/php/db/config.php";
        $user_id = $_SESSION['id'];
        $cond = "SELECT * FROM `freelancer` WHERE `user_id` = '$user_id'";
        $chck = mysqli_query($link, $cond);
        if($chck){
            if(mysqli_num_rows($chck)>0){
                $msg = "Already Applied";
            }else{
                $cond = "INSERT INTO `freelancer`(`user_id`, `status`, `about`, `category`) VALUES ('$user_id','pending','$about','$cat')";
                $chck = mysqli_query($link, $cond);
                if($chck){
                    $msg = "Thank you ".$name." for Applying, your application is under process.";
                }
            }
        }
    }
?>
<html>
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
        <?php if($msg){include('../modal.php');} ?>

        <div id="content" class="d-flex justify-content-center align-items-center">
            <div class="jumbotron">
                <center><h2>Become a Freelancer</h2></center>
                <form style="width: 400px; padding: 20px;" class="" method="POST" action="">
                    <div class="mb-3 input-group">
                        <label class="input-group-text">Category</label>
                        <select class="form-control" name="cat" required>
                            <option disabled selected value> -- select a category -- </option>
                            <option value="technology">Technology</option>
                            <option value="Media">Media</option>
                            <option value="Accounting & Finance">Accounting & Finance</option>
                            <option value="project management">Project Management</option>
                            <option value="Writing & Editing">Writing & Editing</option>
                            <option value="Education & Training">Education & Training</option>
                            <option value="Administrative">Administrative</option>
                            <option value="Healthcare">Healthcare</option>
                            <option value="Marketing">Marketing</option>
                            <option value="HR & Recruiting">HR & Recruiting</option>
                            <option value="Graphic Design">Graphic Design</option>
                            <option value="Mortgage & Real Estate">Mortgage & Real Estate</option>
                            <option value="Photography">Photography</option>
                            <option value="Virtual Assistant">Virtual Assistant</option>
                            <option value="Interior Designing">Interior Designing</option>
                        </select>
                    </div>
                    <div class="mb-3 input-group">
                        <label class="input-group-text">About</label>
                        <!-- <input type="password" class="form-control" name="about" /> -->
                        <textarea  class="form-control" name="about" rows="2" name="about" required></textarea>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit" name="apply" />
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