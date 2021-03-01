<?php
	include("../include/config.php");
	include('islogin.php');
	
    $year = isset($_GET['year'])&&$_GET['year']!=''?$dbins->re_db_input($_GET['year']):date('Y');
    $m = isset($_GET['month'])&&$_GET['month']!=''?$dbins->re_db_input($_GET['month']):'';
    $mt = $m;
	$instance = new admin_master();
	$teachers = $instance->count_teachers();
	
	$tid = $admin['type']==2?$_SESSION['admin_id']:'';
	
	$instance = new questions_master();
	$questions = $instance->count_questions($tid);
	
	$instance = new tests_master();
	$tests = $instance->count_tests($tid);
	
    $tmc = '';
    $qmc = '';
	$con = $admin['type']==2?" and am.admin_id='".$_SESSION['admin_id']."' ":"";
    if($m!=''){
        if($m<10){
            $m = '0'.$m;
        }
        $tmc .= " AND DATE_FORMAT(tm.created_time,'%m')='".$m."' ";
        $qmc .= " AND DATE_FORMAT(qm.created_time,'%m')='".$m."' ";
    }
	$q = "SELECT am.name,(
			SELECT IFNULL(COUNT(*),0) AS total
			FROM tests_master AS tm
			WHERE tm.admin_id=am.admin_id AND tm.is_delete='0' AND DATE_FORMAT(tm.created_time,'%Y')='".$year."' ".$tmc." ) AS total_tests,
			(
			SELECT COUNT(*) AS t
			FROM questions_master AS qm
			WHERE qm.test_id IN (
			SELECT id
			FROM tests_master AS tm
			WHERE tm.admin_id=am.admin_id and tm.is_delete='0') AND DATE_FORMAT(qm.created_time,'%Y')='".$year."' and qm.is_delete='0' ".$qmc." ) as total_questions
			FROM admin_master AS am
			WHERE am.is_delete=0 AND am.type=2".$con;
       
	$res = $dbins->re_db_query($q);
	$return = array();
	$tcr = array();
	$tst = array();
	$qus = array();
	while($row = $dbins->re_db_fetch_array($res)){
		array_push($tcr,$row['name']);
		array_push($tst,intval($row['total_tests']));
		array_push($qus,intval($row['total_questions']));
	}
	$tname = json_encode($tcr);
	$tt = json_encode($tst);
	$tq = json_encode($qus);
	
    if($admin['type']==2){
        $array = array();
        
        $q = "SELECT IFNULL(COUNT(*),0) AS `tests`, DATE_FORMAT(tm.created_time,'%m') AS `month`,(
                SELECT IFNULL(COUNT(*),0)
                FROM questions_master AS qm
                WHERE qm.is_delete='0' AND qm.test_id=tm.id) AS questions
                FROM tests_master AS tm
                WHERE tm.is_delete='0' AND tm.admin_id='".$_SESSION['admin_id']."' AND DATE_FORMAT(tm.created_time,'%Y')='".$year."'
                GROUP BY DATE_FORMAT(tm.created_time,'%m')";
        $res = $dbins->re_db_query($q);
        while($row=$dbins->re_db_fetch_array($res)){
            $array['tests'][$row['month']] = intval($row['tests']);
            $array['questions'][$row['month']] = intval($row['questions']);
        }
        
        $months = array();
        
        for($i=1;$i<=12;$i++){
            $a = $i;
            if($i<10){
                $a = '0'.$i;
            }
            if(!isset($array['tests'][$a])){
                $array['tests'][$a] = 0;
                $array['questions'][$a] = 0;
            }
            $monthName = date('F', mktime(0, 0, 0, $i, 10));
            array_push($months,$monthName);
        }
        
        $month = json_encode($months);
        ksort($array['tests']);
        ksort($array['questions']);
        $tests_count = json_encode(array_values($array['tests']));
        $questions_count = json_encode(array_values($array['questions'])); 
        //echo '<pre>';print_r($array);exit;
    }
	
    //echo $questions_count;exit;
	$content="index";
    require_once(DIR_WS_TEMPLATES_ADMIN."main_page.tpl.php");
?>