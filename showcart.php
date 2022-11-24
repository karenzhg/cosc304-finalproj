<?php
// Get the current list of products
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<h2 align="left"><a href="listorder.php">List All Orders</a></h2>
<title>Your Shopping Cart</title>
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

<?php
$productList = null;
if (isset($_SESSION['productList'])){
	$productList = $_SESSION['productList'];
	echo("<h1>Your Shopping Cart</h1>");
	echo("<table><tr><th>Product Id</th><th>Product Name</th><th>Quantity</th>");
	echo("<th>Price</th><th>Subtotal</th></tr>");

	$total =0;
	foreach ($productList as $id => $prod) {
		echo("<tr><td>". $prod['id'] . "</td>");
		echo("<td>" . str_replace('\t', ' ', $prod['name']) . "</td>");

		echo("<td align=\"center\">". $prod['quantity'] . "</td>");
		$price = $prod['price'];

		echo("<td align=\"right\">$" . number_format($price ,2) ."</td>");
		echo("<td align=\"right\">$" . number_format($prod['quantity']*$price, 2) . "</td></tr>");
		echo("</tr>");
		$total = $total +$prod['quantity']*$price;
	}
	echo("<tr><td colspan=\"4\" align=\"right\"><b>Order Total</b></td><td align=\"right\">$" . number_format($total,2) ."</td></tr>");
	echo("</table>");

	echo("<h2><a href=\"checkout.php\">Check Out</a></h2>");
} else{
	echo("<H1>Your shopping cart is empty!</H1>");
}
?>
<h2><a href="listprod.php">Continue Shopping</a></h2>
</body>
</html> 

