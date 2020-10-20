<!-- Notifications -->
<div class="m-t-20">
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
                <li><a href="#students" >اطلاعیه های <?= $this->session->userdata('studentDName'); ?></a></li>
                <li><a href="#teachers">اطلاعیه های <?= $this->session->userdata('teacherDName'); ?></a></li>
                <li><a href="#courses" >اطلاعیه های <?= $this->session->userdata('studentDName').' و '.$this->session->userdata('teacherDName'); ?></a></li>
                <li><a href="#all">اطلاعیه های دوره</a></li>
            </ul>
        </nav>
        <div class="content-wrap">
            <section id="students">
                <div class="col-sm-12">
                    <div class="white-box">
                        <?php
                        if(!empty($announcements)):
                            foreach($announcements as $item):
                                if($item->receiver == 'std'):
                                    ?>
                                    <div class="comment-center p-t-10">
                                        <div class="comment-body">
                                            <div class="user-img"> <img src="<?= base_url('assets/profile-picture/thumb/' . $this->session->userdata('logo')); ?>" alt="user" class="img-circle"></div>
                                            <div class="mail-contnet">
                                                <h5>عنوان: <?= htmlspecialchars($item->title, ENT_QUOTES); ?></h5>
                                                <?php if(!empty($item->file_name)):?>
                                                <div class="pull-right">
                                                    <span>فایل ضمیمه: </span><a href="<?= base_url('./assets/ticket-file/' . $item->file_name); ?>"><button class="btn btn-inverse">دانلود</button></a>
                                                </div>
                                                <?php endif; ?>
                                                <span class="time m-r-10">تاریخ انتشار: از</span><span class="time m-r-10"><?= htmlspecialchars($item->start_time, ENT_QUOTES); ?></span>
                                                <span class="time m-r-10">تا</span><span class="time m-r-10"><?= htmlspecialchars($item->stop_time, ENT_QUOTES); ?></span>
                                                <?php
                                                //   convert date shamsi to time()
