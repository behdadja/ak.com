<div class="col-sm-12">
    <div class="white-box">
        <div class="row">
            <?php foreach ($courseofemployer as $cm): ?>
                <div class="col-md-6">
                    <h2 class="box-title m-b-0 text-blue"> دوره: <?php echo $lesson_name = $cm->lesson_name; ?></h2>
                </div>
            <?php endforeach; ?>
            <div class="col-md-12">
                <?php if ($this->session->flashdata('delete_file')) : ?>
                    <div class="alert alert-success"><?php echo $this->session->flashdata('delete_file'); ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error-upload')) : ?>
                    <div class="alert alert-danger"><?php echo $this->session->flashdata('error-upload'); ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('insert-success')) : ?>
                    <div class="alert alert-success"><?php echo $this->session->flashdata('insert-success'); ?></div>
                <?php endif; ?>
            </div>
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
                        <th style="text-align: center">مدت زمان(دقیقه)</th>
                        <th style="text-align: center">ارسال فایل آموزشی</th>
                        <th style="text-align: center">فایل های ارسال شده</th>
                        <th style="text-align: center">لیست <?php echo $this->session->userdata('studentDName') . " ها"; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($attendancelist)) {
                        foreach ($attendancelist as $more):
                            if ($more->meeting_number != null):
                                $meeting = $more->meeting_number;
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars("جلسه  ".$meeting, ENT_QUOTES); ?></td>
                                    <td><?php echo htmlspecialchars($more->time_meeting, ENT_QUOTES); ?></td>
                                    <td class="text-center">
                                        <a alt="default" data-toggle="modal" data-target="#course_<?php echo $courseid . $meeting; ?>"><i class="glyphicon glyphicon-download-alt"></i></a>
                                        <div id="course_<?php echo $courseid . $meeting; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title" id="myModalLabel">ارسال مطلب آموزشی</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal" action="<?= base_url(); ?>teacher/courses/ufile-awareness" enctype="multipart/form-data" method="post">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                            <input type="hidden" name="course_id" class="form-control" value="<?php echo $courseid; ?>">
                                                            <input type="hidden" name="meeting_number" class="form-control" value="<?php echo $meeting; ?>"> 
                                                            <input type="hidden" name="lesson_name" class="form-control" value="<?php echo $lesson_name; ?>"> 
                                                            <div class="form-group">
                                                                <label class="col-md-12">موضوع یا عنوان<span class="help"></span></label>
                                                                <div class="col-md-12">
                                                                    <input type="text" name="awareness_title" class="form-control" value="" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="text-danger" for="input-file-now"> ارسال فایل با پسوندهای  pdf ، mp4 ، doc ، docx ، txt ، jpg ، jpeg و png امکان پذیر است.</label>
                                                                <input type="file" id="input-file-now" name="awareness_file" required class="dropify" />
                                                            </div>
                                                            <button type="submit" style="width: 80%" class="btn btn-success">ثبت</button>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-info" data-dismiss="modal">بستن</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    </td>
                                    <td>
                                        <a alt="default" data-toggle="modal" data-target="#file_<?= $courseid . $meeting; ?>"> <i class="glyphicon glyphicon-open"></i> </a>
                                        <!-- /.modal -->
                                        <div id="file_<?= $courseid . $meeting; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">دوره  <?php echo $lesson_name; ?> جلسه  <?php echo $meeting; ?></h4> </div>
                                                    <div class="modal-body">
                                                        <table class="table table-bordered" style="text-align: center">
                                                            <thead>
                                                                <tr>
                                                                    <th style="text-align: center">عنوان فایل</th>
                                                                    <th style="text-align: center">دریافت</th>
                                                                    <th style="text-align: center">حذف</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (!empty($awareness_subject)):
                                                                    foreach ($awareness_subject as $as):
                                                                        if ($as->course_id === $more->course_id && $as->meeting_number === $meeting):
                                                                            ?>
                                                                            <tr>
                                                                                <td><label><?php echo $as->awareness_subject_title; ?></label></td>
                                                                                <td><a class="btn btn-success" href="<?php echo base_url('/assets/awareness/' . $as->file_name); ?>"><?php echo $as->file_name; ?></a></td>
                                                                                <td><a href="<?php echo base_url('teacher/courses/delete_file/' . $more->course_id . "/" . $as->awareness_subject_id); ?>" class="glyphicon glyphicon-remove text-danger"></a></td>
                                                                            </tr>
                                                                            <?php
                                                                        endif;
                                                                    endforeach;
                                                                else:
                                                                    ?>
                                                                    <tr>
                                                                        <td class="text-danger text-center">
                                                                            فایلی ثبت نشده است
                                                                        </td>
                                                                        <td class="text-danger text-center">
                                                                            ***
                                                                        </td>
                                                                        <td class="text-danger text-center">
                                                                            ***
                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-info" data-dismiss="modal">بستن</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><a href="<?= base_url(); ?>teacher/courses/students_of_course/<?php echo htmlspecialchars($courseid, ENT_QUOTES) ?>/<?php echo htmlspecialchars($meeting, ENT_QUOTES) ?>"><i class="glyphicon glyphicon-equalizer"></i></a></td>
                                </tr>
                            <?php endif; ?>
                            <?php
                        endforeach;
                    } else {
                        ?>
                        <tr>
                            <td class="text-danger text-center"> جلسه ای ثبت نشده است</td>
                            <td class="text-danger text-center">***</td>
                            <td class="text-danger text-center">***</td>
                            <td class="text-danger text-center">***</td>
                            <td class="text-danger text-center">***</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($attendancelist)): ?>
            <div class="col-md-12">
                <div class="form-actions">
                    <a href="<?= base_url(); ?>teacher/courses/insert-new-meeting/<?php echo htmlspecialchars($courseid, ENT_QUOTES) ?>/<?php echo htmlspecialchars($meeting, ENT_QUOTES) ?>"
                       style="float:left" class="btn btn-success"> <i class="fa fa-check"></i> افزودن جلسه</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

