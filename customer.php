<?php 
    include 'auth.php';	
	$user = $_SESSION['authenticatedUser'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Customer Page</title>
</head>
<body>

<?php     
    include 'header.php';
    include 'include/db_credentials.php';
?>
<?php
/** Create connection, and validate that it connected successfully **/

$host = "cosc304_sqlserver"; 
$database = "orders";
$uid = "sa";
$pw = "304#sa#pw";

$connectionInfo = array("Database"=>$database, "UID"=>$username, "PWD"=>$password, "CharacterSet" => "UTF-8", "TrustServerCertificate"=>"yes");
$con = sqlsrv_connect($server, $connectionInfo);
if( $con === false ) {
	die( print_r( sqlsrv_errors(), true));
}
//$sql = "SELECT * FROM customer C WHERE userid = ?";
$sql = "SELECT * FROM customer C WHERE userid = ?";

// TODO: Print Customer information
$results = sqlsrv_query($con, $sql, array($user));
while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
	echo("<tr align=left><td><table border=1><th>ID</th><td>" . $row['customerId'] . "</td></tr><tr><th>First Name</th><td>" . $row['firstName'] . "</td></tr><tr><th>Last Name</th><td>" . $row['lastName'] 
            . "</td></tr><tr><th>Email</th><td>" . $row['email'] . "</td></tr><tr><th>Phone</th><td>" . $row['phonenum'] . "</td></tr><tr><th>Address</th><td>" . $row['address']
            . "</td></tr><tr><th>City</th><td>" . $row['city'] . "</td></tr><tr><th>State</th><td>" . $row['state'] . "</td></tr><tr><th>Postal Code</th><td>" . $row['postalCode']
            . "</td></tr><tr><th>Country</th><td>" . $row['country'] . "</td></tr><tr><th>Username</th><td>" . $row['userid'] . "</td></tr>");
}
echo("</table></td></tr>");
    
// Make sure to close connection
sqlsrv_close($con)
?>
</body>
</html>
