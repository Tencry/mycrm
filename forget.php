<?
session_start();
$key = $_GET['key'];
$_SESSION[$key] = null;
unset($_SESSION[$key]);
?>