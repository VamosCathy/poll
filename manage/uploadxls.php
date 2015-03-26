<?php
session_start();
$input = $_POST;
$state = 0;
$msg = '0';
$title = '0';

function checkStr($str,$target)
{
	$tmpArr = explode($str,$target);
	//print_r($tmpArr);
	if(count($tmpArr)>1)return true;
	else return false;
}

require_once 'excel_reader2.php';

$coursefilepath = dirname(dirname(__FILE__)) . "/coursefile/";

$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';

if (($_FILES["coursexls"]["type"] == "application/vnd.ms-excel") && ($_FILES["coursexls"]["size"] < 2048000)){//上传正确格式
	$_FILES["coursexls"]["name"] = strtotime("now");
	$rst = move_uploaded_file($_FILES["coursexls"]["tmp_name"],$coursefilepath . $_FILES["coursexls"]["name"] . ".xls");
	if($rst != true){//内部错误
		$title = 'Oops，出错啦！';
		$msg = '发生了一些小错误，请重新上传。';
		$state = 0;
	}

	//打开上传的文件
	$data = new Spreadsheet_Excel_Reader($coursefilepath . $_FILES["coursexls"]["name"] . ".xls");
	$_SESSION['xlspath'] = $coursefilepath . $_FILES["coursexls"]["name"] . ".xls";
	
	//------获得课程名------
	$tmp_csname = $data->val(3,'E');
	//检查该单元格内容是否表示课程名称
	$result = checkStr("课程名称：",$tmp_csname);
	//var_dump($result);
	if ($result == true) {
		$upl_csname = substr($tmp_csname,15);
	}
	//------获得课程名------


	//-------获得任课老师-------
	$tmp_tchname = $data->val(4,'D');
	//检查该单元格内容是否表示任课老师
	$result_tch = checkStr("任课教师：",$tmp_tchname);
	if ($result_tch == true) {
		$tchGroup = substr($tmp_tchname,15);
		$tchArr = explode("/",$tchGroup);
	}
	//-------获得任课老师-------

	$title = '课程信息确认';
	$state = 1;
	$msg = '已上传';

	$edittch_sql = 'SELECT * from teachers';
	$edittch_tmp = $db->query($edittch_sql);
	$edittchFromDb = $edittch_tmp->fetchAll();
}
else{//上传格式错误
	$msg = "上传文件格式错误，请重新上传。";
	$title = 'Oops，出错啦！';
	$state = 0;
}
require_once __DIR__ . '/../resource/uploadxls.html';
?>