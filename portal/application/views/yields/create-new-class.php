<div class="col-md-12">
    <div class="white-box">

        <!--.row-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading"> ثبت کلاس جدید</div>
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body">
                             
                            <!-- error inputs -->
                            <div class="m-b-20">
                                <?php if (validation_errors()): ?>
                                    <div class="alert alert-danger">خطاهای زیر را بررسی کنید</div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('class_name'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('class_description'); ?></div>
                                <?php endif; ?>
                            </div>
                            <!-- /error inputs -->
                                
                            <form action="<?php echo base_url(); ?>training/insert-new-class" method="post" name="class_register">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                <div class="form-body">
                                    <h3 class="box-title">اطلاعات کلاس</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger ">نام کلاس</label>
                                                <input type="text" name="class_name" id="class_name" class="form-control" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا نام کلاس را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block">مثال: کلاس الف یا کلاس 4</span> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">توضیحات</label>
                                                <input type="text" name="class_description" id="class_description" class="form-control" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا توضیحات کلاس را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block"></span> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/row-->
                                <div class="col-md-12">
                                    <div class="form-actions">
                                        <button type="submit" style="float:left" class="btn btn-success"> <i class="fa fa-check"></i>ایجاد کلاس جدید</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--./row-->
    </div>
</div>

<script type="text/javascript">
    rescuefieldvalues(['class_name', 'class_description']);
</script>
