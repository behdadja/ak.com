<?= 'sfsergfsrfgsr' ?>
<!---->
<!--<style>-->
<!--	* {-->
<!--		box-sizing: border-box;-->
<!--	}-->
<!--	#regForm {-->
<!--		background-color: #ffffff;-->
<!--		margin: auto;-->
<!--		width: 85%;-->
<!--		min-width: 300px;-->
<!--	}-->
<!--	/* Mark input boxes that gets an error on validation: */-->
<!--	input.invalid {-->
<!--		background-color: #ffdddd;-->
<!--	}-->
<!--	/* Hide all steps by default: */-->
<!--	.tab {-->
<!--		display: none;-->
<!--	}-->
<!--	button {-->
<!--		background-color: #4CAF50;-->
<!--		color: #ffffff;-->
<!--		border: none;-->
<!--		padding: 10px 20px;-->
<!--		cursor: pointer;-->
<!--	}-->
<!---->
<!--	button:hover {-->
<!--		opacity: 0.8;-->
<!--	}-->
<!---->
<!--	#prevBtn {-->
<!--		background-color: #bbbbbb;-->
<!--	}-->
<!---->
<!--	/* Make circles that indicate the steps of the form: */-->
<!--	.step {-->
<!--		height: 15px;-->
<!--		width: 15px;-->
<!--		margin: 0 2px;-->
<!--		background-color: #bbbbbb;-->
<!--		border: none;-->
<!--		border-radius: 50%;-->
<!--		display: inline-block;-->
<!--		opacity: 0.5;-->
<!--	}-->
<!---->
<!--	.step.active {-->
<!--		opacity: 1;-->
<!--	}-->
<!---->
<!--	/* Mark the steps that are finished and valid: */-->
<!--	.step.finish {-->
<!--		background-color: #4CAF50;-->
<!--	}-->
<!---->
<!--	#radioBtn .notActive{-->
<!--		color: #3276b1;-->
<!--		background-color: #fff;-->
<!--	}-->
<!--</style>-->
<!---->
<!---->
<!--<form id="regForm" action="--><?//= base_url('test-insert'); ?><!--" method="post" enctype="multipart/form-data" name="course_register">-->
<!---->
<!--		<div class="row">-->
<!--			<div class="col-md-12">-->
<!--				<div class="panel panel-info">-->
<!--					<div class="panel-wrapper collapse in" aria-expanded="true">-->
<!--						<div class="panel-body">-->
<!---->
<!--							<!--******************************************* Errors *******************************************-->-->
<!--							--><?php //if (validation_errors()): ?>
<!--								<div class="m-b-20">-->
<!--									<div class="alert alert-danger">خطاهای زیر را بررسی کنید</div>-->
<!--									<div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid">--><?php //echo form_error('course_name'); ?><!--</div>-->
<!--									<div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid">--><?php //echo form_error('employee_id'); ?><!--</div>-->
<!--									<div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid">--><?php //echo form_error('course_duration'); ?><!--</div>-->
<!--									<div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid">--><?php //echo form_error('time_meeting'); ?><!--</div>-->
<!--									<div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid">--><?php //echo form_error('start_date'); ?><!--</div>-->
<!--								</div>-->
<!--							--><?php //endif; ?>
<!--							<!--*******************************************-->-->
<!--							--><?php
//							if (!empty($this->session->flashdata('var'))) :
//								$all_var = $this->session->flashdata('var');
//								?>
<!--								<div class="m-b-20">-->
<!--									--><?php //foreach ($all_var as $var): ?>
<!--										<div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid">--><?php //echo $var['error']; ?><!--</div>-->
<!--									--><?php //endforeach; ?>
<!--								</div>-->
<!--							--><?php //endif; ?>
<!--							<!--*******************************************-->-->
<!--							--><?php //if ($this->session->flashdata('upload-msg')) : ?>
<!--								<div class="alert alert-danger">--><?php //echo $this->session->flashdata('upload-msg'); ?><!--</div>-->
<!--							--><?php //endif; ?>
<!--							--><?php //if ($this->session->flashdata('start-date')) : ?>
<!--								<div class="alert alert-danger">--><?php //echo $this->session->flashdata('start-date'); ?><!--</div>-->
<!--							--><?php //endif; ?>
<!--							--><?php //if ($this->session->flashdata('empty_clock_error')) : ?>
<!--								<div class="alert alert-danger">--><?php //echo $this->session->flashdata('empty_clock_error'); ?><!--</div>-->
<!--							--><?php //endif; ?>
<!--							<!--*******************************************-->-->
<!--							--><?php
//							$classError = $this->session->flashdata('classError');
//							if (!empty($classError)):
//								?>
<!--								<div class="alert alert-danger">-->
<!--									--><?//= 'تداخل زمانی با کلاس انتخاب شده'; ?>
<!--									<a href="" style="color: black;border-radius: 50px" class="btn btn-warning" data-toggle="modal" data-target="#class"> جزئیات ...</a>-->
<!--								</div>-->
<!--								<!-- modal -->-->
<!--								<div id="class" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">-->
<!--									<div class="modal-dialog">-->
<!--										<div class="modal-content text-center">-->
<!--											<div class="modal-header" style="background-color: #edf0f2">-->
<!--												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<!--												<h4 class="modal-title" id="myModalLabel">تداخل زمانی با کلاس انتخاب شده </h4>-->
<!--											</div>-->
<!--											<div class="modal-body">--><?php
//												for ($j = 0; $j < sizeof($classError); $j++) {
//													echo $classError[$j]['class'] . '<br>';
//												}
//												?>
<!--											</div>-->
<!--											<div class="modal-footer">-->
<!--												<button type="button" class="btn btn-info" style="width: 100%" data-dismiss="modal">بستن</button>-->
<!--											</div>-->
<!--										</div>-->
<!--									</div>-->
<!--								</div>-->
<!--								<!-- / modal -->-->
<!--							--><?php
//							endif;
//							$teacherError = $this->session->flashdata('thrError');
//							if (!empty($teacherError)):
//								?>
<!--								<div class="alert alert-danger">-->
<!--									--><?//= 'تداخل زمانی با استاد انتخاب شده'; ?>
<!--									<a href="" style="color: black;border-radius: 50px" class="btn btn-warning" data-toggle="modal" data-target="#teacher"> جزئیات ...</a>-->
<!--								</div>-->
<!--								<!-- modal -->-->
<!--								<div id="teacher" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">-->
<!--									<div class="modal-dialog">-->
<!--										<div class="modal-content text-center">-->
<!--											<div class="modal-header" style="background-color: #edf0f2">-->
<!--												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<!--												<h4 class="modal-title" id="myModalLabel">تداخل زمانی با استاد انتخاب شده </h4>-->
<!--											</div>-->
<!--											<div class="modal-body">--><?php
//												for ($i = 0; $i < sizeof($teacherError); $i++) {
//													echo $teacherError[$i]['teacher'] . '<br>';
//												}
//												?>
<!--											</div>-->
<!--											<div class="modal-footer">-->
<!--												<button type="button" class="btn btn-info" style="width: 100%" data-dismiss="modal">بستن</button>-->
<!--											</div>-->
<!--										</div>-->
<!--									</div>-->
<!--								</div>-->
<!--								<!-- / modal -->-->
<!--							--><?php //endif; ?>
<!--							<!--******************************************* /End Errors *******************************************-->-->
<!---->
<!--							<input type="hidden" name="--><?php //echo $this->security->get_csrf_token_name(); ?><!--" value="--><?php //echo $this->security->get_csrf_hash(); ?><!--" />-->
<!--							<div class="form-body">-->
<!--								<h3 class="box-title">مرحله  1 : مشخصات دوره</h3>-->
<!--								<hr>-->
<!--								<div class="row">-->
<!--									<div class="col-md-3">-->
<!--										<div class="form-group">-->
<!--											<label for="course_name" class="control-label">نام درس</label>-->
<!--											<select name="course_name" id="course_name" class="form-control" >-->
<!--												--><?php //if (!empty($lessons)): ?>
<!--													--><?php //foreach ($lessons as $lesson): ?>
<!--														<option value="--><?php //echo htmlspecialchars($lesson->lesson_id, ENT_QUOTES); ?><!--">--><?php //echo htmlspecialchars($lesson->lesson_name, ENT_QUOTES); ?><!--</option>-->
<!--													--><?php
//													endforeach;
//												endif;
//												?>
<!--											</select>-->
<!--										</div>-->
<!--									</div>-->
<!--									<!--/span-->-->
<!--									<div class="col-md-3">-->
<!--										<div class="form-group">-->
<!--											<label for="employee_id" class="control-label">نام --><?php //echo $this->session->userdata('teacherDName'); ?><!--</label>-->
<!--											<select name="employee_id" id="employee_name" class="form-control" >-->
<!--												--><?php //if (!empty($employers)): ?>
<!--													--><?php //foreach ($employers as $employee): ?>
<!--														<option value="--><?php //echo htmlspecialchars($employee->employee_id, ENT_QUOTES); ?><!--">--><?php //echo htmlspecialchars($employee->first_name, ENT_QUOTES) . ' ' . htmlspecialchars($employee->last_name, ENT_QUOTES); ?><!--</option>-->
<!--													--><?php
//													endforeach;
//												endif;
//												?>
<!--											</select>-->
<!--										</div>-->
<!--									</div>-->
<!--									<!--/span-->-->
<!--									<div class="col-md-3">-->
<!--										<div class="form-group">-->
<!--											<label class="control-label">مدت زمان دوره (ساعت)</label>-->
<!--											<input type="number" name="course_duration" id="course_duration" class="form-control" placeholder="35" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا مدت زمان دوره را وارد کنید')" onchange="try {-->
<!--                                                        setCustomValidity('');-->
<!--                                                    } catch (e) {-->
<!--                                                    }">-->
<!--										</div>-->
<!--									</div>-->
<!--									<!--/span-->-->
<!--									<div class="col-md-3">-->
<!--										<div class="form-group">-->
<!--											<label class="control-label">زمان هر جلسه(دقیقه)</label>-->
<!--											<input type="number" name="time_meeting" id="time_meeting" class="form-control" placeholder="90" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا زمان هر جلسه را وارد کنید')" onchange="try {-->
<!--                                                        setCustomValidity('');-->
<!--                                                    } catch (e) {-->
<!--                                                    }">-->
<!--										</div>-->
<!--									</div>-->
<!--									<!--/span-->-->
<!--									<div class="col-md-3">-->
<!--										<div class="form-group">-->
<!--											<label for="class_id" class="control-label">نام کلاس</label>-->
<!--											<select name="class_id" id="course_name" class="form-control" >-->
<!--												--><?php //if (!empty($classes)): ?>
<!--													--><?php //foreach ($classes as $class): ?>
<!--														<option value="--><?php //echo htmlspecialchars($class->class_id, ENT_QUOTES); ?><!--">--><?php //echo htmlspecialchars($class->class_name, ENT_QUOTES); ?><!--</option>-->
<!--													--><?php
//													endforeach;
//												endif;
//												?>
<!--											</select>-->
<!--										</div>-->
<!--									</div>-->
<!--									<!--/span-->-->
<!--									<div class="col-md-3">-->
<!--										<label class="control-label">تاریخ شروع دوره : </label>-->
<!--										<input type="text" name='start_date' class="auto-close-example form-control" onkeyup="-->
<!--                                                var date = this.value;-->
<!--                                                if (date.match(/^\d{4}$/) !== null) {-->
<!--                                                    this.value = date + '-';-->
<!--                                                } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {-->
<!--                                                    this.value = date + '-';-->
<!--                                                }" maxlength="10"/>-->
<!---->
<!--										<!--<input type="text" name='start_date' id="start_date" class="start-date form-control" />-->-->
<!--									</div>-->
<!--									<!--/span-->-->
<!--									<div class="col-md-3">-->
<!--										<div class="form-group">-->
<!--											<label class="control-label">ظرفیت پذیرش --><?php //echo $this->session->userdata('studentDName'); ?><!--</label>-->
<!--											<input type="number" id="capacity" name="capacity" class="form-control" placeholder="25" value="" onkeyup='saveValue(this);'> <span class="help-block"></span>-->
<!--										</div>-->
<!--									</div>-->
<!--									<!--/span-->-->
<!--									<div class="col-md-3">-->
<!--										<div class="form-group">-->
<!--											<label for="happy" class="control-label">نوع برگزاری</label>-->
<!---->
<!--											<div class="input-group">-->
<!--												<div id="radioBtn" class="btn-group">-->
<!--													<a class="btn btn-info btn-md notActive" data-toggle="gender" data-title="1">آقایان</a>-->
<!--													<a class="btn btn-info btn-md active" data-toggle="gender" data-title="0">مختلط</a>-->
<!--													<a class="btn btn-info btn-md notActive" data-toggle="gender" data-title="2">بانوان</a>-->
<!--												</div>-->
<!--												<input type="hidden" name="type_gender" id="gender" value="0">-->
<!--											</div>-->
<!--										</div>-->
<!--									</div>-->
<!--									<!--/span-->-->
<!--								</div>-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->
<!--				<!--./row-->-->
<!--			</div>-->
<!--		</div>-->
<!---->
<!--		<div class="panel panel-info">-->
<!--			<div class="panel-wrapper collapse in" aria-expanded="true">-->
<!--				<div class="panel-body">-->
<!--					<h3 class="box-title">مرحله  2 : شهریه و دستمزد دوره</h3>-->
<!--					<hr>-->
<!--					<div class="row">-->
<!--						<div class="col-md-12">-->
<!--							<div class="col-md-3">-->
<!--								<div class="form-group">-->
<!--									<h3 for="happy" class="control-label">نوع دوره</h3>-->
<!--									<div class="input-group">-->
<!--										<div id="radioBtn" class="btn-group">-->
<!--											<a id="btn1" class="btn btn-info btn-md active" data-toggle="happy" data-title="0">عمومی</a>-->
<!--											<a id="btn2" class="btn btn-info btn-md notActive" data-toggle="happy" data-title="1">خصوصی</a>-->
<!--										</div>-->
<!--										<input type="hidden" name="type_course" id="happy" value="0">-->
<!--									</div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<!--/span-->-->
<!--							<div class="col-md-3">-->
<!--								<div class="form-group">-->
<!--									<h3 for="type-of-class-holding" class="control-label">نوع برگزاری کلاس</h3>-->
<!--									<div class="input-group">-->
<!--										<div id="radioBtn" class="btn-group">-->
<!--											<a id="hold-btn1" class="btn btn-info btn-md active" data-toggle="type-of-class-holding" data-title="0">حضوری</a>-->
<!--											<a id="hold-btn2" class="btn btn-info btn-md notActive" data-toggle="type-of-class-holding" data-title="1">آنلاین</a>-->
<!--										</div>-->
<!--										<input type="hidden" name="type_holding" id="type-of-class-holding" value="0">-->
<!--									</div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<!--/span-->-->
<!--							<div class="col-md-3">-->
<!--								<div class="form-group">-->
<!--									<h3 class="control-label">نوع دستمزد --><?php //echo $this->session->userdata('teacherDName'); ?><!--</h3>-->
<!--									<div class="input-group">-->
<!--										<div id="radioBtn" class="btn-group">-->
<!--											<a id="ba1" class="btn btn-info btn-md active" data-toggle="fun" data-title="0">درصدی</a>-->
<!--											<a id="ba2" class="btn btn-info btn-md notActive" data-toggle="fun" data-title="1">ساعتی</a>-->
<!--											<a id="ba3" class="btn btn-info btn-md notActive" data-toggle="fun" data-title="2">ماهیانه</a>-->
<!--										</div>-->
<!--										<input type="hidden" name="type_pay" id="fun" value="0">-->
<!--									</div>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div class="col-md-3">-->
<!--								<div id='am' class="form-group">-->
<!--									<h3 for="value_pay">درصد / مبلغ هر ساعت:</h3>-->
<!--									<div class="radio-list">-->
<!--										<input type="number" name="value_pay" class="form-control" placeholder=""  onkeyup='saveValue(this);'>-->
<!--									</div>-->
<!--								</div>-->
<!--							</div>-->
<!--						</div>-->
<!--						<!--/span-->-->
<!--						<!--عمومی -->-->
<!--						<div id="tuition2" class="col-md-12">-->
<!--							<div class="form-group">-->
<!--								<h3 class="control-label" for="">شهریه دوره (تومان)</h3>-->
<!--								<input type="number" name="course_tuition" id="course_tuition" class="form-control" placeholder="480000" onkeyup='saveValue(this);'>-->
<!--							</div>-->
<!--						</div>-->
<!--						<!--/span-->-->
<!--						<!--خصوصی -->-->
<!--						<div id="tuition1" class="col-md-12">-->
<!--							<h3 for="type_pay">نوع شهریه --><?php //echo $this->session->userdata('studentDName'); ?><!--</h3>-->
<!--							<div class="col-md-6">-->
<!--								<div class="input-group">-->
<!--                                    <span class="input-group-addon">-->
<!--                                        <label class="control-label">ساعتی</label>-->
<!--                                        <input type="radio" id='s1' name='type_tuition' value="0" class="control-label" data-color="#6164c1" data-size="small" checked />-->
<!--                                    </span>-->
<!--									<input type="number" id='t1' name="value_tuition_clock" class="form-control" placeholder="12000" onkeyup='saveValue(this);'>-->
<!--								</div>-->
<!--							</div>-->
<!--							<div class="col-md-6" style="margin-bottom: 20px">-->
<!--								<div class="input-group">-->
<!--                                    <span class="input-group-addon">-->
<!--                                        <label class="control-label">دوره ای</label>-->
<!--                                        <input type="radio" id='s2' name='type_tuition' value="1" class="control-label" data-color="#6164c1" data-size="small" />-->
<!--                                    </span>-->
<!--									<input type="number" id='t2' name="value_tuition_course"  class="form-control" placeholder="560000" disabled>-->
<!--								</div>-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		<!--./row-->-->
<!---->
<!--		<div class="panel panel-info">-->
<!--			<div class="panel-wrapper collapse in" aria-expanded="true">-->
<!--				<div class="panel-body">-->
<!--					<h3 class="box-title">مرحله  3 :توضیحات، تصویر و زمان برگزاری</h3>-->
<!--					<hr>-->
<!--					<div class="row text-center">-->
<!--						<div class="col-md-12">-->
<!--							<div class="col-md-1 form-group" style="margin: 0; padding: 0">-->
<!--								<label class="control-label">شنبه</label>-->
<!--								<input type="checkbox" id='sat_check' name='sat_check' class="js-switch form-control" data-color="#6164c1" data-size="small" autocomplete="off"/>-->
<!--								<div class="input-append">-->
<!--									<input type="text" maxlength="5" disabled id='sat_clock' class="form-control add-on" name="sat_clock" placeholder="13:00" value="">-->
<!--								</div>-->
<!--							</div>-->
<!--							<div class="col-md-2 form-group">-->
<!--								<label class="control-label">یکشنبه</label>-->
<!--								<input type="checkbox" id='sun_check' name='sun_check' class="js-switch form-control" data-color="#6164c1" data-size="small" autocomplete="off"/>-->
<!--								<div class="input-append">-->
<!--									<input type="text" maxlength="5" disabled id='sun_clock' class="form-control add-on" name="sun_clock" placeholder="13:00" value="">-->
<!--								</div>-->
<!--							</div>-->
<!--							<div class="col-md-2 form-group">-->
<!--								<label class="control-label">دوشنبه</label>-->
<!--								<input type="checkbox" id='mon_check' name='mon_check' class="js-switch form-control" data-color="#6164c1" data-size="small" autocomplete="off"/>-->
<!--								<div class="input-append">-->
<!--									<input type="text" maxlength="5" disabled id='mon_clock' class="form-control add-on" name="mon_clock" placeholder="13:00" value="">-->
<!--								</div>-->
<!--							</div>-->
<!--							<div class="col-md-2 form-group">-->
<!--								<label class="control-label">سه شنبه</label>-->
<!--								<input type="checkbox" id='tue_check' name='tue_check'  class="js-switch form-control" data-color="#6164c1" data-size="small" autocomplete="off"/>-->
<!--								<div class="input-append">-->
<!--									<input type="text" maxlength="5" disabled id='tue_clock' class="form-control add-on" name="tue_clock" placeholder="13:00" value="">-->
<!--								</div>-->
<!--							</div>-->
<!--							<div class="col-md-2 form-group">-->
<!--								<label class="control-label">چهارشنبه</label>-->
<!--								<input type="checkbox" id='wed_check' name='wed_check' class="js-switch form-control" data-color="#6164c1" data-size="small" autocomplete="off"/>-->
<!--								<div class="input-append">-->
<!--									<input type="text" maxlength="5" disabled id='wed_clock' class="form-control add-on" name="wed_clock" placeholder="13:00" value="">-->
<!--								</div>-->
<!--							</div>-->
<!--							<div class="col-md-2 form-group">-->
<!--								<label class="control-label">پنجشنبه</label>-->
<!--								<input type="checkbox" id='thu_check' name='thu_check' class="js-switch form-control" data-color="#6164c1" data-size="small" autocomplete="off"/>-->
<!--								<div class="input-append">-->
<!--									<input type="text" maxlength="5" disabled id='thu_clock' class="form-control add-on" name="thu_clock" placeholder="13:00" value="">-->
<!--								</div>-->
<!--							</div>-->
<!--							<div class="col-md-1 form-group" style="margin: 0; padding: 0">-->
<!--								<label class="control-label">جمعه</label>-->
<!--								<input type="checkbox" id='fri_check' name='fri_check' class="js-switch form-control" data-color="#6164c1" data-size="small" autocomplete="off"/>-->
<!--								<div class="input-append">-->
<!--									<input type="text" maxlength="5" disabled id='fri_clock' class="form-control add-on" name="fri_clock" placeholder="13:00" value="">-->
<!--								</div>-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="col-md-12">-->
<!--							<div class="col-sm-4">-->
<!--								<div class="white-box">-->
<!--									<h3 class="box-title">اختصاص عکس به دوره</h3>-->
<!--									<input type="file" id="input-file-now" name="pic_name" required class="dropify" />-->
<!--								</div>-->
<!--							</div>-->
<!--							<div class="col-sm-8">-->
<!--								<h3 class="control-label text-info" for="">توضیحات دوره: </h3>-->
<!--								<textarea type="text" id="description" name="description" class="timepicker form-control" style="height: 200px" placeholder="توضیحاتی در مورد دوره" required onkeyup='saveValue(this);'></textarea>-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->
<!--					<!--/row-->-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		<!--./row-->-->
<!---->
<!--	<div style="overflow:auto;">-->
<!--		<div style="float:left;">-->
<!--			<button type="button" id="prevBtn" onclick="nextPrev(-1)">بازگشت</button>-->
<!--			<button type="button" id="nextBtn" onclick="nextPrev(1)">مرحله بعد</button>-->
<!--		</div>-->
<!--	</div>-->
<!--	<!-- Circles which indicates the steps of the form: -->-->
<!--	<div style="text-align:center;margin-top:40px;">-->
<!--		<span class="step"></span>-->
<!--		<span class="step"></span>-->
<!--		<span class="step"></span>-->
<!--	</div>-->
<!--</form>-->
<!---->
<!--<script>-->
<!--	$(document).ready(function () {-->
<!---->
<!--		$('#tuition1').hide();-->
<!---->
<!--		$('#btn1').click(function () {-->
<!--			$('#tuition1').hide();-->
<!--			$('#tuition2').show();-->
<!--		});-->
<!--		$('#btn2').click(function () {-->
<!--			$('#tuition2').hide();-->
<!--			$('#tuition1').show();-->
<!--		});-->
<!--		$('#ba3').click(function () {-->
<!--			$('#am').hide();-->
<!--		});-->
<!--		$('#ba2').click(function () {-->
<!--			$('#am').show();-->
<!--		});-->
<!--		$('#ba1').click(function () {-->
<!--			$('#am').show();-->
<!--		});-->
<!--	});-->
<!---->
<!--	rescuefieldvalues(['course_name', 'employee_id', 'course_duration', 'time_meeting', 'class_id', 'start_date', 'capacity', 'type_gender',-->
<!--		'type_course', 'value_pay', 'course_tuition', 'type_tuition', 'value_tuition_clock', 'value_tuition_course', 'description']);-->
<!--</script>-->
<!---->
<!---->
<!---->
