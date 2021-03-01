<?php
	require_once('include/config.php');
	$act = isset($_GET['act'])&&$_GET['act']!=''?$dbins->re_db_input($_GET['act']):'';
	$tid = isset($_GET['t'])&&$_GET['t']!=''?$dbins->re_db_input($_GET['t']):'0';	$opt = isset($_GET['opt'])&&$_GET['opt']!=''?$dbins->re_db_input($_GET['opt']):'0';
	if($act=='retake' && $opt=='1'){		foreach($_SESSION as $key => $val){			if ($key == 'answered' || $key == 'questions' || $key == 'answers'){			}			else{				unset($_SESSION[$key]);			}		}
	}	else{		session_destroy();	}	
	header("location:".SITE_URL."quiz.php?t=".$tid);exit;
?>