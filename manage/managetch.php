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

	$course_sql = 'SELECT * from `courses`';
	$pdoTmp = $db->query($course_sql);
	$courseInfo = $pdoTmp->fetchAll();

	$tch_sql = 'SELECT * from `teachers`';
	$pdoTmp2 = $db->query($tch_sql);
	$tchInfo = $pdoTmp2->fetchAll();

	require_once __DIR__ . '/../resource/managetch.html';
}

?>