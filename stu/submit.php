<?php
session_start();
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
if (!isset($_SESSION['uid'])) {
	header("location:../index.php");
	exit;
}
elseif ($_SESSION['username'] == $conf['manageid']) {
	header("location:../manage/manage.php");
	exit;
}
else{
	$sumflower = 0;//学生个人本次投出的鲜花总数
	$sumegg = 0;//学生个人本次投出的鸡蛋总数

	$temp=array('1','2','3','4','5','6','7','8','9','0');

	//判断送出鲜花和鸡蛋的总数是否超过数量
	foreach ($_POST as $key => $value) {
		if(strpos($key, "flw")){
			$sumflower += $value;
		}
		else if(strpos($key, "egg")){
			$sumegg += $value;
		}
	}
	if($sumflower > $_SESSION['flowernum'] && $sumegg > $_SESSION['eggnum']){
		$_SESSION['submitErr'] = "你的鲜花和鸡蛋都不够了";
		header("Location:./home.php");
		exit;
	}
	else if($sumflower > $_SESSION['flowernum'] && $sumegg <= $_SESSION['eggnum']){
		$_SESSION['submitErr'] = "你的鲜花不够了";
		header("Location:./home.php");
		exit;
	}
	else if($sumflower <= $_SESSION['flowernum'] && $sumegg > $_SESSION['eggnum']){
		$_SESSION['submitErr'] = "你的鸡蛋不够了";
		header("Location:./home.php");
		exit;
	}
	else{
		$_SESSION['flowernum'] -= $sumflower;
		$_SESSION['eggnum'] -= $sumegg;
		$_SESSION['voted'] = 1;

		$dsn = 'mysql:host=' . $conf['host'] . ';port=' . $conf['port'] . ';dbname=' . $conf['dbname'] . ';charset=' . $conf['charset'];
		$db = new PDO($dsn,$conf['username'],$conf['password']);
	//更新学生表中的鲜花鸡蛋数量
		$update_pollers_sql = 'UPDATE `pollers` set `flowernum`=' . $_SESSION['flowernum'] . ',`eggnum`=' . $_SESSION['eggnum'] . ',`voted`=1 WHERE `u_id`=' . $_SESSION['uid'];
		$db->exec($update_pollers_sql);

		

	//取出每个老师上的不同课程的鲜花和鸡蛋
		foreach ($_POST as $key => $value) {
			$c_id_str = '';
			$category = '';
			$c_id = 0;

		//当前提交数据的课程id
			for($i=0;$i<strlen($key);$i++){
				if(in_array($key[$i],$temp)){
					$c_id_str.=$key[$i];
				}
			}
			$c_id = intval($c_id_str);

		//当前提交数据的种类（鲜花还是鸡蛋）
			if(strpos($key, "flw")){
			//更新课程表中的鲜花数量
				$update_courses_sql = 'UPDATE `courses` set `getflowers`=`getflowers`+' . $value . ' WHERE `c_id`=' . $c_id;
				$update_teachers_sql = 'UPDATE `teachers` set `getflowers`=`getflowers`+' . $value . ' WHERE `t_id` IN (SELECT `t_id` from `courses` where `c_id`=' . $c_id . ')';
			}
			else if(strpos($key, "egg")){
			//更新课程表中的鸡蛋数量
				$update_courses_sql = 'UPDATE `courses` set `geteggs`=`geteggs`+' . $value . ' WHERE `c_id`=' . $c_id;
				$update_teachers_sql = 'UPDATE `teachers` set `geteggs`=`geteggs`+' . $value . ' WHERE `t_id` IN (SELECT `t_id` from `courses` where `c_id`=' . $c_id . ')';
			}
			$db->exec($update_courses_sql);
			$db->exec($update_teachers_sql);
		}
		header("Location:home.php");
	}
}
?>