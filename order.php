<?php
/** Get customer id **/
$custId = null;
if(isset($_GET['customerId'])){
	$custId = $_GET['customerId'];
}

$password1 = null;
if(isset($_GET['password'])){
	$password1 = $_GET['password'];
}

session_start();
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Orinthego Grocery Order Processing</title>
</head>
<body style="background-color:#f5f2e6">

<?php
include 'include/db_credentials.php';
$productList = null;
if (isset($_SESSION['productList'])){
	$productList = $_SESSION['productList'];
}


/** Make connection and validate **/
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
Determine if valid customer id was entered
Determine if there are products in the shopping cart
If either are not true, display an error message
**/
$sql1 = "SELECT customerId FROM customer";
$sql2 = "SELECT totalAmount FROM orderSummary WHERE customerId = '" . $custId . "'";

$result1 = sqlsrv_query($con, $sql1, array());
$result2 = sqlsrv_query($con, $sql2, array());
$include = false;

while ($row = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)) {
	if($row['customerId'] == $custId){
		$include = true;
	}
}
$pass = sqlsrv_query($con, "SELECT password FROM customer WHERE customerId = ?", array($custId));
if($prow = sqlsrv_fetch_array($pass)){
	$p = $prow['password'];
}


if($include){
	if($p != $password1){
		echo("<h1>Wrong password</h1>");
		$include = false;
	}
	if($result2 == 0){
		echo("Cart is empty");
	}
}
else{
	echo("<h1>Customer ID is invalid</h1>");
}
if($include){
/** Save order information to database**/

	/**
	// Use retrieval of auto-generated keys.
	$sql = "INSERT INTO <TABLE> OUTPUT INSERTED.orderId VALUES( ... )";
	$pstmt = sqlsrv_query( ... );
	if(!sqlsrv_fetch($pstmt)){
		//Use sqlsrv_errors();
	}
	$orderId = sqlsrv_get_field($pstmt,0);
	**/
	
	$sql3 = "INSERT INTO ordersummary (customerId, totalAmount, orderDate) OUTPUT INSERTED.orderId VALUES(?, 0, ?);";
	$pstmt = sqlsrv_query($con, $sql3, array($custId , date("Y-m-d H:i:s")));
	if(!sqlsrv_fetch($pstmt)){
		echo("Error");
	}
	$orderId = sqlsrv_get_field($pstmt,0);

/** Insert each item into OrderedProduct table using OrderId from previous INSERT **/
$total = 0;	
foreach ($productList as $id => $prod) {
		$pid = intval($prod['id']);
		$result5 = sqlsrv_query($con, "INSERT INTO orderproduct VALUES (?, ?, ?, ?)", array($orderId , $pid , $prod['quantity'] , $prod['price']));		
		$total = $total + $prod['quantity'] * $prod['price'];
	}

/** Update total amount for order record **/
	sqlsrv_query($con, "UPDATE ordersummary SET totalAmount = ? WHERE orderId = ?", array($total, $orderId));
	
/** For each entry in the productList is an array with key values: id, name, quantity, price **/

/** Print out order summary **/
	$subtotal = 0;
	$total = 0;
	echo("<h2>Your Order Summary</h2>");
	echo("<table><tr><th>Product Id</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr>");
	foreach ($productList as $id => $prod) {
		$subtotal = number_format($prod['quantity'] * $prod['price'], 2);
		$total = $total + $subtotal;
		$pname = str_replace('\t', ' ', $prod['name']);
		echo("<tr><td>" . $prod['id'] . "</td><td>" . $pname . "</td><td>" . $prod['quantity'] . "</td><td>$" . number_format($prod['price'],2) . "</td><td>$" . $subtotal . "</td></tr>");
	}

	$name = sqlsrv_query($con, "SELECT firstName, lastName FROM customer WHERE customerId = ?", array($custId));
	if($nrow = sqlsrv_fetch_array($name)){
		$n = $nrow['firstName'] . " " . $nrow['lastName'];
	}

	echo("<tr><td>Order Total: $" . number_format($total,2));
	echo("</td></tr>");
	echo("</table>");
	echo("<h2>Order completed. Will be shipped soon...<br>");
	echo("Your order reference number is: '" . $orderId . "'<br>");
	echo("Shipping to customer: " . $custId . " ");
	echo("Name: " . $n);
	echo("</h2>");
	echo("<br><h2 align='left'><a href='listprod.php'>Continue Shopping</a></h2>");
}
/** Clear session/cart **/
	session_destroy();
	sqlsrv_close($con)

?>
</body>
</html>

