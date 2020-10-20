<div class="col-sm-12">
    <div class="white-box">
        <div class="table-responsive">

            <?php if ($this->session->flashdata('id')) : ?>
                <div class="alert alert-success">تیکت شما با موفقیت ارسال شد<span class="pull-right"><a href="<?= base_url('tickets/info-employee-tickets/' . $this->session->flashdata('id')) ?>" >مشاهده</a></span></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error-upload')) : ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error-upload') ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
            <?php endif; ?>

            <div class="col-lg-12 col-sm-12 col-xs-12 m-b-20 m-t-10">
                <div class="col-lg-6 col-sm-6 col-xs-12 m-b-10">
                    <a href="#"  alt="default" class="btn btn-block btn-info btn-rounded" data-toggle="modal" data-target="#myModal_all" data-original-title="ارسال"><span class="fa fa-comment-alt m-r-20"></span>ارسال تیکت به همه <?php echo $this->session->userdata('teacherDName'); ?> ها <span class="fa fa-comment-alt m-l-20"></span></a>
                </div>
                <div id="myModal_all" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title text-center" id="myModalLabel">ارسال تیکت</h4> </div>
                            <div class="modal-body">
                                <form class="" id='send_all' action="<?= base_url('send-to-employee'); ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
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

                <div class="col-lg-6 col-sm-6 col-xs-12">
                    <a href="#"  alt="default" class="btn btn-block btn-primary btn-rounded" data-toggle="modal" data-target="#myModal_all_sms" data-original-title="ارسال"> <span class="fa fa-mobile-alt m-r-20"></span> ارسال پیامک به همه <?php echo $this->session->userdata('teacherDName'); ?> ها<span class="fa fa-mobile-alt m-l-20"></span></a>
                </div>
                <div id="myModal_all_sms" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content text-center">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title text-center" id="myModalLabel">ارسال پیامک به همه <?= $this->session->userdata('teacherDName').' ها' ?></h4>
                            </div>
                            <div class="modal-body">
                                <form class="" id='send_all' action="<?= base_url('send-sms-to-employee'); ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                    <div class="form-group">
                                        <label class="m-t-30">محتوای پیامک</label>
                                        <hr class="m-t-5" style="background-color: black; width: 50%" />
                                        <label class="m-t-20">با عرض سلام خدمت <?= htmlspecialchars($this->session->userdata('teacherDName'), ENT_QUOTES) ?> گرامی؛</label>
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
            </div>

            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <!--<th>کد <?php echo $this->session->userdata('teacherDName'); ?></th>-->
                        <th>نام <?php echo $this->session->userdata('teacherDName'); ?></th>
                        <th class="text-center">کدملی</th>
                        <th class="text-center">تیکت</th>
                        <th class="text-center">پیامک</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <!--<th>کد <?php echo $this->session->userdata('teacherDName'); ?></th>-->
                        <th>نام <?php echo $this->session->userdata('teacherDName'); ?></th>
                        <th class="text-center">کدملی</th>
                        <th class="text-center">تیکت</th>
                        <th class="text-center">پیامک</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if ($employers_info): ?>
                        <?php foreach ($employers_info as $employee): ?>
                            <tr>
                                <!--<td><?php echo htmlspecialchars($employee->employee_id, ENT_QUOTES) ?></td>-->
                                <td>
                                    <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo htmlspecialchars($employee->pic_name, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                                    <?php echo htmlspecialchars($employee->first_name . ' ' . $employee->last_name, ENT_QUOTES); ?>
                                </td>
                                <td class="text-center"><?php echo htmlspecialchars($employee->national_code, ENT_QUOTES) ?></td>

                                <td class="text-center">
                                    <a href="#"  alt="default" data-toggle="modal" data-target="#myModal_em_<?php echo htmlspecialchars($employee->employee_id, ENT_QUOTES); ?>" data-original-title="ارسال"> <i class="fa fa-comment-alt text-inverse"></i> </a>

                                    <div id="myModal_em_<?php echo htmlspecialchars($employee->employee_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">ارسال تیکت</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="" id='send_st_<?php echo htmlspecialchars($employee->employee_id); ?>' action="<?php echo base_url('send-to-employee'); ?>" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                        <input type="hidden" name="employee_nc" value="<?php echo htmlspecialchars($employee->national_code, ENT_QUOTES); ?>">
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
                                    <a href="#"  alt="default" data-toggle="modal" data-target="#myModal_em_sms_<?php echo htmlspecialchars($employee->employee_id, ENT_QUOTES); ?>" data-original-title="ارسال"> <i class="fa fa-mobile-alt text-inverse"></i> </a>

                                    <div id="myModal_em_sms_<?php echo htmlspecialchars($employee->employee_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">ارسال پیامک</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="" id='send_st_<?php echo htmlspecialchars($employee->employee_id); ?>' action="<?php echo base_url('send-sms-to-employee'); ?>" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                        <input type="hidden" name="employee_nc" value="<?php echo htmlspecialchars($employee->national_code, ENT_QUOTES); ?>">
                                                        <div class="form-group">
                                                            <label class="m-t-30">محتوای پیامک</label>
                                                            <hr class="m-t-5" style="background-color: black; width: 50%" />
                                                            <label class="m-t-20">با عرض سلام خدمت <?= htmlspecialchars($this->session->userdata('teacherDName'), ENT_QUOTES) ?> گرامی؛</label>
                                                            <textarea name="sms_body" class="form-control m-b-5" rows="4" cols="50" required="" placeholder="متن شما"></textarea>
                                                            <label class="m-b-30"><?= $this->session->userdata('academyDName') . " " . $this->session->userdata('academy_name') ?></label>
                                                        </div>
                                                        <div class="form-group m-t-20">
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
