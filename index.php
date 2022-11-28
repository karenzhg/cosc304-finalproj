<?php 
    session_start();
    include 'auth.php';
    $user = $_SESSION['authenticatedUser'];
?>
<!DOCTYPE html>
<html>
<head>
        <title>Orinthego Main Page</title>
        <?php
    // TODO: Display user name that is logged in (or nothing if not logged in)
    if ($_SESSION['authenticatedUser']  != null){
        echo ($user . "'s account");
    }

?>
</head>

<body style="background-color:#f5f2e6; color:#032115">
<h1 align="center">Welcome to Orinthego Onigiri</h1>

<h2 align="center"><a href="login.php">Login</a></h2>

<h2 align="center"><a href="listprod.php">Begin Shopping</a></h2>

<h2 align="center"><a href="listorder.php">List All Orders</a></h2>

<h2 align="center"><a href="customer.php">Customer Info</a></h2>

<h2 align="center"><a href="admin.php">Administrators</a></h2>

<h2 align="center"><a href="logout.php">Log out</a></h2>

</body>
</head>
