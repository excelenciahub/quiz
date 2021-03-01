<?php
    require_once('../include/config.php');
    require_once('islogin.php');
    
    $instance = new admin_master();
    
    $id = $_SESSION['admin_id'];
    
    $error = '';
    $warning = '';
    $success = '';
    
    $name = '';
    $email = '';
    $mobile = '';
    
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
        
        $id = $_SESSION['admin_id'];
        $_POST['id'] = $id;
        $name = isset($_POST['name'])?trim($instance->re_db_input($_POST['name'])):'';
        $email = isset($_POST['email'])?trim($instance->re_db_input($_POST['email'])):'';
        $mobile = isset($_POST['mobile'])?trim($instance->re_db_input($_POST['mobile'])):'';
        
        $return = $instance->insert_update($_POST);
        if($return===true){
            if($id==0){
                header('location:'.CURRENT_PAGE_ADMIN.'?msg=I');exit;
            }
            else{
                header('location:'.CURRENT_PAGE_ADMIN.'?msg=U');exit;
            }
        }
        else{
            $error = $return;
        }
    }
    $return = $instance->edit($id);
    if($return==false){
        $warning = UNKWON_ERROR;
    }
    else{
        $name = $instance->re_db_output($return['name']);
        $email = $instance->re_db_output($return['email']);
        $mobile = $instance->re_db_output($return['mobile']);
        
    }
	
    $content="profile";
    require_once(DIR_WS_TEMPLATES_ADMIN."main_page.tpl.php");
?>