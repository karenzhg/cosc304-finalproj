<?php 
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
        <title>Orinthego Main Page</title>
</head>

<body>
<h1 align="center">Welcome to Orinthego Onigiri</h1>

<h2 align="center"><a href="login.php">Login</a></h2>

<h2 align="center"><a href="listprod.php">Begin Shopping</a></h2>

<h2 align="center"><a href="listorder.php">List All Orders</a></h2>

<h2 align="center"><a href="customer.php">Customer Info</a></h2>

<h2 align="center"><a href="admin.php">Administrators</a></h2>

<h2 align="center"><a href="logout.php">Log out</a></h2>

<?php     
    // TODO: Display user name that is logged in (or nothing if not logged in)	
    if ($_SESSION['authenticatedUser']  != null){
        echo("<li><a href=\"account.php\">" + userName + "\'s Account</a></li>");
        echo("<li><a href=\"admin.php\">Admin</a></li>");
        echo("<li><a href=\"logout.php\">Logout</a></li>");
    }
    else
      //  echo("<li><a href=\"login.php\" class=\"active\">Login</a></li>");
    
?>
</body>
</head>


