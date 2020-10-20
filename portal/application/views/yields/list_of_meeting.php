<div class="col-sm-12">
    <div class="white-box">
        <div class="row">
            <?php foreach ($courseofemployer as $cm): ?>
                <div class="col-md-6">
                    <h2 class="box-title m-b-0 text-blue">نام دوره: <?php echo $cm->lesson_name; ?></h2>
                </div>
                <div class="col-md-6">
                    <h2 class="box-title m-b-0 text-blue"><?php echo $this->session->userdata('teacherDName'); ?>: <?php echo $cm->first_name . ' ' . $cm->last_name; ?></h2>
                </div>
            <?php endforeach; ?>
        </div>
        <br><br>
        <div class="table-responsive">
            <?php if ($this->session->flashdata('enroll-e')) : ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('enroll-e'); ?></div>
            <?php endif; ?>
            <table class="table table-bordered center" style="text-align: center">
                <thead>
                    <tr>
                        <th style="text-align: center">لیست جلسات</th>
                        <th style="text-align: center">تاریخ برگزاری</th>
                        <th style="text-align: center">مدت زمان(دقیقه)</th>
                        <th style="text-align: center">جزئیات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($attendancelist)) {
                        foreach ($attendancelist as $more):
                            if ($more->meeting_number != null):
                                $meeting_number = $more->meeting_number;
                                ?>
                                <tr>
                                    <td class="text_center">جلسه<?php echo htmlspecialchars($meeting_number, ENT_QUOTES); ?></td>
                                    <td class="text_center"><?php echo htmlspecialchars($more->date, ENT_QUOTES); ?></td>
                                    <!--<td class="text_center"><input type="text" disabled style="background:white; border:0" name='start_date' value="<?php echo htmlspecialchars($more->date, ENT_QUOTES); ?>" id="start_date" class="start-date form-control text-center" /></td>-->
                                    <td class="text_center"><?php echo htmlspecialchars($more->time_meeting, ENT_QUOTES); ?></td>
                                    <td class="text_center">
                                        <?php if ($course_status !== '2'): ?>
                                            <a href="#" data-toggle="modal" data-target="#modal_<?php echo $meeting_number; ?>"> <i class="glyphicon glyphicon-pencil text-center m-r-10" data-toggle="tooltip" data-original-title="ویرایش مدت زمان"></i> </a>
                                        <?php endif; ?>
                                        <!-- .modal -->
                                        <div id="modal_<?php echo $meeting_number; ?>" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color: #edf0f2">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">ویرایش مدت زمان جلسه</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?php echo base_url('training/change-time-meeting'); ?>" method="post">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                            <div class="form-group">
                                                                <label>مدت زمان جدید:</label>
                                                                <input type="number" name="new_time_meeting" class="form-control" value="<?php echo $more->time_meeting ?>">
                                                                <input type="hidden" name="old_time_meeting" value="<?php echo $more->time_meeting ?>">
                                                                <input type="hidden" name="course_status" value="<?php echo $course_status ?>">
                                                                <input type="hidden" name="meeting_number" value="<?php echo $meeting_number ?>">
                                                                <input type="hidden" name="courseid" value="<?php echo $courseid ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <button class="form-control btn btn-success">ثبت</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">بستن</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="<?php echo base_url('training/students_of_course/' . $courseid . '/' . $meeting_number); ?>"> <i class="glyphicon glyphicon-equalizer text-center m-r-10" data-toggle="tooltip" data-original-title="لیست <?php echo $this->session->userdata('studentDName') . " ها"; ?>"></i> </a>
                                    </td>
                                </tr>
                                <?php
                            endif;
                        endforeach;
                    } else {
                        ?>
                        <tr>
                            <td class="text-danger text-center">
                                جلسه ای ثبت نشده است
                            </td>
                            <td class="text-danger text-center">
                                ***
                            </td>
                            <td class="text-danger text-center">
                                ***
                            </td>
                            <td class="text-danger text-center">
                                ***
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php
        foreach ($courseofemployer as $cm):
            $employer_nc = $cm->course_master;
        endforeach;
        if (!empty($attendancelist) && $course_status !== '2'):
            ?>
            <div class="col-md-12">
                <div class="form-actions">
                    <a href="#" onclick="event.preventDefault();document.getElementById('meeting_<?php echo htmlspecialchars($meeting_number, ENT_QUOTES); ?>').submit();" style="float:left" class="btn btn-success"> <i class="fa fa-check"></i> افزودن جلسه</a>
                    <form class="" id='meeting_<?php echo htmlspecialchars($meeting_number, ENT_QUOTES); ?>' style="display:none" action="<?php echo base_url(); ?>training/insert_new_meeting" method="post">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($courseid, ENT_QUOTES); ?>">
                        <input type="hidden" name="meeting" value="<?php echo htmlspecialchars($meeting_number, ENT_QUOTES); ?>">
                        <input type="hidden" name="course_status" value="<?php echo htmlspecialchars($course_status, ENT_QUOTES); ?>">
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

