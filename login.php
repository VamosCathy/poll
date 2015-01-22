<?php
session_start();
if(empty($_POST)){
	exit('非法访问！');
}
else{
	$username = $_POST['username'];
	$password = $_POST['password'];

//输入合法性检测


	$conf = parse_ini_file(__DIR__ . '/conf/db.ini');
	$dsn = 'mysql:host=' . $conf['host'] . ';port=' . $conf['port'] . ';dbname=' . $conf['dbname'] . ';charset=' . $conf['charset'];
	$db = new PDO($dsn,$conf['username'],$conf['password']);

	$sql = 'SELECT * FROM `pollers` WHERE username=' . $username . ' LIMIT 1';

	$pdoTmp = $db->query($sql);
	$InfoFromDb = $pdoTmp->fetchAll();

	if($InfoFromDb[0]['pwd'] == md5($password)){
		if($username != $conf['manageid']){
			header("Location:./stu/home.php");
			$_SESSION['uid'] = $InfoFromDb[0]['u_id'];
			$_SESSION['username'] = $username;
			$_SESSION['voted'] = $InfoFromDb[0]['voted'];
			$_SESSION['flowernum'] = $InfoFromDb[0]['flowernum'];
			$_SESSION['eggnum'] = $InfoFromDb[0]['eggnum'];
		}
		else{
			header("location:./manage/manage.php");
			$_SESSION['uid'] = $InfoFromDb[0]['u_id'];
			$_SESSION['username'] = $username;
			$_SESSION['manage'] = 1;
		}
	}
	else{
		$_SESSION['msg'] = "用户名或密码错误";
		header("Location:./welcome.php");
	}
}
?>