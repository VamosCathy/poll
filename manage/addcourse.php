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
	if (!isset($_SESSION['uid']) || $_SESSION['username'] != $conf['manageid']) {
		header("location:index.php");
		exit;
	}
	else{
		if(!isset($_SESSION['username']) || $_SESSION['username'] == ""){
			header("location:index.php");
			exit;
		}
		require_once __DIR__ . '/../conf/conn.php';

		$tch_sql = 'SELECT * from `teachers`';
		$pdoTmp2 = $db->query($tch_sql);
		$tchInfo = $pdoTmp2->fetchAll();

		require_once __DIR__ . '/../resource/addcourse.html';
	}

}

?>
