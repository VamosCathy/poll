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
		$temp=array('1','2','3','4','5','6','7','8','9','0');

		require_once __DIR__ . '/../conf/conn.php';

		foreach ($_POST as $key => $value) {
			$c_id_str = '';
			$c_id = 0;
	//取出课程号
			for($i=0;$i<strlen($key);$i++){
				if(in_array($key[$i],$temp)){
					$c_id_str.=$key[$i];
				}
			}
			$c_id = intval($c_id_str);
	//指定当前课程老师
			if(strpos($key,"tch")){
				if ($value != NULL) {
					$chng_tid_in_course = 'UPDATE `courses` SET `t_id`=' . $value . ' where `c_id`=' . $c_id;
					$db->exec($chng_tid_in_course);
				}
				
			}
	//指定当前课程开课年级
			// elseif(strpos($key,"grade")){
			// 	$chng_grade_reset = 'UPDATE `courses` set `grade_1`=0,`grade_2`=0,`grade_3`=0,`grade_4`=0 where `c_id`=' . $c_id;
			// 	$db->exec($chng_grade_reset);
			// 	for($i=0;$i<count($value);$i++){
			// 		$chng_grade_in_course = 'UPDATE `courses` set `' . $value[$i] . '`=1 where `c_id`=' . $c_id;
			// 		$db->exec($chng_grade_in_course);
			// 	}
			// }
			if ($db->errorCode() != '00000'){
				$error = $db->errorInfo();
				echo '错误: [',$error['1'],'] ',$error['2'];
				die();
			}
		}
		header("location:managetch.php");
	}
}
?>