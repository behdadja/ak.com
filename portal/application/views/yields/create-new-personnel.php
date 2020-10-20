
<div class="col-md-12">
    <div class="white-box">

        <!--.row-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading"> ثبت اطلاعات کارمند جدید</div>
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body">

                            <!-- error for upload image -->
                            <?php if ($this->session->flashdata('upload-msg')) : ?>
                                <div class="alert alert-danger"><?php echo $this->session->flashdata('upload-msg'); ?></div>
                            <?php endif; ?>
                            <!-- / error for upload image -->

                            <!-- error for exist national_code -->
                            <?php if ($this->session->flashdata('national-code-msg')) : ?>
                                <div class="alert alert-danger"><?php echo $this->session->flashdata('national-code-msg'); ?></div>
                            <?php endif; ?>
                            <!-- / error for exist national_code --> 

                            <!-- error inputs -->
                            <div class="m-b-20">
                                <?php if (validation_errors()): ?>
                                <div class="alert alert-danger">خطاهای زیر را بررسی کنید</div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('first_name'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('last_name'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('first_name_en'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('last_name_en'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('father_name'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('birthday'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('national_code'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('phone_num'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('tell'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('province'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('city'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('street'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('postal_code'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('activity_unit'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('monthly_salary'); ?></div>
                                <?php endif; ?>
                            </div>
                            <!-- /error inputs -->

                            <form action="<?php echo base_url(); ?>users/insert-new-personnel" enctype="multipart/form-data" method="post" name="user_register">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
                                <div class="form-body">
                                    <h3 class="box-title text-blue">اطلاعات شخصی</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><span class="text-danger m-r-10">*</span>نام</label>
                                                <input type="text" name="first_name" id="first_name" class="form-control" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا نام را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><span class="text-danger m-r-10">*</span>نام خانوادگی</label>
                                                <input type="text" id="last_name" name="last_name" class="form-control" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا نام خانوادگی را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">First Name</label>
                                                <input type="text" id="first_name_en" name="first_name_en" class="form-control" onkeyup='saveValue(this);'>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Last Name </label>
                                                <input type="text" id="last_name_en" name="last_name_en" class="form-control" onkeyup='saveValue(this);'>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><span class="text-danger m-r-10">*</span>نام پدر</label>
                                                <input type="text" id="father_name" name="father_name" class="form-control" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا نام پدر را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><span class="text-danger m-r-10">*</span>کد ملی</label>
                                                <input onKeyPress="if (this.value.length == 10)
                                                            return false;" type="number" maxlength="10" id="national_code" name="national_code" class="form-control" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا کد ملی را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block">کد ملی باید 10 رقم باشد</span>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">جنسیت</label>
                                                <select class="form-control" name="gender">
                                                    <option value="0">زن</option>
                                                    <option value="1">مرد</option>
                                                </select> <span class="help-block"> جنسیت خود را انتخاب کنید </span>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><span class="text-danger m-r-10">*</span>تاریخ تولد</label>
                                                <input type="text" id="birthday" name="birthday" placeholder="1370-01-22" class="form-control auto-close-example" onkeyup="
                                                        var date = this.value;
                                                        if (date.match(/^\d{4}$/) !== null) {
                                                            this.value = date + '-';
                                                        } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                            this.value = date + '-';
                                                        }" maxlength="10" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تاریخ تولد را وارد کنید')" onchange="try {
                                                                    setCustomValidity('');
                                                                } catch (e) {
                                                                }"><span class="help-block"></span>
                                                <!--<input type="text" id="birthday" name="birthday" class="form-control birth-date" placeholder="1396/01/22" required=""> <span class="help-block"></span></div>-->
                                            </div>
                                            <!--/span-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"> وضعیت تاهل</label>
                                                <select class="form-control" tabindex="1" name="marital_status">
                                                    <option value="0"> مجرد</option>
                                                    <option value="1"> متاهل</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">عکس </label>
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                        <span class="fileinput-filename"></span>
                                                    </div>
                                                    <span class="input-group-addon btn btn-default btn-file"> <span class="fileinput-new">انتخاب فایل</span> <span class="fileinput-exists">تغییر</span>
                                                        <input type="hidden" required=""><input type="file" name="pic_name"> </span> <a href="form-material-elements.html#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">حذف</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    <div class="row">
                                                                            
                                                                                                                    <div class="col-md-6">
                                                                                                                        <div class="form-group">
                                                                                                                            <label class="control-label text-danger">رمز عبور</label>
                                                                                                                            <input type="text" id="password" name="password" class="form-control" placeholder="" required=""> <span class="help-block"></span></div>
                                    <?php if (validation_errors() && form_error('password')): ?>
                                                                                                                                                                                                                <div class="alert alert-danger"><?php echo form_error('password'); ?></div>
                                    <?php endif; ?>
                                                                                                                    </div>
                                                                        </div>-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="box-title text-info">آدرس و شماره تماس ها</h3>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><span class="text-danger m-r-10">*</span>تلفن همراه</label>
                                                <input onKeyPress="if (this.value.length == 11)
                                                            return false;" min="09000000000" max="99999999999" type="number" maxlength="11" class="form-control" name="phone_num" id='phone_num' placeholder="091xxx" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تلفن همراه را وارد کنید')" onchange="try {
                                                            setCustomValidity('');} catch (e) {
                                                        }"> <span class="help-block">شماره همراه 11 رقم باشد</span>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>تلفن ثابت </label>
                                                <input onKeyPress="if (this.value.length == 11)
                                                            return false;" min="01000000000" max="99999999999" type="number" maxlength="11" name="tell" id='tell' class="form-control" placeholder="071xxx" onkeyup='saveValue(this);'>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><span class="text-danger m-r-10">*</span>استان</label>
                                                <input readonly type="text" name="province" class="form-control" value="فارس" placeholder="فارس" required>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><span class="text-danger m-r-10">*</span>شهر</label>
                                                <!--<input type="text" name="city" class="form-control" value="شیراز"placeholder="" required="">-->
                                                <select class="form-control" name="city">
                                                    <option value="194">شیراز</option>
                                                    <?php foreach ($city as $cty): ?>
                                                        <option value="<?= $cty->id; ?>"><?= $cty->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><span class="text-danger m-r-10">*</span>آدرس</label>
                                                <input type="text" id="address" name="street" class="form-control" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا آدرس را وارد کنید')" onchange="try {
                                                            setCustomValidity('');} catch (e) {
                                                        }"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>کد پستی</label>
                                                <input type="text" maxlength="10" id="postal_code" name="postal_code" class="form-control" placeholder="7364587392"  onkeyup='saveValue(this);'> <span class="help-block">کد پستی 10 رقمی</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="box-title text-info">اطلاعات دسته بندی</h3>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label font-bold"><span class="text-danger m-r-10">*</span>انتخاب واحد فعالیت</label>
                                                <select class="form-control" tabindex="1" name="activity_unit" >
                                                    <option selected value="">انتخاب کنید</option>
                                                    <option value="1">مدیر داخلی</option>
                                                    <option value="2">مالی و حسابداری</option>
                                                    <option value="0">سایر کارمندان</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label font-bold"><span class="text-danger m-r-10">*</span>حقوق ماهیانه</label>
                                                <input type="text" maxlength="8" id="monthly_salary" name="monthly_salary" class="form-control" placeholder="2500000" required oninvalid="setCustomValidity('لطفا حقوق ماهیانه را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block text-danger">واحد محاسبه تومان است</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-12 col-sm-4">
                                            <div class="panel panel-default">
                                                <a href="#" data-perform="panel-collapse">
                                                    <div class="panel-heading" style="background-color: gainsboro"> سطح دسترسی
                                                        <div class="pull-right"><span class="fa fa-angle-down"></span></div>
                                                    </div></a>
                                                <div class="panel-wrapper collapse" aria-expanded="true">
                                                    <div class="panel-body">
                                                        <div class="col-md-12 text-center">
                                                            <div class="checkbox checkbox-primary p-t-0">
                                                                <div class="well well-sm" style="background-color: #f3f3f3;">
                                                                    <div class="form-group m-b-0">
                                                                        <input id="all_level" name="all_level" type="checkbox">
                                                                        <label for="all_level"> دسترسی به همه سطوح</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 text-center">
                                                            <div class="checkbox checkbox-primary p-t-0">
                                                                <div class="well well-sm" style="background-color: #f3f3f3;">
                                                                    <div class="form-group m-b-0">
                                                                        <input id="classs" name="classs" type="checkbox">
                                                                        <label for="classs"> ایجاد و مدیریت کلاس</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 text-center">
                                                            <div class="checkbox checkbox-primary p-t-0">
                                                                <div class="well well-sm" style="background-color: #f3f3f3;">
                                                                    <div class="form-group m-b-0">
                                                                        <input id="lesson" name="lesson" type="checkbox">
                                                                        <label for="lesson"> ایجاد و مدیریت درس</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 text-center">
                                                            <div class="checkbox checkbox-primary p-t-0">
                                                                <div class="well well-sm" style="background-color: #f3f3f3">
                                                                    <div class="form-group m-b-0">
                                                                        <input id="course" name="course" type="checkbox">
                                                                        <label for="course"> ایجاد و مدیریت دوره</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 text-center">
                                                            <div class="checkbox checkbox-primary p-t-0">
                                                                <div class="well well-sm" style="background-color: #f3f3f3">
                                                                    <div class="form-group m-b-0">
                                                                        <input id="exam" name="exam" type="checkbox">
                                                                        <label for="exam"> ایجاد و مدیریت آزمون</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                            <div class="checkbox checkbox-primary p-t-0">
                                                                <div class="well well-sm" style="background-color: #f3f3f3">
                                                                    <div class="form-group m-b-0">
                                                                        <input id="student" name="student" type="checkbox">
                                                                        <label for="student"> ایجاد و مدیریت دانشجو</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                            <div class="checkbox checkbox-primary p-t-0">
                                                                <div class="well well-sm" style="background-color: #f3f3f3">
                                                                    <div class="form-group m-b-0">
                                                                        <input id="teacher" name="teacher" type="checkbox">
                                                                        <label for="teacher"> ایجاد و مدیریت استاد</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                            <div class="checkbox checkbox-primary p-t-0">
                                                                <div class="well well-sm" style="background-color: #f3f3f3">
                                                                    <div class="form-group m-b-0">
                                                                        <input id="personnel" name="personnel" type="checkbox">
                                                                        <label for="personnel"> ایجاد و مدیریت کارمند</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                            <div class="checkbox checkbox-primary p-t-0">
                                                                <div class="well well-sm" style="background-color: #f3f3f3">
                                                                    <div class="form-group m-b-0">
                                                                        <input id="financial_std" name="financial_std" type="checkbox">
                                                                        <label for="financial_std">وضعیت مالی دانشجو</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                            <div class="checkbox checkbox-primary p-t-0">
                                                                <div class="well well-sm" style="background-color: #f3f3f3">
                                                                    <div class="form-group m-b-0">
                                                                        <input id="financial_thr" name="financial_thr" type="checkbox">
                                                                        <label for="financial_thr">وضعیت مالی استاد</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                            <div class="checkbox checkbox-primary p-t-0">
                                                                <div class="well well-sm" style="background-color: #f3f3f3">
                                                                    <div class="form-group m-b-0">
                                                                        <input id="financial_prl" name="financial_prl" type="checkbox">
                                                                        <label for="financial_prl"> وضعیت مالی کارمند</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                            <div class="checkbox checkbox-primary p-t-0">
                                                                <div class="well well-sm" style="background-color: #f3f3f3">
                                                                    <div class="form-group m-b-0">
                                                                        <input id="ticket_std" name="ticket_std" type="checkbox">
                                                                        <label for="ticket_std">تیکت های دانشجو</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                            <div class="checkbox checkbox-primary p-t-0">
                                                                <div class="well well-sm" style="background-color: #f3f3f3">
                                                                    <div class="form-group m-b-0">
                                                                        <input id="ticket_thr" name="ticket_thr" type="checkbox">
                                                                        <label for="ticket_thr">تیکت های استاد</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                            <div class="checkbox checkbox-primary p-t-0">
                                                                <div class="well well-sm" style="background-color: #f3f3f3">
                                                                    <div class="form-group m-b-0">
                                                                        <input id="ticket_prl" name="ticket_prl" type="checkbox">
                                                                        <label for="ticket_prl"> تیکت های کارمند</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class="form-actions">
                                        <button type="submit" name="register" class="btn btn-success"
                                                style='float:left'><i class="fa fa-check"></i> ذخیره
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--./row-->
            </div>
        </div>
        <!-- .row -->
    </div>
</div>

<script type="text/javascript">
    rescuefieldvalues(['first_name', 'last_name','first_name_en', 'last_name_en', 'father_name', 'birthday', 'national_code',
        'phone_num','tell', 'province', 'city', 'street', 'postal_code', 'monthly_salary']);
</script>