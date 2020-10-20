<?php if ($this->session->flashdata('success-insert-st')) : ?>
    <div class="alert alert-success"><?php echo $this->session->flashdata('success-insert-st'); ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error-upload')) : ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error-upload') ?></div>
<?php endif; ?>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myModalLabel">پاسخ به تیکت</h4> </div>
            <div class="modal-body">
                <form action="<?php echo base_url('student/tickets/answer-manager-tickets'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input type="hidden" name="ticket_id" value="<?php echo htmlspecialchars($manager_tickets[0]->ticket_id, ENT_QUOTES); ?>">
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

<div class="media" style="background-color: #edf1f5;border-radius: 10px">
    <div class="media-left">
        <?php if($manager_tickets[0]->sender_type == 'std'):?>
            <img src="<?= base_url('./assets/profile-picture/thumb/' . $this->session->userdata('pic_name')); ?>" class="img-circle" style="width:45px">
        <?php else: ?>
            <img src="<?= base_url('assets/profile-picture/thumb/' . $this->session->userdata('manage_pic')); ?>" class="img-circle" style="width:45px">
        <?php endif; ?>
    </div>
    <div class="media-body">
        <h5 class="media-heading text-info">
            <?php if($manager_tickets[0]->sender_type == 'std'){
                echo 'تیکت شما';
            }else{
                echo 'مدیر ' . $this->session->userdata('academyDName') . ' ' . $this->session->userdata('academy_name');
            } ?>
            <small class="pull-right"><?= $manager_tickets[0]->created_at ?></small>
        </h5>
        <hr>
        <h5>عنوان: <?= $manager_tickets[0]->ticket_title ?></h5>
        <p>متن: <?= $manager_tickets[0]->ticket_body ?></p>
        <?php if (!empty($manager_tickets[0]->file_name)): ?>
            <span>فایل ضمیمه:  </span><a href="<?= base_url('./assets/ticket-file/' . $manager_tickets[0]->file_name); ?>"><button class="btn" style="border-radius: 5px;background-color: lightsteelblue">دانلود</button></a>
        <?php endif; ?>
        <span><a href="#" class="btn btn-inverse pull-right"  alt="default" data-toggle="modal" data-target="#myModal" style="border-radius: 5px">پاسخ شما</a></span>
    </div>
</div>

<?php if (!empty($answer_manager_tickets)): ?>
    <div class="media m-l-20" style="background-color: #edf1f5;border-radius: 10px">
        <?php
        foreach ($answer_manager_tickets as $answer):
            if ($answer->sender_type === 'std'):
                ?>
                <div class="media m-l-20" style="background-color: gainsboro;border-radius: 10px">
                    <div class="media-left">
                        <img src="<?= base_url('./assets/profile-picture/thumb/' . $this->session->userdata('pic_name')); ?>" class="img-circle" style="width:45px">
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading">پاسخ شما<small class="pull-right"><?= $answer->created_at ?></small></h5>
                        <hr>
                        <p><?= $answer->ticket_body ?></p>
                        <?php if (!empty($answer->file_name)): ?>
                            <span>فایل ضمیمه: </span><a href="<?= base_url('./assets/ticket-file/' . $answer->file_name); ?>"><button class="btn" style="border-radius: 5px;background-color: lightsteelblue">دانلود</button></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php
            elseif ($answer->sender_type === 'mng'):
                ?>
                <div class="media m-l-40" style="background-color: white;border-radius: 10px">
                    <div class="media-left">
                        <img src="<?= base_url('./assets/profile-picture/thumb/' . $this->session->userdata('manage_pic')); ?>" class="img-circle" style="width:45px">
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading text-info">مدیر<small class="pull-right"><?= $answer->created_at ?></small></h5>
                        <hr>
                        <p><?= $answer->ticket_body ?></p>
                        <?php if (!empty($answer->file_name)): ?>
                            <span>فایل ضمیمه: </span><a href="<?= base_url('./assets/ticket-file/' . $answer->file_name); ?>"><button class="btn" style="border-radius: 5px;background-color: lightsteelblue">دانلود</button></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php
            endif;
        endforeach;
        ?>
    </div>
<?php endif; ?>
