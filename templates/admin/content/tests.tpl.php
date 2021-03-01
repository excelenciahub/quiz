<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Tests</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo SITE_URL_ADMIN; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Tests</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<?php
            if(isset($error) && $error!=''){
                ?>
				<div class="alert alert-danger">
					<?php echo $error; ?>
				</div>
				<?php
            }
            else if(isset($success) && $success!=''){
                ?>
				<div class="alert alert-success">
					<?php echo $success; ?>
				</div>
				<?php
            }
            else if(isset($warning) && $warning!=''){
                ?>
				<div class="alert alert-warning">
					<?php echo $warning; ?>
				</div>
				<?php
            }
        ?>
		
		<?php
            if($action=='add_new'||($action=='edit' && $id>0)){
                ?>
                <form action="<?php echo CURRENT_PAGE_ADMIN.$form_add; ?>" method="post">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-edit"></i> <?php echo $action=='add_new'?'Add New':'Edit'; ?> Test</h3>
                            <div class="pull-right">
                                <a href="<?php echo CURRENT_PAGE_ADMIN; ?>" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> View List</a>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Test Name <span class="text-red font-verdana">*</span></label>
                                        <input type="text" name="name" id="name" value="<?php echo $name; ?>" class="form-control" />
                                    </div>
                                </div>
							</div>
                        </div>
                        <div class="box-footer">
                            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" readonly="readonly" />
                            <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>
				
				<?php
			if($action=='edit' && $id>0 && ($q_action=='add_new' || $q_action=='edit') ){
						?>
						<form action="<?php echo CURRENT_PAGE_ADMIN.$form_add; ?>" method="post">
							<div class="box box-info">
								<div class="box-header with-border">
									<h3 class="box-title"><i class="fa fa-edit"></i> <?php echo $q_action=='add_new'?'Add New':'Edit'; ?> Question</h3>
									<div class="pull-right">
										<a href="<?php echo CURRENT_PAGE_ADMIN; ?>?action=edit&id=<?php echo $id; ?>&q_action=view" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> View List</a>
									</div>
								</div>
								<div class="box-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Question <span class="text-red font-verdana">*</span></label>
												<input type="text" name="question" id="question" value="<?php echo $question; ?>" class="form-control" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Time (In Sec.) <span class="text-red font-verdana">*</span></label>
												<input type="text" name="time" id="time" value="<?php echo $time; ?>" class="form-control" />
											</div>
										</div>
									</div>
									<?php
										$option_count = 0;
										foreach($options as $key=>$val){
											?>
											<div class="row">
												<div class="col-md-6 form-group">
													<label>Option <?php echo ++$option_count; echo $option_count<=2?' <span class="text-red font-verdana">*</span>':''; ?></label>
													<div class="input-group">
														<span class="input-group-addon">
															<input name="is_correct[]" <?php echo in_array(($option_count-1),$is_correct)?'checked="checked"':''; ?> value="<?php echo ($option_count-1); ?>" type="radio" />
														</span>
														<input type="text" name="options[]" value="<?php echo isset($options[$key])?$options[$key]:''; ?>" id="option<?php echo $option_count; ?>" class="form-control" />
														<?php
															if($option_count>2){
																?>
																<span class="input-group-addon remove" >
																	<i class="fa fa-minus "></i>
																</span>
																<?php
															}
														?>
													</div>
													<!-- /input-group -->
												</div>
											</div>
											<?php
										}
									?>
									
									<div id="more_options"></div>
									<div class="row">
										<div class="col-md-12">
											<button type="button" name="add_option" id="add_option" onclick="addOption();" class="btn btn-default"><i class="fa fa-plus"></i></button>
										</div>
									</div>
								</div>
								<div class="box-footer">
									<input type="hidden" name="id" id="id" value="<?php echo $q_id; ?>" readonly="readonly" />
									<input type="hidden" name="test" id="test" value="<?php echo $test_id; ?>" readonly="readonly" />
									<input type="hidden" name="ref" value="<?php echo CURRENT_PAGE_ADMIN_QRY; ?>" />
									<input type="hidden" name="q_action" value="<?php echo $q_action; ?>" /> 
									<button type="submit" name="submit" value="submit_question" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save</button>
								</div>
							</div>
						</form>
						<script type="text/javascript">
								var opt = '<?php echo $option_count; ?>';
								function addOption(){
									opt = parseInt(opt);
									opt++;
									var data = '<div class="row">'+
													'<div class="col-md-6 form-group">'+
														'<label>Option '+opt+'</label>'+
														'<div class="input-group">'+
															'<span class="input-group-addon">'+
																'<input name="is_correct[]" value="'+(opt-1)+'" type="radio" />'+
															'</span>'+
															'<input type="text" name="options[]" value="" id="option'+opt+'" class="form-control" />'+
															'<span class="input-group-addon remove" >'+
																'<i class="fa fa-minus "></i>'+
															'</span>'+
														'</div>'+
														'<!-- /input-group -->'+
													'</div>'+
												'</div>';
									$('#more_options').before(data);
								}
								$(document).on('click', '.remove', function() {
									$(this).closest('.row').remove();
								});
						</script>
					<?php
				}
				else if($q_action='view' && $action=='edit'){
					?>
					<!-- DataTables -->
					<link rel="stylesheet" href="<?php echo SITE_PLUGINS; ?>datatables/dataTables.bootstrap.min.css" />
					<script src="<?php echo SITE_PLUGINS; ?>datatables/jquery.dataTables.min.js"></script>
					<script src="<?php echo SITE_PLUGINS; ?>datatables/dataTables.bootstrap.min.js"></script>
					
					<div class="box box-info">
						<div class="box-header with-border">
								<h3 class="box-title"><i class="fa fa-list"></i> Question List</h3>
								<?php
									if($admin['type']==2){
										?>
										<div class="pull-right">
											<a href="<?php echo CURRENT_PAGE_ADMIN.$form_add; ?>&q_action=add_new" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Add New Question</a>
										</div>
										<?php
									}
								?>
							</div>
							<div class="box-body table-responsive">
							
								<table class="table table-hover table-striped" id="data-table">
									<thead>
									
										<tr>
											<th class="text-center">#No</th>
											<th>Questions</th>
											<th>Options</th>
											<th>Time(In Sec.)</th>
											<th class="text-center">Status</th>
											<th class="text-center">Action</th>
										</tr>
										
									</thead>
									<tbody>
										<?php
										
											$count = 0;
											foreach($questions_list as $key=>$val){
												?>
												<tr>
													<td class="text-center"><?php echo ++$count; ?></td>
													
													<td><?php echo $val['question']; ?></td>
													
													<td>
														<?php
															foreach($val['options'] as $k=>$v){
																$cls = $v['is_correct']==1?'text-green':'';
																?>
																<span class="<?php echo $cls; ?>"><?php echo $dbins->re_db_output($v['option']); ?></span><br />
																<?php
															}
														?>
													</td>
													
													<td><?php echo $val['time']; ?></td>
													
													<td class="text-center">
														<?php
															if($val['status']==1){
																?>
																<a href="<?php echo CURRENT_PAGE_ADMIN; ?>?action=edit&id=<?php echo $id; ?>&q_action=status&q_id=<?php echo $val['id']; ?>&q_status=0" class="btn btn-xs btn-success"><i class="fa fa-check-square-o"></i> Enabled</a>
																<?php
															}
															else{
																?>
																<a href="<?php echo CURRENT_PAGE_ADMIN; ?>?action=edit&id=<?php echo $id; ?>&q_action=status&q_id=<?php echo $val['id']; ?>&q_status=1" class="btn btn-xs btn-warning"><i class="fa fa-warning"></i> Disabled</a>
																<?php
															}
														?>
													</td>
													
													<td class="text-center">
														<a href="<?php echo CURRENT_PAGE_ADMIN; ?>?action=edit&id=<?php echo $id; ?>&q_action=edit&q_id=<?php echo $val['id']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
														<a href="<?php echo CURRENT_PAGE_ADMIN; ?>?action=edit&id=<?php echo $id; ?>&q_action=delete&q_id=<?php echo $val['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i> Delete</a>
													</td>
												</tr>
												<?php
												
											}
										?>
									</tbody>
								</table>
							
							</div>
						</div>
					</div>
					
					<script type="text/javascript">
						$(document).ready(function(){
							
							$("#data-table").DataTable({
								  "aoColumnDefs": [
									  { 'bSortable': false, 'aTargets': [ -1 ] },
									  { "sWidth": "150px", "aTargets": [ -1 ] }
								   ]
							});
							
						});
					</script>
					<?php
				}
            }
            else{
                ?>
				<!-- DataTables -->
				<link rel="stylesheet" href="<?php echo SITE_PLUGINS; ?>datatables/dataTables.bootstrap.min.css" />
				<script src="<?php echo SITE_PLUGINS; ?>datatables/jquery.dataTables.min.js"></script>
				<script src="<?php echo SITE_PLUGINS; ?>datatables/dataTables.bootstrap.min.js"></script>
		
                <div class="box box-info">
                    <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-list"></i> Tests List</h3>
                            <div class="pull-right">
								<!--
    							Share Page: 
                                <?php
                                    $url = SITE_URL.'tests.php?t='.$admin_id;
                                    $test_title = $dbins->re_db_output($metatitle);
                                ?>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                                <a href="https://twitter.com/home?status=<?php echo $url; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                                <a href="https://plus.google.com/share?url=<?php echo $url; ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php echo $test_title; ?> - kwizards&summary=&source=" target="_blank"><i class="fa fa-linkedin"></i></a>
								-->
                                <?php
    								if($admin['type']==2){
    									?>
    										<a href="<?php echo CURRENT_PAGE_ADMIN; ?>?action=add_new" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Add New Test</a>
    									<?php
    								}
    							?>
                            </div>
                        </div>
                        <div class="table-responsive box-body">
                        
                            <table class="table table-hover table-striped" id="data-table">
                                <thead>
                                
                                    <tr>
                                        <th class="text-center">#No</th>
                                        <th>Test Name</th>
                                        <th class="text-center">Share Test</th>
                                        <th class="text-center filterable customFilterColumn">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    
                                </thead>
                                <tbody>
                                    <?php
										$con = isset($_GET['tid'])&&$_GET['tid']!=''?'&tid='.$instance->re_db_input($_GET['tid']):'';
										$count = 0;
                                        foreach($return as $key=>$val){
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo ++$count; ?></td>
                                                <td><?php echo $dbins->re_db_output($val['test_name']); ?></td>
                                                <td class="text-center social-sharing-square sharing">
                                                    <?php
                                                        $url = SITE_URL.'quiz.php?t='.$val['id'];
                                                        $test_title = $dbins->re_db_output($val['test_name']);
                                                    ?>
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                                                    <a href="https://twitter.com/home?status=<?php echo $url; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                                                    <a href="https://plus.google.com/share?url=<?php echo $url; ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
                                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php echo $test_title; ?> - kwizards&summary=&source=" target="_blank"><i class="fa fa-linkedin"></i></a>
                                                </td>
												
												<?php
													if($val['status']==1){
														?>
														<td class="text-center" data-filter="Enabled">
														<a href="<?php echo CURRENT_PAGE_ADMIN; ?>?action=status&id=<?php echo $val['id']; ?>&status=0<?php echo $con; ?>" class="btn btn-xs btn-success"><i class="fa fa-check-square-o"></i> Enabled</a>
														</td>
														<?php
													}
													else{
														?>
														<td class="text-center" data-filter="Disabled">
														<a href="<?php echo CURRENT_PAGE_ADMIN; ?>?action=status&id=<?php echo $val['id']; ?>&status=1<?php echo $con; ?>" class="btn btn-xs btn-warning"><i class="fa fa-warning"></i> Disabled</a>
														</td>
														<?php
													}
												?>
												
                                                <td class="text-center">
                                                    <?php
                                                        if($admin['type']==2){
                                                            ?>
													<a href="<?php echo CURRENT_PAGE_ADMIN; ?>?action=edit&id=<?php echo $val['id']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                                            <?php
                                                        }
                                                    ?>
													<a href="<?php echo CURRENT_PAGE_ADMIN; ?>?action=delete&id=<?php echo $val['id']; ?><?php echo $con; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        
                        </div>
                    </div>
                </div>
				
				<script type="text/javascript">
					$(document).ready(function(){
						
						var table = $("#data-table").DataTable({
							  "aoColumnDefs": [
								  { 'bSortable': false, 'aTargets': [ -1 ] },
								  { "sWidth": "150px", "aTargets": [ -1 ] }
							   ]
						});
						filter(table,'#data-table thead th.filterable','customFilterColumn');
						
					});
				</script>
				
                <?php
            }
    
        ?>
	</section>
	<!-- /.content -->
</div>