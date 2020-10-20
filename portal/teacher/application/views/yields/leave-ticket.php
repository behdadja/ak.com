<h4 class="text-danger text-center">ارسال درخواست مرخصی</h4>
<?php if($this->session->flashdata('success-insert')){ ?>
    <div class="row">
        <div class="alert alert-success">
        <?php echo htmlspecialchars($this->session->flashdata('success-insert'), ENT_QUOTES); ?>
        </div>
    </div>
<?php } ?>
<form class="form-horizontal" action="<?= base_url(); ?>teacher/tickets/sending-request" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    <div class="form-group">
        <label class="col-md-12">عنوان درخواست<span class="help"></span></label>
        <div class="col-md-12">
            <input name="title" type="text" class="form-control" value="">
            <?php if(validation_errors() && form_error('title')): ?>
				<div class="col-lg-12 col-sm-12 col-xs-12">
                    <button class="btn btn-block btn-danger disabled"><?php echo form_error('title'); ?></button>
				</div>
			<?php endif; ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12">متن درخواست</label>
        <div class="col-md-12">
            <textarea name="body" class="form-control" rows="5"></textarea>
            <?php if(validation_errors() && form_error('body')): ?>
				<div class="col-lg-12 col-sm-12 col-xs-12">
                    <button class="btn btn-block btn-danger disabled"><?php echo form_error('body'); ?></button>
				</div>
			<?php endif; ?>
        </div>
    </div>
    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">ثبت</button>
</form>
