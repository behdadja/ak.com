<div class="col-md-12">
    <div class="white-box">

        <!--.row-->
        <div class="row">
            <div class="panel panel-info" style="background-color: #f7fcfc">

                <div class="col-md-12 text-center m-t-20 m-b-20">
                    <div class="col-md-2">
                        <!--<span data-toggle='tooltip' data-title='ویرایش تصویر'>-->
                        <a href="" data-toggle="modal" data-target="#logo">
                            <img src="<?= base_url('assets/profile-picture/thumb/' . $manager_info[0]->logo); ?>" height="120" alt="user" style="border-radius: 10px;margin-bottom: 5px">
                            <button style="width: 80%" class="btn btn-default">ویرایش لوگو</button>
                        </a>
                        <!--</span>-->
                    </div>
                    <div class="col-md-8">
                        <div class="panel-heading"> ویرایش اطلاعات : <?php echo htmlspecialchars($manager_info[0]->academy_display_name . " " . $manager_info[0]->academy_name, ENT_QUOTES); ?></div>
                        <h3 class="box-title text-danger p-t-10  p-r-20">پر کردن موارد ستاره دار ( * ) الزامی می باشد.</h3>
                    </div>
                    <div class="col-md-2">
                        <!--<span data-toggle='tooltip' data-title='ویرایش تصویر'>-->
                        <a href="" data-toggle="modal" data-target="#manage-pic">
                            <img src="<?= base_url('assets/profile-picture/thumb/' . $manager_info[0]->manage_pic); ?>" height="120" alt="user" style="border-radius: 10px;margin-bottom: 5px">
                            <button style="width: 80%" class="btn btn-default">ویرایش عکس</button>
                        </a>
                        <!--</span>-->
                    </div>
                </div>

                <div class="col-md-12 m-t-20 m-b-20">
                    <!-- error for upload image -->
                    <?php if ($this->session->flashdata('upload-msg')) : ?>
                        <div class="m-b-20">
                            <div class="alert alert-danger"><?php echo $this->session->flashdata('upload-msg'); ?></div>
                        </div>
                    <?php endif; ?>
                    <!-- /error for upload image -->

                    <!-- error inputs -->
                    <?php if (validation_errors()): ?>
                        <div class="m-b-20">
                            <div class="alert alert-danger">اخطارهای زیر را بررسی کنید!</div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('first_name'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('last_name'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('birthday'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('national_code'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('academy_name'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('type_academy'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('academy_name_en'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('academy_display_name'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('teacher_display_name'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('student_display_name'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('student_display_name_2'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('phone_num'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('tell'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('email'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('province'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('city'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('address'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('postal_code'); ?></div>
                            <div class="text-danger p-r-10" style="border-right: #ff7676 thick solid"><?php echo form_error('Introduction'); ?></div>
                        </div>
                    <?php endif; ?>
                    <!-- /error inputs -->
                </div>

                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form name="user_register" action="<?php echo base_url('update-profile'); ?>" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
                            <div class="form-body">
                                <h3 class="box-title text-blue">اطلاعات مدیر</h3>
                                <hr style="border-color: #2cabe3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger m-r-10">*</span>نام</label>
                                            <input type="text" name="m_first_name" id="m_first_name" class="form-control"value="<?php echo htmlspecialchars($manager_info[0]->m_first_name, ENT_QUOTES); ?>" required="" oninvalid="setCustomValidity('لطفا نام را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger m-r-10">*</span>نام خانوادگی</label>
                                            <input type="text" id="m_last_name" name="m_last_name" class="form-control"value="<?php echo htmlspecialchars($manager_info[0]->m_last_name, ENT_QUOTES); ?>" required="" oninvalid="setCustomValidity('لطفا نام خانوادگی را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger m-r-10">*</span>نام پدر</label>
                                            <input type="text" id="father_name" name="father_name" class="form-control"value="<?php echo htmlspecialchars($manager_info[0]->father_name, ENT_QUOTES); ?>" required="" oninvalid="setCustomValidity('لطفا نام پدر را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">کد ملی</label>
                                            <input type="text" disabled id="national_code" name="" class="form-control"value="<?php echo htmlspecialchars($manager_info[0]->national_code, ENT_QUOTES); ?>" required="" oninvalid="setCustomValidity('لطفا کد ملی را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block">کد ملی باید 10 رقم باشد</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">تصویر کارت ملی </label>
                                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                    <span class="fileinput-filename"></span></div>
                                                <span class="input-group-addon btn btn-default btn-file"> <span class="fileinput-new">انتخاب فایل</span> <span class="fileinput-exists">تغییر</span>
                                                        <input type="hidden"><input type="file" name="national_card_image"> </span> <a href="form-material-elements.html#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">حذف</a>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                </div>
                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger m-r-10">*</span>تاریخ تولد</label>
                                            <input type="text" readonly value="<?= $birthday ?>" name="birthday" min="1300-01-01" min="1395-12-12" id="example-input2-group2" class="form-control auto-close-example" onkeyup="
                                var date = this.value;
                                if (date.match(/^\d{4}$/) !== null) {
                                    this.value = date + '-';
                                } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                    this.value = date + '-';
                                }" maxlength="10" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تاریخ تولد را وارد کنید')" onchange="try {
                                            setCustomValidity('');
                                        } catch (e) {
                                        }">
                                            <!--                                            <div class="input-group">-->
                                            <!--                                                <input type="text" value="--><?//= $birthday ?><!--" class="form-control">-->
                                            <!--                                                <span class="input-group-addon">انتخاب </span>-->
                                            <!--                                                <input type="month" value="--><?//= $birthday ?><!--" id="example-input2-group2" class="form-control auto-close-example">-->
                                            <!--                                            </div>-->
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">جنسیت</label>
                                            <select class="form-control" name="gender">
                                                <option <?php
                                                if ($manager_info[0]->gender === '1') {
                                                    echo 'selected';
                                                }
                                                ?> value="1">مرد</option>
                                                <option <?php
                                                if ($manager_info[0]->gender === '0') {
                                                    echo 'selected';
                                                }
                                                ?> value="0">زن</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"> وضعیت تاهل</label>
                                            <select class="form-control" data-placeholder="Choose a Category"
                                                    tabindex="1" name="marital_status">
                                                <option <?php
                                                if ($manager_info[0]->marital_status === '0') {
                                                    echo 'selected';
                                                }
                                                ?> value="0"> مجرد</option>
                                                <option <?php
                                                if ($manager_info[0]->marital_status === '1') {
                                                    echo 'selected';
                                                }
                                                ?> value="1"> متاهل</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--/row-->
                                <h3 class="box-title text-blue">اطلاعات آموزشگاه</h3>
                                <hr style="border-color: #2cabe3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger m-r-10">*</span>پیشوند نام</label>
                                            <input type="text" name="academy_display_name" id="first_name" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->academy_display_name, ENT_QUOTES); ?>" required="" oninvalid="setCustomValidity('لطفا پیشوند نام آموزشگاه را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block">مثال : موسسه آموزشی، آموزشگاه زبان، ...</span>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger m-r-10">*</span>نام آموزشگاه</label>
                                            <input type="text" name="academy_name" id="first_name" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->academy_name, ENT_QUOTES); ?>" required="" oninvalid="setCustomValidity('لطفا نام آموزشگاه را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger m-r-10">*</span>نام لاتین آموزشگاه</label>
                                            <input type="text" id="last_name" lang="en" name="academy_name_en" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->academy_name_en, ENT_QUOTES); ?>" required="" oninvalid="setCustomValidity('لطفا نام لاتین آموزشگاه را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger m-r-10">*</span>نوع آموزشگاه</label>
                                            <select name="type_academy" class="form-control custom-select">
                                                <option value="">لطفا انتخاب کنید</option>
                                                <option
                                                    <?php
                                                    if ($manager_info[0]->type_academy === '0') {
                                                        echo 'selected';
                                                    }
                                                    ?>
                                                        value="0">مجتمع آموزشی
                                                </option>

                                                <option
                                                    <?php
                                                    if ($manager_info[0]->type_academy === '1') {
                                                        echo 'selected';
                                                    }
                                                    ?>
                                                        value="1">فنی و حرفه ای
                                                </option>

                                                <option
                                                    <?php
                                                    if ($manager_info[0]->type_academy === '2') {
                                                        echo 'selected';
                                                    }
                                                    ?>
                                                        value="2">درسی و کنکور
                                                </option>

                                                <option
                                                    <?php
                                                    if ($manager_info[0]->type_academy === '3') {
                                                        echo 'selected';
                                                    }
                                                    ?> value="3">زبان
                                                </option>

                                                <option
                                                    <?php
                                                    if ($manager_info[0]->type_academy === '4') {
                                                        echo 'selected';
                                                    }
                                                    ?>
                                                        value="4">هنر و موسیقی
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">تصویر مجوز آموزشگاه </label>
                                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                    <span class="fileinput-filename"></span></div>
                                                <span class="input-group-addon btn btn-default btn-file"> <span class="fileinput-new">انتخاب فایل</span> <span class="fileinput-exists">تغییر</span>
													           <input type="hidden"><input type="file" name="license_image"> </span> <a href="form-material-elements.html#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">حذف</a>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger m-r-10">*</span>لقب آموزش دهنده</label>
                                            <input type="text" id="last_name" name="teacher_display_name" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->teacher_display_name, ENT_QUOTES); ?>" required="" oninvalid="setCustomValidity('لطفا لقب آموزش دهنده را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block">مثال : استاد، آموزش دهنده، ...</span>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger m-r-10">*</span>لقب آموزش پذیر</label>
                                            <input type="text" name="student_display_name" id="first_name" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->student_display_name, ENT_QUOTES); ?>" required="" oninvalid="setCustomValidity('لطفا لقب آموزش پذیر را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block">مثال : دانشجو، زبان آموز، ...</span>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger m-r-10">*</span>لقب دوم آموزش پذیر</label>
                                            <input type="text" id="last_name" name="student_display_name_2" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->student_display_name_2, ENT_QUOTES); ?>" required="" oninvalid="setCustomValidity('لطفا لقب دوم آموزش پذیر را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block">مثال : دانشجوی، زبان آموز، ...</span>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger m-r-10">*</span>معرفی آموزشگاه</label>
                                            <input type="text" name="Introduction" style="height: auto" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->Introduction, ENT_QUOTES); ?>" required="" oninvalid="setCustomValidity('لطفا معرفی آموزشگاه را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                        </div>
                                    </div>
                                </div>
                                <!--/row-->
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="box-title text-info">آدرس و شماره تماس ها</h3>
                                        <hr style="border-color: #2cabe3">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><span class="text-danger m-r-10">*</span>تلفن همراه</label>
                                            <input type="text" class="form-control" name="phone_num" id='phone_num' value="<?php echo htmlspecialchars($manager_info[0]->phone_num, ENT_QUOTES); ?>" required="" oninvalid="setCustomValidity('لطفا شماره همراه را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block">شماره همراه 11 رقم باشد</span>
                                        </div>

                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>تلفن ثابت </label>
                                            <input type="text" name="tell" id='tell' value="<?php echo htmlspecialchars($manager_info[0]->tell, ENT_QUOTES); ?>" class="form-control">
                                            <span class="help-block"></span></div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><span class="text-danger m-r-10">*</span>استان</label>
                                            <input readonly type="text" name="province" class="form-control" value="فارس" placeholder="فارس">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><span class="text-danger m-r-10">*</span>شهر</label>
                                            <!--<input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->city, ENT_QUOTES); ?>" required>-->
                                            <select class="form-control" name="city">
                                                <option value="194">شیراز</option>
                                                <?php foreach ($city as $cty): ?>
                                                    <option <?php
                                                    if ($cty->id === $manager_info[0]->city) {
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
                                            <label>ایمیل</label>
                                            <input type="text" name="email" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->email, ENT_QUOTES); ?>">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>سایت</label>
                                            <input type="text" name="site" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->site, ENT_QUOTES); ?>">
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><span class="text-danger m-r-10">*</span>آدرس</label>
                                            <input type="text" name="address" value="<?php echo htmlspecialchars($manager_info[0]->address, ENT_QUOTES); ?>" class="form-control" required="" oninvalid="setCustomValidity('لطفا آدرس را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><span class="text-danger m-r-10">*</span>کد پستی</label>
                                            <input type="text" name="postal_code" value="<?php echo htmlspecialchars($manager_info[0]->postal_code, ENT_QUOTES); ?>" class="form-control" required="" oninvalid="setCustomValidity('لطفا کد پستی را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block">کد پستی 10 رقمی</span>
                                        </div>
                                    </div>
                                </div>
                                <!--/row-->
                                <div class="form-actions">
                                    <button type="submit" name="register" class="btn btn-success" style='float:left'><i class="fa fa-check"></i> ثبت تغییرات</button>
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


<div id="logo" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">ویرایش لوگو آموزشگاه</h4>
            </div>
            <form class="form-horizontal" action="<?= base_url('manager-update-logo'); ?>" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <div class="form-group">
                        <label class="text-danger" for="input-file-now"> ارسال تصویر با پسوندهای     jpg ، jpeg و png امکان پذیر است.</label>
                        <input type="file" id="input-file-now" name="logo" class="dropify" required oninvalid="setCustomValidity('لطفا یک فایل انتخاب کنید')" onchange="try {
                                    setCustomValidity('');
                                } catch (e) {
                                }">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success" style="width: 100%">ثبت</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" style="width: 100%" class="btn btn-info" data-dismiss="modal">انصراف</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="manage-pic" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">ویرایش تصویر پروفایل</h4>
            </div>
            <form class="form-horizontal" action="<?= base_url('manager-update-pic'); ?>" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <div class="form-group">
                        <label class="text-danger" for="input-file-now"> ارسال تصویر با پسوندهای     jpg ، jpeg و png امکان پذیر است.</label>
                        <input type="file" id="input-file-now" name="manage_pic" class="dropify" required oninvalid="setCustomValidity('لطفا یک فایل انتخاب کنید')" onchange="try {
                                    setCustomValidity('');
                                } catch (e) {
                                }">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success" style="width: 100%">ثبت</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" style="width: 100%" class="btn btn-info" data-dismiss="modal">انصراف</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- edit birthday -->
<!--<div id="edit-birthday" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">-->
<!--    <div class="modal-dialog modal-sm">-->
<!--        <div class="modal-content text-center">-->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
<!--                <h4 class="modal-title" id="myModalLabel">ویرایش تاریخ تولد</h4>-->
<!--            </div>-->
<!--            <form class="form-horizontal" action="--><?//= base_url('manager-edit-birthday'); ?><!--" method="post">-->
<!--                <div class="modal-body" style="padding:10px 40px 10px 40px">-->
<!--                    <input type="hidden" name="--><?php //echo $this->security->get_csrf_token_name(); ?><!--" value="--><?php //echo $this->security->get_csrf_hash(); ?><!--" />-->
<!--                    <input type="hidden" name="national_code" class="form-control" value="--><?php //echo $manager_info[0]->national_code ?><!--">-->
<!--                    <input type="hidden" name="category" class="form-control" value="0">-->
<!--                    <div class="form-group">-->
<!--                        <label class="control-label text-info m-b-20">تاریخ تولد :</label>-->
<!--                        <input type="text" readonly name="birthday" value="kugkuikufguk" class="form-control auto-close-example" required">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="modal-footer">-->
<!--                    <div class="col-md-6">-->
<!--                        <button type="submit" class="btn btn-success" style="width: 100%">ثبت</button>-->
<!--                    </div>-->
<!--                    <div class="col-md-6">-->
<!--                        <button type="button" style="width: 100%" class="btn btn-info" data-dismiss="modal">انصراف</button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
