

<?php if ($this->session->flashdata('sms-msg')): ?>
<div class="col-md-2 text-center pull-right"><button style="width: 100%" class="btn btn-rounded btn-danger" href="#" data-toggle="modal" data-target="#sms-msg">پیام آموزکده به شما</button></div>
<div class="col-md-10"></div>
    <script>
        $(document).ready(function () {
            $('#sms-msg').modal('show');
        });
    </script>
<?php endif; ?>

<!-- modal message activation -->
<div id="sms-msg" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center" style="background-color: #edf0f2">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">سامانه آموزکده</h4>
            </div>
            <div class="modal-body" style="padding: 40px;">
                    <?php
                    if ($userInfo[0]->gender === '1'):
                        echo 'جناب آقای ' . $this->session->userdata('full_name');
                    else:
                        echo 'سرکار خانم ' . $this->session->userdata('full_name');
                    endif;
                    ?><br>
                    <?= ' مدیریت محترم ' . $userInfo[0]->academy_display_name . " " . $userInfo[0]->academy_name; ?>
                    <br>
                   <span> اطلاعات شما جهت بررسی به واحد امور مشترکین ارسال گردید نتیجه به زودی به اطلاع شما خواهد رسید.</span>
                    <br><br><br>
                    <span class="pull-right text-success">با تشکر مدیریت سامانه آموزکده</span>
            </div>
            <div class="modal-footer text-center">
                <button class="btn btn-info" data-dismiss="modal" style="width: 100%">بستن</button>
            </div>
        </div>
    </div>
</div>
<!-- / modal message activation -->

<!-- success update -->
<?php if ($this->session->flashdata('success-update')) : ?>
                    <!--<div class="alert alert-info text-center"><?php echo $this->session->flashdata('success-update'); ?></div>-->
<?php endif; ?>
<!-- /success update -->


<div class="col-md-12">
    <div class="bg-image"><img alt="user" src="<?php echo base_url('../images/admin_logo.png'); ?>"></div>
    <div class="bg-text">
        <div style="float: right">
            <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?= $userInfo[0]->logo; ?>" alt="user-img" width="36" class="bg img-circle">
            <b class="b"><?= $userInfo[0]->academy_display_name . " " . $userInfo[0]->academy_name ?></b>
        </div>
        <div style="float: left">
            <b class="b"><?= $this->session->userdata('full_name') ?></b>
            <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?= $userInfo[0]->manage_pic; ?>" alt="user-img" width="36" class="bg img-circle">
        </div>
    </div>
</div>

