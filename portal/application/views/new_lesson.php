

<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap-rtl-master/dist/css/bootstrap-rtl.min.css" rel="stylesheet">
        <!-- for checkbox -->
<!--        <link href="--><?php //echo base_url(); ?><!--assets/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" />-->
        <!-- Custom CSS -->
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
        <title>مدیریت | ثبت درس جدید</title>
    </head>
    <body>
        <div class="row" style="background-color: whitesmoke;direction: rtl">
            <div class="col-md-12" style="padding: 80px">
                <div class="panel panel-info">
                    <div class="panel-heading"> ثبت درس جدید</div>
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body">

                            <!-- error for exist national_code -->
							<?php if ($this->session->flashdata('error-own-code')): ?>
							<ddiv class="alert alert-danger"><?php echo $this->session->flashdata('error-own-code'); ?></div>
						<?php endif; ?>
                            <!-- / error for exist national_code -->

                            <!-- error inputs -->
                            <?php if ($this->session->flashdata('error-null')) : ?>
                                <div class="alert alert-danger">لطفا تمام موارد خواسته شده در قسمت اطلاعات درس را پر کنید</div>
                            <?php endif; ?>

<!--                            <div class="m-b-20">-->
<!--                                --><?php //if (validation_errors()): ?>
<!--                                    <div class="alert alert-danger">خطاهای زیر را بررسی کنید</div>-->
<!--                                    <div class="text-danger" style="border-right: #ff7676 thick solid">--><?php //echo form_error('stnd'); ?><!--</div>-->
<!--                                    <div class="text-danger" style="border-right: #ff7676 thick solid">--><?php //echo form_error('lesson_name'); ?><!--</div>-->
<!--                                    <div class="text-danger" style="border-right: #ff7676 thick solid">--><?php //echo form_error('lesson_own_code'); ?><!--</div>-->
<!--                                    <div class="text-danger" style="border-right: #ff7676 thick solid">--><?php //echo form_error('lesson_description'); ?><!--</div>-->
<!--                                --><?php //endif; ?>
<!--                            </div>-->
                            <!-- /error inputs -->

                            <form action="<?php echo base_url(); ?>training/insert-new-lesson" method="post" name="class_register">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="box-title">اطلاعات درس</h3>
                                            <hr style="background-color: blue">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">خوشه</label>
                                                    <select class="form-control" name="cluster">
                                                        <option value="0">لطفا انتخاب کنید</option>
                                                        <?php foreach ($data as $cls): ?>
                                                            <option value="<?= $cls->cluster_id ?>"><?= $cls->cluster_name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">نام گروه</label>
                                                    <select class="form-control" name="group">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">نام استاندارد</label>
                                                    <select class="form-control" name="stnd">
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">نام درس</label>
                                                    <input type="text" name="lesson_name" id="lesson_name" class="form-control" placeholder="" required=""> <span class="help-block">مثال : مهارت های هفت گانه ICDL</span> </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">توضیحات</label>
                                                    <input type="text" name="lesson_description" id="lesson_description" class="form-control" placeholder="" required=""> <span class="help-block">مثال: آموزش ویندوز، Word، PowerPoint و ...</span> </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">کد اختصاصی درس</label>
                                                    <input type="text" name="lesson_own_code" id="lesson_own_code" class="form-control" placeholder="" required=""> <span class="help-block"></span> </div>
                                            </div>
                                        </div>

