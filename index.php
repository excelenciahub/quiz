<?php include('include/config.php'); ?>

<?php
	$error = '';
    $email = '';
	$instance = new admin_master();
    
	if(isset($_POST['submit']) && $_POST['submit']=='submit'){
		
        $email = isset($_POST['email'])&&$_POST['email']!=''?$instance->re_db_input($_POST['email']):'';
        
		$return = $instance->login($_POST);
        if($return!=1){
            $error = $return;
        }
        else{
			header('location:'.SITE_URL_ADMIN.'index.php');exit;
        }
	}
    $return = $instance->select(2,1);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Log in</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
	<link rel="shortcut icon" href="<?php echo SITE_IAMGES; ?>favicon.png"/>
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="<?php echo SITE_CSS; ?>bootstrap.min.css" />
	<!-- Font Awesome -->
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo SITE_CSS; ?>font-awesome.min.css" />
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo SITE_CSS; ?>ionicons.min.css" />
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo SITE_CSS; ?>AdminLTE.min.css" />
    <!-- Theme style -->
	<link rel="stylesheet" href="<?php echo SITE_CSS; ?>front.css" />
</head>

<body class="hold-transition login-page">
	<div class="content">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">

				<div class="login-box">
					<div class="login-logo">
                        <a href="#"><b>Quiz</b></a>
					</div>
					<!-- /.login-logo -->
					<div class="row">
						<div class="col-md-8">
							<div class="login-box-body">

								<p class="login-box-msg">Sign in to start your session</p>

								<form action="<?php echo CURRENT_PAGE; ?>" method="post">
									<div class="form-group has-feedback">
										<input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
										<span class="fa fa-envelope form-control-feedback"></span>
									</div>
									<div class="form-group has-feedback">
										<input name="password" id="password" type="password" class="form-control" placeholder="Password" />
										<span class="fa fa-lock form-control-feedback"></span>
									</div>
									<?php
										if($error!==''){
											?>
											<div class="alert alert-danger">
												<?php echo $error; ?>
											</div>
											<?php
										}
									?>
									<div class="row">
										<div class="col-xs-12">
											<button type="submit" name="submit" value="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
										</div>
										<!-- /.col -->
									</div>
								</form>
							</div>
						</div>

						<div class="col-sm-4">
							
								<div class="box box-info direct-chat">
                                    <div class="box-header text-center with-border">
                                        <h3 class="box-title">Tests</h3>
                                    </div>
									<div class="box-body">
                                        <div class="direct-chat-messages" style="height: 170px;">
                                            <?php
                                                foreach($return as $key=>$val){
                                                    ?>
    										      <a href="<?php echo SITE_URL; ?>tests.php?t=<?php echo $val['admin_id']; ?>" class="btn btn-block btn-default btn-sm"><?php echo $dbins->re_db_output($val['name']); ?></a>
                                                  <?php
                                                }
                                            ?>
                                        </div>
									</div>
								</div>
							
							
						</div>

					</div>
				</div>
			</div>

		</div>
		<!-- /.login-box-body -->
	</div>
	<!-- /.login-box -->

	<!-- jQuery 2.2.0 -->
	<script src="<?php echo SITE_JS; ?>jquery.min.js"></script>
	<!-- Bootstrap 3.3.5 -->
	<script src="<?php echo SITE_JS; ?>bootstrap.min.js"></script>
</body>

</html>