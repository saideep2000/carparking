<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'parkingdata';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if(! $conn ) {
        die('Could not connect: ' . mysqli_error());
    }


    $username=$_POST['username'];
    $password=$_POST['password'];
    $carno=$_POST['carno'];

    $user=mysqli_real_escape_string($conn,trim($username));
    $pass=mysqli_real_escape_string($conn,$password);
    $car=mysqli_real_escape_string($conn,$carno);

    $park=0;

    $sql = "INSERT INTO user (name,pass,carno,park) VALUES ('$user', '$pass', '$car', '$park')";

    if ($conn->query($sql) === TRUE)
    {
        $sample=$user;
        header("Location: book.php?message=$sample");
    }
    else
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
?>