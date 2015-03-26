<?php
session_start();
$input = $_POST;

require_once 'excel_reader2.php';

$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';

foreach ($input as $key => $value) {
	print_r($key);
	echo "&nbsp;&nbsp;&nbsp;";
	var_dump($value);
	echo "<br />";
}

$xlspath = $_SESSION['xlspath'];//上传的xls文件

if (empty($input['editcourse'])) {//若没有改动课程名称
	$coursename = $input['xlscourse'];
}
else{
	$coursename = $input['editcourse'];
}

if (empty($input['editteachers'])) {//若没有改动任课教师
	$teachers = $input['xlsteachers'];
}
else{
	$teachers = $input['editteachers'];
}

//打开xls文件
$data = new Spreadsheet_Excel_Reader($xlspath);

//获得课程号
$tmp_c_code = $data->val(3,'A');
$c_code = substr($tmp_c_code,9);

//查找数据库中是否存在该课程
$csname_sql = 'SELECT count(*) from courses where coursename=\'' . $coursename . '\'';
if ($res = $db->query($csname_sql)) {
	if ($res->fetchColumn() > 0) {//若存在当前课程
		//记录课号
		$ud_c_code_sql = 'UPDATE courses set c_code=\'' . $c_code . '\' where coursename=\'' . $coursename . '\'';
		$db->exec($ud_c_code_sql);

		//获取数据库中该课程的c_id
		$get_c_id_sql = 'SELECT c_id from courses where coursename=\'' . $coursename . '\'';
		$c_id_tmp = $db->query($get_c_id_sql);
		$c_idFromDb = $c_id_tmp->fetchAll();
		$c_id = $c_idFromDb[0]['c_id'];
	}
	else{//若不存在当前课程
		$insert_cs_sql = 'INSERT into courses (coursename,c_code) values (' . $coursename . ',' . $c_code . ')';
		$db->exec($insert_cs_sql);
		$c_id = $db->lastInsertId();
	}
}

//-------------添加名单中的上课学生-------------------
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
//-------------添加名单中的上课学生-------------------



//------------添加任课教师信息----------------
foreach ($teachers as $key => $value) {
	//查找教师姓名对应的t_id
	$t_id_sql = 'SELECT t_id from teachers where teachername=\'' . $value . '\'';
	$t_id_tmp = $db->query($t_id_sql);
	$t_idFromDb = $t_id_tmp->fetchAll();
	$t_id = $t_idFromDb[0]['t_id'];

	//查找数据表中是否有该老师执教该课程信息
	$tc_exist_sql = 'SELECT count(*) from tchcourses where t_id=' . $t_id . ' and c_id=' . $c_id;
	if ($res = $db->query($tc_exist_sql)) {
		if ($res->fetchColumn() > 0) {

		}
		else{
			$tc_insert_sql = 'INSERT into tchcourses (c_id,t_id) values (' . $c_id . ',' . $t_id . ')';
			$db->exec($tc_insert_sql);
		}
	}
}
//------------添加任课教师信息----------------
?>