//                                                require_once 'jdf.php';
                                                $start = explode('-',$item->start_time);
                                                $start_time = jmktime(0,0,0,$start[1],$start[2],$start[0]);
                                                $stop = explode('-',$item->stop_time);
                                                $stop_time = jmktime(0,0,0,$stop[1],$stop[2],$stop[0]);
                                                //    end
                                                if(time() >= $start_time && time() <= $stop_time):
                                                    ?>
                                                    <span class="label label-rouded label-success">فعال</span>
                                                <?php else: ?>
                                                    <span class="label label-rouded label-info">معلق</span>
                                                <?php endif ?>
                                                <br/>
                                                <span class="mail-desc"><?= htmlspecialchars($item->body, ENT_QUOTES); ?></span>
                                                <div class="pull-right">
                                                <a href="javacript:void(0)" data-toggle="modal" data-target="#modal-date_<?= htmlspecialchars($item->announcement_id, ENT_QUOTES) ?>" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="ti-pencil text-success m-r-5"></i>ویرایش تاریخ</a>
                                                <!-- modal all students -->
                                                <div id="modal-date_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title text-center" id="myModalLabel">ویرایش تاریخ</h4>
                                                            </div>
                                                            <form action="<?php echo base_url('edit-announcement'); ?>" method="post" enctype="multipart/form-data">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="ant_id" value="<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>">
                                                                    <input type="hidden" name="category" value="date">
                                                                    <div class="form-group p-b-30">
                                                                        <div class="text-center p-b-10">
                                                                            <label class="control-label">انتخاب بازه زمانی جهت نمایش اطلاعیه:</label>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <label class="control-label">تاریخ شروع</label>
                                                                            <input type="text" name="start_time" class="form-control auto-close-example" onkeyup="
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
                                                                            <input type="text" name="stop_time" class="form-control auto-close-example" onkeyup="
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
                                                                <div class="modal-footer" style="background-color: #edf0f2">
                                                                    <div class="col-md-6">
                                                                        <button type="submit" class="btn btn-success m-b-5" style="width: 100%">ثبت</button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button type="button" class="btn btn-danger m-b-5" style="width: 100%" data-dismiss="modal">انصراف</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->

                                                <a href="javacript:void(0)" data-toggle="modal" data-target="#modal-edit_<?= htmlspecialchars($item->announcement_id, ENT_QUOTES) ?>" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="ti-pencil text-success m-r-5"></i>ویرایش متن</a>
                                                <!-- modal all students -->
                                                <div id="modal-edit_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title text-center" id="myModalLabel">ویرایش اطلاعیه</h4>
                                                            </div>
                                                            <form action="<?php echo base_url('edit-announcement'); ?>" method="post" enctype="multipart/form-data">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="ant_id" value="<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>">
                                                                    <input type="hidden" name="category" value="text">
                                                                    <div class="form-group">
                                                                        <input type="text" name="title" value="<?= htmlspecialchars($item->title,ENT_QUOTES) ?>" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <textarea name="body" class="form-control" rows="4" cols="50" required=""><?= htmlspecialchars($item->body,ENT_QUOTES) ?></textarea>
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
                                                                <div class="modal-footer" style="background-color: #edf0f2">
                                                                    <div class="col-md-6">
                                                                        <button type="submit" class="btn btn-success m-b-5" style="width: 100%">ثبت</button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button type="button" class="btn btn-danger m-b-5" style="width: 100%" data-dismiss="modal">انصراف</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->

                                                <a href="javacript:void(0)" data-toggle="modal" data-target="#modal-delete_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="btn-rounded btn btn-default btn-outline"><i class="ti-close text-danger m-r-5"></i>حذف</a>
                                                <!-- modal delete announcement -->
                                                <div id="modal-delete_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="modal fade text-center" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="myModalLabel">حذف اطلاعیه</h4>
                                                            </div>
                                                            <form action="<?php echo base_url('edit-announcement'); ?>" method="post">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="ant_id" value="<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>">
                                                                    <input type="hidden" name="category" value="delete">
                                                                    <p>از حذف اطلاعیه با عنوان:</p>
                                                                    <hr/>
                                                                    <b class="text-danger"><?= htmlspecialchars($item->title,ENT_QUOTES) ?></b>
                                                                    <hr/>
                                                                    <p>اطمینان دارید؟</p>
                                                                </div>
                                                                <div class="modal-footer" style="background-color: #edf0f2">
                                                                    <div class="col-md-6">
                                                                        <button type="submit" class="btn btn-success m-b-5" style="width: 100%">بله</button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button type="button" class="btn btn-danger m-b-5" style="width: 100%" data-dismiss="modal">خیر</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.modal -->
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </section>
            <section id="teachers">
                <div class="col-sm-12">
                    <div class="white-box">

                        <?php
                        if(!empty($announcements)):
                            foreach($announcements as $item):
                                if($item->receiver == 'emp'):
                                    ?>
                                    <div class="comment-center p-t-10">
                                        <div class="comment-body">
                                            <div class="user-img"> <img src="<?= base_url('assets/profile-picture/thumb/' . $this->session->userdata('logo')); ?>" alt="user" class="img-circle"></div>
                                            <div class="mail-contnet">
                                                <h5>عنوان: <?= htmlspecialchars($item->title, ENT_QUOTES); ?></h5>
                                                <?php if(!empty($item->file_name)):?>
                                                    <div class="pull-right">
                                                        <span>فایل ضمیمه: </span><a href="<?= base_url('./assets/ticket-file/' . $item->file_name); ?>"><button class="btn btn-inverse">دانلود</button></a>
                                                    </div>
                                                <?php endif; ?>
                                                <span class="time m-r-10">تاریخ انتشار: از</span><span class="time m-r-10"><?= htmlspecialchars($item->start_time, ENT_QUOTES); ?></span>
                                                <span class="time m-r-10">تا</span><span class="time m-r-10"><?= htmlspecialchars($item->stop_time, ENT_QUOTES); ?></span>
                                                <?php
                                                //   convert date shamsi to time()
