<?php
require_once __DIR__ . '/../conf/conn.php';

//判断是否有重复


$addtch_sql = 'INSERT into `teachers` (teachername,aboutVoter) values (' . $_POST['teachername'] . ',' . $_POST['aboutVoter'] . ')';
$db->exec($addtch_sql);
header("location:addtch.php");
?>