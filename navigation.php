<nav>
    <?php
        session_start();
        if($_SESSION['freelanceadmin'] === true){
            $root_url = "/freelance/admin";
        }else{
            $root_url = "/freelance";
        }
        $search_url = $root_url . "/results";
    ?>
    <a href="<?php echo $root_url; ?>"><img src="<?php echo $logo_img; ?>" class="logo" /></a>
    <ul>
        <?php
            session_start();
            if(!$_SESSION['freelanceloggedin'] === true){
                echo '<li><a href="/freelance/login/">Login</a></li>';
                echo '<li><a href="/freelance/login/create">Register</a></li>';
            }else{
                $data = 'data:image/' . $_SESSION['fpptype'] . ';base64,' . $_SESSION['fpp'];
                echo "<img src='".$data."' width='40' height='40' alt='profile picture' id='profile-picture' />";
                echo '<li><a href="#"><b>Welcome '.$_SESSION['fname'].'</b></a></li>';
                echo '<li><a href="/freelance/login/logout.php">Logout</a></li>';
            }
            if(!$_SESSION['freelanceadmin'] === true){
                require_once "assets/php/db/config.php";
                $id = $_SESSION['id'];
                $cond = "SELECT * FROM `freelancer` WHERE `user_id` = '$id'";
                $chck = mysqli_query($link, $cond);
                if($chck){
                    if(mysqli_num_rows($chck)>0){
                        $data = mysqli_fetch_array($chck);
                        if($data['status'] == "approved"){
                            echo '<li><a href="/freelance/post-gig.php" class="post">Post a Gig</a></li>';
                        }
                    }
                
                }
                
            }
        ?>
    </ul>
</nav>
<div class="header">
    <ul>
        <?php
            session_start();
            if(!$_SESSION['freelanceadmin'] === true){
                echo '<li><a href="/freelance/orders">My Orders</a></li>';
            }
            require_once "assets/php/db/config.php";
            $user_id = $_SESSION['id'];
            $cond = "SELECT * FROM `freelancer` WHERE `user_id` = '$user_id'";
            $chck = mysqli_query($link, $cond);
            if(!$_SESSION['freelanceadmin'] === true){
                if($chck){
                    if(mysqli_num_rows($chck)>0){
                        echo '<li><a href="/freelance/freelancer_dashboard">Freelancer Dashboard</a></li>';
                    }else{
                        echo '<li><a href="/freelance/become_freelancer">Become a Freelancer</a></li>';
                    }
                }
                echo '<li><a href="/freelance/#contact">Contact</a></li>';
                echo '<li><a href="/freelance/#about">About</a></li>';
            }else{
                echo '<li><a href="/freelance/admin/applied_freelancer/">Applied Freelancer</a></li>';
                echo '<li><a href="/freelance/admin/messages/">Messages</a></li>';
            }
        ?>
        
        <form method="GET" action="<?php echo $search_url; ?>" style="float: right">
            <input type="text" placeholder="What are you looking for?" name="q" class="search" autocomplete="off" value="<?php echo $_GET['q']; ?>" required />
            <input type="submit" class="btn btn-primary" value="Search" />
        </form>
    </ul>
</div>