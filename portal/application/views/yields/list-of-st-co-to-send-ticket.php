
<!-- Notifications -->
<div class="m-t-20">
    <?php if ($this->session->flashdata('id')) : ?>
        <div class="alert alert-success">تیکت شما با موفقیت ارسال شد<span class="pull-right"><a href="<?= base_url('tickets/info-student-tickets/' . $this->session->flashdata('id')) ?>" >مشاهده</a></span></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error-upload')) : ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error-upload') ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
</div>
<!-- /Notifications -->

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
                            <div class="col-lg-12 col-sm-12 col-xs-12 m-b-20 m-t-10">
                                <div class="col-lg-6 col-sm-6 col-xs-12m-b-10">

                                    <a href="#"  alt="default" class="btn btn-block btn-primary btn-rounded" data-toggle="modal" data-target="#Modal_ticket_all" data-original-title="ارسال"><span class="fa fa-comment-alt m-r-20"></span>ارسال تیکت به همه <?php echo $this->session->userdata('studentDName'); ?> ها <span class="fa fa-comment-alt m-l-20"></span></a>
                                    <div id="Modal_ticket_all" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title text-center" id="myModalLabel">ارسال تیکت به همه <?= $this->session->userdata('studentDName').' ها'; ?></h4></div>
                                                <div class="modal-body">
                                                    <form action="<?php echo base_url(); ?>tickets/send-to-student" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
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
                                    <!-- /modal -->

                                </div>
                                <div class="col-lg-6 col-sm-6 col-xs-12">

                                    <a href=""  alt="default" class="btn btn-block btn-info btn-rounded" data-toggle="modal" data-target="#Modal_sms_all" data-original-title="ارسال"><span class="fa fa-mobile-alt m-r-20"></span>ارسال پیامک به همه <?php echo $this->session->userdata('studentDName'); ?> ها <span class="fa fa-mobile-alt m-l-20"></span></a>
                                    <div id="Modal_sms_all" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content text-center">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">ارسال پیامک به <?= htmlspecialchars($this->session->userdata('studentDName'), ENT_QUOTES) ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="<?= base_url('send-sms-to-student'); ?>" method="post">
                                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                                        <div class="form-group">
                                                            <label class="m-t-30">محتوای پیامک</label>
                                                            <hr class="m-t-5" style="background-color: black; width: 50%" />
                                                            <label class="m-t-20">با عرض سلام خدمت <?= htmlspecialchars($this->session->userdata('studentDName'), ENT_QUOTES) ?> گرامی؛</label>
                                                            <textarea name="sms_body" class="form-control m-b-5" rows="4" cols="50" required="" placeholder="متن شما"></textarea>
                                                            <label class="m-b-30"><?= $this->session->userdata('academyDName') . " " . $this->session->userdata('academy_name') ?></label>
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
                                    <!-- /modal -->

                                </div>
                            </div>

                            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">کد</th>
                                    <th>نام <?php echo $this->session->userdata('studentDName'); ?></th>
                                    <th class="text-center">کدملی</th>
                                    <th class="text-center">تیکت</th>
                                    <th class="text-center">پیامک</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th class="text-center">کد</th>
                                    <th>نام <?php echo $this->session->userdata('studentDName'); ?></th>
                                    <th class="text-center">کدملی</th>
                                    <th class="text-center">تیکت</th>
                                    <th class="text-center">پیامک</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php if (!empty($students)): ?>
                                    <?php foreach ($students as $student): ?>
                                        <tr>
                                            <td class="text-center"><?php echo htmlspecialchars($student->student_id, ENT_QUOTES); ?></td>
                                            <td>
                                                <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo htmlspecialchars($student->pic_name, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                                                <?php echo htmlspecialchars($student->first_name, ENT_QUOTES) . ' ' . htmlspecialchars($student->last_name, ENT_QUOTES); ?>
                                            </td>
                                            <td class="text-center"><?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?></td>
                                            <td class="text-center">
                                                <a href="#" class="fa fa-comment-alt text-inverse" alt="default" data-toggle="modal" data-target="#myModal_st_<?php echo htmlspecialchars($student->student_id, ENT_QUOTES); ?>"></a>

                                                <div id="myModal_st_<?php echo htmlspecialchars($student->student_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title text-center" id="myModalLabel">ارسال تیکت</h4></div>
                                                            <div class="modal-body">
                                                                <form class="" id='send_st_<?php echo htmlspecialchars($student->student_id); ?>' action="<?php echo base_url(); ?>tickets/send-to-student" method="post" enctype="multipart/form-data">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?>">
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
                                            </td>
                                            <td class="text-center">

                                                <a href="#" class="fa fa-mobile-alt text-inverse" alt="default" data-toggle="modal" data-target="#myModal_st_sms_<?= htmlspecialchars($student->student_id, ENT_QUOTES); ?>"></a>
                                                <div id="myModal_st_sms_<?= htmlspecialchars($student->student_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title" id="myModalLabel">ارسال پیامک به <?= htmlspecialchars($this->session->userdata('studentDName'), ENT_QUOTES) ?></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?= base_url('send-sms-to-student'); ?>" method="post">
                                                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="student_nc" value="<?= htmlspecialchars($student->national_code, ENT_QUOTES); ?>">
                                                                    <input type="hidden" name="type_send" value="one">
                                                                    <div class="form-group">
                                                                        <label class="m-t-30">محتوای پیامک</label>
                                                                        <hr class="m-t-5" style="background-color: black; width: 50%" />
                                                                        <label class="m-t-20">با عرض سلام خدمت <?= htmlspecialchars($this->session->userdata('studentDName'), ENT_QUOTES) ?> گرامی؛</label>
                                                                        <textarea name="sms_body" class="form-control m-b-5" rows="4" cols="50" required="" placeholder="متن شما"></textarea>
                                                                        <label class="m-b-30"><?= $this->session->userdata('academyDName') . " " . $this->session->userdata('academy_name') ?></label>
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
                                                <!-- /modal -->
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
                        <!--<h3 class="box-title">ارسال تیکت به <?= $this->session->userdata('studentDName') . " های"; ?> دوره مورد نظر</h3>-->
                        <div class="table-responsive">
                            <?php if ($this->session->flashdata('success-insert')) : ?>
                                <div class="alert alert-success"><?php echo $this->session->flashdata('success-insert'); ?></div>
                            <?php endif; ?>
                            <table id="example24" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">کد دوره</th>
                                    <th>نام درس</th>
                                    <th class="text-center"><?= htmlspecialchars($this->session->userdata('teacherDName'), ENT_QUOTES) ?> دوره</th>
                                    <th class="text-center">کد ملی <?= htmlspecialchars($this->session->userdata('teacherDName'), ENT_QUOTES) ?></th>
                                    <th class="text-center">تیکت</th>
                                    <th class="text-center">پیامک</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($courses)): ?>
                                    <?php foreach ($courses as $course): ?>
                                        <tr>
                                            <td class="text-center"><?= htmlspecialchars($course->course_id, ENT_QUOTES); ?></td>
                                            <td>
                                                <img src="<?php echo base_url(); ?>assets/course-picture/thumb/<?php echo htmlspecialchars($course->course_pic, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                                                <?= htmlspecialchars($course->lesson_name, ENT_QUOTES); ?>
                                            </td>
                                            <td class="text-center"><?= htmlspecialchars($course->first_name.' '.$course->last_name, ENT_QUOTES); ?></td>
                                            <td class="text-center"><?= htmlspecialchars($course->course_master, ENT_QUOTES); ?></td>
                                            <td class="text-center">

                                                <a href="#"  alt="default" data-toggle="modal" data-target="#myModal_cu_<?= htmlspecialchars($course->course_id, ENT_QUOTES); ?>"> <i class="fa fa-comment-alt text-inverse m-r-10" data-toggle="tooltip" data-original-title="تیکت"></i> </a>
                                                <div id="myModal_cu_<?= htmlspecialchars($course->course_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title" id="myModalLabel">ارسال تیکت به <?= htmlspecialchars($this->session->userdata('studentDName').' های دوره', ENT_QUOTES) ?></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?= base_url('tickets/send-to-student'); ?>" method="post" enctype="multipart/form-data">
                                                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="course_id" value="<?= htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
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
<!--                                                                    <div class="col-sm-6">-->
<!--                                                                        <div class="checkbox checkbox-info">-->
<!--                                                                            <input class="m-l-10" id="checkbox4" name="announcement" type="checkbox">-->
<!--                                                                            <label for="checkbox4">-->
<!---->
<!--                                                                                <a class="mytooltip" href="javascript:void(0)">انتخاب به عنوان اطلاعیه-->
<!--                                                                                    <span class="tooltip-content5">-->
<!--                                                                                                    <span class="tooltip-text3">-->
<!--                                                                                                        <span class="tooltip-inner2">در صورت انتخاب این گزینه<br />--><?//= $this->session->userdata('studentDName') ?><!-- توانایی پاسخ به تیکت <br />را ندارد.-->
<!--                                                                                                        </span>-->
<!--                                                                                                    </span>-->
<!--                                                                                                </span>-->
<!--                                                                                </a>-->
<!---->
<!--                                                                            </label>-->
<!--                                                                        </div>-->
<!--                                                                    </div>-->
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
                                                <!-- /modal -->
                                            </td>
                                            <td class="text-center">
                                                <a href="#"  alt="default" data-toggle="modal" data-target="#myModal_sms_cu_<?= htmlspecialchars($course->course_id, ENT_QUOTES); ?>"> <i class="fa fa-mobile-alt text-inverse m-r-10" data-toggle="tooltip" data-original-title="پیامک"></i> </a>
                                                <div id="myModal_sms_cu_<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title" id="myModalLabel">ارسال پیامک به <?= htmlspecialchars($this->session->userdata('studentDName').' های دوره', ENT_QUOTES) ?></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?= base_url('send-sms-to-student'); ?>" method="post">
                                                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="course_id" value="<?= htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                    <div class="form-group">
                                                                        <label class="m-t-30">محتوای پیامک</label>
                                                                        <hr class="m-t-5" style="background-color: black; width: 50%" />
                                                                        <label class="m-t-20">با عرض سلام خدمت <?= htmlspecialchars($this->session->userdata('studentDName'), ENT_QUOTES) ?> گرامی؛</label>
                                                                        <textarea name="sms_body" class="form-control m-b-5" rows="4" cols="50" required="" placeholder="متن شما"></textarea>
                                                                        <label class="m-b-30"><?= $this->session->userdata('academyDName') . " " . $this->session->userdata('academy_name') ?></label>
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
                                                <!-- /modal -->

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
        </div>
        <!-- /content -->
    </div>
    <!-- /tabs -->
</section>
