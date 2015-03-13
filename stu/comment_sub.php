<?php
session_start();
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
if (!isset($_SESSION['uid'])) {
	header("location;../index.php");
	exit;
}
elseif ($_SESSION['username'] == $conf['manageid']) {
	header("location:../manage/manage.php");
	exit;
}
else{
	if (empty($_POST) || $_POST['tid'] == NULL) {
		echo "非法访问！";
	}
	else{
		require_once __DIR__ . '/../conf/conn.php';
		if ($_POST['comment'] == NULL) {
			header("location:comment.php?tid=" . $_POST['tid']);
		}
		elseif ($_POST['csname'] == NULL) {
			$comment_sql = 'INSERT into comments (t_id,comment) values (' . $_POST['tid'] . ',\'' . $_POST['comment'] . '\')';
		}
		else{
			$comment_sql = 'INSERT into comments (t_id,comment,c_id) values (' . $_POST['tid'] . ',\'' . $_POST['comment'] . '\',' . $_POST['csname'] . ')';
		}
		$db->exec($comment_sql);
		if ($db->errorCode() != '00000'){
		$error = $db->errorInfo();
		echo '错误: [',$error['1'],'] ',$error['2'];
		die();
	}
		header("location:home.php");
	}
}

?>