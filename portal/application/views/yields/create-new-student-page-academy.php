
<div class="col-md-12">
    <div class="white-box">

        <!--.row-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading"><?php echo $this->session->flashdata('available-nc-msg') ?></div>
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

                            <form action="<?php echo base_url('users/insert_new_student2'); ?>" enctype="multipart/form-data" method="post">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
                                <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?>">
                                <input type="hidden" name="first_name" value="<?php echo htmlspecialchars($student_info[0]->first_name, ENT_QUOTES); ?>">
                                <input type="hidden" name="last_name" value="<?php echo htmlspecialchars($student_info[0]->last_name, ENT_QUOTES); ?>">
                                <input type="hidden" name="first_name_en" value="<?php echo htmlspecialchars($student_info[0]->first_name_en, ENT_QUOTES); ?>">
                                <input type="hidden" name="last_name_en" value="<?php echo htmlspecialchars($student_info[0]->last_name_en, ENT_QUOTES); ?>">
                                <input type="hidden" name="father_name" value="<?php echo htmlspecialchars($student_info[0]->father_name, ENT_QUOTES); ?>">
                                <input type="hidden" name="birthday" value="<?php echo htmlspecialchars($student_info[0]->birthday, ENT_QUOTES); ?>">
                                <input type="hidden" name="marital_status" value="<?php echo htmlspecialchars($student_info[0]->marital_status, ENT_QUOTES); ?>">
                                <input type="hidden" name="gender" value="<?php echo htmlspecialchars($student_info[0]->gender, ENT_QUOTES); ?>">
                                <div class="form-body">
                                    <h3 class="box-title text-blue">اطلاعات شخصی</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">نام</label>
                                                <input type="text" disabled id="first_name" class="form-control" value="<?php echo htmlspecialchars($student_info[0]->first_name, ENT_QUOTES); ?>">
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">نام خانوادگی</label>
                                                <input type="text" disabled id="last_name" class="form-control" value="<?php echo htmlspecialchars($student_info[0]->last_name, ENT_QUOTES); ?>">
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">First Name</label>
                                                <input type="text" disabled id="first_name_en" class="form-control" value="<?php echo htmlspecialchars($student_info[0]->first_name_en, ENT_QUOTES); ?>">
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Last Name </label>
                                                <input type="text" disabled id="last_name_en" class="form-control" value="<?php echo htmlspecialchars($student_info[0]->last_name_en, ENT_QUOTES); ?>">
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">نام پدر</label>
                                                <input type="text" disabled id="father_name" class="form-control" value="<?php echo htmlspecialchars($student_info[0]->father_name, ENT_QUOTES); ?>">
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">کد ملی</label>
                                                <input type="number" maxlength="10" disabled id="national_code" class="form-control" value="<?php echo htmlspecialchars($student_info[0]->national_code, ENT_QUOTES); ?>">
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">جنسیت</label>
                                                <select disabled class="form-control" name="">
                                                    <option <?php
                                                    if ($student_info[0]->gender === '0') {
                                                        echo 'selected';
                                                    }
                                                    ?> value="0">زن</option>
                                                    <option <?php
                                                    if ($student_info[0]->gender === '1') {
                                                        echo 'selected';
                                                    }
                                                    ?> value="1">مرد</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">تاریخ تولد</label>
                                                <input type="text" disabled  class="form-control" required value="<?php echo htmlspecialchars($student_info[0]->birthday, ENT_QUOTES); ?>">
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"> وضعیت تاهل</label>
                                                <select disabled class="form-control" data-placeholder="Choose a Category"
                                                        tabindex="1" name="marital_status">
                                                    <option <?php
                                                    if ($student_info[0]->marital_status === '0') {
                                                        echo 'selected';
                                                    }
                                                    ?> value="0"> مجرد</option>
                                                    <option <?php
                                                    if ($student_info[0]->marital_status === '1') {
                                                        echo 'selected';
                                                    }
                                                    ?> value="1"> متاهل</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">عکس <?php echo $this->session->userdata('studentDName'); ?></label>
                                                <div class="col-sm-12">
                                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                        <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                            <span class="fileinput-filename"></span></div>
                                                        <span class="input-group-addon btn btn-default btn-file"> <span class="fileinput-new">انتخاب فایل</span> <span class="fileinput-exists">تغییر</span>
                                                            <input type="hidden"><input type="file" value="<?php echo htmlspecialchars($student_info[0]->pic_name, ENT_QUOTES); ?>" name="pic_name"> </span> <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">حذف</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="box-title text-info">آدرس و شماره تماس ها</h3>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><span class="text-danger m-r-10">*</span>تلفن همراه</label>
                                                <input type="number" maxlength="11" class="form-control" name="phone_num" id='phone_num' value="<?php echo htmlspecialchars($student_info[0]->phone_num, ENT_QUOTES); ?>" required oninvalid="setCustomValidity('لطفا تلفن همراه را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block">شماره همراه 11 رقم باشد</span>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>تلفن ثابت </label>
                                                <input type="number" maxlength="11" name="tell" id='tell' value="<?php echo htmlspecialchars($student_info[0]->tell, ENT_QUOTES); ?>" class="form-control" placeholder="071xxx">
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><span class="text-danger m-r-10">*</span>استان</label>
<!--                                                <input type="text" name="province" class="form-control" value="<?php echo htmlspecialchars($student_info[0]->province, ENT_QUOTES); ?>" required>-->
                                                <input readonly type="text" name="province" class="form-control" value="فارس" placeholder="فارس" required>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><span class="text-danger m-r-10">*</span>شهر</label>
                                                <!--<input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($student_info[0]->city, ENT_QUOTES); ?>" required>-->
                                                <select class="form-control" name="city">
                                                    <option value="194">شیراز</option>
                                                    <?php foreach ($city as $cty): ?>
                                                        <option <?php
                                                        if ($cty->id === $student_info[0]->city) {
                                                            echo 'selected';
                                                        }
                                                        ?> value="<?= $cty->id; ?>"><?= $cty->name; ?></option>
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
                                                <input type="text" name="street" value="<?php echo htmlspecialchars($student_info[0]->street, ENT_QUOTES); ?>" class="form-control" required oninvalid="setCustomValidity('لطفا آدرس را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>کد پستی</label>
                                                <input type="number" maxlength="10" name="postal_code" value="<?php echo htmlspecialchars($student_info[0]->postal_code, ENT_QUOTES); ?>" class="form-control" placeholder="7376545687"> <span class="help-block">کد پستی 10 رقمی</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>کد معرف</label>
                                                <input type="number" maxlength="10" name="reference_code" class="form-control"><span class="help-block">کد ملی معرفی کننده خود را وارد کنید</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                    <!--/row-->
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success" style='float:left'><i class="fa fa-check m-r-10"></i> ثبت</button>
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
