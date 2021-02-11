<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="book_style.css">
    </head>
    <body>
        <div class="login-page">
            <div class="form">
                <?php
                    if(!empty($_GET['message'])) {
                        $message = $_GET['message'];
                        echo '<h2>'.'Mr.'.$message.' '.'book a slot for your car'.'</h2>';
                        'mesg'.'='.$message;

                        $dbhost = 'localhost';
                        $dbuser = 'root';
                        $dbpass = '';
                        $dbname="parkingdata";

                        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

                        if(! $conn ) {
                            die('Could not connect: ' . mysql_error());
                        }

                        $sql = 'SELECT slot,carno,time FROM slot';
                        mysqli_select_db( $conn,'parkingdata');
                        $retval = mysqli_query($conn,$sql);

                        if(! $retval ) {
                            die('Could not get data: ' . mysql_error());
                        }
                        $filledslot = array();
                        $filledcarno = array();
                        $filledname = array();
                        $count=0;
                        while($row = mysqli_fetch_array($retval))
                        {
                            $filledslot[$count]=$row['slot'];
                            $filledcarno[$count]=$row['slot'];
                            $count=$count+1;
                        }
                        for($i=0;$i<sizeof($filledcarno);$i++)
                        {
                            $sample = $filledcarno[$i];
                            $sql2 = "SELECT name FROM user WHERE carno = '". $sample. "'";
                            mysqli_select_db( $conn,'parkingdata');
                            $retval2 = mysqli_query($conn,$sql2);
                            if(! $retval2 ) {
                                die('Could not get data: ' . mysql_error());
                            }
                            while($row = mysqli_fetch_array($retval2))
                            {
                                $filledname[$i]=$row['name'];
                            }
                        }


                        //now selecting few slots and displaying it...
                        $samplecount=0;
                        $fakecount=1;
                        $flag=0;
                        $display=array();
                        while($flag!=1)
                        {
                            if(sizeof($display)!=3)
                            {
                                for($i=0;$i<sizeof($filledcarno);$i++)
                                {
                                    if($filledslot[$i]==$fakecount)
                                    {
                                        break;
                                    }
                                    else
                                    {
                                        $display[$samplecount]=$fakecount;
                                        $samplecount=$samplecount+1;
                                    }
                                }
                            }
                            else
                            {
                                $flag=1;
                                break;
                            }
                            $fakecount=$fakecount+1;
                        }

                        echo $display[0].','.$display[1].','.$display[2].' slots are free.';
                    }
                ?>
                <?php
                    if(array_key_exists('book', $_POST)) {
                        button1($message,$filledslot,$filledname,$filledcarno);
                    }
                    function button1($a,$b,$c,$d)
                    {
                        $dbhost = 'localhost';
                        $dbuser = 'root';
                        $dbpass = '';
                        $dbname="parkingdata";

                        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

                        $slott=$_POST["slot"];

                        if(! $conn ) {
                            die('Could not connect: ' . mysql_error());
                        }

                        $sql3 = "SELECT carno FROM user WHERE name= '". $a. "'";
                        mysqli_select_db( $conn,'parkingdata');
                        $retval3 = mysqli_query($conn,$sql3);

                        for($ii=0;$ii<sizeof($b);$ii++)
                        {
                            if($b[$ii]==$slott)
                            {
                                echo '<script type="text/javascript">';
                                echo 'alert("This slot was already taken by someone, So plz take recommended slot");';
                                // echo 'alert("This slot was already taken So plz take recommended slot");';
                                echo 'window.location.href = "Location: book.php?message=$a";';
                                // header("Location: book.php?message=$a");
                                echo '</script>';
                                exit;
                            }
                        }



                        while($row3 = mysqli_fetch_array($retval3))
                        {
                            $carnumber=$row3['carno'];
                        }
                        
                        date_default_timezone_set('Asia/Kolkata');
                        $date=date('Y-m-d H:i:s', time());
                        $sql4 = "INSERT INTO slot (slot,carno,time) VALUES ('$slott', '$carnumber', '$date')";

                        if ($conn->query($sql4) == TRUE)
                        {

                            $sql5="UPDATE user SET park=1 WHERE carno='$carnumber' ";
                            mysqli_select_db( $conn,'parkingdata');
                            $retval5 = mysqli_query($conn,$sql5);

                            echo '<script type="text/javascript">';
                            echo 'alert("The slot ".$slott." has been booked for you");';
                            // echo 'window.location.href = "Location: payment.php?message=$a";';
                             header("Location: payment.php?message=$a");
                            echo '</script>';
                            exit;
                        }
                        else
                        {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }

                        $conn->close();
                            
                    }
                ?>
              <form class="login-form" method="POST">
                <center><h1 style="color:rgb(111, 119, 194);">Book Car Space</h1></center>
                <input type="text" name='slot' placeholder="Slot Number"/>
                <input type="text" placeholder="Car Type"/>
                <button name="book">Book Slot</button>
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