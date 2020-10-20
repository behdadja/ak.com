
<!-- Notifications -->
<div class="m-t-20">
    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success">اطلاعیه شما با موفقیت ثبت شد<span class="pull-right"><a href="<?= base_url('manage-announcement') ?>" >مشاهده</a></span></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error-upload')) : ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error-upload') ?></div>
    <?php endif; ?>
<!--    --><?php //if ($this->session->flashdata('success')) : ?>
<!--        <div class="alert alert-success">--><?//= $this->session->flashdata('success') ?><!--</div>-->
<!--    --><?php //endif; ?>
</div>
<!-- /Notifications -->


<div class="col-md-4 panel panel-info block5">
    <div class="panel-heading text-center">
        <a href="" data-toggle="modal" data-target="#Modal_all_students" data-perform="panel-collapse"><span class="mdi mdi-presentation m-r-20"></span>ارسال اطلاعیه به همه <?php echo $this->session->userdata('studentDName'); ?> ها <span class="mdi mdi-presentation m-l-20"></span></a>
        <!-- modal all students -->
        <div id="Modal_all_students" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title text-center" id="myModalLabel">ارسال اطلاعیه به همه <?= $this->session->userdata('studentDName').' ها'; ?></h4>
                    </div>
                    <form action="<?php echo base_url('insert-announcement'); ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                            <input type="hidden" name="receiver" value="std">
                            <div class="form-group">
                                <input type="text" name="ant_title" class="form-control" placeholder="عنوان">
                            </div>
                            <div class="form-group">
                                <textarea name="ant_body" class="form-control" rows="4" cols="50" required="" placeholder="متن"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 m-b-20 p-t-10 p-b-10 text-inverse"  style="background-color: lavender">
                                    <div class="text-center p-b-10">
                                        <label class="control-label">انتخاب بازه زمانی جهت نمایش اطلاعیه:</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label">تاریخ شروع</label>
                                        <input type="text" name="start_time" placeholder="1370-01-22" class="form-control auto-close-example" onkeyup="
                                                        var date = this.value;
                                                        if (date.match(/^\d{4}$/) !== null) {
                                                            this.value = date + '-';
                                                        } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                            this.value = date + '-';
                                                        }" maxlength="10" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تاریخ شروع را وارد کنید')" onchange="try {
                                                                    setCustomValidity('');
                                                                } catch (e) {
                                                                }"><span class="help-block"></span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="control-label">تاریخ پایان</label>
                                        <input type="text" name="stop_time" placeholder="1370-01-22" class="form-control auto-close-example" onkeyup="
                                                        var date = this.value;
                                                        if (date.match(/^\d{4}$/) !== null) {
                                                            this.value = date + '-';
                                                        } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                            this.value = date + '-';
                                                        }" maxlength="10" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تاریخ پایان را وارد کنید')" onchange="try {
                                                                    setCustomValidity('');
                                                                } catch (e) {
                                                                }"><span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
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
                                <label class="control-label text-danger">ارسال فایل با پسوندهایpdf ، doc ، docx ، txt ، jpg ، jpeg و png امکان پذیر است</label>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="form-control btn btn-success">ارسال</button>
                    </div>
                        </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /modal -->
    </div>
</div>

