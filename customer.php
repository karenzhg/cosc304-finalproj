<?php 
    include 'auth.php';	
	$user = $_SESSION['authenticatedUser'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Customer Page</title>
</head>
<body style="background-color:#f5f2e6">
<h2 align ="left">
<a href="index.php">Home</a> | 
<a href="listprod.php">Product List</a>
</h2>   
<?php     
    //include 'header.php';
    include 'include/db_credentials.php';
?>

<form method="get" action="customer.php">
<input type="submit" value="Your Orders" name = "userorders">
</form>

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
echo ("</br>");

//$sql3 = "SELECT orderId, orderDate, C.customerId, firstName, lastName, totalAmount FROM orderSummary O JOIN customer C ON O.customerId = C.customerId WHERE C.customerId = ?";
echo ($user);
if (isset($_GET['userorders'])) {
    $sql3 = "SELECT orderId, orderDate, C.customerId, firstName, lastName, totalAmount FROM orderSummary O JOIN customer C ON O.customerId = C.customerId WHERE C.userid = ?";
$results3 = sqlsrv_query($con, $sql3, array($user));
echo("<tr align=left><td colspan=5><table border=1><th>Order ID</th><th>Order Date</th><th>Customer ID</th><th>Customer Name</th><th>Total Amount</th></tr>");
while ($row = sqlsrv_fetch_array($results3, SQLSRV_FETCH_ASSOC)) {
	$orderDate = "";
	if($row['orderDate'] != null){
		$orderDate = date_format($row['orderDate'], "Y-m-d H:i:s");
	}
	
	echo("<tr><td>" . $row['orderId'] . "</td><td>" . $orderDate . "</td><td>" . $row['customerId'] . "</td><td>" . $row['firstName'] . " " . $row['lastName'] . "</td><td>$" . $row['totalAmount'] . "</td></tr>");
	$result2 = sqlsrv_query($con, "SELECT productId, quantity, price FROM orderproduct WHERE orderId = '" . $row['orderId'] ."'", array());
	
	echo("<tr align=right><td colspan=5><table border=1><th>Product ID</th><th>Quantity</th><th>Price</th></tr>");
	
	while ($row2 = sqlsrv_fetch_array($result2)) {	
		echo("<tr><td>" . $row2['productId'] . "</td><td>" . $row2['quantity'] . "</td><td>$" . $row2['price'] . "</td></tr>");
	} 
	echo("</table>");
	
}
echo("</table></td></tr>");
}
    
// Make sure to close connection
sqlsrv_close($con)
?>
</body>
</html>
