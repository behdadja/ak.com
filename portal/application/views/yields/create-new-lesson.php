<body>
<div class="col-md-12">
	<div class="white-box">

		<!--.row-->
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"> ثبت درس جدید</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">

							<?php if ($this->session->flashdata('lesson_own_code')): ?>
								<div class="alert alert-danger" role="alert"><?= $this->session->flashdata('lesson_own_code'); ?></div>
							<?php endif; ?>

							<!-- validation errors -->
							<div class="m-b-20">
								<?php if ($this->session->flashdata('validation_errors')): ?>
									<div class="alert alert-danger">خطاهای زیر را بررسی کنید</div>
									<div class="text-danger" style="border-right: #ff7676 thick solid"><ul><?php echo $this->session->flashdata('validation_errors'); ?></ul></div>
								<?php endif; ?>
							</div>
							<!-- /validation errors -->

							<form action="<?php echo base_url(); ?>training/insert-new-lesson" method="post" name="class_register">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
								<div class="form-body">
									<div class="row">
										<div class="col-md-12">
											<h3 class="box-title">اطلاعات درس</h3>
											<hr style="background-color: blue">

											<?php $type_academy = $this->session->userdata('type_academy');
											if($type_academy == 0):
												?>
												<div class="col-md-3">
													<div class="form-group">
														<label class="control-label">دپارتمان</label>
														<select id="dep" class="form-control" name="department">
															<option value="">لطفا انتخاب کنید</option>
															<option value="1">فنی و حرفه ای</option>
															<option value="2">درسی و کنکور</option>
															<option value="3">زبان</option>
															<option value="4">هنر و موسیقی</option>
														</select>
													</div>
												</div>
											<?php endif; ?>


											<div <?php if($type_academy == 0){echo 'class="col-md-3"';}else{echo 'class="col-md-4"';} ?>>
												<div class="form-group">
													<label class="control-label">خوشه</label>
													<?php if($type_academy == 0): ?>
														<select class="form-control" name="cluster">
														</select>
													<?php else: ?>
														<select class="form-control" name="cluster">
															<option value="">لطفا انتخاب کنید</option>
															<?php if(!empty($data)):
																foreach ($data as $cls): ?>
																	<option value="<?= $cls->cluster_id ?>"><?= $cls->cluster_name ?></option>
																<?php endforeach;
															endif;
															?>
														</select>
													<?php endif; ?>
												</div>
											</div>

											<div <?php if($type_academy== 0){echo 'class="col-md-3"';}else{echo 'class="col-md-4"';} ?>>
												<div class="form-group">
													<label class="control-label">نام گروه</label>
													<select class="form-control" name="group">
													</select>
												</div>
											</div>

											<div <?php if($type_academy== 0){echo 'class="col-md-3"';}else{echo 'class="col-md-4"';} ?>>
												<div class="form-group">
													<label class="control-label">نام استاندارد</label>
													<select class="form-control" name="stnd">
													</select>
												</div>
											</div>


											<div class="col-md-4">
												<div class="form-group">
													<label class="text-danger ">نام درس</label>
													<input type="text" name="lesson_name" id="lesson_name" class="form-control" required> <span class="help-block" onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا نام درس را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">مثال : مهارت های هفت گانه ICDL</span>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">توضیحات</label>
													<input type="text" name="lesson_description" id="lesson_description" class="form-control" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا توضیحات درس را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block">مثال: آموزش ویندوز، Word، PowerPoint و ...</span>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">کد اختصاصی درس</label>
													<input type="text" name="lesson_own_code" id="lesson_own_code" class="form-control" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا کد اختصاصی درس را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
												</div>
											</div>
										</div>

										<?php if($this->session->userdata('type_academy') != 1): ?>

											<div id="test">

												<div class="col-md-12" style="margin-top: 3%">
													<h3 class="box-title">اطلاعات آزمون </h3>
													<hr style="background-color: blue;border-width: 1px">

													<div class="col-md-1">
														<h3 class="box-title">ابزار</h3>
														<hr>
													</div>
													<div class="col-md-2">
														<h3 class="box-title">نوع آزمون</h3>
														<hr>
													</div>
													<div class="col-md-3">
														<h3 class="box-title">نمره آزمون این درس از چند محاسبه می شود؟</h3>
														<hr>
													</div>
													<div class="col-md-3">
														<h3 class="box-title">نمره حد نصاب قبولی در آزمون</h3>
														<hr>
													</div>
													<div class="col-md-3">
														<h3 class="box-title">تاثیر در نمره نهایی (درصد)</h3>
														<hr>
													</div>
												</div>

													<div id="input_fields_wrap">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button id="add_field_button" class="btn btn-success">افزودن</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name" name="test_name[]" value="" placeholder="کتبی">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score" name="range_score[]" value="" placeholder="">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score" name="quota_score[]" value="" placeholder="">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage" name="percentage[]" value="" placeholder="">
															</div>
														</div>
													</div>

										<?php endif; ?>

									</div>
									<!--/row-->
									<div class="col-md-12">
										<div class="form-actions">
											<button type="submit" style="float:left" class="btn btn-success"> <i class="fa fa-check" style="padding-left: 6px"></i>ثبت درس</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--./row-->
	</div>
</div>

<script>
	$(document).ready(function() {
		var max_fields      = 10; //maximum input boxes allowed
		var wrapper   		= $("#input_fields_wrap"); //Fields wrapper
		var add_button      = $("#add_field_button"); //Add button ID

		var x = 1; //initlal text box count
		$(add_button).click(function(e){ //on add input button click
			e.preventDefault();
			if(x < max_fields){ //max input box allowed
				x++; //text box increment
				$(wrapper).append('<div id="fields">' +
						'<div class="col-md-1">' +
						'<div class="form-group">' +
						'<div class="input-group">' +
						'<div class="input-group-btn">' +
						'<button id="remove_field" class="btn btn-danger">حذف</button>' +
						'</div>' +
						'</div>' +
						'</div>' +
						'</div>' +
						'<div class="col-md-2">' +
						'<div class="form-group">' +
						'<input type="text" class="form-control" id="test_name" name="test_name[]" value="" placeholder="کتبی">' +
						'</div>' +
						'</div>' +
						'<div class="col-md-3">' +
						'<div class="form-group">' +
						'<input type="text" class="form-control" id="range_score" name="range_score[]" value="" placeholder="">' +
						'</div>' +
						'</div>' +
						'<div class="col-md-3">' +
						'<div class="form-group">' +
						'<input type="text" class="form-control" id="quota_score" name="quota_score[]" value="" placeholder="">' +
						'</div>' +
						'</div>' +
						'<div class="col-md-3">' +
						'<div class="form-group">' +
						'<input type="text" class="form-control" id="percentage" name="percentage[]" value="" placeholder="">' +
						'</div>' +
						'</div>' +
						'</div>'); //add input box
			}
		});

		$(wrapper).on("click","#remove_field", function(e){ //user click on remove text
			e.preventDefault(); $('#fields').remove(); x--;
		})
	});
</script>
