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
	if (empty($_POST)) {
		echo "非法访问！";
	}
	else{
		$comment = $_POST['comment'];
		$tid = $_POST['tid'];
//header("Content-Type:text/html;charset=utf-8");

//连接数据库
		$dsn = 'mysql:host=' . $conf['host'] . ';port=' . $conf['port'] . ';dbname=' . $conf['dbname'] . ';charset=' . $conf['charset'];
		$db = new PDO($dsn,$conf['username'],$conf['password']);

		$comment_sql = 'INSERT into `comments` (t_id,comment) values (' . $tid . ',\'' . $comment . '\')';
		$db->exec($comment_sql);
		header("location:home.php");
//echo "<script>alert('提交成功');</script>";
	}
}

?>