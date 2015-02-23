<?php
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';
$deletetch_sql = 'SELECT `t_id`,`teachername` from `teachers`';
$deletetchTmp = $db->query($deletetch_sql);
$deletetchFromDb = $deletetchTmp->fetchAll();

require_once __DIR__ . '/../resource/deletetch.html';
?>