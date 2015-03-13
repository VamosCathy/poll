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
	require_once __DIR__ . '/../conf/conn.php';

	//查找教师信息
	$tch_sql = 'SELECT * from `teachers` where `t_id`=' . $input['tid'] . ' LIMIT 1';
	$pdoTmp = $db->query($tch_sql);
	$tchFromDb = $pdoTmp->fetchAll();

	//查找学生信息
	$stu_sql = 'SELECT * from `pollers` where `u_id`=' . $userid . ' LIMIT 1';
	$pdoTmp2 = $db->query($stu_sql);
	$stuFromDb = $pdoTmp2->fetchAll();

	//查找学生对应该教师的选修课
	$elective_sql = 'SELECT coursename,c_id from courses where t_id=' . $input['tid'] . ' and c_id in (SELECT c_id from stucourses where u_id=' . $userid . ')';
	$elective_tmp = $db->query($elective_sql);
	$electiveFromDb = $elective_tmp->fetchAll();

	require_once __DIR__ . '/../resource/comment.html';
}
?>