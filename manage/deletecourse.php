<?php
session_start();
$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
require_once __DIR__ . '/../conf/conn.php';

$allcourses_sql = 'SELECT c_id,coursename from courses';
$allcourses_tmp = $db->query($allcourses_sql);
$allcoursesFromDb = $allcourses_tmp->fetchAll();

require_once __DIR__ . '/../resource/deletecourse.html';
?>