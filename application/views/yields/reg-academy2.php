
<form id="regForm" action="<?php echo base_url('insert-new-academy'); ?>" method="post" enctype="multipart/form-data">
    <?php if ($this->session->flashdata('upload-msg')): ?>>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('upload-msg'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('national-code-msg')): ?>>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('national-code-msg'); ?></div>
    <?php endif; ?>
    <div class="tab">
        <h4 class="box-title">مشخصات مدیریت آموزشگاه</h4>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">نام مدیر:</label>
                    <p><input type="text" name="fname" class="form-control" required></p> 
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">نام خانوادگی:</label>
                    <p><input type="text" name="lname" class="form-control" required></p> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">کد ملی:</label>
                    <p><input type="number" name="national_code" class="form-control" required></p> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">تاریخ تولد:</label>
                    <p><input type="text" name="birthday" class="form-control" required></p> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">جنسیت:</label>
                    <p><select name="gender" id="custom-select" class="form-control custom-select">
                            <option value="1">مرد</option>
                            <option value="0">زن</option>
                        </select></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">وضعیت تاهل:</label>
                    <p><select name="marital_status" id="custom-select" class="form-control custom-select">
                            <option value="0">مجرد</option>
                            <option value="1">متاهل</option>
                        </select></p>
                </div>
            </div>
        </div>
    </div>
    <div class="tab">
        <h4 class="box-title">مشخصات آموزشگاه</h4>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">نام آموزشگاه:</label>
                    <p><input type="text" name="academy_name" class="form-control" placeholder="آموزکده"  required></p> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">نام انگلیسی آموزشگاه:</label>
                    <p><input type="text" name="academy_name_en" class="form-control" placeholder="amoozkadeh" required></p> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">پیشوند نام:</label>
                    <p><input type="text" name="academy_display_name" class="form-control" placeholder="لقب قبل از نام مثل: موسسه آموزشی" required></p> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">لقب آموزش دهنده:</label>
                    <p><input type="text" name="teacher_display_name" class="form-control" placeholder="مثل: استاد، مربی و ..." required></p> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">لقب آموزش پذیر:</label>
                    <p><input type="text" name="student_display_name" class="form-control" placeholder="مثل: دانشجو، زبان آموز و ..." required></p> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">لقب دوم آموزش پذیر:</label>
                    <p><input type="text" name="student_display_name2" class="form-control" placeholder="مثل: دانشجوی، هنرجوی و ..." required></p> 
                </div>
            </div>
        </div>
    </div>
    <div class="tab">
        <h4 class="box-title">اطلاعات تماس</h4>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">شماره تلفن:</label>
                    <p><input type="number" name="phone_num" class="form-control" required></p> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">شماره همراه:</label>
                    <p><input type="number" name="mobile" class="form-control" required></p> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">ایمیل:</label>
                    <p><input type="text" name="email" class="form-control" required></p> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">سایت:</label>
                    <p><input type="text" name="site" class="form-control" required></p> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">استان:</label>
                    <p><input type="text" name="province" class="form-control" required></p> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">شهر:</label>
                    <p><input type="text" name="city" class="form-control" required></p> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">آدرس:</label>
                    <p><input type="text" name="address" class="form-control" placeholder="شهرک ... - خیابان ... - کوچه ..." required></p> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">کد پستی:</label>
                    <p><input type="number" name="postal_code" class="form-control" required></p> 
                </div>
            </div>
        </div>
    </div>
    <div class="tab">
        <h4 class="box-title">معرفی و لوگوی آموزشگاه</h4>
        <hr>
        <div class="row">
            <div class="col-sm-4">
                <div class="white-box">
                    <label class="control-label">لوگوی آموزشگاه:</label>
                    <input type="file" name="logo" required class="dropify"/>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="col-md-12">
                    <label class="control-label"> معرفی:</label>
                    <p><textarea type="text" name="Introduction" class="timepicker form-control" style="height: 150px" placeholder="توضیحاتی در مورد آموزشگاه" required></textarea></p>
                </div>
                <div class="col-md-12" style="padding-top: 10px">
                    <div class="form-group">
                        <p><input type="number" name="reference_code" class="form-control" placeholder="کد معرف" required></p> 
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <div style="overflow:auto;padding-top: 20px">
        <div style="float:left;">
            <button type="button" class="btn btn-danger" id="prevBtn" onclick="nextPrev(-1)">بازگشت</button>
            <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">بعدی</button>
            <button type="submit" class="btn btn-success" id="regBtn">ثبت</button>
        </div>
    </div> 
    <div style="text-align:center;margin-top:40px;">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
    </div>
</form>

<?php if ($this->session->flashdata('reg-modal')): ?>
    <script>
        $(document).ready(function () {
            $('#modal').modal('show');
        });
    </script>
<?php endif; ?>

<div class="modal" id="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #edf0f2">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">مدیریت پایگاه داده</h4>
            </div>
            <div class="modal-body">
                <p>ویرایش خبر با موفقیت انجام شد</p>
            </div>
            <div class="modal-footer" style="background-color: #edf0f2">
                <a class="btn btn-success" data-dismiss="modal">تایید</a>
            </div>
        </div>
    </div>
</div>

</body>

