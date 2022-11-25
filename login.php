<!DOCTYPE html>
<html>
<head>
<title>Orinthego</title>
</head>
<body>

<h2 align="left"><a href="index.php">Home</a> | <a href="listprod.php"> Browse</a> | <a href="showcart.php">Your Shopping Cart</a></h2>

<div style="margin:0 auto;text-align:center;display:inline">

<h3>Please Login to System</h3>

<?php
if ($_SESSION['authenticatedUser']  != null){
	echo("<li><a href=\"account.php\">" + username + "\'s Account</a></li>");
	echo("<li><a href=\"admin.php\">Admin</a></li>");
	echo("<li><a href=\"logout.php\">Logout</a></li>");
}
else
	//echo("<li><a href=\"login.php\" class=\"active\">Login</a></li>");

?>

<?php 
if(empty(session_id()) && !headers_sent()){
	session_start();
    if ($_SESSION['loginMessage']  != null)	
        echo ("<p>" . $_SESSION['loginMessage'] . "</p>");
}
?>

<br>
<form name="MyForm" method="post" action="validateLogin.php">
<table style="display:inline">
<tr>
	<td><div align="right"><font face="Arial, Helvetica, sans-serif" size="2">Username:</font></div></td>
	<td><input type="text" name="username"  size=10 maxlength=10></td>
</tr>
<tr>
	<td><div align="right"><font face="Arial, Helvetica, sans-serif" size="2">Password:</font></div></td>
	<td><input type="password" name="password" size=10 maxlength="10"></td>
</tr>
</table>
<br/>
<input class="submit" type="submit" name="Submit2" value="Log In">
</form>

</div>

</body>
</html>

