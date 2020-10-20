<div class="col-sm-12">
    <div class="white-box">
        <div class="table-responsive">
            <h2 class="text-info">دوره های من</h2>
            <?php if ($this->session->flashdata('error-upload')) : ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('error-upload'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('insert-success')) : ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('insert-success'); ?></div>
            <?php endif; ?>
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">نام دوره</th>
                        <th class="text-center">توضیحات دوره</th>
                        <th class="text-center">هزینه دوره</th>
                        <th class="text-center">تاریخ شروع</th>
                        <th class="text-center">ابزار</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">نام دوره</th>
                        <th class="text-center">توضیحات دوره</th>
                        <th class="text-center">هزینه دوره</th>
                        <th class="text-center">تاریخ شروع</th>
                        <th class="text-center">ابزار</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if (!empty($courses)): ?>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td class="text-center"><?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?> </td>
                                <td class="text-center"><?php echo htmlspecialchars($course->course_description, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($course->course_tuition, ENT_QUOTES) ?> </td>
                                <td class="text-center"><?php echo htmlspecialchars($course->start_date, ENT_QUOTES) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-primary" alt="default" data-toggle="modal" data-target="#course_<?= $course->course_id; ?>">ارسال فایل کمک آموزشی</button>
                                    <div id="course_<?= $course->course_id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">ارسال مطلب آموزشی</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" action="<?= base_url(); ?>teacher/awareness/ufile-awareness" enctype="multipart/form-data" method="post">
                                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                        <input type="hidden" name="course_id" value="<?= $course->course_id; ?>">
                                                        <div class="form-group">
                                                            <label class="col-md-12">موضوع یا عنوان<span class="help"></span></label>
                                                            <div class="col-md-12">
                                                                <input type="text" name="awareness_title" class="form-control" value="" required> 
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-12">انتخاب جلسه<span class="help"></span></label>
                                                            <div class="col-md-12">
                                                                <?php if (!empty($attendance)): ?>
                                                                    <select name="meeting_number" class="form-control" >
                                                                        <?php
                                                                        foreach ($attendance as $att):
                                                                            if ($att->course_id === $course->course_i):
                                                                                ?>
                                                                                <option value="<?php echo $att->meeting_number; ?>"><?php echo $att->meeting_number . " جلسه"; ?></option>
                                                                                <?php
                                                                            endif;
                                                                        endforeach;
                                                                    endif;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="text-danger" for="input-file-now">تنها ارسال فایل های فشرده با پسوندهای rar.* و zip.* امکانپذیر می باشد</label>
                                                            <input type="file" id="input-file-now" name="awareness_file" required class="dropify" />
                                                        </div>
                                                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">ثبت</button>
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
