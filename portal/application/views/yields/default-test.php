<style>
		.modal-xl {
			width: 90%;
			max-width:1200px;
		}
		.modal-footer {
			border-top: 0 none;
		}
</style>
<div class="col-sm-12">
	<div class="white-box">
		<div class="panel panel-info">
			<div class="panel-heading">آزمون پیشفرض</div>
			<div class="panel-wrapper collapse in" aria-expanded="true">
				<div class="panel-body">
					<div class="table-responsive">
						<table id="example26" class="display nowrap" cellspacing="0" width="100%">
							<thead>
							<tr>
								<th class="text-center">کد آزمون</th>
								<th class="text-center">نام پیشفرض</th>
								<th class="text-center">ابزار</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($default_test)):
								foreach ($default_test as $item): ?>
									<tr>
										<td class="text-center"><?= htmlspecialchars($item->default_test_id, ENT_QUOTES); ?></td>
										<td class="text-center"><?= htmlspecialchars($item->test_name, ENT_QUOTES); ?></td>
										<td class="text-center">
											<a href="#" onclick="event.preventDefault();document.getElementById('edit_<?= htmlspecialchars($item->default_test_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="ویرایش"> <i class="mdi mdi-pencil text-info m-r-5"></i> </a>|
											<form class="" id='edit_<?php echo htmlspecialchars($item->default_test_id); ?>' style="display:none" action="<?php echo base_url(); ?>edit-default-test" method="post">
												<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
												<input type="hidden" name="lesson_id" value="<?php echo htmlspecialchars($item->default_test_id, ENT_QUOTES); ?>">
											</form>

											<a href="#" class="m-r-10" data-toggle="modal" data-target="#detail_<?= $item->default_test_id; ?>"><i class="fa fa-close text-danger m-l-5" data-toggle="tooltip" data-original-title="حذف"></i></a>|
											<div id="detail_<?= $item->default_test_id; ?>" class="modal fade bs-example-modal-sm" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog modal-sm">
													<div class="modal-content">
														<div class="modal-header" style="background-color: #edf0f2">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title" id="myModalLabel">حذف آزمون</h4>
														</div>
														<form action="<?php echo base_url('delete-default-test'); ?>" method="post">
															<div class="modal-body">
																<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																<div class="form-group">
																	<input type="hidden" name="lesson_id" value="<?php echo htmlspecialchars($item->default_test_id, ENT_QUOTES); ?>">
																	<p> <?php echo "از حذف آزمون " . $item->test_name . " اطمینان دارید؟" ?></p>
																</div>
															</div>
															<div class="modal-footer">
																<button type="submit" class="btn btn-success" style="width: 50%">بله</button>
																<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal" style="width: 50%">خیر</button>
															</div>
														</form>
													</div>
												</div>
											</div>

											<a href="#" data-toggle="modal" data-target="#del_<?= $item->default_test_id; ?>"><i class="glyphicon glyphicon-equalizer text-inverse  m-l-5" data-toggle="tooltip" data-original-title="اطلاعات آزمون"></i></a>
											<div id="del_<?= $item->default_test_id; ?>" class="modal fade bs-example-modal-sm" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header" style="background-color: #edf0f2">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title" id="myModalLabel">آزمون های <?= $item->test_name; ?></h4>
														</div>
														<form action="<?php echo base_url('training/delete-lesson'); ?>" method="post">
															<div class="modal-body">

																<table  class="table table-bordered table-striped display nowrap" cellspacing="0" width="100%">
																	<?php
																	$test= $item->default_test;
																	$test = json_decode($test);
																	if($this->session->userdata('type_academy') != 1 && !empty($test)):
																		?>
																		<thead>
																		<tr>
																			<th class="text-center">نام آزمون</th>
																			<th class="text-center">بازه نمره</th>
																			<th class="text-center">حد نصاب نمره قبولی</th>
																			<th class="text-center">تاثیر در نمره نهایی(درصد)</th>
																		</tr>
																		</thead>
																		<tbody>
																		<?php if(!empty($test->item_0)):?>
																			<tr>
																				<td class="text-center"><?= htmlspecialchars($test->item_0[0], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_0[1], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_0[2], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_0[3], ENT_QUOTES); ?></td>
																			</tr>
																		<?php endif;
																		if(!empty($test->item_1)):?>
																			<tr>
																				<td class="text-center"><?= htmlspecialchars($test->item_1[0], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_1[1], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_1[2], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_1[3], ENT_QUOTES); ?></td>
																			</tr>
																		<?php endif;
																		if(!empty($test->item_2)):?>
																			<tr>
																				<td class="text-center"><?= htmlspecialchars($test->item_2[0], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_2[1], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_2[2], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_2[3], ENT_QUOTES); ?></td>
																			</tr>
																		<?php endif;
																		if(!empty($test->item_3)):?>
																			<tr>
																				<td class="text-center"><?= htmlspecialchars($test->item_3[0], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_3[1], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_3[2], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_3[3], ENT_QUOTES); ?></td>
																			</tr>
																		<?php endif;
																		if(!empty($test->item_4)):?>
																			<tr>
																				<td class="text-center"><?= htmlspecialchars($test->item_4[0], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_4[1], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_4[2], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_4[3], ENT_QUOTES); ?></td>
																			</tr>
																		<?php endif;
																		if(!empty($test->item_5)):?>
																			<tr>
																				<td class="text-center"><?= htmlspecialchars($test->item_5[0], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_5[1], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_5[2], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_5[3], ENT_QUOTES); ?></td>
																			</tr>
																		<?php endif;
																		if(!empty($test->item_6)):?>
																			<tr>
																				<td class="text-center"><?= htmlspecialchars($test->item_6[0], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_6[1], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_6[2], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_6[3], ENT_QUOTES); ?></td>
																			</tr>
																		<?php endif;
																		if(!empty($test->item_7)):?>
																			<tr>
																				<td class="text-center"><?= htmlspecialchars($test->item_7[0], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_7[1], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_7[2], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_7[3], ENT_QUOTES); ?></td>
																			</tr>
																		<?php endif;
																		if(!empty($test->item_8)):?>
																			<tr>
																				<td class="text-center"><?= htmlspecialchars($test->item_8[0], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_8[1], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_8[2], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_8[3], ENT_QUOTES); ?></td>
																			</tr>
																		<?php endif;
																		if(!empty($test->item_9)):?>
																			<tr>
																				<td class="text-center"><?= htmlspecialchars($test->item_9[0], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_9[1], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_9[2], ENT_QUOTES); ?></td>
																				<td class="text-center"><?= htmlspecialchars($test->item_9[3], ENT_QUOTES); ?></td>
																			</tr>
																		<?php endif; ?>
																		</tbody>
																	<?php endif; ?>
																</table>

															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-info waves-effect" data-dismiss="modal" style="width: 100%">بستن</button>
															</div>
														</form>
													</div>
												</div>
											</div>
										</td>
									</tr>
								<?php
								endforeach;
							endif;
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
<!--				<button type="submit" style="float:left" class="btn btn-success"> <i class="fa fa-check" style="padding-left: 6px"></i>آزمون پیشفرض جدید</button>-->
			<a href="#" data-toggle="modal" data-target="#new" style="float:left" class="btn btn-success"><i class="fa fa-check" style="padding-left: 6px"></i>آزمون پیشفرض جدید</a>
			<div id="new" class="modal fade bs-example-modal-xl" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-xl">
					<div class="modal-content">
						<div class="modal-header" style="background-color: #edf0f2">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel">آزمون جدید</h4>
						</div>
						<form action="<?php echo base_url('insert-default-test'); ?>" method="post">
							<div class="modal-body">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label">نام آزمون پیشفرض</label>
										<input type="text" name="lesson_description" id="lesson_description" class="form-control" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا نام آزمون پیشفرض را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block"></span>
									</div>
								</div>
								<div class="col-md-12">
									<div class="col-md-1">
										<h3 class="box-title">افزودن</h3>
										<hr>
									</div>
									<div class="col-md-5">
										<h3 class="box-title">نوع آزمون</h3>
										<hr>
									</div>
									<div class="col-md-2">
										<h3 class="box-title">بازه نمره</h3>
										<hr>
									</div>
									<div class="col-md-2">
										<h3 class="box-title">نمره حد نصاب قبولی</h3>
										<hr>
									</div>
									<div class="col-md-2">
										<h3 class="box-title">تاثیر در نمره نهایی (درصد)</h3>
										<hr>
									</div>
								</div>

								<div class="col-md-12">
									<div id="education_fields">
									</div>
									<div class="col-md-1">
										<div class="form-group">
											<div class="input-group">
												<div class="input-group-btn">
													<button class="btn btn-success" type="button"  onclick="education_fields();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
												</div>
											</div>
										</div>
										<div class="clear"></div>
									</div>
									<div class="col-md-5">
										<div class="form-group">
											<input type="text" class="form-control" id="test_name" name="test_name[]" value="" placeholder="test_name">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<input type="text" class="form-control" id="range_score" name="range_score[]" value="" placeholder="range_score">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<input type="text" class="form-control" id="quota_score" name="quota_score[]" value="" placeholder="quota_score">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<input type="text" class="form-control" id="percentage" name="percentage[]" value="" placeholder="percentage">
										</div>
										<div class="clear"></div>
									</div>
								</div>
							</div>
							<div class="modal-footer" style="margin-top: 250px">
								<button type="submit" class="btn btn-success" style="width: 48%">ثبت آزمون</button>
								<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal" style="width: 48%">انصراف</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	var room = 1;
	function education_fields() {

		room++;
		var objTo = document.getElementById('education_fields')
		var divtest = document.createElement("div");
		divtest.setAttribute("class", "removeclass"+room);
		var rdiv = 'removeclass'+room;
		divtest.innerHTML =
				'<div class="col-sm-1">' +
				'<div class="form-group">' +
				'<div class="input-group"> ' +
				'<div class="input-group-btn"> ' +
				'<button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ' +
				'</button>' +
				'</div>' +
				'</div>' +
				'</div>' +
				'</div>' +
				'<div class="col-sm-5">' +
				'<div class="form-group"> ' +
				'<input type="text" class="form-control" id="test_name" name="test_name[]" value="" placeholder="test_name">' +
				'</div>' +
				'</div>' +
				'<div class="col-sm-2">' +
				'<div class="form-group"> ' +
				'<input type="text" class="form-control" id="range_score" name="range_score[]" value="" placeholder="range_score">' +
				'</div>' +
				'</div>' +
				'<div class="col-sm-2">' +
				'<div class="form-group"> ' +
				'<input type="text" class="form-control" id="quota_score" name="quota_score[]" value="" placeholder="quota_score">' +
				'</div>' +
				'</div>' +
				'<div class="col-sm-2">' +
				'<div class="form-group">' +
				'<input type="text" class="form-control" id="percentage" name="percentage[]" value="" placeholder="percentage">' +
				'</div>' +
				'</div>' +
				'</div>' +
				'</div>' +
				'<div class="clear"></div>';

		objTo.appendChild(divtest)
	}
	function remove_education_fields(rid) {
		$('.removeclass'+rid).remove();
	}
</script>
