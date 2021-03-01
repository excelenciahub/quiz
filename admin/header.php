<!DOCTYPE html>
<html>

    <head>
    	<meta charset="utf-8" />
    	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    	<title>Quizard</title>
    	<!-- Tell the browser to be responsive to screen width -->
    	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
		
		<link rel="shortcut icon" href="<?php echo SITE_IAMGES; ?>favicon.png"/>
		
    	<!-- Bootstrap 3.3.5 -->
    	<link rel="stylesheet" href="<?php echo SITE_CSS; ?>bootstrap.min.css" />
    	<!-- Font Awesome -->
    	<link rel="stylesheet" href="<?php echo SITE_CSS; ?>font-awesome.min.css" />
    	<!-- Ionicons -->
    	<link rel="stylesheet" href="<?php echo SITE_CSS; ?>ionicons.min.css" />
    	<!-- Theme style -->
    	<link rel="stylesheet" href="<?php echo SITE_CSS; ?>AdminLTE.min.css" />
    	<!-- AdminLTE Skins. Choose a skin from the css/skins
        		   folder instead of downloading all of them to reduce the load. -->
    	<link rel="stylesheet" href="<?php echo SITE_CSS; ?>skins/_all-skins.min.css" />
    
    	<link rel="stylesheet" href="<?php echo SITE_CSS; ?>admin.css" />
    
		<!-- jQuery 2.2.0 -->
    	<script src="<?php echo SITE_JS; ?>jquery.min.js"></script>
    	<!-- Bootstrap 3.3.5 -->
    	<script src="<?php echo SITE_JS; ?>bootstrap.min.js"></script>
	
    </head>
    
    <body class="hold-transition skin-blue-light sidebar-mini">
    	<!-- Site wrapper -->
    	<div class="wrapper">
    
    		<header class="main-header">
    			<!-- Logo -->
    			<a href="<?php echo SITE_URL_ADMIN; ?>" class="logo">
    				<!-- mini logo for sidebar mini 50x50 pixels -->
    				<span class="logo-mini"><b>Q</b></span>
    				<!-- logo for regular state and mobile devices -->
    				<span class="logo-lg"><b>Quiz</b></span>
    			</a>
    			<!-- Header Navbar: style can be found in header.less -->
    			<nav class="navbar navbar-static-top" role="navigation">
    				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </a>
    
    				<div class="navbar-custom-menu">
    					<ul class="nav navbar-nav">
    						<li class="dropdown user user-menu">
    							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo $admin['name']; ?> <span class="caret"></span>
                                </a>
    							<ul class="dropdown-menu" role="menu">
    								<li><a href="<?php echo SITE_URL_ADMIN; ?>profile.php"><i class="fa fa-user"></i> Profile</a></li>
    								<li><a href="<?php echo SITE_URL_ADMIN; ?>change-password.php"><i class="fa fa-cog"></i> Change Password</a></li>
    								<li class="divider"></li>
    								<li><a href="<?php echo SITE_URL_ADMIN; ?>logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
    							</ul>
    						</li>
    					</ul>
    				</div>
    			</nav>
    		</header>
    
    		<!-- =============================================== -->
			
			<?php include('sidebar.php'); ?>