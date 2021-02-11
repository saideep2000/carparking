<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname="parkingdata";

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if(! $conn ) {
        die('Could not connect: ' . mysql_error());
    }


    $username=$_POST["username"];
    $password=$_POST["password"];

    $username=mysqli_real_escape_string($conn,$username);
    $password=mysqli_real_escape_string($conn,$password);


    $sql = 'SELECT name,pass,park FROM user';
    mysqli_select_db( $conn,'parkingdata');
    $retval = mysqli_query($conn,$sql);

    if(! $retval ) {
        die('Could not get data: ' . mysql_error());
    }

    $car=1;
    $park=0;

    while($row = mysqli_fetch_array($retval))
    {
        if($username==$row['name'] && $password==$row['pass'] && $car==$row['park'])
        {
            $sample=$username;
            header("Location: payment.php?message=$sample");
            mysqli_close($conn);
            exit;
        }
        elseif($username==$row['name'] && $password==$row['pass'] && $park==$row['park'])
        {
            $sample=$username;
            header("Location: book.php?message=$sample");
            mysqli_close($conn);
            exit;
        }
    }
    echo '<script type="text/javascript">';
    echo 'alert("Wrong Password Enter again");'; 
    echo 'window.location.href = "login.html";';
    echo '</script>';
    
    mysqli_close($conn);
?>