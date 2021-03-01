<?php
    include('include/config.php');
    $array = array();
    
    $answer = isset($_POST['answer'])?trim($dbins->re_db_input($_POST['answer'])):'';
    $question = isset($_POST['question'])?trim($dbins->re_db_input($_POST['question'])):'';
    $timeout = isset($_POST['timeout'])?trim($dbins->re_db_input($_POST['timeout'])):'';
    $start = $_SESSION['question'][$question]['start'];
    $time = $_SESSION['question'][$question]['time'];
    $correct_answer = $_SESSION['question'][$question]['correct_answer'];
    
	$array['correct'] = $correct_answer;
	
    if($timeout==1){
        $array['success'] = 0;
        $array['timeout'] = 1;
		$_SESSION['answered'][$question] = $question;
		$_SESSION['answers'][$question] = $answer;
		$_SESSION['questions'][$question] = $question;
        $array['msg'] = '<div class="alert alert-danger">Timeout for this question.</div>';
        $_SESSION['questions'][$question] = $question;
        $_SESSION['answers'][$question] = $answer;
    }
    if($question==''){
        $array['success'] = 0;
        $array['timeout'] = 0;
        $array['msg'] = '<div class="alert alert-danger">Something went wrong, Please try again.</div>';
    }
    else{
        if($answer=='' && time()>=($start+$time)){
            $array['success'] = 0;
            $array['timeout'] = 1;
			$_SESSION['answered'][$question] = $question;
			$_SESSION['answers'][$question] = $answer;
			$_SESSION['questions'][$question] = $question;
            $array['msg'] = '<div class="alert alert-danger">Timeout for this question.</div>';
        }
        else if(isset($_SESSION['answered']) && in_array($question,$_SESSION['answered'])){
            $array['success'] = 0;
            $array['timeout'] = 0;
            $array['msg'] = '<div class="alert alert-danger">Your have alerdy answered this question.</div>';
        }
        else{
            if(time()>($start+$time)){
                $_SESSION['answered'][$question] = $question;
                $array['success'] = 0;
                $array['timeout'] = 1;
				$_SESSION['answered'][$question] = $question;
				$_SESSION['answers'][$question] = $answer;
				$_SESSION['questions'][$question] = $question;
                $array['msg'] = '<div class="alert alert-danger">Timeout for this question.</div>';
            }
            else if($answer==''){
                $array['success'] = 0;
                $array['timeout'] = 0;
                $array['msg'] = '<div class="alert alert-danger">Please select answer.</div>';
            }
            else{
                if(in_array($answer,$correct_answer)){
                    $array['success'] = 1;
                    $array['is_correct'] = 1;
					$_SESSION['answered'][$question] = $question;
					$_SESSION['answers'][$question] = $answer;
					$_SESSION['questions'][$question] = $question;
                    $array['msg'] = '<div class="alert alert-success">Your answer is correct.</div>';
                }
                else{
                    $array['success'] = 1;
                    $array['is_correct'] = 0;
                    //$array['correct'] = 0;
					$_SESSION['answered'][$question] = $question;
					$_SESSION['answers'][$question] = $answer;
					$_SESSION['questions'][$question] = $question;
                    $array['msg'] = '<div class="alert alert-danger">Your answer is wrong.</div>';
                }
            }
        }
    }
	
    echo json_encode($array);
?>