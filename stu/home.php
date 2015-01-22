<?php
session_start();
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
if (!isset($_SESSION['uid'])) {
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
	$voted = $_SESSION['voted'];

	$dsn = 'mysql:host=' . $conf['host'] . ';port=' . $conf['port'] . ';dbname=' . $conf['dbname'] . ';charset=' . $conf['charset'];
	$db = new PDO($dsn,$conf['username'],$conf['password']);

//查询到该学生学的课程所对应的全部老师
	$tchsql = 'SELECT * from teachers where t_id in (SELECT t_id from courses where c_id in (SELECT c_id from stucourses where u_id=' . $userid . '))';

	$pdoTmp = $db->query($tchsql);
	$InfoFromDb = $pdoTmp->fetchAll();

	$teacherData = array();
	$teacherData['tchinfo'] = $InfoFromDb;

//查询该学生信息
	$stusql = 'SELECT * from pollers where u_id=' . $userid . ' LIMIT 1';
	$stuTmp = $db->query($stusql);
	$stuFromDb = $stuTmp->fetchAll();

	if($voted == 0){
		require_once __DIR__ . '/../resource/homeunvote.html';
	}
	else if($voted == 1){
		require_once __DIR__ . '/../resource/homevoted.html';
	}
}
?>