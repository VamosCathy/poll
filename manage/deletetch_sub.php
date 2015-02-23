<?php
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';

$deletetchsub_sql = 'DELETE from `teachers` where `t_id`=' . $_POST['tchid'];
$db->exec($deletetchsub_sql);
echo "ok";
?>