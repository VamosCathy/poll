<?php
session_start();
if(!isset($_SESSION['uid'])){
	header("location:index.php");
	exit;
}
else{
	session_destroy();
	header("location:index.php");
}

?>