//                                                require_once 'jdf.php';
                                                $start = explode('-',$item->start_time);
                                                $start_time = jmktime(0,0,0,$start[1],$start[2],$start[0]);
                                                $stop = explode('-',$item->stop_time);
                                                $stop_time = jmktime(0,0,0,$stop[1],$stop[2],$stop[0]);
                                                //    end
                                                if(time() >= $start_time && time() <= $stop_time):
                                                    ?>
                                                    <span class="label label-rouded label-success">فعال</span>
                                                <?php else: ?>
                                                    <span class="label label-rouded label-info">معلق</span>
                                                <?php endif ?>
                                                <br/>
                                                <span class="mail-desc"><?= htmlspecialchars($item->body, ENT_QUOTES); ?></span>
                                                <div class="pull-right">
                                                <a href="javacript:void(0)" data-toggle="modal" data-target="#modal-date_<?= htmlspecialchars($item->announcement_id, ENT_QUOTES) ?>" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="ti-pencil text-success m-r-5"></i>ویرایش تاریخ</a>
                                                <!-- modal all students -->
                                                <div id="modal-date_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title text-center" id="myModalLabel">ویرایش تاریخ</h4>
                                                            </div>
                                                            <form action="<?php echo base_url('edit-announcement'); ?>" method="post" enctype="multipart/form-data">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="ant_id" value="<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>">
                                                                    <input type="hidden" name="category" value="date">
                                                                    <div class="form-group p-b-30">
                                                                        <div class="text-center p-b-10">
                                                                            <label class="control-label">انتخاب بازه زمانی جهت نمایش اطلاعیه:</label>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <label class="control-label">تاریخ شروع</label>
                                                                            <input type="text" name="start_time" class="form-control auto-close-example" onkeyup="
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
                                                                            <input type="text" name="stop_time" class="form-control auto-close-example" onkeyup="
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
                                                                <div class="modal-footer" style="background-color: #edf0f2">
                                                                    <div class="col-md-6">
                                                                        <button type="submit" class="btn btn-success m-b-5" style="width: 100%">ثبت</button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button type="button" class="btn btn-danger m-b-5" style="width: 100%" data-dismiss="modal">انصراف</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->

                                                <a href="javacript:void(0)" data-toggle="modal" data-target="#modal-edit_<?= htmlspecialchars($item->announcement_id, ENT_QUOTES) ?>" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="ti-pencil text-success m-r-5"></i>ویرایش متن</a>
                                                <!-- modal all students -->
                                                <div id="modal-edit_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title text-center" id="myModalLabel">ویرایش اطلاعیه</h4>
                                                            </div>
                                                            <form action="<?php echo base_url('edit-announcement'); ?>" method="post" enctype="multipart/form-data">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="ant_id" value="<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>">
                                                                    <input type="hidden" name="category" value="text">
                                                                    <div class="form-group">
                                                                        <input type="text" name="title" value="<?= htmlspecialchars($item->title,ENT_QUOTES) ?>" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <textarea name="body" class="form-control" rows="4" cols="50" required=""><?= htmlspecialchars($item->body,ENT_QUOTES) ?></textarea>
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
                                                                <div class="modal-footer" style="background-color: #edf0f2">
                                                                    <div class="col-md-6">
                                                                        <button type="submit" class="btn btn-success m-b-5" style="width: 100%">ثبت</button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button type="button" class="btn btn-danger m-b-5" style="width: 100%" data-dismiss="modal">انصراف</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->

                                                <a href="javacript:void(0)" data-toggle="modal" data-target="#modal-delete_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="btn-rounded btn btn-default btn-outline"><i class="ti-close text-danger m-r-5"></i>حذف</a>
                                                <!-- modal delete announcement -->
                                                <div id="modal-delete_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="modal fade text-center" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="myModalLabel">حذف اطلاعیه</h4>
                                                            </div>
                                                            <form action="<?php echo base_url('edit-announcement'); ?>" method="post">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="ant_id" value="<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>">
                                                                    <input type="hidden" name="category" value="delete">
                                                                    <p>از حذف اطلاعیه با عنوان:</p>
                                                                    <hr/>
                                                                    <b class="text-danger"><?= htmlspecialchars($item->title,ENT_QUOTES) ?></b>
                                                                    <hr/>
                                                                    <p>اطمینان دارید؟</p>
                                                                </div>
                                                                <div class="modal-footer" style="background-color: #edf0f2">
                                                                    <div class="col-md-6">
                                                                        <button type="submit" class="btn btn-success m-b-5" style="width: 100%">بله</button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button type="button" class="btn btn-danger m-b-5" style="width: 100%" data-dismiss="modal">خیر</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.modal -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                endif;
                            endforeach;
                        endif;
                        ?>

                    </div>
                </div>
            </section>
            <section id="all">
                <div class="col-sm-12">
                    <div class="white-box">

                        <?php
                        if(!empty($announcements)):
                            foreach($announcements as $item):
                                if($item->receiver == 'all'):
                                    ?>
                                    <div class="comment-center p-t-10">
                                        <div class="comment-body">
                                            <div class="user-img"> <img src="<?= base_url('assets/profile-picture/thumb/' . $this->session->userdata('logo')); ?>" alt="user" class="img-circle"></div>
                                            <div class="mail-contnet">
                                                <h5>عنوان: <?= htmlspecialchars($item->title, ENT_QUOTES); ?></h5>
                                                <?php if(!empty($item->file_name)):?>
                                                    <div class="pull-right">
                                                        <span>فایل ضمیمه: </span><a href="<?= base_url('./assets/ticket-file/' . $item->file_name); ?>"><button class="btn btn-inverse">دانلود</button></a>
                                                    </div>
                                                <?php endif; ?>
                                                <span class="time m-r-10">تاریخ انتشار: از</span><span class="time m-r-10"><?= htmlspecialchars($item->start_time, ENT_QUOTES); ?></span>
                                                <span class="time m-r-10">تا</span><span class="time m-r-10"><?= htmlspecialchars($item->stop_time, ENT_QUOTES); ?></span>
                                                <?php
                                                //   convert date shamsi to time()
