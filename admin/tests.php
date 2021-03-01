<?php
    require_once('../include/config.php');
	
    require_once('islogin.php');
    
    $instance = new tests_master();
    $form_add = '';
	
    $action = isset($_GET['action'])?$instance->re_db_input($_GET['action']):'';
    $id = isset($_GET['id'])?$instance->re_db_input($_GET['id']):0;
    $test_id = $id;
	$q_id = isset($_GET['q_id'])?$instance->re_db_input($_GET['q_id']):0;
	
    $error = '';
    $warning = '';
    $success = '';
    
    $return = array();
    
    $name = '';
    $email = '';
    $mobile = '';
	
	$question = '';
    $options = array('','');
    $is_correct = array();
    $time = '';
    $test = '';
	$q_action = isset($_GET['q_action'])?$instance->re_db_input($_GET['q_action']):'add_new';
    $questions_list = array();
	
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
        $return = $instance->insert_update($_POST);
        if($return===true){
            if($id==0){
                header('location:'.CURRENT_PAGE_ADMIN.'?msg=I');exit;
            }
            else{
                header('location:'.CURRENT_PAGE_ADMIN.'?action=edit&id='.$id.'&msg=U');exit;
            }
        }
        else{
            $error = $return;
        }
    }
	else if(isset($_POST['submit'])&&$_POST['submit']=='submit_question'){
        
        $q_id = isset($_POST['id'])?trim($instance->re_db_input($_POST['id'])):0;
        $question = isset($_POST['question'])?trim($instance->re_db_input($_POST['question'])):'';
        $options = isset($_POST['options'])?$_POST['options']:array('','');
        $is_correct = isset($_POST['is_correct'])?$_POST['is_correct']:array();
        $time = isset($_POST['time'])?trim($instance->re_db_input($_POST['time'])):'';
        $test = isset($_POST['test'])?trim($instance->re_db_input($_POST['test'])):'';
        $ref = isset($_POST['ref'])?trim($instance->re_db_input($_POST['ref'])):CURRENT_PAGE_ADMIN;
		
		$instance_question = new questions_master();
		
        $return = $instance_question->insert_update($_POST);
        if($return===true){
            if($id==0){
                header('location:'.$ref.'&msg=I');exit;
            }
            else{
                header('location:'.$ref.'&msg=U');exit;
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
		$tid = isset($_GET['tid'])?$instance->re_db_input($_GET['tid']):'';
		$con = $admin['type']==1&&$tid!=''?'&tid='.$tid:'';
        if($return==true){
            header('location:'.CURRENT_PAGE_ADMIN.'?msg=S'.$con);exit;
        }
        else{
            header('location:'.CURRENT_PAGE_ADMIN.'?msg=W'.$con);exit;
        }
    }  
    else if(isset($_GET['action'])&&$_GET['action']=='delete'&&isset($_GET['id'])&&$_GET['id']>0)
    {
        $id = $instance->re_db_input($_GET['id']);
		$tid = isset($_GET['tid'])?$instance->re_db_input($_GET['tid']):'';
		$con = $admin['type']==1&&$tid!=''?'&tid='.$tid:'';
        $return = $instance->delete($id);
        if($return==true){
            header('location:'.CURRENT_PAGE_ADMIN.'?msg=D'.$con);exit;
        }
        else{
            header('location:'.CURRENT_PAGE_ADMIN.'?msg=W'.$con);exit;
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
                $id = $instance->re_db_output($return['id']);
                $name = $instance->re_db_output($return['test_name']);
            }
        }
    }
    else{
        if($admin['type']==2){
			$return = $instance->select($_SESSION['admin_id']);
		}
		else if($admin['type']==1){
			$tid = isset($_GET['tid'])&&$_GET['tid']!=''?intval($dbins->re_db_input($_GET['tid'])):'';
			
			$return = $instance->select($tid);
		}
        $metatitle = isset($return[0]['admin_name'])?$return[0]['admin_name'].' - Kwizards':'Kwizards';
        $admin_id = isset($return[0]['admin_id'])?$return[0]['admin_id']:0;
    }
	
	if($q_action=='view' && $id>0){
		$instance_question = new questions_master();
		$questions_list = $instance_question->select($id);
	}
	else if(isset($_GET['q_action'])&&$_GET['q_action']=='status'&&isset($_GET['q_id'])&&$_GET['q_id']>0&&isset($_GET['q_status'])&&($_GET['q_status']==0 || $_GET['q_status']==1))
    {
		$instance_question = new questions_master();
        $q_id = $instance->re_db_input($_GET['q_id']);
        $q_status = $instance->re_db_input($_GET['q_status']);
		$return = $instance_question->status($q_id,$q_status);
        if($return==true){
            header('location:'.CURRENT_PAGE_ADMIN.'?action='.$action.'&id='.$id.'&q_action=view&msg=S');exit;
        }
        else{
            header('location:'.CURRENT_PAGE_ADMIN.'?msg=W');exit;
        }
    }  
    else if(isset($_GET['q_action'])&&$_GET['q_action']=='delete'&&isset($_GET['q_id'])&&$_GET['q_id']>0)
    {
		$instance_question = new questions_master();
        $q_id = $instance->re_db_input($_GET['q_id']);
        $return = $instance_question->delete($q_id);
        if($return==true){
			header('location:'.CURRENT_PAGE_ADMIN.'?action='.$action.'&id='.$id.'&q_action=view&msg=D');exit;
        }
        else{
            header('location:'.CURRENT_PAGE_ADMIN.'?msg=W');exit;
        }
    }
	if($q_action=='edit'){
        
        if($q_id==0){
			
        }
        else if($q_id>0){
			$instance_question = new questions_master();
            $return = $instance_question->edit($q_id);
            if($return==false){
                $warning = UNKWON_ERROR;
            }
            else{
                $q_id = $instance->re_db_output($return['id']);
                $question = $return['question'];
                $options = $return['options'];
                $is_correct = $return['is_correct'];
                $time = $instance->re_db_output($return['time']);
                $test = $instance->re_db_input($return['test_id']);
            }
        }
    }
    $content="tests";
    require_once(DIR_WS_TEMPLATES_ADMIN."main_page.tpl.php");
?>