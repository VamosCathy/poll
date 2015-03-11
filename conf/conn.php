<?php

$dsn = 'mysql:host=' . $conf['host'] . ';port=' . $conf['port'] . ';dbname=' . $conf['dbname'] . ';charset=' . $conf['charset'];
$db = new PDO($dsn,$conf['username'],$conf['password']);

//查询投票截止时间
$dltime_sql = 'SELECT * from `deadline` where `iscurrent`=1 limit 1';
$timeTmp = $db->query($dltime_sql);
$dltimeFromDb = $timeTmp->fetchAll();

//检测当期投票是否到期
date_default_timezone_set("Asia/Shanghai");

if(strtotime("now") > strtotime($dltimeFromDb[0]['vote_dl']) && $dltimeFromDb[0]['istohistory'] == 0){//如果当前时间超过规定的截止时间并且没有登记到历史数据表中
	//将本期的数据复制到历史期的数据表中

	//teachers表数据转移
	$nowtohistory_tch_sql = 'SELECT * from `teachers`';
	$nowtohistory_tch_tmp = $db->query($nowtohistory_tch_sql);
	$nowtohistory_tch_FromDb = $nowtohistory_tch_tmp->fetchAll();
	if(!empty($nowtohistory_tch_FromDb)){
		foreach ($nowtohistory_tch_FromDb as $key => $value) {
				//echo $value['t_id'];
			$nowtohistory_ud_htch_sql = 'INSERT into `historyTch` (t_id,tch_flower,tch_egg,vote_dl) values (' . $value['t_id'] . ',' . $value['getflowers'] . ',' . $value['geteggs'] . ',\'' . $dltimeFromDb[0]['vote_dl'] . '\')';
			$tmp2 = $db->exec($nowtohistory_ud_htch_sql);
			if ($db->errorCode() != '00000'){
				$error = $db->errorInfo();
				echo '错误: [',$error['1'],'] ',$error['2'];
				die();
			}
		}
	}
	$nowtohistory_reset_tch_sql = 'UPDATE `teachers` set `getflowers`=0,`geteggs`=0';
	$db->exec($nowtohistory_reset_tch_sql);
	if ($db->errorCode() != '00000'){
		$error = $db->errorInfo();
		echo '错误: [',$error['1'],'] ',$error['2'];
		die();
	}


		//courses表数据转移
	$nowtohistory_course_sql = 'SELECT * from `courses`';
	$nowtohistory_course_tmp = $db->query($nowtohistory_course_sql);
	$nowtohistory_course_FromDb = $nowtohistory_course_tmp->fetchAll();
	if(!empty($nowtohistory_course_FromDb)){
		foreach ($nowtohistory_course_FromDb as $key => $value) {
			$nowtohistory_ud_hcs_sql = 'INSERT into `historyCourse` (c_id,t_id,cs_flower,cs_egg,vote_dl) values (' . $value['c_id'] . ',' . $value['t_id'] . ',' . $value['getflowers'] . ',' . $value['geteggs'] . ',\'' . $dltimeFromDb[0]['vote_dl'] . '\')';
			$db->exec($nowtohistory_ud_hcs_sql);
		}
		if ($db->errorCode() != '00000'){
			$error = $db->errorInfo();
			echo '错误: [',$error['1'],'] ',$error['2'];
			die();
		}
	}
	$nowtohistory_reset_cs_sql = 'UPDATE `courses` set `getflowers`=0,`geteggs`=0';
	$db->exec($nowtohistory_reset_cs_sql);
	if ($db->errorCode() != '00000'){
		$error = $db->errorInfo();
		echo '错误: [',$error['1'],'] ',$error['2'];
		die();
	}

		//comments表数据转移
	$nowtohistory_cmt_sql = 'SELECT * from `comments`';
	$nowtohistory_cmt_tmp = $db->query($nowtohistory_cmt_sql);
	$nowtohistory_cmt_FromDb = $nowtohistory_cmt_tmp->fetchAll();
	if(!empty($nowtohistory_cmt_FromDb)){
		foreach ($nowtohistory_cmt_FromDb as $key => $value) {
			$nowtohistory_ud_hcmt_sql = 'INSERT into `historyComments` (t_id,comment,vote_dl) values (' . $value['t_id'] . ',\'' . $value['comment'] . '\',\'' . $dltimeFromDb[0]['vote_dl'] . '\')';
			$db->exec($nowtohistory_ud_hcmt_sql);
		}
		if ($db->errorCode() != '00000'){
			$error = $db->errorInfo();
			echo '错误: [',$error['1'],'] ',$error['2'];
			die();
		}
	}
	$nowtohistory_reset_cmt_sql = 'TRUNCATE table `comments`';
	$db->exec($nowtohistory_reset_cmt_sql);
	if ($db->errorCode() != '00000'){
		$error = $db->errorInfo();
		echo '错误: [',$error['1'],'] ',$error['2'];
		die();
	}

	//本期数据转移到历史数据表中成功后确认
	$confirm_dl_sql = 'UPDATE `deadline` set `istohistory`=1 where `iscurrent`=1';
	$db->exec($confirm_dl_sql);

	//停止投票
	$stoppoll_sql = 'UPDATE pollers set voted=1';
	$db->exec($stoppoll_sql);
}
else{
	//检测是否有需要开始的投票期
	$setcurrent_sql = 'SELECT * from deadline where iscurrent=0 and istohistory=0';
	$setcurrent_tmp = $db->query($setcurrent_sql);
	$setcurrent_FromDb = $setcurrent_tmp->fetchAll();
	if (!empty($setcurrent_FromDb)) {
		foreach ($setcurrent_FromDb as $key => $value) {
			if (strtotime("now") > strtotime($value['starttime'])) {
				$udcurrent_sql = 'UPDATE deadline set iscurrent=1 where dl_id=' . $value['dl_id'];
				$db->exec($udcurrent_sql);
				$udlast_sql = 'UPDATE deadline set iscurrent=0 where iscurrent=1 and istohistory=1';
				$db->exec($udlast_sql);
				if ($db->errorCode() != '00000'){
					$error = $db->errorInfo();
					echo '错误: [',$error['1'],'] ',$error['2'];
					die();
				}
				$resetfenum_sql = 'UPDATE pollers set flowernum=10,eggnum=5,voted=0';
				$db->exec($resetfenum_sql);
				break;
			}
		}
	}
}



?>