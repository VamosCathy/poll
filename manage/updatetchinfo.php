<?php
session_start();
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';

$tchinfo_sql = 'SELECT t_id,teachername from teachers';
$tchinfo_tmp = $db->query($tchinfo_sql);
$tchinfoFromDb = $tchinfo_tmp->fetchAll();

require_once __DIR__ . '/../resource/updatetchinfo.html';
?>