<div class="col-md-4 panel panel-primary block5">
    <div class="panel-heading text-center">
        <a href="" data-toggle="modal" data-target="#Modal_all_employers" data-perform="panel-collapse"><span class="mdi mdi-presentation m-r-20"></span>ارسال اطلاعیه به همه <?php echo $this->session->userdata('teacherDName'); ?> ها <span class="mdi mdi-presentation m-l-20"></span></a>
        <!-- modal all employers -->
        <div id="Modal_all_employers" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title text-center" id="myModalLabel">ارسال اطلاعیه به همه <?= $this->session->userdata('teacherDName').' ها'; ?></h4>
                    </div>
                    <form action="<?php echo base_url('insert-announcement'); ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                            <input type="hidden" name="receiver" value="emp">
                            <div class="form-group">
                                <input type="text" name="ant_title" class="form-control" placeholder="عنوان">
                            </div>
                            <div class="form-group">
                                <textarea name="ant_body" class="form-control" rows="4" cols="50" required="" placeholder="متن"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 m-b-20 p-t-10 p-b-10 text-inverse"  style="background-color: lavender">
                                    <div class="text-center p-b-10">
                                        <label class="control-label">انتخاب بازه زمانی جهت نمایش اطلاعیه:</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label">تاریخ شروع</label>
                                        <input type="text" name="start_time" placeholder="1370-01-22" class="form-control auto-close-example" onkeyup="
                                                        var date = this.value;
                                                        if (date.match(/^\d{4}$/) !== null) {
                                                            this.value = date + '-';
                                                        } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                            this.value = date + '-';
                                                        }" maxlength="10" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تاریخ شروع را وارد کنید')" onchange="try {
                                                                    setCustomValidity('');
                                                                } catch (e) {
                                                                }"><span class="help-block"></span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="control-label">تاریخ پایان</label>
                                        <input type="text" name="stop_time" placeholder="1370-01-22" class="form-control auto-close-example" onkeyup="
                                                        var date = this.value;
                                                        if (date.match(/^\d{4}$/) !== null) {
                                                            this.value = date + '-';
                                                        } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                            this.value = date + '-';
                                                        }" maxlength="10" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تاریخ پایان را وارد کنید')" onchange="try {
                                                                    setCustomValidity('');
                                                                } catch (e) {
                                                                }"><span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
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
                                <label class="control-label text-danger">ارسال فایل با پسوندهایpdf ، doc ، docx ، txt ، jpg ، jpeg و png امکان پذیر است</label>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="form-control btn btn-success">ارسال</button>
                    </div>
                        </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /modal -->
    </div>
</div>
<div class="col-md-4 panel panel-success block5">
    <div class="panel-heading text-center">
        <a href="" data-toggle="modal" data-target="#Modal_all_members" data-perform="panel-collapse"><span class="mdi mdi-presentation m-r-20"></span>ارسال به همه  <?php echo $this->session->userdata('studentDName').' ها و '.$this->session->userdata('teacherDName').' ها'; ?><span class="mdi mdi-presentation m-l-20"></span></a>
        <!-- modal all members -->
        <div id="Modal_all_members" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title text-center" id="myModalLabel">ارسال اطلاعیه به همه اعضا</h4>
                    </div>
                    <form action="<?php echo base_url('insert-announcement'); ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                            <input type="hidden" name="receiver" value="all">
                            <div class="form-group">
                                <input type="text" name="ant_title" class="form-control" placeholder="عنوان">
                            </div>
                            <div class="form-group">
                                <textarea name="ant_body" class="form-control" rows="4" cols="50" required="" placeholder="متن"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 m-b-20 p-t-10 p-b-10 text-inverse"  style="background-color: lavender">
                                    <div class="text-center p-b-10">
                                        <label class="control-label">انتخاب بازه زمانی جهت نمایش اطلاعیه:</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label">تاریخ شروع</label>
                                        <input type="text" name="start_time" placeholder="1370-01-22" class="form-control auto-close-example" onkeyup="
                                                        var date = this.value;
                                                        if (date.match(/^\d{4}$/) !== null) {
                                                            this.value = date + '-';
                                                        } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                            this.value = date + '-';
                                                        }" maxlength="10" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تاریخ شروع را وارد کنید')" onchange="try {
                                                                    setCustomValidity('');
                                                                } catch (e) {
                                                                }"><span class="help-block"></span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="control-label">تاریخ پایان</label>
                                        <input type="text" name="stop_time" placeholder="1370-01-22" class="form-control auto-close-example" onkeyup="
                                                        var date = this.value;
                                                        if (date.match(/^\d{4}$/) !== null) {
                                                            this.value = date + '-';
                                                        } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                            this.value = date + '-';
                                                        }" maxlength="10" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تاریخ پایان را وارد کنید')" onchange="try {
                                                                    setCustomValidity('');
                                                                } catch (e) {
                                                                }"><span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
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
                                <label class="control-label text-danger">ارسال فایل با پسوندهایpdf ، doc ، docx ، txt ، jpg ، jpeg و png امکان پذیر است</label>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="form-control btn btn-success">ارسال</button>
                    </div>
                        </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /modal -->
    </div>
