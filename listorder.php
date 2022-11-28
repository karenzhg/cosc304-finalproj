<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Orinthego Order List</title>
<style>
a:link {
  color: #40b1c9;
  background-color: transparent;
  text-decoration: none;
}

a:visited {
  color: #012229;
  background-color: transparent;
  text-decoration: none;
}
</style>
</head>
<body style="background-color:#f5f2e6; color:#032115">
<h2 align="left"><a href="index.php">Home</a> | <a href="listprod.php">Product List</a> | <a href="showcart.php">Your Shopping Cart</a></h2>
<h1>Order List</h1>

<?php
include 'include/db_credentials.php';

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

/**
Useful code for formatting currency:
	number_format(yourCurrencyVariableHere,2)
**/

/** Write query to retrieve all order headers **/
$sql = "SELECT orderId, orderDate, C.customerId, firstName, lastName, totalAmount FROM orderSummary O JOIN customer C ON O.customerId = C.customerId";
$results = sqlsrv_query($con, $sql, array());
echo("<tr align=left><td colspan=5><table border=1><th>Order ID</th><th>Order Date</th><th>Customer ID</th><th>Customer Name</th><th>Total Amount</th></tr>");
while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
	$orderDate = "";
	if($row['orderDate'] != null){
		$orderDate = date_format($row['orderDate'], "Y-m-d H:i:s");
	}
	
	echo("<tr><td>" . $row['orderId'] . "</td><td>" . $orderDate . "</td><td>" . $row['customerId'] . "</td><td>" . $row['firstName'] . " " . $row['lastName'] . "</td><td>$" . $row['totalAmount'] . "</td></tr>");
	$result2 = sqlsrv_query($con, "SELECT productId, quantity, price FROM orderproduct WHERE orderId = '" . $row['orderId'] ."'", array());
	
	echo("<tr align=right><td colspan=5><table border=1><th>Product ID</th><th>Quantity</th><th>Price</th></tr>");
	/** For each order in the results
		Print out the order header information
		Write a query to retrieve the products in the order
			- Use sqlsrv_prepare($connection, $sql, array( &$variable ) 
				and sqlsrv_execute($preparedStatement) 
				so you can reuse the query multiple times (just change the value of $variable)
		For each product in the order
			Write out product information 
	**/
	while ($row2 = sqlsrv_fetch_array($result2)) {	
		echo("<tr><td>" . $row2['productId'] . "</td><td>" . $row2['quantity'] . "</td><td>$" . $row2['price'] . "</td></tr>");
	} 
	echo("</table>");
	
}
echo("</table></td></tr>");

/** Close connection **/
sqlsrv_close($con)
?>

</body>
</html>

