<div class="col-sm-12">
    <div class="white-box">
        <div class="table-responsive">

            <?php if ($this->session->flashdata('id')) : ?>
                <div class="alert alert-success">تیکت شما با موفقیت ارسال شد<span class="pull-right"><a href="<?= base_url('student/tickets/info-employee-tickets/' . $this->session->flashdata('id')) ?>" >مشاهده</a></span></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error-upload')) : ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error-upload') ?></div>
            <?php endif; ?>

            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>نام <?php echo $this->session->userdata('teacherDName'); ?></th>
                        <th class="text-center">کدملی</th>
                        <th class="text-center">ارسال تیکت</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>نام <?php echo $this->session->userdata('teacherDName'); ?></th>
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
                                    <div id="myModal_<?php echo htmlspecialchars($sCourse->employee_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title text-center" id="myModalLabel">ارسال تیکت</h4> </div>
                                                <div class="modal-body">
                                                    <form class="" id='send_st_<?php echo htmlspecialchars($sCourse->student_id); ?>' action="<?php echo base_url(); ?>student/tickets/send-to-employee" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                        <input type="hidden" name="employee_nc" value="<?php echo htmlspecialchars($sCourse->national_code, ENT_QUOTES); ?>">
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
                                    <a href="" class="mdi mdi-comment-check-outline text-inverse" alt="default" data-toggle="modal" data-target="#myModal_<?php echo htmlspecialchars($sCourse->employee_id, ENT_QUOTES); ?>" data-original-title="ارسال"></a>
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
