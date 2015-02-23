<?php
session_start();
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';

$selecttch_sql = 'SELECT * from teachers where t_id=' . $_GET['id'];
$selecttch_tmp = $db->query($selecttch_sql);
$selecttchFromDb = $selecttch_tmp->fetchAll();

require_once __DIR__ . '/../resource/updatetchinfosub.html';
?>