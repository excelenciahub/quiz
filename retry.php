<?php require_once('include/config.php');

	$qid = isset($_GET['id'])&&$_GET['id']!=''?$dbins->re_db_input($_GET['id']):0;
	$ref = isset($_GET['ref'])&&$_GET['ref']!=''?$dbins->re_db_input(base64_decode($_GET['ref'])):SITE_URL;
	
	if($qid>0){
		unset($_SESSION['answered'][$qid]);
		unset($_SESSION['answers'][$qid]);
		unset($_SESSION['questions'][$qid]);
		unset($_SESSION['question'][$qid]['start']);
		unset($_SESSION['question'][$qid]['time']);
		unset($_SESSION['question'][$qid]['correct_answer']);
	}
	header("location:".$ref);exit;
?>