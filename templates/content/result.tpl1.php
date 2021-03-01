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
        						<h3 class="box-title">Result</h3>
								<div class="pull-right">
									<a href="<?php echo SITE_URL; ?>retake.php?t=<?php echo $tid; ?>&act=retake" class="btn btn-primary btn-sm"><i class="fa fa-rotate-left"></i> Retake</a>
								</div>
        					</div>
        					<div class="table-responsive box-body">
                                
                                <table class="table table-striped table-bordered table-hover" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#No</th>
                                            <th>Question</th>
                                            <th>Options</th>
                                            <th>Correct Answer</th>
                                            <th>Your Answer</th>
                                            <th>Result</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $total_que = 0;
                                            $correct = 0;
                                            $wrong = 0;
											$count = 0;
                                            foreach($return as $key=>$val){
                                                $myans = '';
                                                $total_que++;
                                                $cna = array();
                                                ?>
                                                <tr>
                                                    <td><?php echo ++$count; ?></td>
                                                    <td><?php echo $dbins->re_db_output($val['question']); ?></td>
                                                    <td>
                                                        <?php
                                                            foreach($val['options'] as $k=>$v){
                                                                if($answers[$val['id']]==$k){
                                                                    $myans = $dbins->re_db_output($v['option']);
                                                                }
                                                                ?>
                                                                <span class=""><?php echo $dbins->re_db_output($v['option']); ?></span><br />
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        foreach($val['options'] as $k=>$v){
                                                            if($v['is_correct']==1){
                                                                array_push($cna,$k);
                                                                ?>
                                                                <span class="<?php echo $cls; ?>"><?php echo $dbins->re_db_output($v['option']); ?></span><br />
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                    </td>
                                                    <td><?php echo $myans; ?></td>
                                                    <td>
                                                        <?php
                                                            if(in_array($answers[$val['id']],$cna)){
                                                                $correct++;
                                                                ?>
                                                                <span class="badge bg-green"><i class="fa fa-check-square-o"></i> Correct</span>
                                                                <?php
                                                            }
                                                            else{
                                                                $wrong++;
                                                                ?>
                                                                <span class="badge bg-red"><i class="fa fa-times"></i> Wrong</span>
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                
        					</div>
        					<!-- /.box-body -->
        					<div class="box-footer">
                                <button type="button" class="btn btn-primary"><?php echo $correct; ?> Correct answers out of <?php echo $total_que; ?></button>
        					</div>
        					<!-- /.box-footer-->
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
				  //{ 'bSortable': false, 'aTargets': [ -1 ] }
			   ]
		});
		//$('.content-wrapper').attr('style','');
	});
</script>