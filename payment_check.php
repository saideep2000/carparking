<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname="parkingdata";

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if(! $conn ) {
        die('Could not connect: ' . mysql_error());
    }


    $user=$_POST["user"];
    $user=mysqli_real_escape_string($conn,$user);


    $sql1="SELECT name,carno FROM user";
    mysqli_select_db( $conn,'parkingdata');
    $retval = mysqli_query($conn,$sql1);

    if(! $retval ) {
        die('Could not get data: ' . mysql_error());
    }

    while($row = mysqli_fetch_array($retval))
    {
        if ($row['name']==$user)
        {
            $carnum=$row['carno'];
        }
    }

    echo $carnum;

    $sql2="DELETE FROM slot WHERE carno='$carnum' ";
    mysqli_select_db( $conn,'parkingdata');
    $retval2 = mysqli_query($conn,$sql2);

    if(! $retval2 ) {
        die('Could not get data: ' . mysql_error());
    }

    $sql3="UPDATE user SET park=0 WHERE carno='$carnum' ";
    mysqli_select_db( $conn,'parkingdata');
    $retval3 = mysqli_query($conn,$sql3);

    if(! $retval3 ) {
        die('Could not get data: ' . mysql_error());
    }
    


    mysqli_close($conn);


    header("Location: book.php?message=$user");


    
    
?>


