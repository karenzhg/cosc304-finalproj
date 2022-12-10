<!DOCTYPE html>
<html>
<head>
    <title>User Registration Complete</title>
<body>
</head>
<p>User Registration is Completed </p>

<?php

//validation
$email = $_POST["email"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$password = $_POST["password"];
$phonenum = $_POST["phonenum"];
$address= $_POST["address"];
$city= $_POST["city"];
$state = $_POST["state"];
$postalcode= $_POST["postalcode"];
$country= $_POST["country"];
$userid = $_POST["userid"];
echo("Email: ".$email."<br>");
echo("First Name: ".$firstname."<br>");
echo("Last Name: ".$lastname."<br>");
include 'include/db_credentials.php';
	
	$host = "cosc304_sqlserver";   
	$database = "orders";
	$uid = "sa";
	$pw = "304#sa#pw";
	
	$connectionInfo = array("Database"=>$database, "UID"=>$username, "PWD"=>$password, "CharacterSet" => "UTF-8", "TrustServerCertificate"=>"yes");
	$con = sqlsrv_connect($server, $connectionInfo);
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
    $sql = "INSERT INTO Customer (email, firstName, lastName, password, phonenum, address, city, state, postalcode, country, userid) VALUES ('$email','$firstname','$lastname','$password','$phonenum','$address', '$city', '$state', '$postalcode', '$country', '$userid')";
    sqlsrv_query($con, $sql, array());
?>
<a href="./index.php">Return</a>
</body>
</html>
