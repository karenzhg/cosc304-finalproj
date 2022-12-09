<?php
$authenticatedUser = NULL;
session_start();

$authenticatedUser = validateLogin();

if ($authenticatedUser != NULL) {
    header('Location: index.php');
} else {
    header('Location: login.php');
}
?>

<?php
function validateLogin() {
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        return NULL;
    }
    
    // Beware db_credentials $username conflict!
    // db_credentials defines $username which will
    // override any previous $username on include.
    $webUsername = $_POST['username'];
    $webPassword = $_POST['password'];

    if (strlen($webUsername) == 0 || strlen($webPassword) == 0) {
        return NULL;
    }

    $sql = "SELECT * FROM Customer WHERE userId = ? and password = ?";
	include 'include/db_credentials.php';
    $con = sqlsrv_connect($server, $connectionInfo);
	
	/* Try/Catch connection errors */
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
    }
    
    $pstmt = sqlsrv_query($con, $sql, array($webUsername, $webPassword));
    $retStr = sqlsrv_fetch_array($pstmt, SQLSRV_FETCH_ASSOC);

    sqlsrv_close($con);

    if ($retStr) {
        $_SESSION['authenticatedUser'] = $webUsername;
    } else {
        $_SESSION['loginMessage'] = "Could not connect to the system using that username/password.";
    }

    return $retStr;
}
?>
