
<div id="wrapper" class="login-register">
    <div class="login-box" style=";margin-top: 50px;border-radius: 50px 0 50px 0">
        <div style="padding: 30px 70px 30px 70px">
            <div class="form-group">
                <div class="col-xs-12 text-center" style="padding: 10px;margin-bottom: 30px">
                    <a data-toggle="tooltip" data-placement="bottom" title="صفحه اصلی" href="<?php echo base_url('../'); ?>">
                        <div class="user-thumb text-center">
                            <img alt="thumbnail" class="img-circle" width="100" src="<?php echo base_url('./../images/admin_logo.png'); ?>">
                            <h3>سامانه آموزشی آموزکده</h3>
                        </div>
                    </a>
                </div>
            </div>

            <div>
				<div class="text-center">
					<p class="text-info">شماره ای که کد تاییدیه به آن ارسال شد:</p>
					<p class="text-danger" style="margin-bottom: 15px"><?= $this->session->userdata('phone_num') ?></p>
				</div>
                <form class="form-horizontal form-material" id="loginform" action="<?php echo base_url('verify'); ?>" method="post">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <div class="col-md-12" style="margin-bottom: 20px">
                        <div class="has-success has-feedback">
                            <input type="text" class="form-control" name='user_otp' placeholder="کد تاییدیه را وارد کنید " onKeyPress="if (this.value.length == 4) return false;" min="1000" max="9999"> <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                        </div>
                    </div>
                    <?php if (validation_errors() && form_error('user_otp')): ?>
                        <div class="col-md-12 text-center" style="padding: 1px">
                            <div class="alert alert-danger" style="margin-bottom: 10px;padding: 10px"><?php echo form_error('user_otp'); ?></div>
                        </div>
                    <?php endif; ?>
                    <div class="form-group text-center" style="width: 100%">
                        <div class="col-md-12">
                            <button style="margin-left: -30px" class="btn btn-info btn-lg btn-block waves-effect waves-light" type="submit">ورود</button>
                            <button style="margin-left: -30px" id="myBtn" disabled class="btn btn-success btn-lg btn-block waves-effect waves-light" onclick="event.preventDefault();document.getElementById('send_<?php echo $this->session->userdata('national_code'); ?>').submit();">ارسال مجدد کد</button>
                            <div id="myTimer"></div>
                        </div>
                    </div>
                </form>
                <form id='send_<?php echo $this->session->userdata('national_code'); ?>' style="display:none" action="<?php echo base_url('login'); ?>" method="post">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input type="hidden" name="national_code" value="<?php echo $this->session->userdata('national_code'); ?>">
                    <input type="hidden" name="category" value="<?php echo $this->session->userdata('category'); ?>">
                </form>
            </div>
        </div>
    </div>
</div>

<?php if ($this->session->flashdata('invalid-verify-code')): ?>
    <script>
        $(document).ready(function () {
            $('#invalid-verify-code').modal('show');
        });
    </script>
<?php endif; ?>
<div class="modal fade"  id="invalid-verify-code" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="text-align: center">
            <div class="modal-header" style="background-color: #edf0f2">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">سامانه آموزشی آموزکده</h4>
            </div>
            <div class="modal-body text-danger">
                <?php echo $this->session->flashdata('invalid-verify-code'); ?>
            </div>
            <div class="modal-footer">
                <div class="col-md-4">
                    <a style="width: 100%" class="btn btn-info" data-dismiss="modal">دوباره امتحان می کنم</a>
                </div>
                <div class="col-md-4">
                    <a style="width: 100%" class="btn btn-success" href="<?php echo base_url('login') ?>">ورود مجدد کد ملی</a>
                </div>
                <div class="col-md-4">
                    <a style="width: 100%" class="btn btn-info" href="<?php echo base_url('../'); ?>">صفحه اصلی</a> 
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if ($this->session->flashdata('data')):
    $academy = $this->session->flashdata('data');
    ?>
    <script>
        $(document).ready(function () {
            $('#choose-academy').modal({
                show: false,
                backdrop: 'static'
            });
            $('#choose-academy').modal('show');
        });
    </script>
<?php endif; ?>

<!-- modal choose academy -->
<div class="modal fade" id="choose-academy" role="dialog">
    <div class="modal-dialog" style="margin-top: 150px">
        <div class="modal-content" style="border-radius: 30px 0 30px 0">
            <div class="modal-body" style="padding: 30px">
                <?php foreach ($academy as $acdm): ?>
                    <div class="m-t-20">
                        <a style="width: 100%;border-radius: 20px 0 20px 0" class="btn btn-info" onclick="document.getElementById('academy_<?= $acdm['academy_id']; ?>').submit();">
                            <img src="<?= base_url('assets/profile-picture/thumb/' . $acdm['logo']); ?>" alt="logo" width="60" class="bg img-circle"><br>
                            <h5 style="margin-top: 10px"><?= $acdm['academy']; ?></h5>
                        </a>
                        <form class="" id='academy_<?= $acdm['academy_id']; ?>' style="display:none" action="<?php echo base_url('verify-complete'); ?>" method="post">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                            <input type="hidden" name="academy_id" value="<?= $acdm['academy_id']; ?>"/>
                            <input type="hidden" name="category" value="<?= $acdm['category']; ?>"/>
                            <input type="hidden" name="national_code" value="<?= $acdm['national_code']; ?>"/>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>



