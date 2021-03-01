<?php
    require_once('../include/config.php');
    require_once('islogin.php');
    
    if($admin['type']==2){
        header('location:'.SITE_URL_ADMIN);exit;
    }
    
    $instance = new admin_master();
    $form_add = '';
	
    $action = isset($_GET['action'])?$instance->re_db_input($_GET['action']):'';
    $id = isset($_GET['id'])?$instance->re_db_input($_GET['id']):0;
    
    $error = '';
    $warning = '';
    $success = '';
    
    $return = array();
    
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
        
        $id = isset($_POST['id'])?trim($instance->re_db_input($_POST['id'])):0;
        $name = isset($_POST['name'])?trim($instance->re_db_input($_POST['name'])):'';
        $email = isset($_POST['email'])?trim($instance->re_db_input($_POST['email'])):'';
        $mobile = isset($_POST['mobile'])?trim($instance->re_db_input($_POST['mobile'])):'';
        $_POST['type'] = 2;
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
    else if(isset($_GET['action'])&&$_GET['action']=='status'&&isset($_GET['id'])&&$_GET['id']>0&&isset($_GET['status'])&&($_GET['status']==0 || $_GET['status']==1))
    {
        $id = $instance->re_db_input($_GET['id']);
        $status = $instance->re_db_input($_GET['status']);
        $return = $instance->status($id,$status);
        if($return==true){
            header('location:'.CURRENT_PAGE_ADMIN.'?msg=S');exit;
        }
        else{
            header('location:'.CURRENT_PAGE_ADMIN.'?msg=W');exit;
        }
    }  
    else if(isset($_GET['action'])&&$_GET['action']=='delete'&&isset($_GET['id'])&&$_GET['id']>0)
    {
        $id = $instance->re_db_input($_GET['id']);
        $return = $instance->delete($id);
        if($return==true){
            header('location:'.CURRENT_PAGE_ADMIN.'?msg=D');exit;
        }
        else{
            header('location:'.CURRENT_PAGE_ADMIN.'?msg=W');exit;
        }
    }
     
    if($action=='add_new' || $action=='edit'){
        if($id==0){
			$form_add = '?action=add_new';
        }
        else{
			$form_add = '?action=edit&id='.$id;
            $return = $instance->edit($id);
            if($return==false){
                $warning = UNKWON_ERROR;
            }
            else{
                $id = $instance->re_db_output($return['admin_id']);
                $name = $instance->re_db_output($return['name']);
                $email = $instance->re_db_output($return['email']);
                $mobile = $instance->re_db_output($return['mobile']);
                
            }
        }
    }
    else{
        $return = $instance->select(2);
    }
	
    $content="teachers";
    require_once(DIR_WS_TEMPLATES_ADMIN."main_page.tpl.php");
?>