</div>


<div class="col-sm-12">
    <div class="panel panel-inverse block5">
        <div class="panel-heading text-center">
            <a href="" data-perform="panel-collapse"><span class="caret m-r-20"></span>ارسال اطلاعیه به دوره مورد نظر<span class="caret m-l-20"></span></a>
        </div>
        <div class="panel-wrapper collapse in" aria-expanded="true">
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="text-center">کد دوره</th>
                            <th>نام درس</th>
                            <th class="text-center"><?= htmlspecialchars($this->session->userdata('teacherDName'), ENT_QUOTES) ?> دوره</th>
                            <th class="text-center">کد ملی <?= htmlspecialchars($this->session->userdata('teacherDName'), ENT_QUOTES) ?></th>
                            <th class="text-nowrap text-center">ارسال</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($courses)): ?>
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td class="text-center"><?= htmlspecialchars($course->course_id, ENT_QUOTES); ?></td>
                                    <td>
                                        <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo htmlspecialchars($course->course_pic, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                                        <?= htmlspecialchars($course->lesson_name, ENT_QUOTES); ?>
                                    </td>
                                    <td class="text-center"><?= htmlspecialchars($course->first_name.' '.$course->last_name, ENT_QUOTES); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($course->course_master, ENT_QUOTES); ?></td>
                                    <td class="text-nowrap text-center">
                                        <a href="#"  alt="default" data-toggle="modal" data-target="#myModal_cu_<?= htmlspecialchars($course->course_id, ENT_QUOTES); ?>"> <i class="mdi mdi-presentation text-inverse m-r-10" data-toggle="tooltip" data-original-title="اطلاعیه"></i> </a>
                                        <!-- modal for course -->
                                        <div id="myModal_cu_<?= htmlspecialchars($course->course_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title" id="myModalLabel">ارسال تیکت به <?= htmlspecialchars($this->session->userdata('studentDName').' های دوره', ENT_QUOTES) ?></h4>
                                                    </div>
                                                    <form action="<?= base_url('insert-announcement'); ?>" method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                                            <input type="hidden" name="receiver" value="crs">
                                                            <input type="hidden" name="course_id" value="<?= htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                            <div class="form-group">
                                                                <input type="text" name="ant_title" class="form-control" placeholder="عنوان">
                                                            </div>
                                                            <div class="form-group">
                                                                <textarea name="ant_body" class="form-control" rows="4" cols="50" required="" placeholder="متن"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-12 m-b-20 p-t-10 p-b-10"  style="background-color: lavender">
                                                                    <div class="text-center p-b-10">
                                                                    <label class="control-label">انتخاب بازه زمانی جهت نمایش اطلاعیه:</label>
                                                                    </div>
                                                                <div class="col-sm-6">
                                                                    <label class="control-label">تاریخ شروع</label>
                                                                    <input type="text" name="start_time" placeholder="1370-01-22" class="form-control auto-close-example" onkeyup="
                                                        var date = this.value;
                                                        if (date.match(/^\d{4}$/) !== null) {
                                                            this.value = date + '-';
                                                        } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                            this.value = date + '-';
                                                        }" maxlength="10" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تاریخ شروع را وارد کنید')" onchange="try {
                                                                    setCustomValidity('');
                                                                } catch (e) {
                                                                }"><span class="help-block"></span>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <label class="control-label">تاریخ پایان</label>
                                                                    <input type="text" name="stop_time" placeholder="1370-01-22" class="form-control auto-close-example" onkeyup="
                                                        var date = this.value;
                                                        if (date.match(/^\d{4}$/) !== null) {
                                                            this.value = date + '-';
                                                        } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                            this.value = date + '-';
                                                        }" maxlength="10" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تاریخ پایان را وارد کنید')" onchange="try {
                                                                    setCustomValidity('');
                                                                } catch (e) {
                                                                }"><span class="help-block"></span>
                                                                </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
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
                                                                <label class="control-label text-danger">ارسال فایل با پسوندهایpdf ، doc ، docx ، txt ، jpg ، jpeg و png امکان پذیر است</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="form-control btn btn-success">ارسال</button>
                                                        </div>
                                                    </form>
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
    </div>
</div>



