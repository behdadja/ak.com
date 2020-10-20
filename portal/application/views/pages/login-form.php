

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

            <div id="f1">
                <form class="form-horizontal form-material" id="loginform" action="<?php echo base_url('login'); ?>" method="post">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <div class="col-md-12" style="margin-bottom: 30px">
                        <div class="has-success has-feedback">
                            <input type="text" class="form-control" name='national_code' placeholder="کد ملی " onKeyPress="if (this.value.length == 10) return false;"><span class="glyphicon glyphicon-ok form-control-feedback"></span>
                        </div>
                    </div>
                    <?php if (validation_errors() && form_error('national_code')): ?>
                        <div class="col-md-12 text-center" style="padding: 1px">
                            <div class="alert alert-danger" style="margin-bottom: 10px;padding: 10px"><?php echo form_error('national_code'); ?></div>
                        </div>
                    <?php endif; ?>
                    <div class="form-group" style="padding:5px 15px 10px 13px">
                        <div class="input-group"style="width: 100%">
                            <div id="radioBtn" class="btn-group" style="width: 100%">
                                <a style="width: 34%" class="btn btn-success btn-md notActive" data-toggle="category" data-title="2">استاد</a>
                                <a style="width: 33%" class="btn btn-success btn-md active" data-toggle="category" data-title="1">آموزشگاه</a>
                                <a style="width: 33%" class="btn btn-success btn-md notActive" data-toggle="category" data-title="3">دانشجو</a>
                            </div>
                            <input type="hidden" name="category" id="category" value="1">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">ارسال کد ورود</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if ($this->session->flashdata('invalid-national-code')): ?>
    <script>
        $(document).ready(function () {
            $('#invalid-national-code').modal('show');
        });
    </script>
<?php endif; ?>
<div id="invalid-national-code" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="text-align: center">
            <div class="modal-header" style="background-color: #edf0f2">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">سامانه آموزشی آموزکده</h4>
            </div>
            <div class="modal-body text-danger">
                <?php echo $this->session->flashdata('invalid-national-code'); ?>
            </div>
            <div class="modal-footer">
                <div class="col-md-6">
                    <a style="width: 100%" class="btn btn-success" data-dismiss="modal">دوباره امتحان می کنم</a>
                </div>
                <div class="col-md-6">
                    <a style="width: 100%" class="btn btn-info" href="<?php echo base_url('../'); ?>">صفحه اصلی</a> 
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($this->session->flashdata('notExistPhoneNumber')): ?>
	<script>
		$(document).ready(function () {
			$('#notExistPhoneNumber').modal('show');
		});
	</script>
<?php endif; ?>
<div id="notExistPhoneNumber" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" style="text-align: center">
			<div class="modal-header" style="background-color: #edf0f2">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">سامانه آموزشی آموزکده</h4>
			</div>
			<div class="modal-body text-danger">
				<?php echo $this->session->flashdata('notExistPhoneNumber'); ?>
			</div>
			<div class="modal-footer">
				<a style="width: 100%" class="btn btn-success" data-dismiss="modal">بستن</a>
			</div>
		</div>
	</div>
</div>
