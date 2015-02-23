<?php
$input = $_GET['dlchoice'];//获得dl的id

$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';

$history_sql = 'SELECT teachername,imgurl,tch_flower,tch_egg,coursename,cs_flower,cs_egg from (SELECT m.t_id,teachername,imgurl,tch_flower,tch_egg,c_id,cs_flower,cs_egg from teachers m,(SELECT m.t_id,tch_flower,tch_egg,c_id,cs_flower,cs_egg from (SELECT * from `historyTch` where `vote_dl` in (SELECT `vote_dl` from `deadline` where `dl_id`=' . $input . '))m,(SELECT * from `historyCourse` where `vote_dl` in (SELECT `vote_dl` from `deadline` where `dl_id`=' . $input . '))n where m.t_id=n.t_id order by m.t_id)n where m.t_id=n.t_id)p,courses q where p.c_id=q.c_id order by p.t_id';

$history_tmp = $db->query($history_sql);
$historyFromDb = $history_tmp->fetchAll();

echo json_encode($historyFromDb);
?>