//                                                require_once 'jdf.php';
                                                $start = explode('-',$item->start_time);
                                                $start_time = jmktime(0,0,0,$start[1],$start[2],$start[0]);
                                                $stop = explode('-',$item->stop_time);
                                                $stop_time = jmktime(0,0,0,$stop[1],$stop[2],$stop[0]);
                                                //    end
                                                if(time() >= $start_time && time() <= $stop_time):
                                                    ?>
                                                    <span class="label label-rouded label-success">فعال</span>
                                                <?php else: ?>
                                                    <span class="label label-rouded label-info">معلق</span>
                                                <?php endif ?>
                                                <br/>
                                                <span class="mail-desc"><?= htmlspecialchars($item->body, ENT_QUOTES); ?></span>
                                                <div class="pull-right">
                                                <a href="javacript:void(0)" data-toggle="modal" data-target="#modal-date_<?= htmlspecialchars($item->announcement_id, ENT_QUOTES) ?>" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="ti-pencil text-success m-r-5"></i>ویرایش تاریخ</a>
                                                <!-- modal all students -->
                                                <div id="modal-date_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title text-center" id="myModalLabel">ویرایش تاریخ</h4>
                                                            </div>
                                                            <form action="<?php echo base_url('edit-announcement'); ?>" method="post" enctype="multipart/form-data">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="ant_id" value="<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>">
                                                                    <input type="hidden" name="category" value="date">
                                                                    <div class="form-group p-b-30">
                                                                        <div class="text-center p-b-10">
                                                                            <label class="control-label">انتخاب بازه زمانی جهت نمایش اطلاعیه:</label>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <label class="control-label">تاریخ شروع</label>
                                                                            <input type="text" name="start_time" class="form-control auto-close-example" onkeyup="
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
                                                                            <input type="text" name="stop_time" class="form-control auto-close-example" onkeyup="
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
                                                                <div class="modal-footer" style="background-color: #edf0f2">
                                                                    <div class="col-md-6">
                                                                        <button type="submit" class="btn btn-success m-b-5" style="width: 100%">ثبت</button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button type="button" class="btn btn-danger m-b-5" style="width: 100%" data-dismiss="modal">انصراف</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->

                                                <a href="javacript:void(0)" data-toggle="modal" data-target="#modal-edit_<?= htmlspecialchars($item->announcement_id, ENT_QUOTES) ?>" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="ti-pencil text-success m-r-5"></i>ویرایش متن</a>
                                                <!-- modal all students -->
                                                <div id="modal-edit_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title text-center" id="myModalLabel">ویرایش اطلاعیه</h4>
                                                            </div>
                                                            <form action="<?php echo base_url('edit-announcement'); ?>" method="post" enctype="multipart/form-data">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="ant_id" value="<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>">
                                                                    <input type="hidden" name="category" value="text">
                                                                    <div class="form-group">
                                                                        <input type="text" name="title" value="<?= htmlspecialchars($item->title,ENT_QUOTES) ?>" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <textarea name="body" class="form-control" rows="4" cols="50" required=""><?= htmlspecialchars($item->body,ENT_QUOTES) ?></textarea>
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
                                                                <div class="modal-footer" style="background-color: #edf0f2">
                                                                    <div class="col-md-6">
                                                                        <button type="submit" class="btn btn-success m-b-5" style="width: 100%">ثبت</button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button type="button" class="btn btn-danger m-b-5" style="width: 100%" data-dismiss="modal">انصراف</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->

                                                <a href="javacript:void(0)" data-toggle="modal" data-target="#modal-delete_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="btn-rounded btn btn-default btn-outline"><i class="ti-close text-danger m-r-5"></i>حذف</a>
                                                <!-- modal delete announcement -->
                                                <div id="modal-delete_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="modal fade text-center" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="myModalLabel">حذف اطلاعیه</h4>
                                                            </div>
                                                            <form action="<?php echo base_url('edit-announcement'); ?>" method="post">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="ant_id" value="<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>">
                                                                    <input type="hidden" name="category" value="delete">
                                                                    <p>از حذف اطلاعیه با عنوان:</p>
                                                                    <hr/>
                                                                    <b class="text-danger"><?= htmlspecialchars($item->title,ENT_QUOTES) ?></b>
                                                                    <hr/>
                                                                    <p>اطمینان دارید؟</p>
                                                                </div>
                                                                <div class="modal-footer" style="background-color: #edf0f2">
                                                                    <div class="col-md-6">
                                                                        <button type="submit" class="btn btn-success m-b-5" style="width: 100%">بله</button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button type="button" class="btn btn-danger m-b-5" style="width: 100%" data-dismiss="modal">خیر</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.modal -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                endif;
                            endforeach;
                        endif;
                        ?>

                    </div>
                </div>
            </section>
            <section id="courses">
                <div class="col-sm-12">
                    <div class="white-box">

                        <?php
                        if(!empty($announcement_courses)):
                            foreach($announcement_courses as $item):
                                if($item->receiver == 'crs'):
                                    ?>
                                    <div class="comment-center p-t-10">
                                        <div class="comment-body">
                                            <div class="user-img"> <img src="<?= base_url('assets/profile-picture/thumb/' . $this->session->userdata('logo')); ?>" alt="user" class="img-circle"></div>
                                            <div class="mail-contnet">
                                                <h5>عنوان: <?= htmlspecialchars($item->title, ENT_QUOTES); ?></h5>
                                                <?php if(!empty($item->file_name)):?>
                                                    <div class="pull-right">
                                                        <span>فایل ضمیمه: </span><a href="<?= base_url('./assets/ticket-file/' . $item->file_name); ?>"><button class="btn btn-inverse">دانلود</button></a>
                                                    </div>
                                                <?php endif; ?>
                                                <h5>مربوط به دوره: <?= htmlspecialchars($item->lesson_name, ENT_QUOTES).' ( '.htmlspecialchars($item->ant_course_id, ENT_QUOTES).' )'; ?></h5>
                                                <span class="time m-r-10">تاریخ انتشار: از</span><span class="time m-r-10"><?= htmlspecialchars($item->start_time, ENT_QUOTES); ?></span>
                                                <span class="time m-r-10">تا</span><span class="time m-r-10"><?= htmlspecialchars($item->stop_time, ENT_QUOTES); ?></span>
                                                <?php
                                                //   convert date shamsi to time()
