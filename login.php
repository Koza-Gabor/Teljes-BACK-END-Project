<?php

$host="localhost";
$user="root";
$password="asd";
$db="belepes";

session_start();

$data=mysqli_connect($host, $user, $password, $db);
if($data===false)
{
    die("connection error");
}

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $nev=$_POST["nev"];
    $kod=$_POST["kod"];

    $sql="select * from felhasznalok where nev='".$nev."' AND kod='".$kod."' ";

    $result=mysqli_query($data,$sql);

    $row=mysqli_fetch_array($result);

    if($row["jog"]=="user")
    {
        $_SESSION["nev"]=$nev;

        header("location:menu.php");
    }
    
    elseif($row["jog"]=="admin")
    {
        $_SESSION["nev"]=$nev;
        
        header("location:adminmenu.php");
    }

    else
    {
        echo "nev or kod incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
    </head>
    <body>
    
        <center>
                <h1>Bejelentkezés</h1>
            <br><br><br><br>
                <div style="background-color: grey; width: 500px;" >
            <br><br>
            <form action="#" method="POST">
                <div>
                    <label>felhaszálói név</label>
                    <input type="text" name="nev" id="name" placeholder="Kérem a nevet" required> 
                </div>
            <br><br>
                <div>
                    <label>kód</label>
                    <input type="password" name="kod" id="kod" placeholder="Kérem a kódot" required> 
                </div>
            <br><br>
                <div>
                    <input type="submit" value="Belép">
                </div>
            </form>
            <br><br>
                </div>
        </center>
    </body>
</html>