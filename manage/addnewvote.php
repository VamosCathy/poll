<?php
$input = $_POST;
$state = 0;
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';

if (strtotime($input['newstarttime']) >= strtotime($input['newdltime'])) {//结束时间早于开始时间，报错
	$state = 2;
}
elseif (strtotime("now") > strtotime($input['newstarttime'])) {//设定的开始时间早于当前
	//如果当前投票期还在进行中，返回错误
	if (strtotime($dltimeFromDb[0]['vote_dl']) > strtotime("now")) {
		$state = 3;
	}
	else{//若当前投票期已经结束，则设定新的一期开始时间为现在
		$input['newstarttime'] = date("Y-m-d H:i:s");
		$state = 1;
	}
}
else{//开始时间晚于当前时间
	$chooseall_sql = 'SELECT starttime,vote_dl from deadline order by dl_id desc';
	$chooseal_tmp = $db->query($chooseall_sql);
	$chooseallFromDb = $chooseal_tmp->fetchAll();

	foreach ($chooseallFromDb as $key => $value) {
		if (strtotime($input['newstarttime']) >= strtotime($value['starttime']) && strtotime($input['newstarttime']) < strtotime($value['vote_dl'])) {
			$state = 4;
			break;
		}
	}
	if ($state != 4) {
		$state = 1;
	}
	
}
if ($state == 1) {
	$addnewvote_sql = 'INSERT into deadline (starttime,vote_dl) values (\'' . $input['newstarttime'] . '\',\'' . $input['newdltime'] . '\')';
	$db->exec($addnewvote_sql);
}
echo $state;
?>