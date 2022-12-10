<!DOCTYPE html>
<html>
<head>
<body>
</head>


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
$err = [];
echo("Email: ".$email."<br>");
echo("First Name: ".$firstname."<br>");
echo("Last Name: ".$lastname."<br>");
echo("Phone Num: ".$phonenum."<br>");
echo("Address: ".$address."<br>");
echo("City: ".$city."<br>");
echo("State: ".$state."<br>");
echo("Postal Code: ".$postalcode."<br>");
echo("Country: ".$country."<br>");
echo("userid: ".$userid."<br>");
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
    $sql1 = "SELECT * FROM Customer";
    $result1 = sqlsrv_query($con, $sql1, array());
    $valid = true;
    if(!empty($email)){
        if($row = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)) {
            //echo(count($row));
            if($row['email'] != $email){
            }
            else{
                $valid = false;
                echo("This email address already exists"."<br>");
            }
        }
    }
    else{
        $valid =false;
        echo("Email is empty"."<br>");
    }
    if(!empty($userid)){
        if($row = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)) {
            //echo(count($row));
            if($row['userid'] != $userid){
            }
            else{
                $valid = false;
                echo("This userid already exists")."<br>";
            }
        }
    }
    else{
        $valid =false;
        echo("UserID is empty"."<br>");
    }
    if(empty($firstname)){
        $valid = false;
        echo("First Name is empty"."<br>");
    }
    if(empty($lastname)){
        $valid = false;
        echo("Last Name is empty"."<br>");
    }
    if(empty($password)){
        $valid = false;
        echo("Password is empty"."<br>");
    }
    if(empty($address)){
        $valid = false;
        echo("Password is empty"."<br>");
    }
    if(empty($phonenum)){
        $valid = false;
        echo("Phone Number is empty"."<br>");
    }
    if(empty($city)){
        $valid = false;
        echo("City is empty"."<br>");
    }
    if(empty($state)){
        $valid = false;
        echo("State is empty"."<br>");
    }
    if(empty($postalcode)){
        $valid = false;
        echo("Postal Code is empty"."<br>");
    }
    if(empty($country)){
        $valid = false;
        echo("Country is empty"."<br>");
    }
    if($valid){

        $sql2 = "INSERT INTO Customer (email, firstName, lastName, password, phonenum, address, city, state, postalcode, country, userid) VALUES ('$email','$firstname','$lastname','$password','$phonenum','$address', '$city', '$state', '$postalcode', '$country', '$userid')";
        sqlsrv_query($con, $sq2, array());
        echo("Registration completed"."<br>");

    }
    else{
        echo("Registration Rejected"."<br>");
    }
?>
<a href="./index.php">Return</a>
</body>
</html>
