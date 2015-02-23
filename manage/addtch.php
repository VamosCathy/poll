<?php
session_start();
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
if(!isset($_SESSION['uid'])){
	header("location:../index.php");
	exit;
}
elseif ($_SESSION['username'] != $conf['manageid']) {
	header("location:../stu/home.php");
	exit;
}
else{
	require_once __DIR__ . '/../conf/conn.php';

	require_once __DIR__ . '/../resource/addtch.html';
}
?>