

<form class="form" id="regForm" action="<?php echo base_url('welcome/result_test'); ?>" method="post" enctype="multipart/form-data" name="course_register">
<!--	<form class="form" id="regForm" action="--><?php //echo base_url('test-insert'); ?><!--" method="post" enctype="multipart/form-data" name="course_register">-->
    <!-- One "tab" for each step in the form: -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <?php
                        $classError = $this->session->flashdata('classError');
                        if (!empty($classError)):
                            ?>
                            <div class="alert alert-danger">
                                <?= 'تداخل زمانی با کلاس انتخاب شده'; ?>
                                <a href="" data-toggle="modal" data-target="#class"> جزئیات ...</a>
                            </div>
                            <!-- modal -->
                            <div id="class" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #edf0f2">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">تداخل زمانی با کلاس </h4>
                                        </div>
                                        <div class="modal-body"><?php
                                            for ($j = 0; $j < sizeof($classError); $j++) {
                                                echo $classError[$j]['class'] . '<br>';
                                            }
                                            ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-info" style="width: 100%" data-dismiss="modal">بستن</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php
                        $teacherError = $this->session->flashdata('thrError');
                        if (!empty($teacherError)):
                            ?>
                            <div class="alert alert-danger">
                                <?= 'تداخل زمانی با استاد انتخاب شده'; ?>
                                <a href="" data-toggle="modal" data-target="#teacher"> جزئیات ...</a>
                            </div>
                            <!-- modal -->
                            <div id="teacher" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #edf0f2">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">تداخل زمانی بااستاد </h4>
                                        </div>
                                        <div class="modal-body"><?php
                                            for ($i = 0; $i < sizeof($teacherError); $i++) {
                                                echo $teacherError[$i]['teacher'] . '<br>';
                                            }
                                            ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-info" style="width: 100%" data-dismiss="modal">بستن</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('upload-msg')) : ?>
                            <div class="alert alert-danger"><?php echo $this->session->flashdata('upload-msg'); ?></div>
                        <?php endif; ?>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        <div class="form-body">
                            <h3 class="box-title">مرحله  1 : مشخصات دوره</h3>
                            <hr>
                            <div class="row">  
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="course_name" class="control-label">نام درس</label>
                                        <select name="course_name" id="course_name" class="form-control" >
                                            <?php if (!empty($lessons)): ?>
                                                <?php foreach ($lessons as $lesson): ?>
                                                    <option value="<?php echo htmlspecialchars($lesson->lesson_id, ENT_QUOTES); ?>"><?php echo htmlspecialchars($lesson->lesson_name, ENT_QUOTES); ?></option>
                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </select>
                                        <?php if (validation_errors() && form_error('course_name')): ?>
                                            <div class="alert alert-danger"><?php echo form_error('course_name'); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="course_name" class="control-label">نام <?php echo $this->session->userdata('teacherDName'); ?></label>
                                        <select name="employee_id" id="employee_name" class="form-control" >
                                            <?php if (!empty($employers)): ?>
                                                <?php foreach ($employers as $employee): ?>
                                                    <option value="<?php echo htmlspecialchars($employee->employee_id, ENT_QUOTES); ?>"><?php echo htmlspecialchars($employee->first_name, ENT_QUOTES) . ' ' . htmlspecialchars($employee->last_name, ENT_QUOTES); ?></option>
                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </select>
                                        <?php if (validation_errors() && form_error('employee_id')): ?>
                                            <div class="alert alert-danger"><?php echo form_error('employee_id'); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">مدت زمان دوره (ساعت)</label>
                                        <input type="number" name="course_duration" id="course_duration" class="form-control" placeholder="35" required="">
                                    </div>
                                    <?php if (validation_errors() && form_error('course_duration')): ?>
                                        <div class="alert alert-danger"><?php echo form_error('course_duration'); ?></div>
                                    <?php endif; ?>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">زمان هر جلسه(دقیقه)</label>
                                        <input type="number" name="time_meeting" id="time_meeting" class="form-control" placeholder="90" required=""> 
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="class_id" class="control-label">نام کلاس</label>
                                        <select name="class_id" id="course_name" class="form-control" >
                                            <?php if (!empty($classes)): ?>
                                                <?php foreach ($classes as $class): ?>
                                                    <option value="<?php echo htmlspecialchars($class->class_id, ENT_QUOTES); ?>"><?php echo htmlspecialchars($class->class_name, ENT_QUOTES); ?></option>
                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </select>
                                        <?php if (validation_errors() && form_error('class_id')): ?>
                                            <div class="alert alert-danger"><?php echo form_error('class_id'); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <label class="control-label">تاریخ شروع دوره : </label>
										<input type="text" name='start_date' class="auto-close-example form-control" onkeyup="
                                                var date = this.value;
                                                if (date.match(/^\d{4}$/) !== null) {
                                                    this.value = date + '-';
                                                } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                    this.value = date + '-';
                                                }" maxlength="10"/>

                                                    <!--<input type="text" name='start_date' id="start_date" class="start-date form-control" />-->
                                        <?php if (validation_errors() && form_error('start_date')): ?>
                                            <div class="alert alert-danger"><?php echo form_error('start_date'); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row"> 
                                <div class="col-md-12 text-center">
                                    <div class="form-group col-md-1">
                                        <label class="control-label">شنبه</label>
                                        <input type="checkbox" id='sat_check' name='sat_check'  class="js-switch form-control" data-color="#6164c1" data-size="small" autocomplete="off"/>
                                        <input type="time" disabled id='sat_clock' class="form-control" name="sat_clock" value="">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label">یکشنبه</label>
                                        <input type="checkbox" id='sun_check' name='sun_check'   class="js-switch form-control" data-color="#6164c1" data-size="small" autocomplete="off"/>
                                        <input type="time" disabled id='sun_clock' class="form-control" name="sun_clock" value="">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label">دوشنبه</label>
                                        <input type="checkbox" id='mon_check' name='mon_check'  class="js-switch form-control" data-color="#6164c1" data-size="small" autocomplete="off"/>
                                        <input type="time" disabled id='mon_clock' class="form-control" name="mon_clock" value="">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label">سه شنبه</label>
                                        <input type="checkbox" id='tue_check' name='tue_check'  class="js-switch form-control" data-color="#6164c1" data-size="small" autocomplete="off"/>
                                        <input type="time" disabled id='tue_clock' class="form-control" name="tue_clock" value="">
                                    </div>
                                    <div class="form-group col-md-2" >
                                        <label class="control-label">چهار شنبه</label>
                                        <input type="checkbox" id='wed_check' name='wed_check'  class="js-switch form-control" data-color="#6164c1" data-size="small" autocomplete="off"/>
                                        <input type="time" disabled id='wed_clock' class="form-control" name="wed_clock" value="">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label">پنج شنبه</label>
                                        <input type="checkbox" id='thu_check' name='thu_check'  class="js-switch form-control" data-color="#6164c1" data-size="small" autocomplete="off"/>
                                        <input type="time" disabled id='thu_clock' class="form-control" name="thu_clock" value="">
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label class="control-label">جمعه</label>
                                        <input type="checkbox" id='fri_check' name='fri_check'  class="js-switch form-control" data-color="#6164c1" data-size="small" autocomplete="off"/>
                                        <input type="time" disabled id='fri_clock' class="form-control" name="fri_clock" value="">
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="float:left;">
        <button type="submit"class="btn btn-success">ثبت</button>
    </div>

</form>
