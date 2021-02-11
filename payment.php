<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="payment_style.css">
    </head>
    <body>
        <div class="login-page">
            <div class="form">
                <?php
                    if(!empty($_GET['message']))
                    {
                        $message = $_GET['message'];
                        echo '<h2>'.'Mr.'.$message.' '.'book a slot for your car'.'</h2>';
                        'mesg'.'='.$message;
                    }
                ?>
              <form class="login-form" method="POST">
                <center><h1 style="color:#fc9723;">Payment</h1></center>
                <b>Your Car Is Parked</b>
                <br>
                <br>
                <button name="payment">Check The Cost</button>
              </form>
              <?php
                    if(array_key_exists('payment', $_POST))
                    {
                        button1($message);
                    }
                    function button1($a)
                    {
                        $dbhost = 'localhost';
                        $dbuser = 'root';
                        $dbpass = '';
                        $dbname="parkingdata";

                        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

                        if(! $conn ) {
                            die('Could not connect: ' . mysqli_error());
                        }

                        $sql1 = 'SELECT slot,carno,time FROM slot';
                        mysqli_select_db( $conn,'parkingdata');
                        $retval1 = mysqli_query($conn,$sql1);

                        if(! $retval1 ) {
                            die('Could not get data: ' . mysqli_error());
                        }
                        $count=0;

                        $sql3 = "SELECT carno FROM user WHERE name= '". $a. "'";
                        mysqli_select_db( $conn,'parkingdata');
                        $retval3 = mysqli_query($conn,$sql3);


                        while($row3 = mysqli_fetch_array($retval3))
                        {
                            $carnumber=$row3['carno'];
                            echo '<br>';
                            echo $carnumber;

                        }

                        while($row1 = mysqli_fetch_array($retval1))
                        {
                            if($carnumber==$row1['carno'])
                            {
                                $time=$row1['time'];
                                break;
                            }
                        }
                        date_default_timezone_set('Asia/Kolkata');
                        $date=date('Y-m-d H:i:s T', time());
                        $datetime1 = strtotime($time);
                        $datetime2 = strtotime($date);

                        // == <seconds between the two times>
                        $timetaken = $datetime2 - $datetime1;
                        echo'<br>';
                        echo 'You have taken '.$timetaken.' secs ';
                        echo'<br>';
                        echo'<br>';
                        $totalcost=$timetaken*(2);
                        echo 'Your total Payment is '.$totalcost.' rupees ';
                        //$days = $secs/86400;

                        echo'';
                        mysqli_close($conn);
                    }
                ?>
                <form action="payment_check.php" class="login-form" method="POST">
                    <input type="hidden" name="user" value="<?php echo $message; ?>" required="required" />
                    <br>
                    <button type="submit" name="completed">Pay the Payment</button>
                </form>
                <form class="login-form" method="POST">
                    <br>
                <button name="logout">LOGOUT</button>
              </form>
              <?php
                if(array_key_exists('logout',$_POST)) 
                {
                    button18();
                }
                function button18()
                {
                    header("Location: login.html");
                }
              ?>
            </div>
          </div>
    </body>
</html>