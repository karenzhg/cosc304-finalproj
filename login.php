<!DOCTYPE html>
<html>
<head>
<title>Orinthego</title>
</head>
<body style="background-color:#f5f2e6">

<h2 align="left"><a href="index.php">Home</a> | <a href="listprod.php"> Browse</a> | <a href="showcart.php">Your Shopping Cart</a></h2>

<div style="margin:0 auto;text-align:center;display:inline">

<h3>Please Login to System</h3>

<?php
if (isset($_SESSION['loginMessage'])) {
    echo("<p>" . $_SESSION['loginMessage'] . "</p>");
    $_SESSION['loginMessage'] = NULL;
}
?>

<br>
<form name="MyForm" method=post action="validateLogin.php">
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