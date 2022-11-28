<html>
<head>
<title>Orinthego Shipment Processing</title>
</head>
<body>

<?php

	// TODO: Get order id      
	$orderId=null;
	if(isset($_GET['orderId'])){
		$orderId = $_GET['orderId'];
	}
	echo("OrderId = " . $orderId . "<br>");
	echo("Connecting<br>");

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
	echo("Connected<br>");

	// TODO: Check if valid order id
	echo("Verifying order ID<br>");
	$result = sqlsrv_query($con, "SELECT orderId FROM ordersummary");
	$include = false;
	if($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
		if($row['orderId'] == $orderId){
			$include = true;
		}
	}
	if($include=false){
		echo("Invalid order ID<br>");
	}
	else{
		echo("Valid order ID<br>");
		// TODO: Start a transaction 

		#session_start();

		// TODO: Retrieve all items in order with given id

		$sql2 = "SELECT productId, quantity FROM orderProduct WHERE orderId = ?";
		$result2 = sqlsrv_query($con, $sql2, array($orderId));
		$prodList = [];
		$quantityOrder = [];
		while($row = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)) {
			$quan = $row['quantity'];

			//for($i = 0; $i <= $quan; $i++){
			$prodList[] =  $row['productId'];
			$quantityOrder[]= $row['quantity'];
			//}
			//echo("Quantity: " . $quan ." Products id is:".$row['productId']. "  ");
			
		}

		// TODO: Create a new shipment record.

		$sql4 = "INSERT INTO shipment (warehouseId) OUTPUT INSERTED.shipmentId VALUES(?);";
		$result4 = sqlsrv_query($con, $sql4, array(1));
		if(!sqlsrv_fetch($result4)){
			echo("Error");
		}
		$shipmentId = sqlsrv_get_field($result4,0);

		// TODO: For each item verify sufficient quantity available in warehouse 1.
		/** 
		$sql5 = "SELECT productId, quantity FROM productInventory WHERE warehouseId = 1";
		$result5 = sqlsrv_query($con, $sql5, array());
		$sufficient = [];
		while($row = sqlsrv_fetch_array($result5, SQLSRV_FETCH_ASSOC)){
			echo($row['productId'] . "     " . $row['quantity'] . "<br>");
			foreach($prodList as &$value){
				if($value == $row['productId'] && $row['quantity'] > 0){
					echo($row['productId'] . " Sufficient<br>");
				}
				elseif($value == $row['productId']){
					echo("Insufficient<br>");
				}
			}	
		}
		*/
		$sql5 = "SELECT productId, quantity FROM productInventory WHERE warehouseId = 1";
		$result5 = sqlsrv_query($con, $sql5, array());
		$inventoryQuantity=[]; 
		while($row = sqlsrv_fetch_array($result5, SQLSRV_FETCH_ASSOC)){
			foreach($prodList as &$value){
				if($value==$row['productId']){
					$inventoryQuantity[]=$row['quantity'];

				}
			}

		}
		//foreach($inventoryQuantity as &$value){
			//	echo("inventoryQuantity is ".$value."<br>");
		//	}
		$newQuantity = [];
		$update=true;
		for ($i = 0; $i < count($inventoryQuantity); $i++)  {
			if($quantityOrder[$i]<$inventoryQuantity[$i]){
				$newInventory=$inventoryQuantity[$i]-$quantityOrder[$i];
				$newQuantity[]=$newInventory;
				echo("Product ID is: ".$prodList[$i]."   "."Quantity in Order is ".$quantityOrder[$i]."   "."Quantity in Inventory is ".$inventoryQuantity[$i].""." "."New Inventory: ".$newInventory."<br>");
			}
			else{
				// TODO: If any item does not have sufficient inventory, cancel transaction and rollback. Otherwise, update inventory for each item.
				echo("Insufficient Quantity for Product ID: ". $prodList[$i]." Transaction Canceled");
				$update=false;
				break;
			}
		}
		//update inventory
		if($update){
			for ($i = 0; $i < count($prodList); $i++)  {
				sqlsrv_query($con, "UPDATE productInventory SET quantity = ? WHERE productId = ?", array($newQuantity[$i], $prodList[$i]));
			}
			echo("Shipment successfully processed");
		}
		/**
		 * Testing if inventory is updated
		
		$sql6 = "SELECT productId, quantity FROM productInventory WHERE warehouseId = 1";
		$result6 = sqlsrv_query($con, $sql5, array());
		while($row = sqlsrv_fetch_array($result6, SQLSRV_FETCH_ASSOC)){
			echo("Product ID: ".$row['productId']. "Quantity: ".$row['quantity']);
		}
		 */
		// TODO: Make sure to commit or rollback active transaction
	}
?>

<h2><a href="shop.html">Back to Main Page</a></h2>

</body>
</html>