<?php
include 'auth.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Administrator Page</title>
</head>
<body style="background-color:#f5f2e6">

<?php
$webUsername = $_SESSION['authenticatedUser'];

echo("<h3>Administrator Sales Report by Day</h3>");

$sql = "select year(orderDate), month(orderDate), day(orderDate), SUM(totalAmount) FROM OrderSummary GROUP BY year(orderDate), month(orderDate), day(orderDate)";
include 'include/db_credentials.php';
$con = sqlsrv_connect($server, $connectionInfo);

/* Try/Catch connection errors */
if( $con === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$pstmt = sqlsrv_query($con, $sql);

echo("<table class=\"table\" border=\"1\">");
echo("<tr><th>Order Date</th><th>Total Order Amount</th>");	
while(sqlsrv_fetch($pstmt)) {
    echo("<tr><td>".sqlsrv_get_field($pstmt, 0)."-".sqlsrv_get_field($pstmt, 1)."-".sqlsrv_get_field($pstmt, 2)."</td><td>$".number_format(sqlsrv_get_field($pstmt, 3),2)."</td></tr>");
}
echo("</table>");	

sqlsrv_close($con);
?>

</body>
</html>