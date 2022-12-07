<?php 
    session_start();
    include 'header.php';
    include 'include/db_credentials.php';
    $prodId = null;
    if(isset($_GET['id'])){
        $prodId = $_GET['id'];
    }
?>

<!DOCTYPE html>
<html>
<head>
<title>Orinthego - Product Information</title>
</head>
<body style="background-color:#f5f2e6">

<?php
    $host = "cosc304_sqlserver";   
    $database = "orders";
    $uid = "sa";
    $pw = "304#sa#pw";

    $connectionInfo = array("Database"=>$database, "UID"=>$username, "PWD"=>$password, "CharacterSet" => "UTF-8", "TrustServerCertificate"=>"yes");
    $con = sqlsrv_connect($server, $connectionInfo);
    if( $con === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

// Get product name to search for
// TODO: Retrieve and display info for the product
// $id = $_GET['id'];
// TODO: If there is a productImageURL, display using IMG tag

    $sql1 = "SELECT * FROM product WHERE productId =?";
    $result1 = sqlsrv_query($con, $sql1, array($prodId));
    $pname = "";
    $pprice = 0;
    if($row = sqlsrv_fetch_array($result1)){
        $img = "<img src = \"img/" . $prodId . ".jpg\"/>";
        $pname = str_replace('\'', '%27', $row['productName']);
        $pname = str_replace(' ', '\t', $pname);
        $pprice = $row['productPrice'];
        echo("<h2>" . $row['productName'] . "</h2>" . $img . "<br>Id: " . $row['productId'] . "<br>Price: $" . $row['productPrice']);
    }

// TODO: Retrieve any image stored directly in database. Note: Call displayImage.php with product id as parameter.

    //echo("<img src='/displayImage.php?id=" . $prodId . "'/>");

// TODO: Add links to Add to Cart and Continue Shopping

$url = "$localhost/addcart.php?id=" . $prodId . "&name=" . $pname . "&price=" . $pprice;
echo("<h2 align='left'><a href=$url>Add to Cart</a></h2>");
echo("<h2 align='left'><a href='listprod.php'>Continue Shopping</a></h2>");
?>
</body>
</html>
