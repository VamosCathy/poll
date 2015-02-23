<?php
$input = $_POST;
$state = 1;
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';

$currentstarttime_sql = 'SELECT starttime from deadline where iscurrent=1';
$currentstarttime_tmp = $db->query($currentstarttime_sql);
$currentstarttimeFromDb = $currentstarttime_tmp->fetchAll();

$chooseall_sql = 'SELECT starttime from deadline order by dl_id desc';
$chooseal_tmp = $db->query($chooseall_sql);
$chooseallFromDb = $chooseal_tmp->fetchAll();

foreach ($chooseallFromDb as $key => $value) {
	if (strtotime($currentstarttimeFromDb[0]['starttime']) < strtotime($value['starttime']) && strtotime($_POST['prolongtime']) >= strtotime($value['starttime'])) {
		$state = 0;
		break;
	}
}
if ($state == 1) {
	$prolongtime_sql = 'UPDATE deadline set vote_dl=\'' . $input['prolongtime'] . '\' WHERE dl_id=' . $input['dlid'];
	$prolongtimeTmp = $db->exec($prolongtime_sql);
}
echo $state;
?>