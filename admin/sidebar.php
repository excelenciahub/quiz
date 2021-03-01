<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="header">MAIN NAVIGATION</li>
			<li class="<?php echo FILE_NAME=='index.php'?'active':''; ?>"><a href="<?php echo SITE_URL_ADMIN; ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			
            <?php
                if($admin['type']==1){
                    ?>
                    <li class="<?php echo FILE_NAME=='teachers.php'?'active':''; ?>"><a href="<?php echo SITE_URL_ADMIN; ?>teachers.php"><i class="fa fa-users"></i> <span>Teachers</span></a></li>
                    <?php
                }
                else if($admin['type']==2){
                    ?>
                    <li class="<?php echo FILE_NAME=='tests.php'?'active':''; ?>"><a href="<?php echo SITE_URL_ADMIN; ?>tests.php"><i class="fa fa-users"></i> <span>Tests</span></a></li>
                    <li class="<?php echo FILE_NAME=='questions.php'?'active':''; ?>"><a href="<?php echo SITE_URL_ADMIN; ?>questions.php"><i class="fa fa-question-circle-o"></i> <span>Questions</span></a></li>
                    <?php
                }
            ?>
			
			<!--
			<li class="treeview">
				<a href="#">
					<i class="fa fa-users"></i> <span>Teachers</span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="#"><i class="fa fa-circle-o"></i> Add Teachers</a></li>
					<li><a href="#"><i class="fa fa-circle-o"></i> View Teachers</a></li>
				</ul>
			</li>
			-->
			
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>

<!-- =============================================== -->