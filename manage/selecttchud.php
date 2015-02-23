<?php
$input = $_POST;
$imagefilepath = dirname(dirname(__FILE__)) . "/images/";

$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';
$udtchinfo_sql = 'UPDATE teachers set aboutVoter=\'' . $input['abouttch'] . '\'';

if ((($_FILES["tchimg"]["type"] == "image/gif") || ($_FILES["tchimg"]["type"] == "image/jpeg")|| ($_FILES["tchimg"]["type"] == "image/pjpeg")) && ($_FILES["tchimg"]["size"] < 2048000))//有图片上传
{
	$_FILES["tchimg"]["name"] = strtotime("now");
	move_uploaded_file($_FILES["tchimg"]["tmp_name"],$imagefilepath . $_FILES["tchimg"]["name"] . ".jpg");
	$udtchinfo_sql .= ',imgurl=\'./images/' . $_FILES["tchimg"]["name"] . '.jpg\'';
	//删除文件夹中教师的旧图片
	$deleteoldimg_sql = 'SELECT imgurl from teachers where t_id=' . $input['tid'];
	$deleteoldimg_tmp = $db->query($deleteoldimg_sql);
	$oldimgFromDb = $deleteoldimg_tmp->fetchAll();
	unlink("." . $oldimgFromDb[0]['imgurl']);
}
$udtchinfo_sql .= ' where t_id=' . $input['tid'];
$db->exec($udtchinfo_sql);
if ($db->errorCode() != '00000'){
	$error = $db->errorInfo();
	echo '错误: [',$error['1'],'] ',$error['2'];
	die();
}
header("location:updatetchinfo.php");

?>