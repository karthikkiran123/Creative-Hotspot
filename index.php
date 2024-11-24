<!doctype HTML>
<?php
    session_start();
    // if(!$_SESSION['freelanceloggedin'] === true){
    //     header("location: /freelance");
    // }
?>
<html>
    <head>
        <title>Creative Hotspot</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="assets/css/style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- <link rel="icon" href="assets/img/favicon.jpg"> -->
    </head>
    <body>
    <?php $logo_img = "assets/img/logo.gif" ?>
        <?php include('navigation.php'); ?>

        <div id="content">
            <div class="banner">
                <video autoplay muted loop id="myVideo">
                    <source src="assets/video/banner.mp4" type="video/mp4">
                    Your browser does not support HTML5 video.
                </video>
            </div>
            <br/><br/>
            <h2 style="padding: 50px">Popular Freelancer</h2>
            <div class="container text-center">
            <?php
                session_start();
                
                require_once "assets/php/db/config.php";
                $cond = "SELECT DISTINCT * FROM `user` INNER JOIN `gigs` ON `user`.`id` = `gigs`.`user_id` INNER JOIN `freelancer` ON `user`.`id` = `freelancer`.`user_id` AND `freelancer`.`status` = 'approved' ORDER BY `gigs`.`views` DESC LIMIT 8";
                $chck = mysqli_query($link, $cond);
                if($chck){
                    if(mysqli_num_rows($chck)>0){
                        $count = mysqli_num_rows($chck);
                        $i = 1;
                        echo '<div class="container text-center">';
                        echo '<br />';
                        echo '<div class="row">';
                        while ($row = mysqli_fetch_array($chck)) {
                            $img_data = 'data:image/' . $row['file type'] . ';base64,' . $row['picture'];
                            $status = "Not Applied";
                            $id = $row['id'];
                            
                            $name = $row['name'];
                            
                            echo '<div class="col">';
                                echo '<div class="card" style="width: 18rem;">';
                                    echo '<img src="'.$img_data.'" class="card-img-top" alt="...">';
                                    echo '<div class="card-body">';
                                        echo '<h5 class="card-title">'.$name.'</h5>';
                                        echo '<p class="card-text">'.$row['mail'].'  </p>';
                                        echo '<p class="card-text">'.$row['contact'].'</p>';
                                        echo '<a href="/freelance/demo/?id='.$row['id'].'" class="btn btn-primary">View Gig</a>';
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
                        echo '<h6 style="padding: 50px">No popular freelancer.</h6>';
                    }
                }
            ?>
            </div>

            <br/><br/>
            <h2 style="padding: 50px">Popular Gigs</h2>
            <div class="container text-center">
                <!-- <?php
                    echo '<div class="container text-center">';
                    echo '<br />';
                    echo '<div class="row">';
                ?> -->

                <?php
                    session_start();
            
                    require_once "assets/php/db/config.php";
                    $cond = "SELECT * FROM `gigs` ORDER BY `views` DESC LIMIT 8";
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
                            echo '</div>';
                        }else{
                            echo '<h6 style="padding: 50px">No Popular gigs.</h6>';
                        }
                    }
                ?>
                <br/><br/>
                <!-- <?php
                    require_once "assets/php/db/config.php";
                    $cond = "SELECT * FROM `gigs`";
                    $chck = mysqli_query($link, $cond);
                    if($chck){
                        if(mysqli_num_rows($chck)>8){
                            echo '<a href="gigs.php" class="btn btn-success">View More</a>';
                        }
                    }
                ?> -->
            </div>
            <br/><br/>
            <h2 style="padding: 50px" id="about">Need something done?</h2>
            <div class="container text-center">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://www.f-cdn.com/assets/main/en/assets/illustrations/project/post-a-project.svg" width="50" height="50" />
                                <h5>Post a Job</h5>
                                <p>It’s free and easy to post a job. Simply fill in a title, description and budget and competitive bids come within minutes.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://www.f-cdn.com/assets/main/en/assets/illustrations/freelancer/work.svg" width="50" height="50" />
                                <h5>Choose freelancer</h5>
                                <p>No job is too big or too small. We've got freelancers for jobs of any size or budget, across 1800+ skills. No job is too complex. We can get it done!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://www.f-cdn.com/assets/main/en/assets/illustrations/payment/pay-safely.svg" width="50" height="50" />
                                <h5>Pay safely</h5>
                                <p>Only pay for work when it has been completed and you're 100% satisfied with the quality using our milestone payment system.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://www.f-cdn.com/assets/main/en/assets/illustrations/freelancer/about-me.svg" width="50" height="50" />
                                <h5>We're here to help</h5>
                                <p>Our talented team of recruiters can help you find the best freelancer for the job and our technical co-pilots can even manage the project for you.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br/><br/>
            <h2 style="padding: 50px">What's great about it?</h2>
            <div class="container text-center">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://www.f-cdn.com/assets/main/en/assets/illustrations/portfolio/browse-portfolios.svg" width="50" height="50" />
                                <h5>Browse portfolios</h5>
                                <p>Find professionals you can trust by browsing their samples of previous work and reading their profile reviews.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://www.f-cdn.com/assets/main/en/assets/illustrations/bids/bids-alt.svg" width="50" height="50" />
                                <h5>Fast bids</h5>
                                <p>Receive obligation free quotes from our talented freelancers fast. 80% of projects get bid on within 60 seconds.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://www.f-cdn.com/assets/main/en/assets/illustrations/quality-rewards/rank-higher.svg" width="50" height="50" />
                                <h5>Quality work</h5>
                                <p>Freelancer.com has by far the largest pool of quality freelancers globally- over 50 million to choose from.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <img src="https://www.f-cdn.com/assets/main/en/assets/illustrations/time/track-progress.svg" width="50" height="50" />
                                <h5>Track progress</h5>
                                <p>Keep up-to-date and on-the-go with our time tracker. Always know what freelancers are up to.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php
                $msg = null;
                if(isset($_POST['sendMessage'])){
                    require_once "assets/php/db/config.php";
                    $name = $_POST['name'];
                    $mail = $_POST['mail'];
                    $contact = $_POST['mob'];
                    $feedback = $_POST['message'];
                    $cond = "INSERT INTO `message`(`name`, `mail`, `contact`, `message`) VALUES ('$name','$mail','$contact','$feedback')";
                    $chck = mysqli_query($link, $cond);
                    if($chck){
                        $msg = "Thank you " . $name . ", We'll get back to you soon.";
                    }else{
                        $msg = "Something went wrong";
                    }
                }
                if($msg){include('modal.php');}
            ?>
            <br/><br/>
            <br/>

        </div>
            <!-- </div> -->
        <a href="#top" class="topbtn"><img src="/freelance/assets/img/top.png" /></a>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
        
        <div class="footer">
        <div id="contact" style="background:#263645;color:#fff">
                <br/><br/><center><h2>Contact Us</h2></center><br/><br/>
                <div style="width:50%;float:right;padding:20px;text-align:left;font-size:17px;bottom:0">
                    <br/><br/>
                    <b>Mobile Number </b>: <a href="tel:6361584244" style="color:#fff;text-decoration:none;" >6361 584 244</a><br/><br/>
                    <b>Email </b>: <a href="mailto:karthikkiran298@gmail.com" style="color:#fff;text-decoration:none;" >karthikkiran298@gmail.com</a><br/><br/>
                    <b>Address </b>: <a href="https://maps.app.goo.gl/dFVb6hTVTZGvx1VW7" style="color:#fff;text-decoration:none;" >Shavige Malleshwara Hills, 1st Stage, Kumaraswamy Layout, Bengaluru, Karnataka 560111</a><br/><br/>
                   <b>Connect Us With </b>:     <a href="https://instagram.com/official_bca_dsi?igshid=YmMyMTA2M2Y=" target="_blank" style="color:#fff;text-decoration:none;background-image: linear-gradient(to bottom left, rgb(168, 29, 219), rgb(237, 31, 217), rgb(237, 231, 47));padding:5px;border-radius:10px;font-size:25px"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                </div>
                <form method="POST" action="#contact" style="width: 40%; padding: 20px;border-radius:10px;text-align:left;">
                    <div class="form-floating mb-3" style="color:#000;">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Name" required name="name">
                        <label for="floatingInput">Name</label>
                    </div>
                    <div class="form-floating mb-3" style="color:#000;">
                        <input type="email" class="form-control" id="floatingMail" placeholder="Email" required name="mail">
                        <label for="floatingMail">Email</label>
                    </div>
                    <div class="form-floating mb-3" style="color:#000;">
                        <input type="text" class="form-control" id="floatingMob" placeholder="Contact" required name="mob">
                        <label for="floatingMob">Contact</label>
                    </div>
                    <div class="form-floating mb-3" style="color:#000;">
                        <textarea class="form-control" placeholder="Leave a Message here" id="floatingTextarea" required name="message"></textarea>
                        <label for="floatingTextarea">Message</label>
                    </div>
                    <center><input type="submit" class="btn btn-success" value="Send" name="sendMessage" /></center>
                </form>
            </div>
            <center>Copyrights &copy; 2022 Proudly Developed by <b>Karthik Kiran</b></center></div>
    </body>
</html>