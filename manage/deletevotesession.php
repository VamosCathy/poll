<?php
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';

$deletevote_sql = 'DELETE from deadline where dl_id=' . $_POST['dlid'];
$db->exec($deletevote_sql);
echo "删除成功";
?>