<!--                                        <div class="col-md-12" style="margin-top: 3%">-->
<!--                                            <h3 class="box-title">اطلاعات آزمون </h3>-->
<!--                                            <hr style="background-color: blue;border-width: 1px">-->
<!--												<div class="col-md-2">-->
<!--													<h3 class="box-title">نوع آزمون</h3>-->
<!--													<hr>-->
<!--													<div class="form-group">-->
<!--														<label class="control-label">کتبی</label>-->
<!--														<input type="checkbox" id='a1' name='written'  class="js-switch form-control" data-color="#6164c1" data-size="small" />-->
<!--													</div>-->
<!--													<div class="form-group" style="margin-top:25%">-->
<!--														<label class="control-label">عملی</label>-->
<!--														<input type="checkbox" id='b1' name='practical'   class="js-switch form-control" data-color="#6164c1" data-size="small" />-->
<!--													</div>-->
<!--												</div>-->
<!--												<div class="col-md-4">-->
<!--													<h3 class="box-title">نمره آزمون این درس از چند محاسبه می شود؟</h3>-->
<!--													<hr>-->
<!--													<div class="form-group">-->
<!--														<input type="number" disabled id='a2' class="form-control" name="written_range_score" value="">-->
<!--													</div>-->
<!--													<div class="form-group">-->
<!--														<input type="number" disabled id='b2' class="form-control" name="practical_range_score" value="">-->
<!--													</div>-->
<!--												</div>-->
<!--												<div class="col-md-3">-->
<!--													<h3 class="box-title">نمره حد نصاب قبولی در آزمون</h3>-->
<!--													<hr>-->
<!--													<div class="form-group">-->
<!--														<input type="number" disabled id='a2' class="form-control" name="written_quota_Score" value="">-->
<!--													</div>-->
<!--													<div class="form-group">-->
<!--														<input type="number" disabled id='b2' class="form-control" name="practical_quota_Score" value="">-->
<!--													</div>-->
<!--												</div>-->
<!--												<div class="col-md-3">-->
<!--													<h3 class="box-title">تاثیر در نمره نهایی (درصد)</h3>-->
<!--													<hr>-->
<!--													<div class="form-group">-->
<!--														<input type="number" max="100" disabled id='a2' class="form-control" name="written_percentage" value="">-->
<!--													</div>-->
<!--													<div class="form-group">-->
<!--														<input type="number" max="100" disabled id='b2' class="form-control" name="practical_percentage" value="">-->
<!--													</div>-->
<!--												</div>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                    <!--/row-->



										<?php if($this->session->userdata('type_academy') != 1): ?>

										<div class="col-md-12" style="margin-top: 3%">
											<h3 class="box-title">اطلاعات آزمون </h3>
											<hr style="background-color: blue;border-width: 1px">

											<div class="col-md-1">
												<h3 class="box-title">افزودن</h3>
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
												<div class="col-md-2">
													<div class="form-group">
														<input type="text" class="form-control" id="Test-name" name="Test-name[]" value="" placeholder="speaking or lesening or ...">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<input type="text" class="form-control" id="range_score" name="range_score[]" value="" placeholder="range_score">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<input type="text" class="form-control" id="quota_Score" name="quota_Score[]" value="" placeholder="quota_Score">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<input type="text" class="form-control" id="percentage" name="percentage[]" value="" placeholder="percentage">
													</div>
													<div class="clear"></div>
												</div>
										</div>

										<?php endif; ?>

									</div>
									<!--/row-->
                                    <div class="col-md-12">
                                        <div style="float:left">
                                            <button type="submit" class="btn btn-success"> <i style="padding-left: 6px" class="fa fa-check"></i>ایجاد درس جدید</button>
                                            <a type="button" style="color: white" href="<?= base_url('profile'); ?>" class="btn btn-danger"> <i style="padding-left: 6px" class="fa fa-close"></i>بازگشت</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