//                                                require_once 'jdf.php';
                                                $start = explode('-',$item->start_time);
                                                $start_time = jmktime(0,0,0,$start[1],$start[2],$start[0]);
                                                $stop = explode('-',$item->stop_time);
                                                $stop_time = jmktime(0,0,0,$stop[1],$stop[2],$stop[0]);
                                                //    end
                                                if(time() >= $start_time && time() <= $stop_time):
                                                    ?>
                                                    <span class="label label-rouded label-success">فعال</span>
                                                <?php else: ?>
                                                    <span class="label label-rouded label-info">معلق</span>
                                                <?php endif ?>
                                                <br/>
                                                <span class="mail-desc"><?= htmlspecialchars($item->body, ENT_QUOTES); ?></span>
                                                <div class="pull-right">
                                                <a href="javacript:void(0)" data-toggle="modal" data-target="#modal-date_<?= htmlspecialchars($item->announcement_id, ENT_QUOTES) ?>" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="ti-pencil text-success m-r-5"></i>ویرایش تاریخ</a>
                                                <!-- modal all students -->
                                                <div id="modal-date_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title text-center" id="myModalLabel">ویرایش تاریخ</h4>
                                                            </div>
                                                            <form action="<?php echo base_url('edit-announcement'); ?>" method="post" enctype="multipart/form-data">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="ant_id" value="<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>">
                                                                    <input type="hidden" name="category" value="date">
                                                                    <div class="form-group p-b-30">
                                                                        <div class="text-center p-b-10">
                                                                            <label class="control-label">انتخاب بازه زمانی جهت نمایش اطلاعیه:</label>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <label class="control-label">تاریخ شروع</label>
                                                                            <input type="text" name="start_time" class="form-control auto-close-example" onkeyup="
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
                                                                            <input type="text" name="stop_time" class="form-control auto-close-example" onkeyup="
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
                                                                <div class="modal-footer" style="background-color: #edf0f2">
                                                                    <div class="col-md-6">
                                                                        <button type="submit" class="btn btn-success m-b-5" style="width: 100%">ثبت</button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button type="button" class="btn btn-danger m-b-5" style="width: 100%" data-dismiss="modal">انصراف</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->

                                                <a href="javacript:void(0)" data-toggle="modal" data-target="#modal-edit_<?= htmlspecialchars($item->announcement_id, ENT_QUOTES) ?>" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="ti-pencil text-success m-r-5"></i>ویرایش متن</a>
                                                <!-- modal all students -->
                                                <div id="modal-edit_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title text-center" id="myModalLabel">ویرایش اطلاعیه</h4>
                                                            </div>
                                                            <form action="<?php echo base_url('edit-announcement'); ?>" method="post" enctype="multipart/form-data">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="ant_id" value="<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>">
                                                                    <input type="hidden" name="category" value="text">
                                                                    <div class="form-group">
                                                                        <input type="text" name="title" value="<?= htmlspecialchars($item->title,ENT_QUOTES) ?>" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <textarea name="body" class="form-control" rows="4" cols="50" required=""><?= htmlspecialchars($item->body,ENT_QUOTES) ?></textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label">کد دوره:</label>
                                                                        <input type="text" value="<?= htmlspecialchars($item->ant_course_id,ENT_QUOTES) ?>" name="ant_course_id" class="form-control">
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
                                                                <div class="modal-footer" style="background-color: #edf0f2">
                                                                    <div class="col-md-6">
                                                                        <button type="submit" class="btn btn-success m-b-5" style="width: 100%">ثبت</button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button type="button" class="btn btn-danger m-b-5" style="width: 100%" data-dismiss="modal">انصراف</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->

                                                <a href="javacript:void(0)" data-toggle="modal" data-target="#modal-delete_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="btn-rounded btn btn-default btn-outline"><i class="ti-close text-danger m-r-5"></i>حذف</a>
                                                <!-- modal delete announcement -->
                                                <div id="modal-delete_<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>" class="modal fade text-center" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="myModalLabel">حذف اطلاعیه</h4>
                                                            </div>
                                                            <form action="<?php echo base_url('edit-announcement'); ?>" method="post">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="ant_id" value="<?= htmlspecialchars($item->announcement_id,ENT_QUOTES) ?>">
                                                                    <input type="hidden" name="category" value="delete">
                                                                    <p>از حذف اطلاعیه با عنوان:</p>
                                                                    <hr/>
                                                                    <b class="text-danger"><?= htmlspecialchars($item->title,ENT_QUOTES) ?></b>
                                                                    <hr/>
                                                                    <p>اطمینان دارید؟</p>
                                                                </div>
                                                                <div class="modal-footer" style="background-color: #edf0f2">
                                                                    <div class="col-md-6">
                                                                        <button type="submit" class="btn btn-success m-b-5" style="width: 100%">بله</button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button type="button" class="btn btn-danger m-b-5" style="width: 100%" data-dismiss="modal">خیر</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.modal -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                endif;
                            endforeach;
                        endif;
                        ?>

                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
