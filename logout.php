<?
header('Content-Type: text/html; charset=utf-8');
include 'startup.php';


$mgr = new Model_Manager();
if ($mgr->logout()) {
	header("Location: /login.php");
	exit;
}
