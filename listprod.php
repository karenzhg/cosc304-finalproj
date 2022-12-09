<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Orinthego Product List</title>
</head>
<body style="background-color:#f5f2e6; color:#032115">
<h2 align="left"><a href="index.php">Home</a> | <a href="listorder.php">Order List</a> | <a href="showcart.php">Your Shopping Cart</a></h2>
<h1>Search for the products you want to buy:</h1>

<form method="get" action="listprod.php">
<input type="text" name="productName" size="50">
<input type="submit" value="Submit"><input type="reset" value="Reset"> (Leave blank for all products)
</br>
<input type="submit" value="Drinks" name = "drinks">  <input type="submit" value="Onigiri" name = "onigiri">  <input type="submit" value="Other" name = "Other">
</form>

<?php
	include 'include/db_credentials.php';

	/** Get product name to search for **/
	$name = "%";
	if (isset($_GET['productName'])){
		$name = "%" . $_GET['productName'] . "%";
	}

	/** $name now contains the search string the user entered
	Use it to build a query and print out the results. **/
	$sql = "SELECT productId, productName, productPrice FROM product WHERE productname LIKE '" . $name ."'";

	if(isset($_GET['drinks'])) {
		$sql = "SELECT productId, productName, productPrice FROM product WHERE productId < 8 ";
	}

	if(isset($_GET['onigiri'])) {
		$sql = "SELECT productId, productName, productPrice FROM product WHERE productId > 7 AND productID < 16";
	}

	if(isset($_GET['Other'])) {
		$sql = "SELECT productId, productName, productPrice FROM product WHERE productId > 15";
	}

	/** Create and validate connection **/
	$host = "cosc304_sqlserver";   
	$database = "orders";
	$uid = "sa";
	$pw = "304#sa#pw";

	$connectionInfo = array("Database"=>$database, "UID"=>$username, "PWD"=>$password, "CharacterSet" => "UTF-8", "TrustServerCertificate"=>"yes");
	$con = sqlsrv_connect($server, $connectionInfo);
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
	}

	/** Print out the ResultSet **/
	$results = sqlsrv_query($con, $sql, array());
	echo("<table border=1><tr><th></th><th>Product Name</th><th>Product Price</th></tr>");
	while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
		$pname = str_replace('\'', '%27', $row['productName']);
		echo("<tr><td><a href='$localhost/addcart.php?id=" . $row['productId'] . "&name=" . $pname . "&price=" . $row['productPrice'] . "'>Add to cart</a></td><td><a href='$localhost/product.php?id=" . $row['productId'] . "'>" . $row['productName'] . "</a></td><td>$" . $row['productPrice'] . "</td></tr>");
	}
	echo("</table>");

	/** 
	For each product create a link of the form
	addcart.php?id=<productId>&name=<productName>&price=<productPrice>
	Note: As some product names contain special characters, you may need to encode URL parameter for product name like this: urlencode($productName)
	**/
	
	/** Close connection **/
	sqlsrv_close($con);

	/**
        Useful code for formatting currency:
	       number_format(yourCurrencyVariableHere,2)
     **/
?>

</body>
</html> 
