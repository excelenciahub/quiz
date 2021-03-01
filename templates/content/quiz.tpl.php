<!-- Full Width Column -->
<div class="content-wrapper">
	<div class="container quiz-container">
		
		<!-- Main content -->
		<section class="content">

            <div class="row">
                <div class="col-sm-12">
                
                    <?php
                        if(count($return)==0){
                            ?>
                            <div class="alert alert-warning">
                                No questions found.
                            </div>
                            <button onclick="window.history.back();" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</button>
							<?php
								if(count($question)>0){
									?>
                            <a href="<?php echo SITE_URL; ?>result.php" class="btn btn-success"><i class="fa fa-eye"></i> Result</a>
									<?php
								}
                        }
                        else{
                            ?>
                            <form id="form" method="post">
                                <!-- Default box -->
                				<div class="box box-info box-infos">
                					<div class="box-header with-border">
                						<h3 class="box-title"><?php echo $return['question']; ?></h3>
                                        <div class="pull-right">
                                            
                                        </div>
                					</div>
                					<div class="box-body">
                                        
                                        <?php
                                            foreach($return['options'] as $key=>$val){
                                                ?>
                                                <div class="radio" id="answer_<?php echo $key; ?>">
                                                    <label>
                                                        <input type="radio" name="answer" id="answer<?php echo $key; ?>" value="<?php echo $key; ?>" class="minimal" />
                                                        <?php echo $dbins->re_db_output($val); ?>
                                                    </label>
                                                </div>
                                                <?php
                                            }
											
                                        ?>
										<div class="row">
											<div class="col-md-12">
												<div id="progressTimer"></div>
											</div>
										</div>
                                        <div id="msgbox"></div>
                					</div>
                                    <div class="overlay" id="overlay" style="display: none;">
                                        <i class="fa fa-spin fa-spinner"></i>
                                    </div>
                					<!-- /.box-body -->
                					<div class="box-footer">
                                        <input type="hidden" name="question" id="question" value="<?php echo $return['id']; ?>" />
                						<button style="display: none;" type="submit" id="submit" name="submit" value="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Submit</button>
                                        <input type="hidden" name="timeout" id="timeout" value="0" />
										
                                        <?php
                                           $t = $dbins->re_db_output($return['time']);
                                            $tm = time();
											/*
                                            if(isset($_SESSION['question'][$return['id']]['start'])){
                                                if(($_SESSION['question'][$return['id']]['start']+$_SESSION['question'][$return['id']]['time'])-$tm>=0){
                                                    $t = ($_SESSION['question'][$return['id']]['start']+$_SESSION['question'][$return['id']]['time'])-$tm;
                                                }
                                                else{
                                                    $t = 0;
                                                }
                                            }
											*/
                                        ?>
                                        <button type="button" id="timebtn" class="btn btn-primary btn-md"><i class="fa fa-clock-o"></i> <span id="timer"><?php echo $t; ?></span></button>
										<span id="retry" style="display: none;"></span>
                                        <div class="pull-right">
											<?php
												if($has_prev!=0){
													?>
                                            <a href="<?php echo CURRENT_PAGE; ?>?t=<?php echo $tid; ?>&q=<?php echo $return['id']; ?>&action=0" class="btn btn-primary btn-md"><i class="fa fa-angle-double-left"></i> Previous</a>
													<?php
												}
											?>
											
											<?php
												if($has_next==0){
													$href = SITE_URL.'result.php?tid='.$tid;
												}
												else{
													$href = CURRENT_PAGE.'?t='.$tid.'&q='.$return['id'].'&action=1';
												}
											?>
											
                                            <a style="<?php echo $has_next!=0?'':'display:none'; ?>" href="<?php echo $href; ?>" class="btn btn-primary btn-md" id="next">Next <i class="fa fa-angle-double-right"></i></a>
                                        </div>
                					</div>
                					<!-- /.box-footer-->
                				</div>
                				<!-- /.box -->
                            </form>
                            <?php
                        }
                    ?>
                    
                </div>
            </div>
			
		</section>
		<!-- /.content -->
	</div>
	<!-- /.container -->
</div>

