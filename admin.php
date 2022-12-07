<!DOCTYPE html>
<html>
<head>
<title>Administrator Page</title>
</head>
<body style="background-color:#f5f2e6">

<?php 
// TODO: Include files auth.php and include/db_credentials.php
include 'include/db_credentials.php';
if(empty(session_id()) && !headers_sent())
    include 'auth.php';

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

$sql = "SELECT CAST(orderDate AS DATE) AS day, SUM(totalAmount) AS sumTotal FROM ordersummary GROUP BY CAST(orderDate AS DATE) HAVING SUM(totalAmount) > 0 ORDER BY CAST(orderDate AS DATE)";


$results = sqlsrv_query($con, $sql, array());
echo("<table border=1>");
echo("<tr><th>OrderDate</th><th>Total Order Amount</th></tr>");
while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
	$orderDate = "";
	if($row['day'] != null){
		$orderDate = date_format($row['day'], "Y-m-d");
	}
    echo("<tr><td>" . $orderDate . "</td><td> $" . $row['sumTotal'] . "</td></tr>");
}
echo("</table>");
/** Close connection **/
sqlsrv_close($con)


?>
</body>
</html>
