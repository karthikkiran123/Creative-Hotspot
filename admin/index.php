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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
        <link rel="stylesheet" href="../assets/css/style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <!-- <link rel="icon" href="assets/img/favicon.jpg"> -->
    </head>
    <body>
        <?php $logo_img = "../assets/img/logo.gif" ?>
        <?php require('../navigation.php'); ?>

        <div id="content">
            <br/><br/><br/>
            <canvas id="myChart" style="width:50%;max-width:600px;float:right;margin-right:50px"></canvas>
            <canvas id="orders" style="width:50%;max-width:600px;margin-left:50px"></canvas>
        </div>

        <script>
            var orderData = {
                labels: ["Initial Payment", "Completed", "Final Payment", "Delivered"],
                datasets: [{
                    data: [1200, 1700, 800, 200, 500],
                    <?php
                        $initial_payment = 0;
                        $completed = 0;
                        $final_payment = 0;
                        $delivered = 0;
                        $cond = "SELECT * FROM `orders` WHERE `status` = 'initial_payment'";
                        $chck = mysqli_query($link, $cond);
                        if($chck){
                            $initial_payment = mysqli_num_rows($chck);
                        }
                        $cond = "SELECT * FROM `orders` WHERE `status` = 'complete'";
                        $chck = mysqli_query($link, $cond);
                        if($chck){
                            $completed = mysqli_num_rows($chck);
                        }
                        $cond = "SELECT * FROM `orders` WHERE `status` = 'final_payment'";
                        $chck = mysqli_query($link, $cond);
                        if($chck){
                            $final_payment = mysqli_num_rows($chck);
                        }
                        $cond = "SELECT * FROM `orders` WHERE `status` = 'delivered'";
                        $chck = mysqli_query($link, $cond);
                        if($chck){
                            $delivered = mysqli_num_rows($chck);
                        }
                        echo 'data: ['.$initial_payment.','.$completed.' ,'.$final_payment.' ,'.$delivered.' ],';
                    ?>
                    backgroundColor: [
                    "rgba(255, 0, 0, 0.5)",
                    "rgba(100, 255, 0, 0.5)",
                    "rgba(200, 50, 255, 0.5)",
                    "rgba(0, 100, 255, 0.5)",
                    "rgba(0, 171, 169, 0.5)"
                    ]
                }]
            };
                
            var chartOptions = {
                title: {
                    display: true,
                    align: "start",
                    text: "Order Status"
                },
                legend: {
                    align: "start"
                }
            };
            
            var polarAreaChart = new Chart("orders", {
            type: 'polarArea',
            data: orderData,
            options: chartOptions
            });
        </script>

        <script>
            var xValues = ["Clients" , "Applied Freelancer", "Approved Freelancer", "Rejected Freelancer", "Admin"];
            
            <?php
                $applied = 0;
                $rejected = 0;
                $approved = 0;
                $not_applied = 0;
                $total = 0;
                require_once "../assets/php/db/config.php";
                $cond = "SELECT * FROM `freelancer`";
                $chck = mysqli_query($link, $cond);
                if($chck){
                    $total = mysqli_num_rows($chck);
                }
                $cond = "SELECT * FROM `user`";
                $chck = mysqli_query($link, $cond);
                if($chck){
                    $not_applied = (int)mysqli_num_rows($chck) - (int)$total - 1;
                }

                $cond = "SELECT * FROM `freelancer` WHERE `status` = 'pending'";
                $chck = mysqli_query($link, $cond);
                if($chck){
                    $applied = mysqli_num_rows($chck);
                }
                $cond = "SELECT * FROM `freelancer` WHERE `status` = 'approved'";
                $chck = mysqli_query($link, $cond);
                if($chck){
                    $approved = mysqli_num_rows($chck);
                }
                $cond = "SELECT * FROM `freelancer` WHERE `status` = 'rejected'";
                $chck = mysqli_query($link, $cond);
                if($chck){
                    $rejected = mysqli_num_rows($chck);
                }
                echo 'var yValues = ['.$not_applied.', '.$applied.','.$approved.' ,'.$rejected.' ,1 ];';
            ?>
            var barColors = [
            "#b91d47",
            "#00aba9",
            "#2b5797",
            "#e8c3b9",
            "#1e7145"
            ];

            new Chart("myChart", {
            type: "doughnut",
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yValues
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: "Total Users"
                    }
                }
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
        
        <div class="footer"><center>Copyrights &copy; 2022 Proudly Developed by <b>Karthik Kiran</b></center></div>
    </body>
</html>