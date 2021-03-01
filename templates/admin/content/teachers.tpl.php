<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Teachers</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo SITE_URL_ADMIN; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Teachers</li>
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
                            <h3 class="box-title"><i class="fa fa-edit"></i> <?php echo $action=='add_new'?'Add New':'Edit'; ?> Teacher</h3>
                            <div class="pull-right">
                                <a href="<?php echo CURRENT_PAGE_ADMIN; ?>" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> View List</a>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name <span class="text-red font-verdana">*</span></label>
                                        <input type="text" name="name" id="name" value="<?php echo $name; ?>" class="form-control" />
                                    </div>
                                </div>
							</div>
							<div class="row">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email <span class="text-red font-verdana">*</span></label>
                                        <input type="text" name="email" id="email" value="<?php echo $email; ?>" class="form-control" />
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mobile <span class="text-red font-verdana">*</span></label>
                                        <input type="text" name="mobile" id="mobile" value="<?php echo $mobile; ?>" class="form-control" />
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password <?php echo $action=='add_new'?'<span class="text-red font-verdana">*</span>':''; ?></label>
                                        <input type="password" name="password" id="password" class="form-control" />
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm Password <?php echo $action=='add_new'?'<span class="text-red font-verdana">*</span>':''; ?></label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" />
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
            }
            else{
                ?>
				<!-- DataTables -->
				<link rel="stylesheet" href="<?php echo SITE_PLUGINS; ?>datatables/dataTables.bootstrap.min.css" />
				<script src="<?php echo SITE_PLUGINS; ?>datatables/jquery.dataTables.min.js"></script>
				<script src="<?php echo SITE_PLUGINS; ?>datatables/dataTables.bootstrap.min.js"></script>
		
                <div class="box box-info">
                    <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-list"></i> Teacher List</h3>
                            <div class="pull-right">
                                <a href="<?php echo CURRENT_PAGE_ADMIN; ?>?action=add_new" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Add New Teacher</a>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                        
                            <table class="table table-hover table-striped" id="data-table">
                                <thead>
                                
                                    <tr>
                                        <th class="text-center">#No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th class="text-center filterable customFilterColumn">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    
                                </thead>
                                <tbody>
									<?php
										$count = 0;
                                        foreach($return as $key=>$val){
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo ++$count; ?></td>
                                                <td><?php echo $dbins->re_db_output($val['name']); ?></td>
                                                <td><?php echo $dbins->re_db_output($val['email']); ?></td>
                                                <td><?php echo $dbins->re_db_output($val['mobile']); ?></td>
												<?php
													if($val['status']==1){
														?>
														<td class="text-center" data-filter="Enabled">
														<a href="<?php echo CURRENT_PAGE_ADMIN; ?>?action=status&id=<?php echo $val['admin_id']; ?>&status=0" class="btn btn-xs btn-success"><i class="fa fa-check-square-o"></i> Enabled</a>
														</td>
														<?php
													}
													else{
														?>
														<td class="text-center" data-filter="Disabled">
														<a href="<?php echo CURRENT_PAGE_ADMIN; ?>?action=status&id=<?php echo $val['admin_id']; ?>&status=1" class="btn btn-xs btn-warning"><i class="fa fa-warning"></i> Disabled</a>
														</td>
														<?php
													}
												?>
                                                <td class="text-center">
													<a href="<?php echo CURRENT_PAGE_ADMIN; ?>?action=edit&id=<?php echo $val['admin_id']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
													
													<a href="<?php echo SITE_URL_ADMIN; ?>tests.php?tid=<?php echo $val['admin_id']; ?>" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Tests</a>
													
													<a href="<?php echo CURRENT_PAGE_ADMIN; ?>?action=delete&id=<?php echo $val['admin_id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i> Delete</a>
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
						var table =  $("#data-table").DataTable({
							  "aoColumnDefs": [
								  { 'bSortable': false, 'aTargets': [ -1 ] },
								  { "sWidth": "220px", "aTargets": [ -1 ] }
							   ]
						});
						//filter(table,'#data-table thead th.filterable','customFilterColumn');
					});
				</script>
				
                <?php
            }
    
        ?>
	</section>
	<!-- /.content -->
</div>