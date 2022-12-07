<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body style="background-color:#f5f2e6; color:#032115">
<?php
	include 'include/db_credentials.php';
	$connectionInfo["Database"] = "";
	$con = sqlsrv_connect($server, $connectionInfo);
	echo("<h1>Connecting to database.</h1><p>");
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
	$fileName = "./ddl/SQLServer_orderdb.ddl";
	$file = file_get_contents($fileName, true);
	$lines = explode(";", $file);
	echo("<ol>");
	foreach ($lines as $line){
		$line = trim($line);
		if($line != ""){
			echo("<li>".$line . ";</li><br/>");
			sqlsrv_query($con, $line, array());
		}
	}
	sqlsrv_close($con);
	echo("</p><h2>Database loading complete!</h2>");
?>
</body>
</html>
