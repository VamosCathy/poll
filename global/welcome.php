<?php session_start();
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
if (isset($_SESSION['uid']) && $_SESSION['username'] == $conf['manageid']) {
	header("location:./manage/manage.php");
	exit;
}
elseif (isset($_SESSION['uid']) && $_SESSION['username'] != $conf['manageid']) {
	header("location:./stu/home.php");
	exit;
}
else{
	require_once __DIR__ . '/../resource/welcome.html';
}
?>