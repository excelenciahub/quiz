<?php

    include('include/config.php');

    $has_prev = 0;

	$has_next = '';

	

	$query_string = CURRENT_PAGE.'?'.$_SERVER['QUERY_STRING'];

	$returnid = '';

	

    $return = array();

    $tid = isset($_GET['t'])?intval(trim($dbins->re_db_input($_GET['t']))):0;

    if($tid==0){

        header("location:".SITE_URL);exit;

    }

    else{

        $instance = new questions_master();

        $qid = isset($_GET['q'])?intval(trim($instance->re_db_input($_GET['q']))):0;

        $action = isset($_GET['action'])?intval(trim($instance->re_db_input($_GET['action']))):0;

		$answered = '';

		if(isset($_SESSION['answered'])&&count($_SESSION['answered'])>0){

			$answered = implode(',',$_SESSION['answered']);

		}

        $return = $instance->get_test_que($tid,$qid,$action,$answered,'order by rand()');

        if($return===false){

            header("location:".SITE_URL);exit;

        }

		if(isset($return['id'])){

			

			$returnid = $return['id'];

			$answered = '';

			if(isset($_SESSION['answered'])&&count($_SESSION['answered'])>0){

				$answered = implode(',',$_SESSION['answered']);

			}

			//$has_prev = $instance->has_prev($return['id'],$tid);

			$has_next = $instance->has_next($answered,$tid);

			if($has_next==1){

				$has_next = 0;

			}

		}

    }
    $metatitle = isset($return['test_name'])?$dbins->re_db_output($return['test_name']):'';
    $question = isset($_SESSION['questions'])?$_SESSION['questions']:array();



    $content="quiz";

    require_once(DIR_WS_TEMPLATES."main_page.tpl.php");	

?>