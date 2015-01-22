<?php
session_start();
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
if(!isset($_SESSION['uid'])){
	header("location:../index.php");
	exit;
}
elseif ($_SESSION['username'] == $conf['manageid']) {
	header("location:../manage/manage.php");
	exit;
}
else{
	$userid = $_SESSION['uid'];
	$username = $_SESSION['username'];
	$input = $_GET;
	$d = array();
	if (!isset($input['tid']) || empty($input['tid'])) {
		$_SESSION['commentErr'] = '没有参数';
		header("location:./home.php");
		exit;
	}

	$dsn = 'mysql:host=' . $conf['host'] . ';port=' . $conf['port'] . ';dbname=' . $conf['dbname'] . ';charset=' . $conf['charset'];
	$db = new PDO($dsn,$conf['username'],$conf['password']);

//查找教师信息
	$tch_sql = 'SELECT * from `teachers` where `t_id`=' . $input['tid'] . ' LIMIT 1';
	$pdoTmp = $db->query($tch_sql);
	$tchFromDb = $pdoTmp->fetchAll();

//查找学生信息
	$stu_sql = 'SELECT * from `pollers` where `u_id`=' . $userid . ' LIMIT 1';
	$pdoTmp2 = $db->query($stu_sql);
	$stuFromDb = $pdoTmp2->fetchAll();

	require_once __DIR__ . '/../resource/comment.html';
}
?>