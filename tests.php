<?php

    include('include/config.php');

	session_destroy();

   	$query_string = CURRENT_PAGE.'?'.$_SERVER['QUERY_STRING'];

	$returnid = '';

	

    $return = array();

    $tid = isset($_GET['t'])?intval(trim($dbins->re_db_input($_GET['t']))):0;

    if($tid==0){

        header("location:".SITE_URL);exit;

    }

    

    $instance = new tests_master();

    $return = $instance->select($tid);

    $metatitle = isset($return[0]['admin_name'])?$return[0]['admin_name'].' - Kwizards':'Kwizards';

    $content="tests";

    require_once(DIR_WS_TEMPLATES."main_page.tpl.php");

?>