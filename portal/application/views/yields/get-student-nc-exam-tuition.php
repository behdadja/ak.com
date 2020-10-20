<div class="col-md-12">
    <div class="white-box">

        <!--.row-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">جست و جو کردن همه آزمون های <?php echo $this->session->userdata('studentDName');?></div>
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body">
                            <?php if ($this->session->flashdata('success-insert')) : ?>
                                <div class="alert alert-success"><?php echo $this->session->flashdata('success-insert'); ?></div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('do-not-exist-student')) : ?>
                                <div class="alert alert-warning"><?php echo $this->session->flashdata('do-not-exist-student'); ?></div>
                            <?php endif; ?>
                            <form action="<?php echo base_url(); ?>financial/get-all-exam-tuition" method="post" name="class_register">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                <div class="form-body">
                                    <h3 class="box-title">کدملی</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger "></label>
                                                <input type="text" name="student_nc" id="student_nc" class="form-control" placeholder="" required=""> <span class="help-block">کد ملی 10 رقمی <?php echo $this->session->userdata('studentDName');?> را وارد نمایید</span></div>
                                            <?php if (validation_errors() && form_error('student_nc')): ?>
                                                <div class="alert alert-danger"><?php echo form_error('student_nc'); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <!--/row-->
                                <div class="col-md-12">
                                    <div class="form-actions">
                                        <button type="submit" style="float:left" class="btn btn-success"> <i class="fa fa-check"></i>جست و جو</button>
                                    </div>
                                </div>

                        </div></form>
                    </div>
                </div>
            </div>
        </div>
        <!--./row-->
    </div>
</div>
</div>
