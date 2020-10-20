<div class="col-sm-12">
	<div class="white-box">
		<div class="table-responsive">


			<?php if ($this->session->flashdata('success-insert-st')) : ?>
				<div class="alert alert-success"><?php echo $this->session->flashdata('success-insert-st'); ?></div>
			<?php endif; ?>
			<table id="example23" class="display nowrap" cellspacing="0" width="100%">
				<thead>
				<tr>

					<th>نام و نام خانوادگی</th>

					<th>ابزار</th>
				</tr>
				</thead>
				<tfoot>
				<tr>

					<th>نام و نام خانوادگی</th>


					<th>ابزار</th>
				</tr>
				</tfoot>
				<tbody>
				<?php if ($employers_info): ?>
					<?php foreach ($employers_info as $employee): ?>
						<tr>
							<td>
								<img src="<?php echo base_url();?>assets/profile-picture/thumb/<?php echo htmlspecialchars($employee['pic_name'], ENT_QUOTES)?>" height="32" alt="user" class="img-circle">
								<?php echo htmlspecialchars($employee['first_name'].' '.$employee['last_name'], ENT_QUOTES);?>
							</td>
							<td class="text-nowrap">
								<div id="myModal_em_<?php echo htmlspecialchars($employee['employee_id'], ENT_QUOTES);?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h4 class="modal-title" id="myModalLabel">متن پیغام را وارد نمایید</h4> </div>
											<div class="modal-body">
												<form class="" id='send_st_<?php echo htmlspecialchars($employee['employee_id']);?>' action="<?php echo base_url(); ?>student/tickets/sending-employee" method="post">
													<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
													<input type="hidden" name="employee_nc" value="<?php echo htmlspecialchars($employee['national_code'], ENT_QUOTES);?>">
													<div class="form-group">
														<textarea name="ticket_body" class="form-control" rows="4" cols="50" required=""></textarea>
													</div>
													<div class="form-group">
														<button type="submit" class="form-control btn btn-success">ارسال</button>
													</div>
												</form>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-info waves-effect" data-dismiss="modal">بستن</button>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->

								</div>

								<button alt="default" data-toggle="modal" data-target="#myModal_em_<?php echo htmlspecialchars($employee['employee_id'], ENT_QUOTES);?>" data-original-title="ارسال"> <i class="mdi mdi-comment-check-outline text-inverse m-r-10"></i> </button>


							</td>
						</tr>
					<?php endforeach; endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
