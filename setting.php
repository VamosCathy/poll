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
	$dsn = 'mysql:host=' . $conf['host'] . ';port=' . $conf['port'] . ';dbname=' . $conf['dbname'] . ';charset=' . $conf['charset'];
	$db = new PDO($dsn,$conf['username'],$conf['password']);

	$stusql = 'SELECT * FROM `pollers` where `u_id`=' . $userid . ' LIMIT 1';
	$pdoTmp = $db->query($stusql);
	$stuFromDb = $pdoTmp->fetchAll();

	require_once __DIR__ . '/resource/setting.html';

}

?>