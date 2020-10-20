<div class="col-sm-12">
    <div class="white-box">
        <?php if ($this->session->flashdata('enroll-exam-mark')) : ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('enroll-exam-mark'); ?></div>
        <?php endif; ?>
        <div class="table-responsive">
            <h3 class="text-center text-primary alert alert-dark" style="font-weight: bold !important;">
                وضعیت کلاس ها و آزمون های
                <?php if (!empty($student_info)): ?>
                    <span class="text-danger"><?php echo htmlspecialchars($student_info[0]->first_name . ' ' . $student_info[0]->last_name, ENT_QUOTES) ?></span>
                    با کد ملی
                    <span class="text-danger"><?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?></span>
                <?php endif; ?>
            </h3>
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">کد دوره</th>
                        <th class="text-center">نام دوره</th>
                        <th class="text-center">وضعیت آزمون ها</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">کد دوره</th>
                        <th class="text-center">نام دوره</th>
                        <th class="text-center">وضعیت آزمون ها</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if (!empty($student_courses) && !empty($student_info)): ?>
                        <?php foreach ($student_courses as $course): ?>
                            <tr>
                                <td class="text-center"><?php echo htmlspecialchars($course->course_id, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?></td>
                                <td class="text-nowrap text-center">
                                    <button alt="default" data-toggle="modal" data-target="#exams_details_<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>" data-original-title="جزئیات"> <i class="mdi mdi-account-card-details"></i> </button>
                                    <!-- /.modal -->
                                    <div id="exams_details_<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content" style="height: 450px; width: 1100px">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">وضعیت آزمون های دوره <?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?></h4> </div>
                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-danger text-center">کتبی مرحله 1</th>
                                                                    <th>عملی مرحله 1</th>
                                                                    <th class="text-danger text-center">کتبی مرحله 2</th>
                                                                    <th>عملی مرحله 2</th>
                                                                    <th class="text-danger text-center">کتبی مرحله 3</th>
                                                                    <th>عملی مرحله 3</th>
                                                                    <th class="text-info text-center">وضعیت نهایی کتبی</th>
                                                                    <th class="text-info text-center">وضعیت نهایی عملی</th>
                                                                    <th class="text-info text-center">وضعیت نهایی کل</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <?php if ($course->first_written === '0'): ?>
                                                                            <div class="modal fade bs-example-modal-sm" id="first_w_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog modal-sm">
                                                                                    <div class="modal-content">
                                                                                        
                                                                                            <div class="modal-header">
                                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                                <h4 class="modal-title" id="mySmallModalLabel">تاریخ آزمون را وارد نمایید : </h4> 
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <form id="enroll_exam_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" action="<?php echo base_url(); ?>enrollment/student-enroll-in-exam" method="post">
                                                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                    <div class="form-group">
                                                                                                        <input type="date" id="birthday" name="exam_date"   class="form-control birth-date" placeholder="1396/01/22" required="">
                                                                                                    </div>
                                                                                                    <input name="course_id" type="hidden" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                                                    <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?>">
                                                                                                    <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>">
                                                                                                    <input type="hidden" name="exam_stage" value="first_written">
                                                                                                    <input type="hidden" name="exam_stage_p" value="first_practical">
                                                                                                    <input type="hidden" name="exam_id" value="1">
                                                                                                    <input type="hidden" name="exam_cost" value="<?php echo $exams[0]->exam_cost; ?>">
                                                                                                    <div class="form-group">
                                                                                                        <button type="submit" class="btn btn-success form-control">ثبت نهایی</button>
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                        
                                                                                    </div>
                                                                                    <!-- /.modal-content -->
                                                                                </div>
                                                                                <!-- /.modal-dialog -->
                                                                            </div>
                                                                            <!-- /.modal -->
                                                                            <span style="cursor: pointer" alt="default" data-toggle="modal" data-target="#first_w_modal"  class="label label-primary">ثبت نام کردن</span>

                                                                        <?php elseif ($course->first_written === '1' && $course->first_w_status === '0'): ?>
                                                                            <button  class="btn label-warning label" alt="default" data-toggle="modal" data-target="#mark_w_1">در انتطار ثبت نمره</button>
                                                                            <div id="mark_w_1"  class="modal fade bg-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
                                                                                            <h4 class="modal-title">نمره درس مورد نظر را وارد نمایید : </h4> </div>
                                                                                        <div class="modal-body">
                                                                                            <form id="mark_enroll_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" style="" action="<?php echo base_url(); ?>enrollment/student-enroll-written-exam-mark" method="post">
                                                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                <input name="course_id" type="hidden" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="mark_stage" value="first_w_status">
                                                                                                <input type="hidden" name="exam_stage" value="first_written">
                                                                                                <div class="form-group">
                                                                                                    <label for="mark" class="text-danger ">نمره اخذ شده در آزمون کتبی مرحله اول درس <?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?></label>
                                                                                                    <input type="number"  name="mark" id="mark" class="form-control" placeholder="" required> <span class="help-block">کد ملی 10 رقمی <?php echo $this->session->userdata('studentDName');?> را وارد نمایید</span></div>
                                                                                                <?php if (validation_errors() && form_error('mark')): ?>
                                                                                                    <div class="alert alert-danger"><?php echo form_error('mark'); ?></div>
                                                                                                <?php endif; ?>
                                                                                                <button type="submit" class="btn btn-danger waves-effect waves-light">ثبت نمره</button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="modal-footer">

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php elseif ($course->first_written === '2'): ?>
                                                                            <span class="label label-info">
                                                                                <?php echo htmlspecialchars($course->first_w_status, ENT_QUOTES); ?>
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($course->first_practical === '0' && $course->first_written === '2' && $course->first_w_status < 50): ?>
                                                                            <span class="label label-danger">کتبی مرحله بعد</span>
                                                                        <?php elseif ($course->first_practical === '1' && $course->first_written === '1'): ?>
                                                                            <span class="label label-primary">در انتظار</span>
                                                                        <?php elseif ($course->first_practical === '1' && $course->first_written === '2' && $course->first_w_status >= 50): ?>
                                                                            <button  class="btn label-warning label" alt="default" data-toggle="modal" data-target="#mark_p_1">در انتطار ثبت نمره</button>
                                                                            <div id="mark_p_1"  class="modal fade bg-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
                                                                                            <h4 class="modal-title">نمره درس مورد نظر را وارد نمایید : </h4> </div>
                                                                                        <div class="modal-body">
                                                                                            <form id="mark_enroll_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" style="" action="<?php echo base_url(); ?>enrollment/student-enroll-practical-exam-mark" method="post">
                                                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                <input name="course_id" type="hidden" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="mark_stage" value="first_p_status">
                                                                                                <input type="hidden" name="exam_stage" value="first_practical">
                                                                                                <div class="form-group">
                                                                                                    <label for="mark" class="text-danger ">نمره اخذ شده در آزمون عملی مرحله اول درس <?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?></label>
                                                                                                    <input type="number"  name="mark" id="mark" class="form-control" placeholder="" required> <span class="help-block">کد ملی 10 رقمی <?php echo $this->session->userdata('studentDName');?> را وارد نمایید</span></div>
                                                                                                <?php if (validation_errors() && form_error('mark')): ?>
                                                                                                    <div class="alert alert-danger"><?php echo form_error('mark'); ?></div>
                                                                                                <?php endif; ?>
                                                                                                <button type="submit" class="btn btn-danger waves-effect waves-light">ثبت نمره</button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="modal-footer">

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        <?php elseif ($course->first_w_status > 50 && $course->first_written === '2' && $course->first_p_status < 70): ?>
                                                                            <span class="label label-danger">عملی مرحله بعد</span>
                                                                        <?php elseif ($course->first_w_status < 50 && $course->first_written === '2'): ?>
                                                                            <span class="label label-danger">کتبی مرحله بعد</span>
                                                                        <?php elseif ($course->first_written === '2' && $course->first_w_status >= 50 && $course->first_p_status >= 70): ?>
                                                                            <span class="label label-info">
                                                                                <?php echo htmlspecialchars($course->first_p_status, ENT_QUOTES); ?>
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($course->first_written === '2' && $course->first_w_status < 50 && $course->second_written === '0'): ?>
                                                                            <div class="modal fade bs-example-modal-sm" id="second_w_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog modal-sm">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                            <h4 class="modal-title" id="mySmallModalLabel">تاریخ آزمون را وارد نمایید : </h4> </div>
                                                                                        <div class="modal-body">
                                                                                            <form id="enroll_exam_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" action="<?php echo base_url(); ?>enrollment/student-enroll-in-exam" method="post">
                                                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                <div class="form-group">
                                                                                                    <input type="date" id="birthday" name="exam_date"   class="form-control birth-date" placeholder="1396/01/22" required="">
                                                                                                </div>
                                                                                                <input name="course_id" type="hidden" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="exam_stage" value="second_written">
                                                                                                <input type="hidden" name="exam_stage_p" value="second_practical">
                                                                                                <input type="hidden" name="exam_id" value="2">
                                                                                                <input type="hidden" name="exam_cost" value="<?php echo htmlspecialchars($exams[1]->exam_cost); ?>">
                                                                                                <div class="form-group">
                                                                                                    <button type="submit" class="btn btn-success form-control">ثبت نهایی</button>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- /.modal-content -->
                                                                                </div>
                                                                                <!-- /.modal-dialog -->
                                                                            </div>
                                                                            <!-- /.modal -->
                                                                            <span style="cursor: pointer" alt="default" data-toggle="modal" data-target="#second_w_modal"  class="label label-primary">ثبت نام کردن</span>

                                                                        <?php elseif ($course->second_written === '1' && $course->second_w_status === '0'): ?>
                                                                            <button  class="btn label-warning label" alt="default" data-toggle="modal" data-target="#mark_w_2">در انتطار ثبت نمره</button>
                                                                            <div id="mark_w_2"  class="modal fade bg-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
                                                                                            <h4 class="modal-title">نمره درس مورد نظر را وارد نمایید : </h4> </div>
                                                                                        <div class="modal-body">
                                                                                            <form id="mark_enroll_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" style="" action="<?php echo base_url(); ?>enrollment/student-enroll-written-exam-mark" method="post">
                                                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                <input name="course_id" type="hidden" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="mark_stage" value="second_w_status">
                                                                                                <input type="hidden" name="exam_stage" value="second_written">
                                                                                                <div class="form-group">
                                                                                                    <label for="mark" class="text-danger ">نمره اخذ شده در آزمون کتبی مرحله دوم درس <?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?></label>
                                                                                                    <input type="number"  name="mark" id="mark" class="form-control" placeholder="" required> <span class="help-block">کد ملی 10 رقمی <?php echo $this->session->userdata('studentDName');?> را وارد نمایید</span></div>
                                                                                                <?php if (validation_errors() && form_error('mark')): ?>
                                                                                                    <div class="alert alert-danger"><?php echo form_error('mark'); ?></div>
                                                                                                <?php endif; ?>
                                                                                                <button type="submit" class="btn btn-danger waves-effect waves-light">ثبت نمره</button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="modal-footer">

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php elseif ($course->second_written === '2'): ?>
                                                                            <span class="label label-info">
                                                                                <?php echo htmlspecialchars($course->second_w_status, ENT_QUOTES); ?>
                                                                            </span>
                                                                        <?php elseif ($course->first_w_status >= 50 && $course->first_p_status < 70 && $course->first_practical === '2' && $course->first_written === '2'): ?>
                                                                            <span class="label label-default">
                                                                                ثبت نام در عملی
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($course->second_practical === '1' && $course->second_written === '2' && $course->second_w_status < 50): ?>
                                                                            <span class="label label-danger">کتبی مرحله بعد</span>
                                                                        <?php elseif ($course->second_practical === '1' && $course->second_written === '1'): ?>
                                                                            <span class="label label-primary">در انتظار</span>
                                                                        <?php elseif ($course->second_practical === '1' && $course->second_written === '2' && $course->second_w_status >= 50): ?>
                                                                            <button  class="btn label-warning label" alt="default" data-toggle="modal" data-target="#mark_p_2">در انتطار ثبت نمره</button>
                                                                            <div id="mark_p_2"  class="modal fade bg-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
                                                                                            <h4 class="modal-title">نمره درس مورد نظر را وارد نمایید : </h4> </div>
                                                                                        <div class="modal-body">
                                                                                            <form id="mark_enroll_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" style="" action="<?php echo base_url(); ?>enrollment/student-enroll-practical-exam-mark" method="post">
                                                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                <input name="course_id" type="hidden" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="mark_stage" value="second_p_status">
                                                                                                <input type="hidden" name="exam_stage" value="second_practical">
                                                                                                <div class="form-group">
                                                                                                    <label for="mark" class="text-danger ">نمره اخذ شده در آزمون عملی مرحله دوم درس <?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?></label>
                                                                                                    <input type="number"  name="mark" id="mark" class="form-control" placeholder="" required> <span class="help-block">کد ملی 10 رقمی <?php echo $this->session->userdata('studentDName');?> را وارد نمایید</span></div>
                                                                                                <?php if (validation_errors() && form_error('mark')): ?>
                                                                                                    <div class="alert alert-danger"><?php echo form_error('mark'); ?></div>
                                                                                                <?php endif; ?>
                                                                                                <button type="submit" class="btn btn-danger waves-effect waves-light">ثبت نمره</button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="modal-footer">

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        <?php elseif ($course->second_w_status > 50 && $course->second_written === '2' && $course->second_p_status < 70): ?>
                                                                            <span class="label label-danger">عملی مرحله بعد</span>
                                                                        <?php elseif ($course->second_w_status < 50 && $course->second_written === '2'): ?>
                                                                            <span class="label label-danger">کتبی مرحله بعد</span>
                                                                        <?php elseif ($course->second_written === '2' && $course->second_w_status >= 50 && $course->second_p_status >= 70): ?>
                                                                            <span class="label label-info">
                                                                                <?php echo htmlspecialchars($course->second_p_status, ENT_QUOTES); ?>
                                                                            </span>
                                                                        <?php elseif ($course->first_w_status >= 50 && $course->first_p_status < 70 && $course->first_practical === '2' && $course->first_written === '2' && $course->second_practical === '0'): ?>
                                                                            <div class="modal fade bs-example-modal-sm" id="second_p_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog modal-sm">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                            <h4 class="modal-title" id="mySmallModalLabel">تاریخ آزمون را وارد نمایید : </h4> </div>
                                                                                        <div class="modal-body">
                                                                                            <form id="enroll_alone_p_exam_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" action="<?php echo base_url(); ?>enrollment/student-enroll-in-practical-alone" method="post">
                                                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                <div class="form-group">
                                                                                                    <input type="date" id="birthday" name="exam_date"   class="form-control birth-date" placeholder="1396/01/22" required="">
                                                                                                </div>
                                                                                                <input name="course_id" type="hidden" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="exam_stage" value="second_practical">
                                                                                                <input type="hidden" name="exam_id" value="2">
                                                                                                <input type="hidden" name="exam_cost" value="<?php echo htmlspecialchars($exams[1]->exam_cost); ?>">
                                                                                                <div class="form-group">
                                                                                                    <button type="submit" class="btn btn-success form-control">ثبت نهایی</button>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- /.modal-content -->
                                                                                </div>
                                                                                <!-- /.modal-dialog -->
                                                                            </div>
                                                                            <!-- /.modal -->
                                                                            <span style="cursor: pointer" alt="default" data-toggle="modal" data-target="#second_p_modal"  class="label label-primary">ثبت نام در عملی</span>

                                                                        <?php elseif ($course->first_w_status >= 50 && $course->first_p_status < 70 && $course->first_practical === '2' && $course->first_written === '2' && $course->second_practical === '1'): ?>
                                                                            <button  class="btn label-warning label" alt="default" data-toggle="modal" data-target="#mark_p_a_2">در انتطار ثبت نمره</button>
                                                                            <div id="mark_p_a_2"  class="modal fade bg-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
                                                                                            <h4 class="modal-title">نمره درس مورد نظر را وارد نمایید : </h4> </div>
                                                                                        <div class="modal-body">
                                                                                            <form id="mark_enroll_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" style="" action="<?php echo base_url(); ?>enrollment/student-enroll-practical-exam-mark" method="post">
                                                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                <input name="course_id" type="hidden" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="mark_stage" value="second_p_status">
                                                                                                <input type="hidden" name="exam_stage" value="second_practical">
                                                                                                <div class="form-group">
                                                                                                    <label for="mark" class="text-danger ">نمره اخذ شده در آزمون عملی مرحله دوم درس <?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?></label>
                                                                                                    <input type="number"  name="mark" id="mark" class="form-control" placeholder="" required> <span class="help-block">کد ملی 10 رقمی <?php echo $this->session->userdata('studentDName');?> را وارد نمایید</span></div>
                                                                                                <?php if (validation_errors() && form_error('mark')): ?>
                                                                                                    <div class="alert alert-danger"><?php echo form_error('mark'); ?></div>
                                                                                                <?php endif; ?>
                                                                                                <button type="submit" class="btn btn-danger waves-effect waves-light">ثبت نمره</button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="modal-footer">

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php elseif ($course->first_w_status >= 50 && $course->first_p_status < 70 && $course->first_practical === '2' && $course->first_written === '2' && $course->second_practical === '2'): ?>
                                                                            <span class="label label-info">
                                                                                <?php echo htmlspecialchars($course->second_p_status, ENT_QUOTES); ?>
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($course->second_written === '2' && $course->second_w_status < 50 && $course->third_written === '0'): ?>
                                                                            <div class="modal fade bs-example-modal-sm" id="third_w_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog modal-sm">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                            <h4 class="modal-title" id="mySmallModalLabel">تاریخ آزمون را وارد نمایید : </h4> </div>
                                                                                        <div class="modal-body">
                                                                                            <form id="enroll_exam_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" action="<?php echo base_url(); ?>enrollment/student-enroll-in-exam" method="post">
                                                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                <div class="form-group">
                                                                                                    <input type="date" id="birthday" name="exam_date"   class="form-control birth-date" placeholder="1396/01/22" required="">
                                                                                                </div>
                                                                                                <input name="course_id" type="hidden" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="exam_stage" value="third_written">
                                                                                                <input type="hidden" name="exam_stage_p" value="third_practical">
                                                                                                <input type="hidden" name="exam_id" value="3">
                                                                                                <input type="hidden" name="exam_cost" value="<?php echo htmlspecialchars($exams[2]->exam_cost); ?>">
                                                                                                <div class="form-group">
                                                                                                    <button type="submit" class="btn btn-success form-control">ثبت نهایی</button>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- /.modal-content -->
                                                                                </div>
                                                                                <!-- /.modal-dialog -->
                                                                            </div>
                                                                            <!-- /.modal -->
                                                                            <span style="cursor: pointer" alt="default" data-toggle="modal" data-target="#third_w_modal"  class="label label-primary">ثبت نام کردن</span>

                                                                        <?php elseif ($course->third_written === '1' && $course->third_w_status === '0'): ?>
                                                                            <button  class="btn label-warning label" alt="default" data-toggle="modal" data-target="#mark_w_2">در انتطار ثبت نمره</button>
                                                                            <div id="mark_w_2"  class="modal fade bg-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
                                                                                            <h4 class="modal-title">نمره درس مورد نظر را وارد نمایید : </h4> </div>
                                                                                        <div class="modal-body">
                                                                                            <form id="mark_enroll_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" style="" action="<?php echo base_url(); ?>enrollment/student-enroll-written-exam-mark" method="post">
                                                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                <input name="course_id" type="hidden" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="mark_stage" value="third_w_status">
                                                                                                <input type="hidden" name="exam_stage" value="third_written">
                                                                                                <div class="form-group">
                                                                                                    <label for="mark" class="text-danger ">نمره اخذ شده در آزمون کتبی مرحله سوم درس <?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?></label>
                                                                                                    <input type="number"  name="mark" id="mark" class="form-control" placeholder="" required> <span class="help-block">کد ملی 10 رقمی <?php echo $this->session->userdata('studentDName');?> را وارد نمایید</span></div>
                                                                                                <?php if (validation_errors() && form_error('mark')): ?>
                                                                                                    <div class="alert alert-danger"><?php echo form_error('mark'); ?></div>
                                                                                                <?php endif; ?>
                                                                                                <button type="submit" class="btn btn-danger waves-effect waves-light">ثبت نمره</button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="modal-footer">

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php elseif ($course->third_written === '2'): ?>
                                                                            <span class="label label-info">
                                                                                <?php echo htmlspecialchars($course->third_w_status, ENT_QUOTES); ?>
                                                                            </span>
                                                                        <?php elseif ($course->second_practical === '2' && $course->first_practical === '2' && $course->first_p_status < 70 && $course->second_p_status < 70): ?>
                                                                            <span class="label label-default">
                                                                                ثبت نام در عملی
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($course->third_practical === '1' && $course->third_written === '2' && $course->third_w_status < 50): ?>
                                                                            <span class="label label-danger">کتبی مرحله بعد</span>

                                                                        <?php elseif ($course->third_practical === '1' && $course->third_written === '1'): ?>
                                                                            <span class="label label-primary">در انتظار</span>

                                                                        <?php elseif ($course->third_practical === '1'): ?>

                                                                            <button  class="btn label-warning label" alt="default" data-toggle="modal" data-target="#mark_p_3">در انتطار ثبت نمره</button>
                                                                            <div id="mark_p_3"  class="modal fade bg-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
                                                                                            <h4 class="modal-title">نمره درس مورد نظر را وارد نمایید : </h4> </div>
                                                                                        <div class="modal-body">
                                                                                            <form id="mark_enroll_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" style="" action="<?php echo base_url(); ?>enrollment/student-enroll-practical-exam-mark" method="post">
                                                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                <input name="course_id" type="hidden" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="mark_stage" value="third_p_status">
                                                                                                <input type="hidden" name="exam_stage" value="third_practical">
                                                                                                <div class="form-group">
                                                                                                    <label for="mark" class="text-danger ">نمره اخذ شده در آزمون عملی مرحله دوم درس <?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?></label>
                                                                                                    <input type="number"  name="mark" id="mark" class="form-control" placeholder="" required> <span class="help-block">کد ملی 10 رقمی <?php echo $this->session->userdata('studentDName');?> را وارد نمایید</span></div>
                                                                                                <?php if (validation_errors() && form_error('mark')): ?>
                                                                                                    <div class="alert alert-danger"><?php echo form_error('mark'); ?></div>
                                                                                                <?php endif; ?>
                                                                                                <button type="submit" class="btn btn-danger waves-effect waves-light">ثبت نمره</button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="modal-footer">

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        <?php elseif ($course->third_w_status > 50 && $course->third_written === '2' && $course->third_p_status < 70): ?>
                                                                            <span class="label label-danger">عملی مرحله بعد</span>

                                                                        <?php elseif ($course->third_w_status < 50 && $course->third_written === '2'): ?>
                                                                            <span class="label label-danger">کتبی مرحله بعد</span>

                                                                        <?php elseif ($course->third_written === '2' && $course->third_w_status >= 50 && $course->third_p_status >= 70): ?>
                                                                            <span class="label label-info">
                                                                                <?php echo htmlspecialchars($course->third_p_status, ENT_QUOTES); ?>
                                                                            </span>

                                                                        <?php elseif ($course->final_w_mark >= 50 && $course->first_p_status < 70 && $course->first_practical === '2' && $course->second_p_status < 70 && $course->second_practical === '2' && $course->third_practical === '0'): ?>
                                                                            <div class="modal fade bs-example-modal-sm" id="third_p_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog modal-sm">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                            <h4 class="modal-title" id="mySmallModalLabel">تاریخ آزمون را وارد نمایید : </h4> </div>
                                                                                        <div class="modal-body">
                                                                                            <form id="enroll_alone_p_exam_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" action="<?php echo base_url(); ?>enrollment/student-enroll-in-practical-alone" method="post">
                                                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                <div class="form-group">
                                                                                                    <input type="date" id="birthday" name="exam_date"   class="form-control birth-date" placeholder="1396/01/22" required="">
                                                                                                </div>
                                                                                                <input name="course_id" type="hidden" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="exam_stage" value="third_practical">
                                                                                                <input type="hidden" name="exam_id" value="3">
                                                                                                <input type="hidden" name="exam_cost" value="<?php echo htmlspecialchars($exams[2]->exam_cost); ?>">
                                                                                                <div class="form-group">
                                                                                                    <button type="submit" class="btn btn-success form-control">ثبت نهایی</button>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- /.modal-content -->
                                                                                </div>
                                                                                <!-- /.modal-dialog -->
                                                                            </div>
                                                                            <!-- /.modal -->
                                                                            <span style="cursor: pointer" alt="default" data-toggle="modal" data-target="#third_p_modal"  class="label label-primary">ثبت نام در عملی</span>

                                                                        <?php elseif ($course->second_w_status >= 50 && $course->second_p_status < 70 && $course->second_practical === '2' && $course->second_written === '2' && $course->third_practical === '1'): ?>
                                                                            <button  class="btn label-warning label" alt="default" data-toggle="modal" data-target="#mark_p_a_3">در انتطار ثبت نمره</button>
                                                                            <div id="mark_p_a_3"  class="modal fade bg-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
                                                                                            <h4 class="modal-title">نمره درس مورد نظر را وارد نمایید : </h4> </div>
                                                                                        <div class="modal-body">
                                                                                            <form id="mark_enroll_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" style="" action="<?php echo base_url(); ?>enrollment/student-enroll-practical-exam-mark" method="post">
                                                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                <input name="course_id" type="hidden" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>">
                                                                                                <input type="hidden" name="mark_stage" value="third_p_status">
                                                                                                <input type="hidden" name="exam_stage" value="third_practical">
                                                                                                <div class="form-group">
                                                                                                    <label for="mark" class="text-danger ">نمره اخذ شده در آزمون عملی مرحله سوم درس <?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?></label>
                                                                                                    <input type="number"  name="mark" id="mark" class="form-control" placeholder="" required> <span class="help-block">کد ملی 10 رقمی <?php echo $this->session->userdata('studentDName');?> را وارد نمایید</span></div>
                                                                                                <?php if (validation_errors() && form_error('mark')): ?>
                                                                                                    <div class="alert alert-danger"><?php echo form_error('mark'); ?></div>
                                                                                                <?php endif; ?>
                                                                                                <button type="submit" class="btn btn-danger waves-effect waves-light">ثبت نمره</button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="modal-footer">

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        <?php elseif ($course->third_practical === '2'): ?>
                                                                            <span class="label label-info">
                                                                                <?php echo htmlspecialchars($course->third_p_status, ENT_QUOTES); ?>
                                                                            </span>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($course->final_w_status === '1' && $course->final_w_mark >= 50): ?>
                                                                            <span class="label label-success">
                                                                                <?php echo htmlspecialchars($course->final_w_mark, ENT_QUOTES) . 'قبول'; ?>
                                                                            </span>
                                                                        <?php elseif ($course->final_w_status === '1' && $course->final_w_mark < 50): ?>
                                                                            <span class="label label-danger">
                                                                                <?php echo htmlspecialchars($course->final_w_mark, ENT_QUOTES) . 'مردود'; ?>
                                                                            </span>
                                                                        <?php else: ?>
                                                                            <span class="label label-warning">
                                                                                در لیست انتظار
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($course->final_p_status === '1' && $course->final_p_mark >= 70): ?>
                                                                            <span class="label label-success">
                                                                                <?php echo htmlspecialchars($course->final_p_mark, ENT_QUOTES) . 'قبول'; ?>
                                                                            </span>
                                                                        <?php elseif ($course->final_p_status === '1' && $course->final_p_mark < 70): ?>
                                                                            <span class="label label-danger">
                                                                                <?php echo htmlspecialchars($course->final_p_mark, ENT_QUOTES) . 'مردود'; ?>
                                                                            </span>
                                                                        <?php else: ?>
                                                                            <span class="label label-warning">
                                                                                در لیست انتظار
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($course->final_exam_status === '1' && $course->final_exam_mark >= 70): ?>
                                                                            <span class="label label-success">
                                                                                <?php echo htmlspecialchars($course->final_exam_mark, ENT_QUOTES) . 'قبول'; ?>
                                                                            </span>
                                                                        <?php elseif ($course->final_exam_status === '1' && $course->final_exam_mark < 70): ?>
                                                                            <span class="label label-danger">
                                                                                <?php echo htmlspecialchars($course->final_exam_mark, ENT_QUOTES) . 'مردود'; ?>
                                                                            </span>
                                                                        <?php else: ?>
                                                                            <span class="label label-warning">
                                                                                در لیست انتظار
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Button trigger modal -->
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
