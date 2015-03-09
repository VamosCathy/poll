<?php
session_start();
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';

if(strtotime("now") > strtotime($dltimeFromDb[0]['vote_dl'])){
	$msg = '已截止';
}
else{
	$msg = '进行中';
}

$existvote_sql = 'SELECT * from deadline';
$existvote_tmp = $db->query($existvote_sql);
$existvoteFromDb = $existvote_tmp->fetchAll();
require_once __DIR__ . '/../resource/importstulist.html';
?>