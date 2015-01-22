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
	$dsn = 'mysql:host=' . $conf['host'] . ';port=' . $conf['port'] . ';dbname=' . $conf['dbname'] . ';charset=' . $conf['charset'];
	$db = new PDO($dsn,$conf['username'],$conf['password']);

//选取所有老师信息
	$tch_info_sql = 'SELECT * from `teachers`';
	$pdoTmp = $db->query($tch_info_sql);
	$tchInfo = $pdoTmp->fetchAll();
	require_once __DIR__ . '/../resource/commentlist.html';
}

?>