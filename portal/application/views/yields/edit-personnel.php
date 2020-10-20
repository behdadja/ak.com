<div class="col-md-12">
    <div class="white-box">

        <!--.row-->
        <div class="row">
            <div class="panel panel-info" style="background-color: #f7fcfc">

                <div class="col-md-12 text-center m-t-20">
                    <div class="col-md-10">
                        <div class="panel-heading"> ویرایش اطلاعات کارمند : <?php echo $manager_info[0]->first_name . " " . $manager_info[0]->last_name; ?></div>
                        <h3 class="box-title text-danger p-t-10  p-r-20">پر کردن موارد ستاره دار ( * ) الزامی می باشد.</h3>
                    </div>
                    <div class="col-md-2">
                        <!--<span data-toggle='tooltip' data-title='ویرایش تصویر'>-->
                        <a href="" data-toggle="modal" data-target="#modal-pic">
                            <img src="<?= base_url('assets/profile-picture/thumb/' . $manager_info[0]->pic_name); ?>" height="120" alt="user" style="border-radius: 10px;margin-bottom: 5px">
                            <button style="width: 80%" class="btn btn-default">ویرایش عکس</button>
                        </a>
                        <!--</span>-->
                    </div>
                </div>

                <div class="col-md-12 m-t-20 m-b-20">
                    <!-- errors -->
                    <?php if ($this->session->flashdata('upload-msg')) : ?>
                        <div class="m-b-20">
                            <div class="alert alert-danger"><?php echo $this->session->flashdata('upload-msg'); ?></div>
                        </div>
                    <?php endif; ?>
                    <!-- /errors -->

                    <!-- error inputs -->
                    <?php if (validation_errors()): ?>
                        <div class="m-b-20">
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
                        </div>
                    <?php endif; ?>

                    <!-- /error inputs -->
                </div>

                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">

                        <form action="<?php echo base_url(); ?>users/update-personnel" enctype="multipart/form-data" method="post" name="user_register">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
                            <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($manager_info[0]->national_code, ENT_QUOTES); ?>">
                            <div class="form-body">
                                <h3 class="box-title text-blue">اطلاعات شخصی</h3>
                                <hr style="background-color: black">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger m-r-10">*</span>نام</label>
                                            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->first_name, ENT_QUOTES); ?>" required oninvalid="setCustomValidity('لطفا نام را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger m-r-10">*</span>نام خانوادگی</label>
                                            <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->last_name, ENT_QUOTES); ?>" required oninvalid="setCustomValidity('لطفا نام خانوادگی را وارد کنید')" onchange="try {
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
                                            <input type="text" id="first_name_en" name="first_name_en" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->first_name_en, ENT_QUOTES); ?>" placeholder="" required="" oninvalid="setCustomValidity('لطفا نام لاتین را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Last Name </label>
                                            <input type="text" id="last_name_en" name="last_name_en" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->last_name_en, ENT_QUOTES); ?>" required="" oninvalid="setCustomValidity('لطفا نام خانوادگی لاتین را وارد کنید')" onchange="try {
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
                                            <label class="control-label"><span class="text-danger m-r-10">*</span>نام پدر</label>
                                            <input type="text" id="father_name" name="father_name" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->father_name, ENT_QUOTES); ?>" required oninvalid="setCustomValidity('لطفا نام پدر را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">کد ملی</label>
                                            <input type="text" maxlength="10" disabled id="national_code" class="form-control" value="<?php echo htmlspecialchars($manager_info[0]->national_code, ENT_QUOTES); ?>">
                                        </div>
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
                                            <!--                                                <input type="text" readonly id="example-input2-group2" value="--><?//= $manager_info[0]->birthday ?><!--" class="form-control">-->
                                            <!--                                                <span class="input-group-btn">-->
                                            <!--                                                    <button type="button" data-toggle="modal" data-target="#edit-birthday" class="btn waves-effect waves-light btn-primary">ویرایش</button>-->
                                            <!--                                                </span>-->
                                            <!--                                            </div>-->
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">جنسیت</label>
                                            <select class="form-control" name="gender">
                                                <option <?php
                                                if ($manager_info[0]->gender === '0') {
                                                    echo 'selected';
                                                }
                                                ?> value="0">زن</option>
                                                <option <?php
                                                if ($manager_info[0]->gender === '1') {
                                                    echo 'selected';
                                                }
                                                ?> value="1">مرد</option>
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
                                    <!--/span-->
                                </div>
                                <!--/row-->
                                <div class="row">
                                    <!--                                        <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">عکس</label>
                                                                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                                                        <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                                                            <span class="fileinput-filename"></span></div>
                                                                                        <span class="input-group-addon btn btn-default btn-file"> <span class="fileinput-new">انتخاب فایل</span> <span class="fileinput-exists">تغییر</span>
                                                                                            <input type="hidden"><input type="file" value="<?php echo htmlspecialchars($manager_info[0]->pic_name, ENT_QUOTES); ?>" name="pic_name"> </span> <a href="form-material-elements.html#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">حذف</a>
                                                                                    </div>
                                                                                </div>
                                                                                /span
                                                                            </div>-->
                                </div>
                                <br>
                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="box-title text-info">آدرس و شماره تماس ها</h3>
                                        <hr style="background-color: black">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><span class="text-danger m-r-10">*</span>تلفن همراه</label>
                                            <input onKeyPress="if (this.value.length == 11)
                                                        return false;" min="09000000000" max="99999999999" type="number" maxlength="11" class="form-control" name="phone_num" id='phone_num' value="<?php echo htmlspecialchars($manager_info[0]->phone_num, ENT_QUOTES); ?>" required oninvalid="setCustomValidity('لطفا شماره همراه را وارد کنید')" onchange="try {
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
                                                        return false;" min="01000000000" max="99999999999" type="number" maxlength="11" name="tell" id='tell' value="<?php echo htmlspecialchars($manager_info[0]->tell, ENT_QUOTES); ?>" class="form-control" placeholder="">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><span class="text-danger m-r-10">*</span>استان</label>
                                            <input readonly="" type="text" name="province" class="form-control" value="فارس" placeholder="فارس">
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
                                            <label><span class="text-danger m-r-10">*</span>آدرس</label>
                                            <input type="text" name="street" value="<?php echo htmlspecialchars($manager_info[0]->street, ENT_QUOTES); ?>" class="form-control" required oninvalid="setCustomValidity('لطفا آدرس را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>کد پستی</label>
                                            <input type="text" maxlength="10" name="postal_code" value="<?php echo htmlspecialchars($manager_info[0]->postal_code, ENT_QUOTES); ?>" class="form-control" placeholder="6675434562" required oninvalid="setCustomValidity('لطفا کد پستی را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }"> <span class="help-block">کد پستی 10 رقمی</span></div>
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
                                            <label class="control-label font-bold">انتخاب واحد فعالیت</label>
                                            <select class="form-control" tabindex="1" name="activity_unit">
                                                <option selected value="">انتخاب کنید</option>
                                                <option value="1" <?php
                                                if ($manager_info[0]->activity_unit === '1') {
                                                    echo 'selected';
                                                }
                                                ?> >مدیر داخلی</option>
                                                <option value="2" <?php
                                                if ($manager_info[0]->activity_unit === '2') {
                                                    echo 'selected';
                                                }
                                                ?> >مالی و حسابداری</option>
                                                <option value="0" <?php
                                                if ($manager_info[0]->activity_unit === '0') {
                                                    echo 'selected';
                                                }
                                                ?> >سایر کارمندان</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label font-bold">حقوق ماهیانه</label>
                                            <input type="text" maxlength="8" id="monthly_salary" name="monthly_salary" value="<?php echo htmlspecialchars($manager_info[0]->monthly_salary, ENT_QUOTES); ?>" class="form-control" required oninvalid="setCustomValidity('لطفا حقوق ماهیانه را وارد کنید')" onchange="try {
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
                                                                    <input id="all_level" name="all_level" type="checkbox" <?php
                                                                    if ($manager_info[0]->class === '1' && $manager_info[0]->lesson === '1' && $manager_info[0]->course === '1' && $manager_info[0]->exam === '1' && $manager_info[0]->student === '1' && $manager_info[0]->teacher === '1' && $manager_info[0]->personnel === '1' && $manager_info[0]->financial_std === '1' && $manager_info[0]->financial_thr === '1' && $manager_info[0]->financial_prl === '1' && $manager_info[0]->ticket_std === '1' && $manager_info[0]->ticket_thr === '1' && $manager_info[0]->ticket_prl === '1') {
                                                                        echo 'checked';
                                                                    }
                                                                    ?> >
                                                                    <label for="all_level"> دسترسی به همه سطوح</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <div class="checkbox checkbox-primary p-t-0">
                                                            <div class="well well-sm" style="background-color: #f3f3f3;">
                                                                <div class="form-group m-b-0">
                                                                    <input id="classs" name="classs" type="checkbox"
                                                                        <?php
                                                                        if ($manager_info[0]->class === '1') {
                                                                            echo 'checked';
                                                                        }
                                                                        ?> >
                                                                    <label for="classs"> ایجاد و مدیریت کلاس</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <div class="checkbox checkbox-primary p-t-0">
                                                            <div class="well well-sm" style="background-color: #f3f3f3;">
                                                                <div class="form-group m-b-0">
                                                                    <input id="lesson" name="lesson" type="checkbox"
                                                                        <?php
                                                                        if ($manager_info[0]->lesson === '1') {
                                                                            echo 'checked';
                                                                        }
                                                                        ?> >
                                                                    <label for="lesson"> ایجاد و مدیریت درس</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <div class="checkbox checkbox-primary p-t-0">
                                                            <div class="well well-sm" style="background-color: #f3f3f3">
                                                                <div class="form-group m-b-0">
                                                                    <input id="course" name="course" type="checkbox"
                                                                        <?php
                                                                        if ($manager_info[0]->course === '1') {
                                                                            echo 'checked';
                                                                        }
                                                                        ?> >
                                                                    <label for="course"> ایجاد و مدیریت دوره</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <div class="checkbox checkbox-primary p-t-0">
                                                            <div class="well well-sm" style="background-color: #f3f3f3">
                                                                <div class="form-group m-b-0">
                                                                    <input id="exam" name="exam" type="checkbox"
                                                                        <?php
                                                                        if ($manager_info[0]->exam === '1') {
                                                                            echo 'checked';
                                                                        }
                                                                        ?> >
                                                                    <label for="exam"> ایجاد و مدیریت آزمون</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-center">
                                                        <div class="checkbox checkbox-primary p-t-0">
                                                            <div class="well well-sm" style="background-color: #f3f3f3">
                                                                <div class="form-group m-b-0">
                                                                    <input id="student" name="student" type="checkbox"
                                                                        <?php
                                                                        if ($manager_info[0]->student === '1') {
                                                                            echo 'checked';
                                                                        }
                                                                        ?> >
                                                                    <label for="student"> ایجاد و مدیریت دانشجو</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-center">
                                                        <div class="checkbox checkbox-primary p-t-0">
                                                            <div class="well well-sm" style="background-color: #f3f3f3">
                                                                <div class="form-group m-b-0">
                                                                    <input id="teacher" name="teacher" type="checkbox"
                                                                        <?php
                                                                        if ($manager_info[0]->teacher === '1') {
                                                                            echo 'checked';
                                                                        }
                                                                        ?> >
                                                                    <label for="teacher"> ایجاد و مدیریت استاد</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-center">
                                                        <div class="checkbox checkbox-primary p-t-0">
                                                            <div class="well well-sm" style="background-color: #f3f3f3">
                                                                <div class="form-group m-b-0">
                                                                    <input id="personnel" name="personnel" type="checkbox"
                                                                        <?php
                                                                        if ($manager_info[0]->personnel === '1') {
                                                                            echo 'checked';
                                                                        }
                                                                        ?> >
                                                                    <label for="personnel"> ایجاد و مدیریت کارمند</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-center">
                                                        <div class="checkbox checkbox-primary p-t-0">
                                                            <div class="well well-sm" style="background-color: #f3f3f3">
                                                                <div class="form-group m-b-0">
                                                                    <input id="financial_std" name="financial_std" type="checkbox"
                                                                        <?php
                                                                        if ($manager_info[0]->financial_std === '1') {
                                                                            echo 'checked';
                                                                        }
                                                                        ?> >
                                                                    <label for="financial_std">وضعیت مالی دانشجو</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-center">
                                                        <div class="checkbox checkbox-primary p-t-0">
                                                            <div class="well well-sm" style="background-color: #f3f3f3">
                                                                <div class="form-group m-b-0">
                                                                    <input id="financial_thr" name="financial_thr" type="checkbox"
                                                                        <?php
                                                                        if ($manager_info[0]->financial_thr === '1') {
                                                                            echo 'checked';
                                                                        }
                                                                        ?> >
                                                                    <label for="financial_thr">وضعیت مالی استاد</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-center">
                                                        <div class="checkbox checkbox-primary p-t-0">
                                                            <div class="well well-sm" style="background-color: #f3f3f3">
                                                                <div class="form-group m-b-0">
                                                                    <input id="financial_prl" name="financial_prl" type="checkbox"
                                                                        <?php
                                                                        if ($manager_info[0]->financial_prl === '1') {
                                                                            echo 'checked';
                                                                        }
                                                                        ?> >
                                                                    <label for="financial_prl"> وضعیت مالی کارمند</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-center">
                                                        <div class="checkbox checkbox-primary p-t-0">
                                                            <div class="well well-sm" style="background-color: #f3f3f3">
                                                                <div class="form-group m-b-0">
                                                                    <input id="ticket_std" name="ticket_std" type="checkbox"
                                                                        <?php
                                                                        if ($manager_info[0]->ticket_std === '1') {
                                                                            echo 'checked';
                                                                        }
                                                                        ?> >
                                                                    <label for="ticket_std">تیکت های دانشجو</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-center">
                                                        <div class="checkbox checkbox-primary p-t-0">
                                                            <div class="well well-sm" style="background-color: #f3f3f3">
                                                                <div class="form-group m-b-0">
                                                                    <input id="ticket_thr" name="ticket_thr" type="checkbox"
                                                                        <?php
                                                                        if ($manager_info[0]->ticket_thr === '1') {
                                                                            echo 'checked';
                                                                        }
                                                                        ?> >
                                                                    <label for="ticket_thr">تیکت های استاد</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-center">
                                                        <div class="checkbox checkbox-primary p-t-0">
                                                            <div class="well well-sm" style="background-color: #f3f3f3">
                                                                <div class="form-group m-b-0">
                                                                    <input id="ticket_prl" name="ticket_prl" type="checkbox"
                                                                        <?php
                                                                        if ($manager_info[0]->ticket_prl === '1') {
                                                                            echo 'checked';
                                                                        }
                                                                        ?> >
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
                                    <button type="submit" name="register" class="btn btn-success" style='float:left'><i class="fa fa-check"></i> ویرایش </button>
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

<div id="modal-pic" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">ویرایش تصویر پروفایل</h4>
            </div>
            <form class="form-horizontal" action="<?= base_url('personnel-update-pic'); ?>" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input type="hidden" name="national_code" class="form-control" value="<?php echo $manager_info[0]->national_code ?>">
                    <div class="form-group">
                        <label class="text-danger" for="input-file-now"> ارسال تصویر با پسوندهای     jpg ، jpeg و png امکان پذیر است.</label>
                        <input type="file" id="input-file-now" name="pic_name" class="dropify" required oninvalid="setCustomValidity('لطفا یک فایل انتخاب کنید')" onchange="try {
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
<!--            <form class="form-horizontal" action="--><?//= base_url('edit-birthday'); ?><!--" method="post">-->
<!--                <div class="modal-body" style="padding:10px 40px 10px 40px">-->
<!--                    <input type="hidden" name="--><?php //echo $this->security->get_csrf_token_name(); ?><!--" value="--><?php //echo $this->security->get_csrf_hash(); ?><!--" />-->
<!--                    <input type="hidden" name="national_code" class="form-control" value="--><?php //echo $manager_info[0]->national_code ?><!--">-->
<!--                    <input type="hidden" name="category" class="form-control" value="3">-->
<!--                    <div class="form-group">-->
<!--                        <label class="control-label text-info m-b-20">تاریخ تولد :</label>-->
<!--                        <input type="text" id="birthday" name="birthday" class="form-control auto-close-example" required class="form-control auto-close-example" onkeyup="-->
<!--                                var date = this.value;-->
<!--                                if (date.match(/^\d{4}$/) !== null) {-->
<!--                                    this.value = date + '-';-->
<!--                                } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {-->
<!--                                    this.value = date + '-';-->
<!--                                }" maxlength="10" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تاریخ تولد را وارد کنید')" onchange="try {-->
<!--                                            setCustomValidity('');-->
<!--                                        } catch (e) {-->
<!--                                        }">-->
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
