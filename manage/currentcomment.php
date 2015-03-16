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

//选取所有老师信息
	$tch_info_sql = 'SELECT * from `teachers` where t_id in (select t_id from comments)';
	// $tch_info_sql = 'SELECT * from `teachers` where t_id=9';
	$pdoTmp = $db->query($tch_info_sql);
	$tchInfo = $pdoTmp->fetchAll();
	require_once __DIR__ . '/../resource/currentcomment.html';
}

?>