<?php
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';

$deletecourse_sql = 'DELETE from courses where c_id=' . $_POST['cid'];
$db->exec($deletecourse_sql);
echo "删除成功";
?>