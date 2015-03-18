<?php
session_start();
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
if(!isset($_SESSION['uid'])){
	header("location:../global/index.php");
	exit;
}
elseif ($_SESSION['username'] != $conf['manageid']) {
	header("location:../stu/home.php");
	exit;
}
else{
	require_once __DIR__ . '/../conf/conn.php';
	//从数据库中选取所有课程的信息
	$course_sql = 'SELECT * from courses';
	$course_tmp = $db->query($course_sql);
	$courseFromDb = $course_tmp->fetchAll();
	//查询出所有老师名字
	$tch_sql = 'SELECT t_id,teachername from teachers';
	$tch_tmp = $db->query($tch_sql);
	$tchFromDb = $tch_tmp->fetchAll();
}
require_once __DIR__ . '/../resource/courselist.html';
?>