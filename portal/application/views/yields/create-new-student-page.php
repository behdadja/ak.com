<div class="col-md-12">
    <div class="white-box">
        <!--.row-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading"> ثبت اطلاعات <?php echo $this->session->userdata('studentDName'); ?> جدید</div>
                    <h3 class="box-title text-danger p-t-10  p-r-20">پر کردن موارد ستاره دار ( * ) الزامی می باشد.</h3>
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body">

                            <?php if ($this->session->flashdata('upload-msg')) : ?>
                                <div class="alert alert-danger"><?php echo $this->session->flashdata('upload-msg'); ?></div>
                            <?php endif; ?>

                            <!-- error inputs -->
                            <div class="m-b-20">
                                <?php if (validation_errors()): ?>
                                    <div class="alert alert-danger">خطاهای زیر را بررسی کنید</div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('first_name'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('last_name'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('first_name_en'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('last_name_en'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('father_name'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('national_code'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('birthday'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('phone_num'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('tell'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('province'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('city'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('street'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5" style="border-right: #ff7676 thick solid"><?php echo form_error('postal_code'); ?></div>
                                <?php endif; ?>
                            </div>
                            <!-- /error inputs -->

                            <form action="<?php echo base_url(); ?>users/insert-new-student" enctype="multipart/form-data" method="post" name="user_register">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                       value="<?php echo $this->security->get_csrf_hash(); ?>"/>
                                <div class="form-body">
                                    <h3 class="box-title text-blue">اطلاعات شخصی</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><span class="text-danger m-r-10">*</span>نام</label>
                                                <input type="text" name="first_name" id="first_name" class="form-control" required onkeyup='saveValue(this)' oninvalid="setCustomValidity('لطفا نام را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><span class="text-danger m-r-10">*</span>نام خانوادگی</label>
                                                <input type="text" id="last_name" name="last_name" class="form-control" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا نام خانوادگی را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">First Name</label>
                                                <input type="text" id="first_name_en" name="first_name_en" class="form-control">
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Last Name </label>
                                                <input type="text" id="last_name_en" name="last_name_en" class="form-control">
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
                                                        }">
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><span class="text-danger m-r-10">*</span>کد ملی</label>
                                                <input type="text" maxlength="10" disabled id="national_code" class="form-control" required oninvalid="setCustomValidity('لطفا کد ملی را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }" value="<?= $this->session->userdata('register_nc'); ?>">
                                                <input type="hidden"  value="<?= $this->session->userdata('register_nc'); ?>" name="national_code">

                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">جنسیت</label>
                                                <select class="form-control" name="gender">
                                                    <option value="1">مرد</option>
                                                    <option value="0">زن</option>
                                                </select> <span class="help-block"> جنسیت خود را انتخاب کنید</span>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><span class="text-danger m-r-10">*</span>تاریخ تولد</label>

                                                <input type="text"  name="birthday" placeholder="1370-01-22" class="form-control auto-close-example" onkeyup="
                                                        var date = this.value;
                                                        if (date.match(/^\d{4}$/) !== null) {
                                                            this.value = date + '-';
                                                        } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                            this.value = date + '-';
                                                        }" maxlength="10" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تاریخ تولد را وارد کنید')" onchange="try {
                                                                    setCustomValidity('');
                                                                } catch (e) {
                                                                }"><span class="help-block"></span>

<!--							<input type="text" id="birthday" name="birthday" class="form-control birth-date" placeholder="1396/01/22" required=""> <span class="help-block"></span>-->
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
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
                                                <label class="control-label">عکس زبان آموز</label>
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                        <span class="fileinput-filename"></span>
                                                    </div>
                                                    <span class="input-group-addon btn btn-default btn-file"> 
                                                        <span class="fileinput-new">انتخاب فایل</span> 
                                                        <span class="fileinput-exists">تغییر</span>
                                                        <input type="hidden"><input type="file" name="pic_name"> 
                                                    </span> 
                                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">حذف</a></div>

                                            </div>
                                            <!--/span-->
                                        </div>
                                    </div>
                                    <br>
                                    <!--/row-->

                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="box-title text-info">آدرس و شماره تماس ها</h3>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><span class="text-danger m-r-10">*</span>تلفن همراه</label>
                                                <input onKeyPress="if (this.value.length == 11)
                                                            return false;" min="09000000000" max="99999999999" type="number" class="form-control" name="phone_num" id='phone_num' placeholder="09xxx" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تلفن همراه را وارد کنید')" onchange="try {
                                                                        setCustomValidity('');
                                                                    } catch (e) {
                                                                    }"> <span class="help-block">شماره همراه 11 رقم باشد</span>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>تلفن ثابت </label>
                                                <input onKeyPress="if (this.value.length == 11)
                                                            return false;" min="01000000000" max="99999999999" type="number" name="tell" id='tell' class="form-control" placeholder="071xxx">
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
                                        <!--/span-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><span class="text-danger m-r-10">*</span>آدرس</label>
                                                <input type="text" name="street" class="form-control" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا آدرس را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>کد پستی</label>
                                                <input type="text" maxlength="10" name="postal_code" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>کد معرف</label>
                                                <input type="text" maxlength="10" name="reference_code" class="form-control"><span class="help-block">کد ملی معرفی کننده خود را وارد کنید</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
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
            </div>
        </div>
        <!-- .row -->
    </div>
</div>

<script>
    rescuefieldvalues(['first_name', 'last_name', 'first_name_en', 'last_name_en', 'father_name',
        'birthday', 'phone_num', 'tell', 'province', 'city', 'street', 'postal_code', 'reference_code']);
</script>