<!--        --><?php //if (validation_errors()): ?>
<!--            <script>-->
<!--                $(document).ready(function () {-->
<!--                    $('#myModal').modal('show');-->
<!--                });-->
<!--            </script>-->
<!--        --><?php //endif; ?>
<!--        <div id="myModal" class="modal" role="dialog">-->
<!--            <div class="modal-dialog">-->
<!--                <div class="modal-content">-->
<!--                    <div class="modal-header" style="background-color: #edf0f2">-->
<!--                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<!--                        <h4 class="modal-title" id="myModalLabel">مدیریت</h4>-->
<!--                    </div>-->
<!--                    <div class="modal-body">-->
<!--                        <p>--><?php //$this->session->flashdata('error-own-code') ?><!--</p>-->
<!--                    </div>-->
<!--                    <div class="modal-footer">-->
<!--                        <div class="col-md-12">-->
<!--                            <button type="submit" class="btn btn-success" data-dismiss="modal" style="width: 100%">بستن</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->


        <script>
            $(document).ready(function () {
                $('select[name="cluster"]').on('change', function () {
                    var clust = $(this).val();
                    if (clust) {
                        $.ajax({
                            url: 'dropdown/cluster/' + clust,
                            type: "GET",
                            dataType: "json",
                            success: function (data) {
                                $('select[name="group"]').empty();
                                $('select[name="stnd"]').empty();
								$('select[name="group"]').append('<option value="0"> لطفا انتخاب کنید </option>');
                                $.each(data, function (key, value) {
                                    $('select[name="group"]').append('<option value="' + value.group_id + '">' + value.group_name + '</option>');
                                });
                            }
                        });
                    } else {
                        $('select[name="group"]').empty();
                    }
                });
            });

            $(document).ready(function () {
                $('select[name="group"]').on('change', function () {
                    var grp = $(this).val();
                    if (grp) {
                        $.ajax({
                            url: 'dropdown/group/' + grp,
                            type: "GET",
                            dataType: "json",
                            success: function (data) {
                                $('select[name="stnd"]').empty();
								$('select[name="stnd"]').append('<option value="0"> لطفا انتخاب کنید </option>');
                                $.each(data, function (key, value) {
                                    $('select[name="stnd"]').append('<option value="' + value.standard_id + '">' + value.standard_name + '</option>');
                                });
                            }
                        });
                    } else {
                        $('select[name="stnd"]').empty();
                    }
                });
            });
        </script>
        <script src="<?php echo base_url(); ?>assets/bower_components/switchery/dist/switchery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

		<!-- script for schools Fani va Herfeie -->
<!--        <script>-->
<!--            jQuery(document).ready(function () {-->
<!--                // Switchery-->
<!--                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));-->
<!--                $('.js-switch').each(function () {-->
<!--                    new Switchery($(this)[0], $(this).data());-->
<!--                });-->
<!---->
<!---->
<!--                const a1 = $("#a1");-->
<!--                const b1 = $("#b1");-->
<!--                a1.change(function () {-->
<!--                    var checkbox = event.target;-->
<!--                    if (checkbox.checked) {-->
<!--                        $('form input[id="a2"]').prop("disabled", false);-->
<!--                    } else {-->
<!--                        $('form input[id="a2"]').prop("disabled", true);-->
<!--                    }-->
<!--                });-->
<!--                b1.change(function () {-->
<!--                    var checkbox = event.target;-->
<!--                    if (checkbox.checked) {-->
<!--                        $('form input[id="b2"]').prop("disabled", false);-->
<!--                    } else {-->
<!--                        $('form input[id="b2"]').prop("disabled", true);-->
<!--                    }-->
<!--                });-->
<!--                ////////////// پایان\\\\\\\\\\\\\\\\\\-->
<!--            });-->
<!--        </script>-->

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
					'<div class="col-sm-2">' +
					'<div class="form-group"> ' +
					'<input type="text" class="form-control" id="test_name" name="test_name[]" value="" placeholder="test_name">' +
					'</div>' +
					'</div>' +
					'<div class="col-sm-3">' +
					'<div class="form-group"> ' +
					'<input type="text" class="form-control" id="range_score" name="range_score[]" value="" placeholder="range_score">' +
					'</div>' +
					'</div>' +
					'<div class="col-sm-3">' +
					'<div class="form-group"> ' +
					'<input type="text" class="form-control" id="quota_Score" name="quota_Score[]" value="" placeholder="quota_Score">' +
					'</div>' +
					'</div>' +
					'<div class="col-sm-3">' +
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

    </body>
</html>