<script type="text/javascript">

    $(document).ready(function(){
        
        var audioElement = document.createElement('audio');
        
        var time = parseInt($('#timer').text());
        
        var timeout = true;
        function timer()
        {
            if(parseInt($timerdiv.html())!=0 && timeout==true){
				$timerdiv.html(parseInt($timerdiv.html()) - 1);
				setTimeout(timer, 1000);
             }
             
             if(parseInt($timerdiv.html())==0 && timeout==true){
                if(timeout==true){
                    $('#timeout').val('0');
					setTimeout(function(){ $('#form').submit(); }, 1000);
					setTimeout(function(){ window.location.href = $('#next').attr('href'); }, 2000);
					/*
					setTimeout(function(){ 
						//window.location.href = $('#next').attr('href'); 
						}, 2000);
						*/
                }
                setTimeout(timer, 1000000000);
                timeout = false;
             }
			
             
        }
        
		$('#form input[type="radio"').on("ifChecked", function(){
			$('input[name="answer"]').parent().parent().parent().attr('class','radio');
			$('input[name="answer"]').parent().parent().attr('class','');
			$('#retry').html('');
			$('#form').submit();
		});
		
        // this is the id of the form
        $('#form').submit(function(e) {
			
            var url = "<?php echo SITE_URL; ?>save-answer.php"; // the script where you handle the form input.
            
            $('.overlay').css('display','block');
            /*
            $('#form div.radio label').attr('class','');
            $('#form div.radio input[type="radio"]').attr('class','minimal');
            
            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
              checkboxClass: 'icheckbox_minimal-blue',
              radioClass: 'iradio_minimal-blue'
            });
            */
            
            $.ajax({
                   type: "POST",
                   url: url,
                   data: $('#form').serialize(), // serializes the form's elements.
                   success: function(data){
					   var width = $('.progress-bar').css('width');
					   var cls = $('.progress-bar').attr('class');
					   
                        var $return = JSON.parse(data);
                        
						//if( ($return['success']=='0' && $return['timeout']=='1') || ($return['success']=='1' && $return['is_correct']=='1') )
						{
							$('input[name="answer"]').iCheck('disable');
							if(parseInt($('#timer').text())!=0){
							   $("#progressTimer").progressTimer({
									timeLimit: 0,
									onFinish: function () {
										$('.progress-bar').removeClass('progress-bar-danger');
										$('.progress').removeClass('active');
										$('.123').css('width',width);
										
									},
									baseStyle: '123 '+cls,
									completeStyle: '123 '+cls,
								});
							   }
								
								$('.123').css('width',width);
								timeout = false;
						}
						
                        if($return['success']=='0'){
                            if($return['timeout']=='1'){
                                $('#submit').attr('disabled','disabled');
								$.each($return['correct'], function(index, item) {
									var element = $('#answer'+item);
									
									$(element).parent().parent().addClass('text-green');
									$(element).parent().parent().parent().addClass('alert alert-success');
									$(element).attr('class','minimal-green');
									$('input[type="checkbox"], input[type="radio"].minimal-green').iCheck({
									  checkboxClass: 'icheckbox_minimal-green',
									  radioClass: 'iradio_minimal-green'
									});
									
								});
                            }
							$('#retry').html('<a href="<?php echo SITE_URL; ?>retry.php?id=<?php echo $returnid; ?>&ref=<?php echo base64_encode($query_string); ?>" class="btn btn-primary btn-sm"><i class="rotate-left"></i> Retry</a>');
                            audioElement.setAttribute('src', '<?php echo SITE_URL; ?>sound/wrong/1.mp3');
                            audioElement.play();
							
                            $('#msgbox').html($return['msg']);
							setTimeout(function(){ window.location.href = $('#next').attr('href'); }, 2000);
                        }
                        else if($return['success']=='1' && $return['is_correct']=='0'){
                            
							$('#retry').html('<a href="<?php echo SITE_URL; ?>retry.php?id=<?php echo $returnid; ?>&ref=<?php echo base64_encode($query_string); ?>" class="btn btn-primary btn-sm"><i class="rotate-left"></i> Retry</a>');
							
                            audioElement.setAttribute('src', '<?php echo SITE_URL; ?>sound/wrong/2.mp3');
                            audioElement.play();
                            $('input[name="answer"]:checked').parent().parent().attr('class','text-red');
                            $('input[name="answer"]:checked').parent().parent().parent().addClass('alert alert-danger');
                            
							$('input[name="answer"]:checked').attr('class','minimal-red');
                            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                              checkboxClass: 'icheckbox_minimal-red',
                              radioClass: 'iradio_minimal-red'
                            });
                            
							
                            $.each($return['correct'], function(index, item) {
                                var element = $('#answer'+item);
                                
                                $(element).parent().parent().addClass('text-green');
								$(element).parent().parent().parent().addClass('alert alert-success');
                                $(element).attr('class','minimal-green');
                                $('input[type="checkbox"], input[type="radio"].minimal-green').iCheck({
                                  checkboxClass: 'icheckbox_minimal-green',
                                  radioClass: 'iradio_minimal-green'
                                });
                                
                            });
                            
							
                            $('#msgbox').html($return['msg']);
							setTimeout(function(){ window.location.href = $('#next').attr('href'); }, 2000);
                        }
                        else if($return['success']=='1' && $return['is_correct']=='1'){
                            
                            audioElement.setAttribute('src', '<?php echo SITE_URL; ?>sound/correct/1.mp3');
                            audioElement.play();
                            $('input[name="answer"]:checked').parent().parent().addClass('text-green');
                            $('input[name="answer"]:checked').parent().parent().parent().addClass('alert alert-success');
							$('input[name="answer"]:checked').attr('class','minimal-green');
                            $('input[type="checkbox"].minimal-green, input[type="radio"].minimal-green').iCheck({
                              checkboxClass: 'icheckbox_minimal-green',
                              radioClass: 'iradio_minimal-green'
                            });
                            $('#msgbox').html($return['msg']);
							setTimeout(function(){ window.location.href = $('#next').attr('href'); }, 2000);
                        }
                        
                        //audioElement.play();
                        //$("#status").text("Status: Playing");
                        
                        $('.overlay').css('display','none');
						
                   },
                   error: function (request, status, error) {
                        $('.overlay').css('display','none');
                   }
                 });
        
				
		
            e.preventDefault(); // avoid to execute the actual submit of the form.
        });
        
        $timerdiv = $('#timer');

        timer();
		
		$("#progressTimer").progressTimer({
			timeLimit: $('#timer').text()
		});
        
		if($('#timer').text()=='0'){
			$('.progress-bar').removeClass('progress-bar-success');
			$('.progress-bar').addClass('progress-bar-danger');
			$('.progress-bar').css('width','100%');
		}
		else{
			
		}
		
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });
        
		//$('.content-wrapper').attr('style','');
		//$('.main-footer').css('background','#c8c8c8');
    })
</script>

<?php
    if(!isset($_SESSION['question'][$return['id']]['start'])){
        $_SESSION['question'][$return['id']]['start'] = time();
        $_SESSION['question'][$return['id']]['time'] = $return['time'];
        $_SESSION['question'][$return['id']]['correct_answer'] = $return['is_correct'];
    }
?>