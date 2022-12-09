<?php
session_start();

$authenticated = false;
if (isset($_SESSION['authenticatedUser'])) {
    $authenticated = $_SESSION['authenticatedUser'];
}

if (!$authenticated) {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) {
        $requestUrl = "https://";
    } else {
        $requestUrl = "http://";
    }
    $requestUrl .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $loginMessage = "You have not been authorized to access the URL " . $requestUrl;
    $_SESSION['loginMessage'] = $loginMessage;

    header('Location: login.php');
}
?>