<section class="m-t-20">
    <div class="sttabs tabs-style-flip">
        <nav>
            <ul>
                <li><a href="#manage" class="sticon fa fa-user"><span>مشخصات مدیر</span></a></li>
                <li><a href="#academy" class="sticon fa fa-institution"><span>اطلاعات آموزشگاه</span></a></li>
                <li><a href="#address" class="sticon fa fa-fax"><span>آدرس و شماره تماس</span></a></li>
                <li><a href="#detail" class="sticon fa fa-folder-open"><span>مدارک</span></a></li>
            </ul>
        </nav>
        <div class="content-wrap" style="height: 500px">
            <section id="manage">
                <div class="col-lg-4 col-sm-6 box">
                    <div>
                        <b class="text-muted">نام مدیر:  </b>
                        <b><?= $this->session->userdata('full_name') ?></b>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 box">
                    <div>
                        <b class="text-muted">موبایل:  </b>
                        <b><?= $userInfo[0]->phone_num; ?></b>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 box">
                    <div>
                        <b class="text-muted m-b-10">کد ملی:  </b>
                        <b><?= $userInfo[0]->national_code; ?></b>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 box">
                    <div style="direction: rtl; ">
                        <b class="text-muted">تاریخ تولد:  </b>
                        <input style="width:80px" class="input" value="<?= $userInfo[0]->birthday; ?>" readonly>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 box">
                    <div> 
                        <b class="text-muted">جنسیت:  </b>
                        <b><?php
                            if ($userInfo[0]->gender === '0') {
                                echo 'زن';
                            } elseif ($userInfo[0]->gender === '1') {
                                echo 'مرد';
                            }
                            ?></b>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 box">
                    <div>
                        <b class="text-muted">وضعیت تاهل:  </b>
                        <b><?php
                            if ($userInfo[0]->marital_status === '0') {
                                echo 'مجرد';
                            } elseif ($userInfo[0]->marital_status === '1') {
                                echo 'متاهل';
                            }
                            ?></b>
                    </div>
                </div>
            </section>
            <section id="academy">
                <div class="col-lg-4 col-sm-6 box">
                    <div>
                        <b class="text-muted">نام آموزشگاه:  </b>
                        <b><?= $userInfo[0]->academy_display_name . ' ' . $userInfo[0]->academy_name; ?></b>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 box">
                    <div>
                        <b class="text-muted">نام لاتین:  </b>
                        <b><?= $userInfo[0]->academy_name_en; ?></b>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 box">
                    <div>
                        <b class="text-muted">نوع آموزشگاه:  </b>
                        <b><?php
                            if ($userInfo[0]->type_academy === '0') {
                                echo 'فنی و حرفه ای';
                            } elseif ($userInfo[0]->type_academy === '1') {
                                echo 'مجتمع آموزشی';
                            } elseif ($userInfo[0]->type_academy === '2') {
                                echo 'درسی و کنکور';
                            } elseif ($userInfo[0]->type_academy === '3') {
                                echo 'زبان';
                            } elseif ($userInfo[0]->type_academy === '4') {
                                echo 'هنر و موسیقی';
                            }
                            ?></b>
                    </div>
                </div>                             
                <div class="col-lg-4 col-sm-6 box">
                    <div>
                        <b class="text-muted">لقب آموزش دهنده:  </b>
                        <b><?= $userInfo[0]->teacher_display_name; ?></b>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 box">
                    <div>
                        <b class="text-muted">لقب آموزش پذیر:  </b>
                        <b><?= $userInfo[0]->student_display_name; ?></b>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 box">
                    <div>
                        <b class="text-muted">لقب دوم آموزش پذیر:  </b>
                        <b><?= $userInfo[0]->student_display_name_2; ?></b>
                    </div>
                </div>
            </section>
            <section id="address">
                <div class="col-lg-6 col-sm-6 box">
                    <div>
                        <b class="text-muted">تلفن ثابت:  </b>
                        <b><?= $userInfo[0]->tell; ?></b>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 box">
                    <div>
                        <b class="text-muted">شماره همراه:  </b>
                        <b><?= $userInfo[0]->phone_num; ?></b>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 box">
                    <div>
                        <b class="text-muted">ایمیل:  </b>
                        <b><?= $userInfo[0]->email; ?></b>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 box">
                    <div>
                        <b class="text-muted">سایت:  </b>
                        <b><?= $userInfo[0]->site; ?></b>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 box">
                    <div>
                        <b class="text-muted">استان:  </b>
                        <b><?= $province[0]->name; ?></b>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 box">
					<div>
						<b class="text-muted">شهر:  </b>
						<b><?= $city[0]->name; ?></b>
					</div>
                </div>
                <div class="col-lg-8 col-sm-6 box">
                    <div>
                        <b class="text-muted">آدرس:  </b>
                        <b><?= $userInfo[0]->address; ?></b>
                    </div>
                </div>
            </section>
            <section id="detail">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <div class="white-box text-center">
                        <h3  class="m-t-20 m-b-20">مجوز آموزشگاه</h3>
                    </div>
                    <?php if ($userInfo[0]->national_card_image !== ''): ?>
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-6"> <img style="max-height: 200px" class="img-responsive" alt="user" src="<?php echo base_url(); ?>./assets/documents/thumb/<?= $userInfo[0]->national_card_image; ?>"></div>
                    <?php else: ?>
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-6 text-danger">تصویر مجوز آموزشگاه بارگزاری نشده است</div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <div class="white-box text-center">
                        <h3 class="m-t-20 m-b-20">کارت ملی مدیر</h3>
                    </div>
                    <?php if ($userInfo[0]->license_image !== ''): ?>
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-6"> <img style="max-height: 200px" class="img-responsive" alt="user" src="<?php echo base_url(); ?>./assets/documents/thumb/<?= $userInfo[0]->license_image; ?>"></div>
                    <?php else: ?>
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-6 text-danger">تصویر کارت ملی بارگزاری نشده است</div>
                    <?php endif; ?>

                </div>
                <div class="col-md-2"></div>
            </section>
        </div>
        <!-- /content -->
    </div>
    <!-- /tabs -->
</section>
