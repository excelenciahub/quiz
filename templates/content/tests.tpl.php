<!-- DataTables -->
<link rel="stylesheet" href="<?php echo SITE_PLUGINS; ?>datatables/dataTables.bootstrap.min.css" />
<script src="<?php echo SITE_PLUGINS; ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo SITE_PLUGINS; ?>datatables/dataTables.bootstrap.min.js"></script>
<!-- Full Width Column -->
<div class="content-wrapper">
	<div class="container result-container">
		
		<!-- Main content -->
		<section class="content">
            <div class="row">
                <div class="col-sm-12">
                
                        <!-- Default box -->
        				<div class="box box-info">
        					<div class="box-header with-border">
        						<h3 class="box-title">Tests</h3>
								<!--
                                <div class="pull-right social-sharing-square sharing">
                                    Share Page: 
                                    <?php
                                        $url = SITE_URL.'tests.php?t='.$tid;
                                        $test_title = $dbins->re_db_output($metatitle);
                                    ?>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                                    <a href="https://twitter.com/home?status=<?php echo $url; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                                    <a href="https://plus.google.com/share?url=<?php echo $url; ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php echo $test_title; ?> - kwizards&summary=&source=" target="_blank"><i class="fa fa-linkedin"></i></a>
                                </div>
								-->
        					</div>
        					<div class="table-responsive box-body">
                                
                                <table class="table table-striped table-bordered table-hover" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#No</th>
                                            <th>Test Name</th>
                                            <th>Action</th>
                                            <th class="text-center">Share</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
											$count = 0;
                                            foreach($return as $key=>$val){
                                                ?>
                                                <tr>
                                                    <td><?php echo ++$count; ?></td>
                                                    <td><?php echo $dbins->re_db_output($val['test_name']); ?></td>
                                                    <td><a href="<?php echo SITE_URL; ?>quiz.php?t=<?php echo $val['id']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-sign-in"></i> Start Test</a></td>
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
                                                </tr>
                                                <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                
        					</div>
        					<!-- /.box-body -->
        				</div>
        				<!-- /.box -->
                            
                </div>
            </div>
			
		</section>
		<!-- /.content -->
	</div>
	<!-- /.container -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
	$(document).ready(function(){
		$("#data-table").DataTable({
			  "aoColumnDefs": [
				  { 'bSortable': false, 'aTargets': [ -1 ] }
			   ]
		});
	});
</script>