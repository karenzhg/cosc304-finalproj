<!DOCTYPE html>
<html>
<head>
<title>Orinthego</title>

<h3>Check Inventory</h3>
</head>
<body>

<?php
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
    $sql = "SELECT warehouseId,warehouseName FROM warehouse";
    $result = sqlsrv_query($con, $sql, array());
    $warehouselists = [];
    $warehousenames = [];
    while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $warehouselists[] = $row['warehouseId'];   
        $warehousenames[] = $row['warehouseName'];
    }
    for ($i = 0; $i < count($warehouselists); $i++)  {
        echo("Warehouse ID is ".$warehouselists[$i]."<br>");
        echo("Warehouse Name: ".$warehousenames[$i]."<br>");
        $sql1 = "SELECT productId, quantity, price FROM productinventory WHERE warehouseId = ?";
        $result1 = sqlsrv_query($con, $sql1, array($warehouselists[$i]));
        while ($row = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)) {
            //echo("Warehouse ID ".$row["warehouseId"]);
            echo("Product ID is: ".$row["productId"]." "."Quantity is ".$row["quantity"]." "."Price is ".$row["price"]."<br>");

        }   
    }

    sqlsrv_close($con);
?>

</body>
</html>