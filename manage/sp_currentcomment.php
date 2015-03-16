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
	//选择有评论的老师，判断get的数据是否合法
	$tch_in_ccomment_sql = 'SELECT t_id from comments';
	$tch_in_ccomment_tmp = $db->query($tch_in_ccomment_sql);
	$tch_in_ccomment_FromDb = $tch_in_ccomment_tmp->fetchAll();
	$flag = 0;
	foreach ($tch_in_ccomment_FromDb as $key => $value) {
		if ($_GET['tid'] == $value['t_id']) {
			$flag = 1;
			break;
		}
	}
	if ($flag != 1) {
		require_once __DIR__ . '/../resource/sp_currentcomment.html';
	}
	else{
		//查找教师姓名
		$tchname_sql = 'SELECT teachername from teachers where t_id=' . $_GET['tid'];
		$tchname_tmp = $db->query($tchname_sql);
		$tchname = $tchname_tmp->fetchAll();

		//查找该教师的所有评论
		$ccomment_sql = 'SELECT * from comments where t_id=' . $_GET['tid'];
		$ccomment_tmp = $db->query($ccomment_sql);
		$ccomment_FromDb = $ccomment_tmp->fetchAll();
		require_once __DIR__ . '/../resource/sp_currentcomment.html';
	}
}
?>