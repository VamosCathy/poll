<?php
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';

//输入合法性检验，不允许删除当前学期课程
$selectcourse_sql = 'SELECT * from courses where c_id=' . $_POST['cid'];
$selectcourse_tmp = $db->query($selectcourse_sql);
if ($db->errorCode() != '00000'){//检查sql语句错误
	die("Invalid input.");
}

$selectcourseFromDb = $selectcourse_tmp->fetchAll();

if (empty($selectcourseFromDb)) {//输入的课程不存在
	die("Invalid input.");
}
else{//课程存在，查看课程号
	$c_code = $selectcourseFromDb[0]['c_code'];
	if ($c_code != NULL) {//课程号非空，查看是否为本学期课程
		$current_semester = intval(date("Ym"));
		$course_semester = substr($c_code,1,11);
		if (substr($course_semester,-1) === '2') {//下学期课程
			$second_year = substr($course_semester,5,4);
			$month_tmp = intval($second_year) * 100;
			if ($current_semester > ($month_tmp + 8) || $current_semester < ($month_tmp + 3)) {
				die("Invalid input.");
			}
		}
		elseif (substr($course_semester,-1) === '1') {//上学期课程
			$first_year = substr($course_semester,0,4);
			$second_year = substr($course_semester,5,4);
			$month_tmp1 = intval($first_year) * 100;
			$month_tmp2 = intval($second_year) * 100;
			if ($current_semester < ($month_tmp1 + 9) || $current_semester > ($month_tmp2 + 2)) {
				die("Invalid input.");
			}
		}
	}

}

//先删除学生的选课信息
$deletesc_sql = 'DELETE from stucourses where c_id=' . $_POST['cid'];
$db->exec($deletesc_sql);
if ($db->errorCode() != '00000'){//检查sql语句错误
	echo "内部出错，请再试一次。";
}
else{
	//删除课程信息
	$deletecourse_sql = 'DELETE from courses where c_id=' . $_POST['cid'];
	$db->exec($deletecourse_sql);
	if ($db->errorCode() != '00000'){//检查sql语句错误
		echo "内部出错，请再试一次。";
	}
	else{
		echo "删除成功";
	}

}
?>