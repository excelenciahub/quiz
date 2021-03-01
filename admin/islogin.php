<?php
	require_once('../include/config.php');

    if(!isset($_SESSION['admin_id'])&&FILE_NAME!='login.php'){
        header("location:".SITE_URL);exit;
    }
    else if(isset($_SESSION['admin_id'])&&FILE_NAME=='login.php'){
        header("location:".SITE_URL_ADMIN."index.php");exit;
    }
?>