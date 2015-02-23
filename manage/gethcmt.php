<?php
$input = $_GET['dlchoice'];//获得dl的id

$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';

$hcmt_sql = 'SELECT teachername,imgurl,comment from (SELECT t_id,teachername,imgurl from teachers)p,(SELECT t_id,comment from historyComments where vote_dl in (SELECT vote_dl from deadline where dl_id=' . $input . '))q where p.t_id=q.t_id order by p.t_id';
$hcmtTmp = $db->query($hcmt_sql);
$hcmtFromDb = $hcmtTmp->fetchAll();

echo json_encode($hcmtFromDb);
?>