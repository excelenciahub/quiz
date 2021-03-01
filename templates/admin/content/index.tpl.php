<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Dashboard</h1>
		<ol class="breadcrumb">
			<li class="active"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<div class="row">
			<?php
				if($admin['type']==1){
					?>
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3><?php echo $teachers; ?></h3>
						<p>Total Teachers</p>
					</div>
					<div class="icon">
						<i class="ion ion-ios-people"></i>
					</div>
					<a href="<?php echo SITE_URL_ADMIN; ?>teachers.php" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<?php
			}
			?>
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-navy">
					<div class="inner">
						<h3><?php echo $tests; ?></h3>
						<p>Total Tests</p>
					</div>
					<div class="icon">
						<i class="fa fa-balance-scale"></i>
					</div>
					<?php
						if($admin['type']==2){
							?>
					<a href="<?php echo SITE_URL_ADMIN; ?>tests.php" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
							<?php
						}
					?>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-purple">
					<div class="inner">
						<h3><?php echo $questions; ?></h3>
						<p>Total Questions</p>
					</div>
					<div class="icon">
						<i class="fa fa-question-circle-o"></i>
					</div>
					<?php
						if($admin['type']==2){
							?>
					<a href="<?php echo SITE_URL_ADMIN; ?>questions.php" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
							<?php
						}
					?>
				</div>
			</div>
		</div>
        
        <form id="chart_filter_form" name="chart_filter_form" action="<?php echo CURRENT_PAGE_ADMIN; ?>" method="get">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Year <span class="text-red font-verdana">*</span></label>
                        <select name="year" id="year" class="form-control">
                            <?php
                                for($i=2017;$i<=date('Y');$i++){
                                    ?>
                                    <option value="<?php echo $i; ?>" <?php echo $i==$year?'selected="selected"':''; ?>><?php echo $i; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <?php
                    if($admin['type']==1){
                        ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Month</label>
                                <select name="month" id="month" class="form-control">
                                    <option value="">All</option>
                                    <?php
                                        for($i=1;$i<=12;$i++){
                                            ?>
                                            <option value="<?php echo $i; ?>" <?php echo $i==$mt?'selected="selected"':''; ?>><?php echo $i; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </form>
		<?php
			if($admin['type']==1){
				?>
				<div class="row">
					<div class="col-md-12">
						<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
					</div>
				</div>
				<?php
			}
            if($admin['type']==2){
                ?>
                <div class="row">
					<div class="col-md-12">
						<div id="monthly_chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
					</div>
				</div>
                <?php
            }
		?>

	</section>
	<!-- /.content -->
</div>

<script type="text/javascript">
    $('#year,#month').change(function(){
        $('#chart_filter_form').submit();
    })
</script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://highcharts.github.io/export-csv/export-csv.js"></script>

<?php
    if($admin['type']==1){
        ?>
<script type="text/javascript">

	Highcharts.chart('container', {
		chart: {
			type: 'column'
		},
		title: {
			text: 'Test/Questions teacher'
		},
		subtitle: {
			text: ''
		},
		xAxis: {
			categories: <?php echo $tname; ?>,
			crosshair: true
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Test/Questions'
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y}</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		credits: {
			enabled: false
		},
		series: [{
				name: 'Tests',
				color: '#001F3F',
				data: <?php echo $tt; ?>
			},
			{
				name: 'Questions',
				color: '#605CA8',
				data: <?php echo $tq; ?>
			}
		]
	});

</script>
<?php } ?>
<?php
    if($admin['type']==2){
        ?>
        <script type="text/javascript">

        	Highcharts.chart('monthly_chart', {
        		chart: {
        			type: 'column'
        		},
        		title: {
        			text: 'Test/Questions'
        		},
        		subtitle: {
        			text: ''
        		},
        		xAxis: {
        			categories: <?php echo $month; ?>,
        			crosshair: true
        		},
        		yAxis: {
        			min: 0,
        			title: {
        				text: 'Test/Questions'
        			}
        		},
        		tooltip: {
        			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
        				'<td style="padding:0"><b>{point.y}</b></td></tr>',
        			footerFormat: '</table>',
        			shared: true,
        			useHTML: true
        		},
        		plotOptions: {
        			column: {
        				pointPadding: 0.2,
        				borderWidth: 0
        			}
        		},
        		credits: {
        			enabled: false
        		},
        		series: [{
        				name: 'Tests',
        				color: '#001F3F',
        				data: <?php echo $tests_count; ?>
        			},
        			{
        				name: 'Questions',
        				color: '#605CA8',
        				data: <?php echo $questions_count; ?>
        			}
        		]
        	});
        
        </script>
        <?php
    }
?>