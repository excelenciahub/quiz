<?php
	require_once('include/config.php');

    if(!isset($_SESSION['admin_id'])&&FILE_NAME!='login.php'){
        header("location:".SITE_URL."login.php");exit;
    }
    else if(isset($_SESSION['admin_id'])&&FILE_NAME=='login.php'){
        header("location:".SITE_URL_ADMIN);exit;
    }
?>