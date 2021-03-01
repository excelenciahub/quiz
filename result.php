<?php
    include('include/config.php');
    $return = array();
    $answers = isset($_SESSION['answers'])?$_SESSION['answers']:array();
    $question = isset($_SESSION['questions'])?$_SESSION['questions']:array();
    $tid = isset($_GET['tid'])?$dbins->re_db_input($_GET['tid']):0;
    if(count($question)>0){
        $instance = new questions_master();
        $return = $instance->select_by_ids($question);
    }
    $content="result";
    require_once(DIR_WS_TEMPLATES."main_page.tpl.php");	
?>