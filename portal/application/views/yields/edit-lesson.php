<div class="col-md-12">
	<div class="white-box">

		<!--.row-->
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading">ویرایش درس با کد داخلی : <?php
						if (!empty($lesson_info)) {
							echo htmlspecialchars($lesson_info[0]->lesson_id, ENT_QUOTES);
						}
						?> و کد اختصاصی : <?php
						if (!empty($lesson_info)) {
							echo htmlspecialchars($lesson_info[0]->lesson_own_code, ENT_QUOTES);
						}
						?></div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">

							<?php if ($this->session->flashdata('error-own-code')) : ?>
								<div class="alert alert-danger"><?php echo $this->session->flashdata('error-own-code'); ?></div>
							<?php endif; ?>

							<!-- error inputs -->
							<div class="m-b-20">
								<?php if (validation_errors()): ?>
									<div class="alert alert-danger">خطاهای زیر را بررسی کنید</div>
									<div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('stnd'); ?></div>
									<div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('lesson_name'); ?></div>
									<div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('lesson_description'); ?></div>
									<div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('lesson_own_code'); ?></div>
								<?php endif; ?>
							</div>
							<!-- /error inputs -->

							<form action="<?php echo base_url(); ?>training/update-lesson" method="post" name="class_register">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
								<input type="hidden" name="lesson_id" value="<?php echo htmlspecialchars($lesson_info[0]->lesson_id, ENT_QUOTES); ?>">
								<div class="form-body">
									<div class="row">
										<div class="col-md-12">
											<h3 class="box-title">اطلاعات درس</h3>
											<hr style="background-color: blue">
											<div class="col-md-4">
												<div class="form-group">
													<label class="text-danger ">نام درس</label>
													<input type="text" name="lesson_name" id="lesson_name" class="form-control" value="<?= htmlspecialchars($lesson_info[0]->lesson_name, ENT_QUOTES); ?>"required>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">توضیحات</label>
													<input type="text" name="lesson_description" id="lesson_description" class="form-control" value="<?= htmlspecialchars($lesson_info[0]->lesson_description, ENT_QUOTES); ?>"required>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">کد اختصاصی درس</label>
													<input type="text" name="lesson_own_code" id="lesson_own_code" class="form-control" value="<?= htmlspecialchars($lesson_info[0]->lesson_own_code, ENT_QUOTES); ?>"required>
												</div>
											</div>
										</div>
										<div class="col-md-12" style="margin-top: 3%">
											<h3 class="box-title">اطلاعات آزمون (
												<?php if($lesson_info[0]->type_academy  == 3 && empty($lesson_info[0]->test)):?>
													<span class="text-danger">گرفته شده از آزمون های پیش فرض</span>
												<?php else:
													if(! empty($lesson_info[0]->test)):?>
														<span class="text-danger">وارد شده توسط کاربر</span>
													<?php else: ?>
														<span class="text-danger">آزمونی ثبت نشده است</span>
													<?php endif;
												endif;?>
												) </h3>
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
												<!--												<div id="education_fields">-->
												<!--													</div>-->
												<!--													<div class="col-md-1">-->
												<!--														<div class="form-group">-->
												<!--															<div class="input-group">-->
												<!--																<div class="input-group-btn">-->
												<!--																	<button class="btn btn-success" type="button" id="btn-add"  onclick="education_fields();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>-->
												<!--																</div>-->
												<!--															</div>-->
												<!--														</div>-->
												<!--														<div class="clear"></div>-->
												<!--													</div>-->
												<!--													<div class="col-md-2">-->
												<!--														<div class="form-group">-->
												<!--															<input type="text" class="form-control" id="test_name" name="test_name[]" value="" placeholder="کتبی">-->
												<!--														</div>-->
												<!--													</div>-->
												<!--													<div class="col-md-3">-->
												<!--														<div class="form-group">-->
												<!--															<input type="text" class="form-control" id="range_score" name="range_score[]" value="" placeholder="">-->
												<!--														</div>-->
												<!--													</div>-->
												<!--													<div class="col-md-3">-->
												<!--														<div class="form-group">-->
												<!--															<input type="text" class="form-control" id="quota_score" name="quota_score[]" value="" placeholder="">-->
												<!--														</div>-->
												<!--													</div>-->
												<!--													<div class="col-md-3">-->
												<!--														<div class="form-group">-->
												<!--															<input type="text" class="form-control" id="percentage" name="percentage[]" value="" placeholder="">-->
												<!--														</div>-->
												<!--														<div class="clear"></div>-->
												<!--													</div>-->
												<!--												</div>-->


											<script>
													var x = 1;
													var max_fields      = 10; //maximum input boxes allowed
													// var wrapper   		= $("#input_fields_wrap"); //Fields wrapper
													// var add_button      = $("#add_field_button"); //Add button ID
											</script>

											<?php
											if ($lesson_info[0]->type_academy != 1):
												if ($lesson_info[0]->type_academy == 3 && empty($lesson_info[0]->test)):
												if (!empty($default_test)):
												foreach ($default_test as $df_test):
												if ($df_test->default_test_id == '2'):
													$test = $df_test->default_test;
													$test = json_decode($test); ?>

													<?php if (!empty($test->item_0)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="input_fields_wrap">
														<div class="col-md-1">

														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_0[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_0[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_0[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_0[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_1)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field1">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field1').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_1[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_1[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_1[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_1[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_2)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field2">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field2').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_2[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_2[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_2[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_2[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_3)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field3">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field3').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_3[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_3[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_3[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_3[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_4)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field4">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field4').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_4[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_4[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_4[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_4[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_5)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field5">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field5').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_5[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_5[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_5[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_5[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_6)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field6">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field6').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_6[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_6[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_6[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_6[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_7)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field7">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field7').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_7[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_7[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_7[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_7[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_8)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field8">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field8').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_8[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_8[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_8[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_8[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_9)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field9">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field9').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_9[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_9[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_9[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_9[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<? endif;
												endforeach;
												endif;
												else:
												$test = $lesson_info[0]->test;
												if (!empty($test)):
												$test = json_decode($test); ?>
												<?php if (!empty($test->item_0)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="input_fields_wrap">
														<div class="col-md-1">

														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_0[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_0[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_0[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_0[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_1)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field1">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field1').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_1[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_1[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_1[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_1[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_2)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field2">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field2').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_2[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_2[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_2[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_2[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_3)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field3">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field3').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_3[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_3[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_3[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_3[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_4)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field4">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field4').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_4[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_4[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_4[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_4[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_5)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field5">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field5').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_5[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_5[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_5[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_5[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_6)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field6">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field6').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_6[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_6[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_6[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_6[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_7)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field7">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field7').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_7[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_7[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_7[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_7[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_8)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field8">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field8').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_8[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_8[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_8[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_8[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												?>
												<?php if (!empty($test->item_9)): ?>
													<script>
														if (x < max_fields) {
															x++;
														}
													</script>
													<div id="field9">
														<div class="col-md-1">
															<div class="form-group">
																<div class="input-group">
																	<div class="input-group-btn">
																		<button onclick="document.getElementById('field9').remove();x--"
																				class="btn btn-danger">حذف
																		</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="text" class="form-control" id="test_name"
																	   name="test_name[]"
																	   value="<?= htmlspecialchars($test->item_9[0], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="range_score"
																	   name="range_score[]"
																	   value="<?= htmlspecialchars($test->item_9[1], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="quota_score"
																	   name="quota_score[]"
																	   value="<?= htmlspecialchars($test->item_9[2], ENT_QUOTES); ?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" class="form-control" id="percentage"
																	   name="percentage[]"
																	   value="<?= htmlspecialchars($test->item_9[3], ENT_QUOTES); ?>">
															</div>
														</div>
													</div>
												<?php endif;
												else:?>
													<div id="input_fields_wrap">
														<div class="col-md-1">

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
												<?php endif;
												endif;
											endif; ?>
											<script>
												if (x < 10) {
											</script>
											<div class="col-md-12">
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-btn">
															<button id="add_field_button"
																	class="btn btn-info" style="width: 30%">افزودن آزمون
															</button>
														</div>
													</div>
												</div>
											</div>
											<script>
												}
											</script>

										</div>
										<!--/row-->
										<div class="col-md-12">
											<div class="form-actions">
												<button type="submit" style="float:left" class="btn btn-success"> <i class="fa fa-check"></i>ویرایش</button>
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
		// var max_fields      = 10; //maximum input boxes allowed
		var wrapper   		= $("#input_fields_wrap"); //Fields wrapper
		var add_button      = $("#add_field_button"); //Add button ID

		// var x = 1; //initlal text box count
		$(add_button).click(function(e){ //on add input button click
			e.preventDefault();
			if(x < max_fields){//max input box allowed
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
