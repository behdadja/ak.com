
<div class="m-t-20">
    <?php if ($this->session->flashdata('id')) : ?>
        <div class="alert alert-success">تیکت شما با موفقیت ارسال شد<span class="pull-right"><a href="<?= base_url('teacher/tickets/info-student-tickets/' . $this->session->flashdata('id')) ?>" >مشاهده</a></span></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error-upload')) : ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error-upload') ?></div>
    <?php endif; ?>
</div>

<section class="m-t-30">
    <div class="sttabs tabs-style-linebox">
        <nav>
            <ul>
                <li><a href="#students" >ارسال به <?php echo $this->session->userdata('studentDName'); ?></a></li>
                <li><a href="#courses">ارسال به <?php echo $this->session->userdata('studentDName') . " های"; ?> دوره مورد نظر</a></li>
            </ul>
        </nav>
        <div class="content-wrap">
            <section id="students">

                <div class="col-sm-12">
                    <div class="white-box">
                        <div class="table-responsive">
                            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>نام <?php echo $this->session->userdata('studentDName'); ?></th>
                                    <th class="text-center">کدملی</th>
                                    <th class="text-center">ارسال تیکت</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>نام <?php echo $this->session->userdata('studentDName'); ?></th>
                                    <th class="text-center">کدملی</th>
                                    <th class="text-center">ارسال تیکت</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php if (!empty($sCourses)): ?>
                                    <?php foreach ($sCourses as $sCourse): ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo htmlspecialchars($sCourse->pic_name, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                                                <?php echo htmlspecialchars($sCourse->first_name . ' ' . $sCourse->last_name, ENT_QUOTES); ?>
                                            </td>
                                            <td style="text-align: center"><?php echo htmlspecialchars($sCourse->national_code, ENT_QUOTES); ?></td>
                                            <td style="text-align: center">

                                                <a href="" class="mdi mdi-comment-check-outline text-inverse" alt="default" data-toggle="modal" data-target="#myModal_<?php echo htmlspecialchars($sCourse->student_id, ENT_QUOTES); ?>" data-original-title="ارسال"></a>
                                                <div id="myModal_<?php echo htmlspecialchars($sCourse->student_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title text-center" id="myModalLabel">ارسال تیکت</h4> </div>
                                                            <div class="modal-body">
                                                                <form action="<?php echo base_url(); ?>teacher/tickets/send-to-student" method="post" enctype="multipart/form-data">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($sCourse->national_code, ENT_QUOTES); ?>">
                                                                    <div class="form-group">
                                                                        <input type="text" name="ticket_title" class="form-control" placeholder="عنوان">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <textarea name="ticket_body" class="form-control" rows="4" cols="50" required="" placeholder="متن"></textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label text-danger">ارسال فایل با پسوندهایpdf ، doc ، docx ، txt ، jpg ، jpeg و png امکان پذیر است</label>
                                                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                                            <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                                                <span class="fileinput-filename"></span>
                                                                            </div>
                                                                            <span class="input-group-addon btn btn-default btn-file">
                                                                    <span class="fileinput-new">انتخاب فایل ضمیمه</span>
                                                                    <span class="fileinput-exists">تغییر</span>
                                                                    <input type="hidden"><input type="file" name="ticket_file">
                                                                </span>
                                                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">حذف</a></div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <button type="submit" class="form-control btn btn-success">ارسال</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->

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
            </section>
            <section id="courses">

                <div class="col-sm-12">
                    <div class="white-box">
                        <div class="table-responsive">
                            <table id="example24" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">کد دوره</th>
                                    <th>نام درس</th>
                                    <th class="text-center">ارسال تیکت</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th class="text-center">کد دوره</th>
                                    <th>نام درس</th>
                                    <th class="text-center">ارسال تیکت</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php if (!empty($iCourses)): ?>
                                    <?php foreach ($iCourses as $iCourse): ?>
                                        <tr>
                                            <td style="text-align: center"><?php echo htmlspecialchars($iCourse->course_id, ENT_QUOTES); ?></td>
                                            <td>
                                                <img src="<?php echo base_url(); ?>assets/course-picture/thumb/<?php echo htmlspecialchars($iCourse->course_pic, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                                                <?php echo htmlspecialchars($iCourse->lesson_name, ENT_QUOTES); ?>
                                            </td>
                                            <td style="text-align: center">

                                                <a href="" class="mdi mdi-comment-check-outline text-inverse" alt="default" data-toggle="modal" data-target="#myModal_<?php echo htmlspecialchars($iCourse->course_id, ENT_QUOTES); ?>" data-original-title="ارسال"></a>
                                                <div id="myModal_<?php echo htmlspecialchars($iCourse->course_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title text-center" id="myModalLabel">ارسال تیکت</h4> </div>
                                                            <div class="modal-body">
                                                                <form action="<?php echo base_url(); ?>teacher/tickets/send-to-student" method="post" enctype="multipart/form-data">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($iCourse->course_id, ENT_QUOTES); ?>">
                                                                    <div class="form-group">
                                                                        <input type="text" name="ticket_title" class="form-control" placeholder="عنوان">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <textarea name="ticket_body" class="form-control" rows="4" cols="50" required="" placeholder="متن"></textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label text-danger">ارسال فایل با پسوندهایpdf ، doc ، docx ، txt ، jpg ، jpeg و png امکان پذیر است</label>
                                                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                                            <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                                                <span class="fileinput-filename"></span>
                                                                            </div>
                                                                            <span class="input-group-addon btn btn-default btn-file">
                                                                                <span class="fileinput-new">انتخاب فایل ضمیمه</span>
                                                                                <span class="fileinput-exists">تغییر</span>
                                                                                <input type="hidden"><input type="file" name="ticket_file">
                                                                            </span>
                                                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">حذف</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <button type="submit" class="form-control btn btn-success">ارسال</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->

                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                else:
                                ?>
                                <tr>
                                    <th class="text-center text-danger">دوره ای به نام شما ثبت نشده است.</th>
                                    <th class="text-center text-danger">*</th>
                                    <th class="text-center text-danger">*</th>
                                </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
</section>

