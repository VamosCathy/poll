<?php
session_start();
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';

$dl_sql = 'SELECT * from deadline where istohistory=1';
$dlTmp = $db->query($dl_sql);
$dlFromDb = $dlTmp->fetchAll();

require_once __DIR__ . '/../resource/historycomment.html';
?>