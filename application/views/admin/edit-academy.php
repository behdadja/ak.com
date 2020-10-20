
<style>
    .modal-backdrop {
        display: none;
    }
    .modal{
        background-color: rgba(0,0,0,0.9);
        margin-top: 100px;
    }
</style>
<div class="card card-body m-32pt">
    <form id="regForm" style="margin-top: -15px" action="<?= base_url('update-academy'); ?>" method="post" enctype="multipart/form-data">

        <!-- error inputs -->
        <?php if ($this->session->flashdata('upload-msg')): ?>
            <div class="alert bg-accent text-white" role="alert"><?= $this->session->flashdata('upload-msg') ?></div>
        <?php endif; ?>

        <?php if (validation_errors()): ?>
            <div class="card">
                <div class="card-body">
                    <div class="alert bg-accent text-white" role="alert">
                        اخطارهای زیر را بررسی کنید!
                    </div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('fname'); ?></div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('lname'); ?></div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('father_name'); ?></div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('birthday'); ?></div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('academy_display_name'); ?></div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('academy_name'); ?></div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('type_academy'); ?></div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('academy_name_en'); ?></div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('teacher_display_name'); ?></div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('student_display_name'); ?></div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('student_display_name_2'); ?></div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('phone_num'); ?></div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('province'); ?></div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('city'); ?></div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('address'); ?></div>
                    <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('Introduction'); ?></div>
                </div>
            </div>
        <?php endif; ?>
        <!-- /error inputs -->

        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <input type="hidden" name="academy_id" value="<?= $academy[0]->academy_id ?>">
        <input type="hidden" name="reference_code" value="<?= $academy[0]->reference_code ?>">
        <div class="form-body">
            <div class="row text-center">
                <div class="col-md-2">
                <!--<span data-toggle='tooltip' data-title='ویرایش تصویر'>-->
                    <a href="" data-toggle="modal" data-target="#logo">
                        <img src="<?= base_url('portal/assets/profile-picture/thumb/' . $academy[0]->logo); ?>" height="120" alt="user" style="border-radius: 10px;margin-bottom: 5px">
                        <button style="width: 100%" class="btn btn-primary">ویرایش لوگو</button>
                    </a>
                    <!--</span>-->
                </div>
                <div class="col-md-8">
                    <h3 style="margin-top:70px;color: #02bec9"><?php echo htmlspecialchars($academy[0]->academy_display_name . " " . $academy[0]->academy_name, ENT_QUOTES); ?></h3>
                </div>
                <div class="col-md-2">
                    <!--<span data-toggle='tooltip' data-title='ویرایش تصویر'>-->
                    <a href="" data-toggle="modal" data-target="#manage-pic">
                        <img src="<?= base_url('portal/assets/profile-picture/thumb/' . $academy[0]->manage_pic); ?>" height="120" alt="user" style="border-radius: 10px;margin-bottom: 5px">
                        <button style="width: 100%" class="btn btn-primary">ویرایش عکس</button>
                    </a>
                    <!--</span>-->
                </div>
            </div>
            <h4 class="box-title">مشخصات مدیر</h4>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">نام مدیر</label>
                        <p><input type="text" name="fname" class="form-control" value="<?php echo $academy[0]->m_first_name ?>"></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">نام خانوادگی</label>
                        <p><input type="text" name="lname" class="form-control" value="<?= $academy[0]->m_last_name ?>" required></p> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">نام پدر</label>
                        <p><input type="text" name="father_name" class="form-control" value="<?= $academy[0]->father_name ?>" required></p> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">کد ملی</label>
                        <p><input disabled type="number" class="form-control" value="<?= $academy[0]->national_code ?>"></p> 
                        <p><input type="hidden" name="national_code" value="<?= $academy[0]->national_code ?>" required></p> 
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">تاریخ تولد</label>
                        <p><input type="text" name="birthday" class="form-control" value="<?= $academy[0]->birthday ?>" required></p> 
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">جنسیت</label>
                        <select name="gender" id="custom-select" class="form-control custom-select">
                            <option <?php
                            if ($academy[0]->gender === 1) {
                                echo 'selected';
                            }
                            ?> value="1">مرد</option>
                            <option <?php
                            if ($academy[0]->gender === 0) {
                                echo 'selected';
                            }
                            ?> value="0">زن</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">وضعیت تاهل</label>
                        <select name="marital_status" id="custom-select" class="form-control custom-select">
                            <option<?php
                            if ($academy[0]->marital_status === 0) {
                                echo 'selected';
                            }
                            ?> value="0">مجرد</option>
                            <option <?php
                            if ($academy[0]->marital_status === 1) {
                                echo 'selected';
                            }
                            ?> value="1">متاهل</option>
                        </select>
                    </div>
                </div>
                <!--                <div class="col-sm-4 form-group">
                                    <label for="file" class="control-label">عکس مدیر</label>
                                    <div class="custom-file">
                                        <input type="file" name="manage_pic" id="file" class="custom-file-input" value="<?= base_url('portal/assets/profile-picture/thumb/' . $academy[0]->logo) ?>">
                                        <label for="file" class="custom-file-label"></label>
                                    </div>
                                </div>-->
            </div>

            <h4 class="box-title">مشخصات آموزشگاه</h4>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">پیشوند نام آموزشگاه</label>
                        <p><input type="text" name="academy_display_name" class="form-control" value="<?= $academy[0]->academy_display_name ?>" required></p> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">نام آموزشگاه</label>
                        <p><input type="text" name="academy_name" class="form-control" value="<?= $academy[0]->academy_name ?>" required></p> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">نوع آموزشگاه</label>
                        <select name="type_academy" class="form-control custom-select">
                            <option value="">لطفا انتخاب کنید</option>
                            <option
                            <?php
                            if ($academy[0]->type_academy === '0') {
                                echo 'selected';
                            }
                            ?>
                                value="0">مجتمع آموزشی
                            </option>

                            <option
                            <?php
                            if ($academy[0]->type_academy === '1') {
                                echo 'selected';
                            }
                            ?>
                                value="1">فنی و حرفه ای
                            </option>

                            <option
                            <?php
                            if ($academy[0]->type_academy === '2') {
                                echo 'selected';
                            }
                            ?> 
                                value="2">درسی و کنکور
                            </option>

                            <option
                            <?php
                            if ($academy[0]->type_academy === '3') {
                                echo 'selected';
                            }
                            ?> value="3">زبان
                            </option>

                            <option
                            <?php
                            if ($academy[0]->type_academy === '4') {
                                echo 'selected';
                            }
                            ?>
                                value="4">هنر و موسیقی
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">نام انگلیسی آموزشگاه</label>
                        <p><input type="text" name="academy_name_en" class="form-control" value="<?= $academy[0]->academy_name_en ?>" required></p> 
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">لقب آموزش دهنده</label>
                        <p><input type="text" name="teacher_display_name" class="form-control" value="<?= $academy[0]->teacher_display_name ?>" required></p> 
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">لقب آموزش پذیر</label>
                        <p><input type="text" name="student_display_name" class="form-control" value="<?= $academy[0]->student_display_name ?>" required></p> 
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">لقب دوم آموزش پذیر</label>
                        <p><input type="text" name="student_display_name_2" class="form-control" value="<?= $academy[0]->student_display_name_2 ?>" required></p> 
                    </div>
                </div>
                <!--                <div class="col-sm-6 form-group">
                                    <label for="file" class="control-label">لوگوی آموزشگاه</label>
                                    <div class="custom-file">
                                        <input type="file" name="logo" id="file" class="custom-file-input" value="<?= base_url('portal/assets/profile-picture/thumb/' . $academy[0]->logo) ?>">
                                        <label for="file" class="custom-file-label"></label>
                                    </div>
                                </div>-->
            </div>

            <h4 class="box-title">اطلاعات تماس</h4>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">شماره همراه</label>
                        <p><input type="number" name="phone_num" class="form-control" value="<?= $academy[0]->phone_num ?>" required></p> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">شماره تلفن</label>
                        <p><input type="number" name="tell" class="form-control" value="<?= $academy[0]->tell ?>"></p> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">ایمیل</label>
                        <p><input type="text" name="email" class="form-control" value="<?= $academy[0]->email ?>"></p> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">سایت</label>
                        <p><input type="text" name="site" class="form-control" value="<?= $academy[0]->site ?>"></p> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">استان</label>
                        <select class="form-control custom-select" id="province_id" name="province" required oninvalid="setCustomValidity('لطفا استان را انتخاب کنید')" onchange="try {
                                    setCustomValidity('');
                                } catch (e) {
                                }">
                            <option value="">انتخاب کنید</option>
                            <?php
                            foreach ($province as $prv) {
                                ?>
                                <option <?php
                                if ($prv->id === $academy[0]->province) {
                                    echo'selected';
                                }
                                ?> value="<?= $prv->id ?>"><?= $prv->name ?></option>
                                <?php } ?> 
                        </select> 
                        <!--<p><input type="text" name="province" class="form-control" value="<?= $academy[0]->province ?>" required></p>--> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">شهر</label>
                        <select class="form-control custom-select" name="city" id="city_id">
                            <option value="">انتخاب کنید</option>
                            <?php
                            foreach ($city as $cty) {
                                ?>
                                <option <?php
                                if ($cty->id === $academy[0]->city) {
                                    echo'selected';
                                }
                                ?> value="<?= $cty->id ?>"><?= $cty->name ?></option>
                                <?php } ?>
                        </select>
                                <!--<p><input type="text" name="city" class="form-control" value="<?= $academy[0]->city ?>" required></p>--> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">آدرس</label>
                        <p><input type="text" name="address" class="form-control" value="<?= $academy[0]->address ?>" required></p> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">کد پستی</label>
                        <p><input type="number" name="postal_code" class="form-control" value="<?= $academy[0]->postal_code ?>" required></p> 
                    </div>
                </div>
            </div>

            <h4 class="box-title">معرفی آموزشگاه</h4>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <!--<label class="control-label"></label>-->
                    <p><textarea type="text" name="Introduction" style="height:100px" class="timepicker form-control" value="<?= $academy[0]->Introduction ?>" required><?= $academy[0]->Introduction ?></textarea></p>
                </div>  
            </div><br>
            <div class="row">
                <div class="col-md-6">
                    <?php if ($academy[0]->status === '0'): ?>
                        <a href="" data-toggle="modal" data-target="#active" class="btn btn-info col-md-12">فعالسازی</a>
                    <?php else: ?>
                        <a href="" data-toggle="modal" data-target="#active" class="btn btn-accent col-md-12">غیر فعالسازی</a>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary col-md-12">ثبت تغییرات</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('select[name="province"]').on('change', function () {
            var province_id = $(this).val();
            if (province_id) {
                $.ajax({
                    url: 'dropdown/city/' + province_id,
                    type: "GET",
                    dataType: "json",
                    success: function (states) {
                        $('select[name="city"]').empty();
                        $.each(states, function (key, value) {
                            $('select[name="city"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="city"]').empty();
            }
        });
    });
</script>

<div id="logo" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <span><h5 class="modal-title" id="myModalLabel">ویرایش لوگو آموزشگاه</h5></span>
            </div>
            <form class="form-horizontal" action="<?= base_url('manager-update-logo'); ?>" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input type="hidden" name="academy_id" value="<?= $academy[0]->academy_id ?>">
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

<div id="manage-pic" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <span><h5 class="modal-title" id="myModalLabel">ویرایش تصویر پروفایل</h5></span>
            </div>
            <form class="form-horizontal" action="<?= base_url('manager-update-pic'); ?>" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input type="hidden" name="academy_id" value="<?= $academy[0]->academy_id ?>">
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

<div id="active" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <span><h5 class="modal-title" id="myModalLabel">مدیریت آموزشگاه ها</h5></span>
            </div>
            <form class="form-horizontal" action="<?= base_url('activation-academy'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input type="hidden" name="academy_id" value="<?= $academy[0]->academy_id ?>">
                    <input type="hidden" name="status" value="<?= $academy[0]->status ?>">
                    <div class="form-group">
                        <?php if ($academy[0]->status === '0'): ?>
                            <label class="text-danger" for="input-file-now">از فعالسازی آموزشگاه اطمینان دارید؟</label>
                        <?php else: ?>
                            <label class="text-danger" for="input-file-now">از غیر فعالسازی آموزشگاه اطمینان دارید؟</label>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success" style="width: 100%">بله</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" style="width: 100%" class="btn btn-info" data-dismiss="modal">خیر</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>





