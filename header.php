<!DOCTYPE html>

<html>



    <head>

    	<meta charset="utf-8" />

    	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

    	<title><?php echo isset($metatitle)&&$metatitle!=''?$metatitle:'Quizard'; ?></title>

		<link rel="shortcut icon" href="<?php echo SITE_IAMGES; ?>favicon.png"/>

    	<!-- Tell the browser to be responsive to screen width -->

    	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />

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

        

        <!-- iCheck for checkboxes and radio inputs -->

        <link rel="stylesheet" href="<?php echo SITE_PLUGINS; ?>iCheck/all.css" />

    

    	<link rel="stylesheet" href="<?php echo SITE_CSS; ?>front.css" />

        

        <!-- jQuery 2.2.0 -->

    	<script src="<?php echo SITE_JS; ?>jquery.min.js"></script>

    	<!-- Bootstrap 3.3.5 -->

    	<script src="<?php echo SITE_JS; ?>bootstrap.min.js"></script>

		

    </head>

    <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

    

    <body id="quiz-body" class="hold-transition skin-blue-light layout-top-nav">

    	<div class="wrapper">

    

    		<header class="main-header">

    			<nav class="navbar navbar-static-top">

    				<div class="container">

    					<div class="navbar-header">
                            <a href="<?php echo SITE_URL; ?>" class="navbar-brand"><b>Quiz</b></a>



                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">



    							<i class="fa fa-bars"></i>



    						</button>
    					</div>

    					<!-- /.navbar-custom-menu -->

    				</div>

    				<!-- /.container-fluid -->

    			</nav>

    		</header>