<?php
	require_once('include/config.php');
	$act = isset($_GET['act'])&&$_GET['act']!=''?$dbins->re_db_input($_GET['act']):'';
	$tid = isset($_GET['t'])&&$_GET['t']!=''?$dbins->re_db_input($_GET['t']):'0';
	if($act=='retake'){
		session_destroy();
	}
	header("location:".SITE_URL."quiz.php?t=".$tid);exit;
?>