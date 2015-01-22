<?php
session_start();
if(!isset($_SESSION['uid'])){
	require __DIR__ . '/welcome.php';
	exit;
}
elseif (isset($_SESSION['uid']) && (!isset($_SESSION['manage']) || !$_SESSION['manage'])) {
	require __DIR__ . '/stu/home.php';
	exit;
}
else{
	require __DIR__ . '/manage/manage.php';
	exit;
}
?>