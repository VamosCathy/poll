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
	if(empty($_POST)){
		exit('非法访问！');
	}
	else{
		require_once __DIR__ . '/../conf/conn.php';
		//判断是否存在相同课程
		$search_course_sql = 'SELECT * from `courses` where `coursename`=\'' . $_POST['coursename'] . '\'';
		$pdoTmp = $db->query($search_course_sql);
		$tmp = $pdoTmp->fetchAll();
		if(!empty($tmp)){
			$_SESSION['addcourseErr'] = '存在此课程';
		}
		else{//不存在
			// if(!$_POST['tid'] && !$_POST['grade']){
			// 	//echo "1";
			// 	$insert_course_sql = 'INSERT into `courses` (coursename) values (' . $_POST['coursename'] . ')';
			// }
			// elseif($_POST['tid'] && !$_POST['grade']){
			// 	//echo "2";
			// 	$insert_course_sql = 'INSERT into `courses` (coursename,t_id) values (' . $_POST['coursename'] . ',' . $_POST['tid'] . ')';
			// }
			// elseif ($_POST['tid'] && $_POST['grade']) {
			// 	//echo "3";
			// 	$sqltmp = '';
			// 	$num = 0;
			// 	$numtmp = '';
			// 	foreach ($_POST['grade'] as $key => $value) {
			// 		$sqltmp .= $value;
			// 		$sqltmp .= ',';
			// 		$num += 1;
			// 	}
			// 	for($i=1;$i<=$num;$i++){
			// 		$numtmp .= '1,';
			// 	}
			// 	$insert_course_sql = 'INSERT into `courses` (coursename,' . $sqltmp . 't_id) values (\'' . $_POST['coursename'] . '\',' . $numtmp . $_POST['tid'] . ')';
			// }
			if (!$_POST['tid']) {
				$insert_course_sql = 'INSERT into courses (coursename) values (\'' . $_POST['coursename'] . '\')';
			}
			else{
				$insert_course_sql = 'INSERT into `courses` (coursename,t_id) values (\'' . $_POST['coursename'] . '\',' . $_POST['tid'] . ')';
			}
			$db->exec($insert_course_sql);
			if ($db->errorCode() != '00000'){
				$error = $db->errorInfo();
				echo '错误: [',$error['1'],'] ',$error['2'];
				die();
			}
		}
		// header("location:addcourse.php");
	}
}

?>