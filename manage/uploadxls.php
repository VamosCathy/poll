<?php
session_start();
$input = $_POST;
$state = 0;
$msg = '0';
$title = '0';
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
	//获得课程名
	$tmp_csname = $data->val(3,'E');
	$upl_csname = substr($tmp_csname,15);
	//查找数据库中是否存在该课程
	$csname_sql = 'SELECT count(*) from courses where coursename=\'' . $upl_csname . '\'';
	if ($res = $db->query($csname_sql)) {
		if ($res->fetchColumn() > 0) {//若存在当前课程
			//记录课号
			$tmp_c_code = $data->val(3,'A');
			$c_code = substr($tmp_c_code,9);
			$ud_c_code_sql = 'UPDATE courses set c_code=\'' . $c_code . '\' where coursename=\'' . $upl_csname . '\'';
			$db->exec($ud_c_code_sql);

			//获取数据库中该课程的c_id
			$get_c_id_sql = 'SELECT c_id from courses where coursename=\'' . $upl_csname . '\'';
			$c_id_tmp = $db->query($get_c_id_sql);
			$c_idFromDb = $c_id_tmp->fetchAll();
			$c_id = $c_idFromDb[0]['c_id'];

			//添加名单中的上课学生
			$num = 6;
			while ($data->val($num,'B') != NULL) {
				$u_id = $data->val($num,'B');
				//检查数据库中是否存在该学生
				$u_id_srch_sql = 'SELECT count(*) from pollers where username=\'' . $u_id . '\'';
				if($res = $db->query($u_id_srch_sql)){
					if($res->fetchColumn() > 0){//若存在该学生
						//查找u_id
						$srch_u_id_sql = 'SELECT u_id from pollers where username=\'' . $u_id . '\'';
						$u_id_tmp = $db->query($srch_u_id_sql);
						$u_idFromDb = $u_id_tmp->fetchAll();

						//查找数据表中是否有该学生选择了该门课的信息
						$sc_exist_sql = 'SELECT count(*) from stucourses where u_id=' . $u_idFromDb[0]['u_id'] . ' and c_id=' . $c_id;
						if ($res = $db->query($sc_exist_sql)) {
							if ($res->fetchColumn() > 0) {
								
							}
							else{
								$sc_insert_sql = 'INSERT into stucourses (u_id,c_id) values (' . $u_idFromDb[0]['u_id'] . ',' . $c_id . ')';
								$db->exec($sc_insert_sql);
							}
						}
					}
					else{//若不存在该学生
						//在学生表中添加该学生
						$insert_stu_sql = 'INSERT into pollers (username,pwd) values (\'' . $u_id . '\',\'' . md5($u_id) . '\')';
						$db->exec($insert_stu_sql);
						//添加选课信息
						$insert_scinfo_sql = 'INSERT into stucourses (u_id,c_id) values (' . $db->lastInsertId() . ',' . $c_id . ')';
						$db->exec($insert_scinfo_sql);
					}
				}
				$num += 1;
			}
			$msg = '上传成功！已更新学生选课信息。';
			$title = '上传成功';
			$state = 1;
		}
		else{//若不存在当前课程
			$msg = "不存在该课程，请先添加该课程。";
			$title = 'Oops，出错啦！';
			$state = 2;
		}
	}
}
else{//上传格式错误
	$msg = "上传文件格式错误，请重新上传。";
	$title = 'Oops，出错啦！';
	$state = 0;
}
require_once __DIR__ . '/../resource/uploadxls.html';
?>