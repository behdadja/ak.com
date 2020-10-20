<div class="col-sm-12">
    <div class="white-box">
        <div class="table-responsive">
            <h2 class="text-info">دوره های موجود جهت ایجاد آزمون آنلاین : </h2>
            <?php if ($this->session->flashdata('error')) : ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('insert-success')) : ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('insert-success'); ?></div>
            <?php endif; ?>
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">کد دوره</th>
                        <th class="text-center">توضیحات</th>
                        <th class="text-center">هزینه دوره</th>
                        <th class="text-center">مدت دوره</th>
                        <th class="text-center">ابزار</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">کد دوره</th>
                        <th class="text-center">توضیحات</th>
                        <th class="text-center">هزینه دوره</th>
                        <th class="text-center">مدت دوره</th>
                        <th class="text-center">ابزار</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if (!empty($courses)): ?>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td class="text-center"><?php echo htmlspecialchars($course->course_id, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($course->course_description, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($course->course_tuition, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($course->start_date, ENT_QUOTES) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-primary" alt="default" data-toggle="modal" data-target="#course_<?= $course->course_id; ?>">تعریف آزمون آنلاین</button>
                                    <div id="course_<?= $course->course_id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">ایجاد آزمون</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" action="<?= base_url(); ?>teacher/exams/create-exam" method="post">
                                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                        <input type="hidden" name="course_id" value="<?= $course->course_id; ?>">
                                                        <div class="form-group">
                                                            <div class="col-md-6 has-error">
                                                                <label class="col-md-6">تعداد سوالات خیلی سخت<span class="help"></span></label>
                                                                <input type="number" name="hard" class="form-control" value="" required>
                                                            </div>
                                                            <div class="col-md-6 has-warning">
                                                                <label class="col-md-6">تعداد سوالات سخت<span class="help"></span></label>
                                                                <input type="number" name="difficult" class="form-control" value="" required>
                                                            </div>
                                                            <div class="col-md-6 has-primery">
                                                                <label class="col-md-3">تعداد سوالات متوسط<span class="help"></span></label>
                                                                <input type="number" name="almost_hard" class="form-control" value="" required>
                                                            </div>
                                                            <div class="col-md-6 has-success">
                                                                <label class="col-md-3">تعداد سوالات آسان<span class="help"></span></label>
                                                                <input type="number" name="easy" class="form-control" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-6">سختی سوال<span class="help"></span></label>
                                                            <select class="form-control" name="course_student_id">
                                                                <option value="">انتخاب کنید</option>
                                                                <?php if (!empty($courses_students)): ?>
                                                                    <?php foreach ($courses_students as $key => $value): ?>
                                                                        <option value="<?= $value[0]->course_student_id; ?>">دوره با کد <?= $value[0]->course_student_id; ?></option>
                                                                        <?php
                                                                    endforeach;
                                                                endif;
                                                                ?>
                                                            </select>
                                                            <?php if (validation_errors() && form_error('course_student_id')): ?>
                                                                <div class="col-lg-12 col-sm-12 col-xs-12">
                                                                    <button class="btn btn-block btn-danger disabled"><?php echo form_error('course_student_id'); ?></button>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">ایجاد کردن</button>
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
