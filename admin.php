<!DOCTYPE html>
<html>
<head>
<title>Administrator Page</title>
</head>
<body>

<?php 
// TODO: Include files auth.php and include/db_credentials.php
include 'include/db_credentials.php';
#include 'auth.php';

$host = "cosc304_sqlserver";   
$database = "orders";
$uid = "sa";
$pw = "304#sa#pw";

$connectionInfo = array("Database"=>$database, "UID"=>$username, "PWD"=>$password, "CharacterSet" => "UTF-8", "TrustServerCertificate"=>"yes");
$con = sqlsrv_connect($server, $connectionInfo);
if( $con === false ) {
	die( print_r( sqlsrv_errors(), true));
}
?>

<?php
// TODO: Write SQL query that prints out total order amount by day
echo("<h3>Administrator Sales Report by Day</h3>");

$sql = "SELECT orderDate, totalAmount FROM ordersummary ORDER BY orderDate";

$results = sqlsrv_query($con, $sql, array());
echo("<table border=1>");
echo("<tr><th>OrderDate</th><th>Total Order Amount</th></tr>");
while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
	$orderDate = "";
	if($row['orderDate'] != null && $row['totalAmount'] > 0){
		$orderDate = date_format($row['orderDate'], "Y-m-d H:i:s");
        echo("<tr><td>" . $orderDate . "</td><td> $" . $row['totalAmount'] . "</td></tr>");
	}
	
}
echo("</table>");
/** Close connection **/
sqlsrv_close($con)


?>
</body>
</html>