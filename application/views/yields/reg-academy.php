<style>
    /* for remove icon input with type:number */
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    /* for modal quide register / bug fix - no overlay */
    .modal-backdrop {
        display: none;
    }
    .modal-dialog {
        margin-top: -20px;
    }
</style>

<?php if($this->session->flashdata('successful-reg')):?>
    <script>
        $(document).ready(function () {
            $('#modal-reg').modal({
                show: false,
                backdrop: 'static'
            })
            $('#modal-reg').modal('show');
        });
    </script>
<?php endif; ?>
<!-- modal message activation -->
<div id="modal-reg" class="w3-modal bd-example-modal-xll" style="background-color: rgba(0,0,0,0.9)" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center; background-color: #edf0f2">
                <h4 class="modal-title">سامانه آموزکده</h4>
            </div>
            <div class="modal-body" style="padding: 40px; text-align: justify-all">
                <?php
                if ($this->session->flashdata('type_academy') == '0'):
                    $type_academy = '';
                elseif ($this->session->flashdata('type_academy') == '1'):
                    $type_academy = 'فنی و حرفه ای';
                elseif ($this->session->flashdata('type_academy') == '2'):
                    $type_academy = 'کنکور';
                elseif ($this->session->flashdata('type_academy') == '3'):
                    $type_academy = 'زبان';
                elseif ($this->session->flashdata('type_academy') == '4'):
                    $type_academy = 'هنری';
                endif;
                echo ' مدیریت محترم آموزشگاه ' . $type_academy . " " . $this->session->flashdata('academy_name').'، '.$this->session->flashdata('full_name');
                ?>
                <br>
                 اطلاعات شما با موفقیت ثبت شد جهت تکمیل اطلاعات با زدن دکمه ادامه به صفحه احراز هویت منتقل می شوید؛
                <br/>
               در صحفه احراز هویت با وارد کردن کد ملی یک کد 4 رقمی به شماره همراه شما ارسال می شود؛
                <br/>
                در ادامه با وارد کردن کد چهار رقمی وارد پورتال خود می شوید.
                <br><br><br>
                <span class="text-center text-info">با تشکر مدیریت سامانه آموزکده</span>
            </div>
            <div class="modal-footer text-left">
                <a href="<?= base_url('portal');?>"  class="btn btn-info btn-block">ادامه</a>
            </div>
        </div>
    </div>
</div>
<!-- / modal message activation -->

<form id="regForm"  name="user_register" action="<?php echo base_url('insert-new-academy'); ?>" method="post" enctype="multipart/form-data">

    <!-- errors -->
    <?php if ($this->session->flashdata('national-code-msg')): ?>
        <div class="alert bg-accent text-white" role="alert"><?php echo $this->session->flashdata('national-code-msg'); ?></div>
    <?php endif; ?>
    <!-- /errors -->

    <!-- error inputs -->
    <?php if (validation_errors()): ?>
        <div class="card">
            <div class="card-body">
                <div class="alert bg-accent text-white" role="alert">
                    اخطارهای زیر را بررسی کنید!
                </div>
                <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('fname'); ?></div>
                <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('lname'); ?></div>
                <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('national_code'); ?></div>
                <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('phone_num'); ?></div>
                <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('type_academy'); ?></div>
                <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('academy_name'); ?></div>
                <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('reference_code'); ?></div>
                <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('province'); ?></div>
                <div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0"><?php echo form_error('city'); ?></div>

            </div>
        </div>
    <?php endif; ?>
    <!-- /error inputs -->

    <h4 class="box-title">فرم ثبت نام آموزشگاه</h4>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">نام مدیر</label>
                <p><input type="text" id="fname" name="fname" class="form-control" required="" oninvalid="setCustomValidity('لطفا نام را وارد کنید')" onchange="try {
                            setCustomValidity('');
                        } catch (e) {
                        }"> </p>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">نام خانوادگی</label>
                <p><input type="text" id="lname" name="lname" class="form-control" required oninvalid="setCustomValidity('لطفا نام خانوادگی را وارد کنید')" onchange="try {
                            setCustomValidity('');
                        } catch (e) {
                        }"></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">کد ملی</label>
                <p><input type="text" id="national_code" name="national_code" class="form-control" required oninvalid="setCustomValidity('لطفا کد ملی را وارد کنید')" onchange="try {
                            setCustomValidity('');
                        } catch (e) {
                        }"></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">شماره همراه:</label>
                <p><input type="text" id="phone_num" name="phone_num" class="form-control" required oninvalid="setCustomValidity('لطفا شماره همراه خود را وارد کنید')" onchange="try {
                            setCustomValidity('');
                        } catch (e) {
                        }"></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">استان</label>
                <select class="form-control custom-select" id="province_id" name="province" required oninvalid="setCustomValidity('لطفا استان را انتخاب کنید')" onchange="try {
                            setCustomValidity('');
                        } catch (e) {
                        }">
					<option value="0">لطفا انتخاب کنید</option>
                    <?php
                    foreach ($province as $prv) {
                        ?>
                        <option value="<?= $prv->id ?>"><?= $prv->name ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">شهر</label>
                <select class="form-control custom-select" name="city" id="city_id">
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">نوع آموزشگاه</label>
                <select name="type_academy" id="type_academy" class="form-control custom-select">
                    <option value="">لطفا انتخاب کنید</option>
                    <option value="0">مجتمع آموزشی</option>
                    <option value="1">فنی و حرفه ای</option>
                    <option value="2">درسی و کنکور</option>
                    <option value="3">زبان</option>
                    <option value="4">هنر و موسیقی</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">نام آموزشگاه</label>
                <p><input type="text" id="academy_name" name="academy_name" class="form-control" placeholder="آموزکده" required oninvalid="setCustomValidity('لطفا نام آموزشگاه را وارد کنید')" onchange="try {
                            setCustomValidity('');
                        } catch (e) {
                        }"></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">کد معرف</label>
                <p><input type="text" id="reference_code" name="reference_code" class="form-control" placeholder="کد ملی معرفی کننده را وارد کنید" oninvalid="setCustomValidity('لطفا کد معرف را وارد کنید')" onchange="try {
                            setCustomValidity('');
                        } catch (e) {
                        }"></p>
            </div>
        </div>
        <div class="col-md-12">
            <button class="btn btn-success" style="float: left" type="submit">ثبت اطلاعات</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('select[name="province"]').on('change', function () {
            var prv = $(this).val();
            if (prv) {
                $.ajax({
                    url: 'dropdown/city/' + prv,
                    type: "GET",
                    dataType: "json",
                    success: function (states) {
                        $('select[name="city"]').empty();
						$('select[name="city"]').append('<option value="0"> لطفا انتخاب کنید </option>');
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
