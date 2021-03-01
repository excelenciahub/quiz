<?php
    require_once('../include/config.php');
    require_once('islogin.php');
    
    $instance = new admin_master();
    
    $error = '';
    $warning = '';
    $success = '';
    
    if(isset($_GET['msg'])){
        $msg = trim($instance->re_db_input($_GET['msg']));
        if($msg=='I'){
            $success = INSERT_MESSAGE;
        }
        else if($msg=='U'){
            $success = UPDATE_MESSAGE;
        }
        else if($msg=='S'){
            $success = STATUS_MESSAGE;
        }
        else if($msg=='D'){
            $success = DELETE_MESSAGE;
        }
        else if($msg=='W'){
            $warning = UNKWON_ERROR;
        }
        else{
            
        }
    }
    
    if(isset($_POST['submit'])&&$_POST['submit']=='submit'){
        
        $return = $instance->change_password($_POST);
        
        if($return===true){
            header('location:'.CURRENT_PAGE_ADMIN.'?msg=U');exit;
        }
        else if($return===false){
            header('location:'.CURRENT_PAGE_ADMIN.'?msg=W');exit;
        }
        else{
            $error = $return;
        }
        
    }
	
    $content="change-password";
    require_once(DIR_WS_TEMPLATES_ADMIN."main_page.tpl.php");
?>