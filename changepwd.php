<?php
session_start();
if(!isset($_SESSION['uid'])){
	header("location:index.php");
	exit;
}
else{
	$currentpwd = $_POST['currentpwd'];
	$newpwd = $_POST['newpwd'];
	$confirmnewpwd = $_POST['confirmnewpwd'];

	$conf = parse_ini_file(__DIR__ . '/conf/db.ini');
	$dsn = 'mysql:host=' . $conf['host'] . ';port=' . $conf['port'] . ';dbname=' . $conf['dbname'] . ';charset=' . $conf['charset'];
	$db = new PDO($dsn,$conf['username'],$conf['password']);

	$selectpwd_sql = 'SELECT `pwd` from `pollers` where `u_id`=' . $_SESSION['uid'] . ' LIMIT 1';

	$pdoTmp = $db->query($selectpwd_sql);
	$pwdFromDb = $pdoTmp->fetchAll();

	if(md5($currentpwd) != $pwdFromDb[0]['pwd']){
		$_SESSION['changepwdErr'] = '原密码不符';
		header("Location:./setting.php");
	}
	elseif (md5($currentpwd) == $pwdFromDb[0]['pwd'] && $newpwd != $confirmnewpwd) {
		$_SESSION['changepwdErr'] = '两次输入的新密码不一致';
		header("Location:./setting.php");
	}
	else{
		$pwd_md5 = md5($newpwd);
		$changepwd_sql = 'UPDATE `pollers` set `pwd`=\'' . $pwd_md5 . '\' where `u_id`=' . $_SESSION['uid'];
		$db->exec($changepwd_sql);

		if ($db->errorCode() != '00000'){
			$error = $db->errorInfo();
			echo '错误: [',$error['1'],'] ',$error['2'];
			die();
		}
		
		session_destroy();
		header("Location:index.php");
	}

}

?>