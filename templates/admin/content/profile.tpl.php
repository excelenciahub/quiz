

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Profile</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo SITE_URL_ADMIN; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Profile</li>
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
		
        <form action="<?php echo CURRENT_PAGE_ADMIN; ?>" method="post">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-edit"></i> Edit Profile</h3>
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
                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>
	</section>
	<!-- /.content -->
</div>