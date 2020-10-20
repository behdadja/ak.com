<div class="col-md-12">
    <div class="panel panel-info">
        <?php if (!empty($class_info)): ?>
            <div class="panel-heading"> ویرایش کلاس با کد : <?php echo htmlentities($class_info[0]->class_id, ENT_QUOTES); ?></div>
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
                    <form action="<?= base_url(); ?>training/update-class" method="post" name="class_register">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_info[0]->class_id); ?>">
                        <div class="form-body">
                            <h3 class="box-title">اطلاعات کلاس</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">نام کلاس</label>
                                        <input type="text" name="class_name" id="class_name" class="form-control" value="<?php echo htmlentities($class_info[0]->class_name, ENT_QUOTES); ?>" required oninvalid="setCustomValidity('لطفا نام کلاس را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block">اسم کلاس متناسب با موقعیت جغرافیایی کلاس انتخاب شود</span> 
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">توضیحات</label>
                                        <input type="text" id="description" name="description" class="form-control" value="<?php echo htmlentities($class_info[0]->class_description, ENT_QUOTES); ?>" required oninvalid="setCustomValidity('لطفا توضیحات کلاس را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block"></span> 
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="form-actions">
                                <button type="submit" name="create_class" class="btn btn-success" style="float:left"> <i class="fa fa-check"></i> ویرایش کلاس</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
