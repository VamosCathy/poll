<?php
session_start();
if(!isset($_SESSION['uid'])){
	header("location:index.php");
	exit;
}
else{
	$userid = $_SESSION['uid'];
	$username = $_SESSION['username'];

//连接数据库
	$conf = parse_ini_file(__DIR__ . '/conf/db.ini');
	require_once __DIR__ . '/conf/conn.php';

	$stusql = 'SELECT * FROM `pollers` where `u_id`=' . $userid . ' LIMIT 1';
	$pdoTmp = $db->query($stusql);
	$stuFromDb = $pdoTmp->fetchAll();

	require_once __DIR__ . '/resource/setting.html';

}

?>