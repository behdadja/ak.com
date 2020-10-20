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
    /*.modal-dialog {*/
    /*    margin-top: -20px;*/
    /*}*/
</style>

<div class="preloader">
    <div class="sk-double-bounce">
        <div class="sk-child sk-double-bounce1"></div>
        <div class="sk-child sk-double-bounce2"></div>
    </div>
</div>

<!-- Header Layout -->
<div class="mdk-header-layout js-mdk-header-layout">

    <!-- Header Layout Content -->
    <div class="mdk-header-layout__content page-content pb-0">
        <div class="mdk-box bg-dark mdk-box--bg-gradient-primary js-mdk-box mb-0" data-effects="blend-background">
            <div class="mdk-box__content">
                <div class="hero py-64pt text-center text-sm-left">
                    <div class="container">
                        <h1 class="text-white">دوره <?= $course[0]->lesson_name; ?></h1>
                        <br>
                        <h4 class="text-white mb-0"><?= $course[0]->academy_display_name . ' ' . $course[0]->academy_name; ?></h4>

                    </div>
                </div>
            </div>
        </div>

        <div class="navbar navbar-expand-sm navbar-light navbar-submenu navbar-list p-0 m-0 align-items-center">
            <div class="container page__container">
                <ul class="nav navbar-nav flex align-items-sm-center">
                    <li class="nav-item navbar-list__item">
                        <div class="media align-items-center">
                            <span class="media-left mr-16pt">
                                <img src="<?= base_url('portal/assets/course-picture/thumb/' . $course[0]->course_pic) ?>" width="40" height="40" alt="course" class="rounded-circle">
                            </span>
                            <div class="media-body">
                                <a class="card-title m-0" href="#"><?= $course[0]->first_name . " " . $course[0]->last_name; ?></a>
                                <p class="text-black-50 lh-1">مدرس</p>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item navbar-list__item">
                        <i class="material-icons text-muted icon--left">play_circle_outline</i>
                        <?= $course[0]->course_duration . " "; ?>ساعت
                    </li>
                    <li class="nav-item navbar-list__item">
                        <i class="material-icons text-muted icon--left">schedule</i>
                        <?= $course[0]->time_meeting . " "; ?>دقیقه
                    </li>
                    <li class="nav-item ml-sm-auto text-sm-center flex-column navbar-list__item">
                        <div class="rating rating-24">
                            <div class="rating__item"><i class="material-icons">star</i></div>
                            <div class="rating__item"><i class="material-icons">star</i></div>
                            <div class="rating__item"><i class="material-icons">star</i></div>
                            <div class="rating__item"><i class="material-icons">star</i></div>
                            <div class="rating__item"><i class="material-icons">star_border</i></div>
                        </div>
                        <p class="lh-1"><small class="text-muted">20 امتیاز</small></p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-section border-bottom-2 bg-body">
            <div class="container page__container">
                <h4>مشخصات و ویژگی های دوره</h4>
                <div class="card-group card-group--lg-up mb-0">
                    <div class="card col-lg-5 p-0 mb-0 justify-content-center">
                        <li class="card-body flex-0 text-center">
                            <img src="<?= base_url('portal/assets/course-picture/thumb/' . $course[0]->course_pic) ?>" width="250px" height="200px"  alt="course">
                            <br>
                            <br>
                            <a href="" data-toggle='modal' data-target='#reg' class="btn btn-outline-accent mb-8pt">ثبت نام در دوره</a>
                            <!--<p>یک حساب کاربری دارید؟ <a href="">ورود</a></p>-->

                            <?php if ($this->session->flashdata('national-code')): ?>
                                <script>
                                    $(document).ready(function () {
                                        $('#reg').modal('show');
                                    });
                                </script>
                            <?php endif; ?>

                            <!-- Modal insert national_code & phone_num -->
                            <div class="w3-modal" id="reg" style="background-color: rgba(0,0,0,0.8)" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content" style="text-align: center">
                                        <div class="modal-header">
                                            <h4 class="col-12 modal-title text-center">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                                <span>ثبت نام در دوره</span>
                                            </h4>
                                        </div>
                                        <?php if ($course[0]->capacity !== '0' && $course[0]->capacity - $course[0]->count_std == 0) { ?>
                                            <span class="alert alert-danger">ظرفیت پذیرش در دوره تکمیل شده است</span>
                                        <?php } else {
                                            $sessId = $this->session->userdata('session_id');
                                            $userType = $this->session->userdata('user_type');
                                            if($sessId && $userType == 'students'):
                                                ?>
                                                <form id="myform"  method="post" action="<?= base_url('student-authentication') ?>">
                                                    <div class="modal-body">
                                                        <div class="col-lg">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                            <input type="hidden" name='course_id' class="form-control" value="<?= $course[0]->course_id; ?>">
                                                            <input type="hidden" name='academy_id' class="form-control" value="<?= $course[0]->academy_id; ?>">
                                                            <input type="hidden" name='type' class="form-control" value="1">

                                                            <div class="alert alert-secondary" role="alert">
                                                                <span><?= $this->session->userdata('studentDName').'  ' ?><strong><?= $this->session->userdata('full_name').'  ' ?></strong>عزیز؛</span><br><br>
                                                                <span>از ثبت نام در دوره <strong class="text-accent"><?= '  '.$course[0]->lesson_name.'  '; ?></strong> اطمینان دارید؟</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="col-md-6"><button style="width: 100%" type="sybmit" class="btn btn-success">بله</button></div>
                                                        <div class="col-md-6"><button style="width: 100%" type="button" class="btn btn-info" data-dismiss="modal">انصراف</button></div>
                                                    </div>
                                                </form>
                                            <?php else: ?>
                                                <form id="myform"  method="post" action="<?= base_url('student-authentication') ?>">
                                                    <div class="modal-body">
                                                        <div class="col-lg">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                            <input type="hidden" name='course_id' class="form-control" value="<?= $course[0]->course_id; ?>">
                                                            <input type="hidden" name='academy_id' class="form-control" value="<?= $course[0]->academy_id; ?>">

                                                            <?php if($this->session->flashdata('national-code')):?>
                                                                <div class="alert alert-accent" role="alert"><?= $this->session->flashdata('national-code');?></div>
                                                            <? endif; ?>
                                                            <div class="form-group">
                                                                <div class="input-group input-group-merge">
                                                                    <input name="national_code" onKeyPress="if (this.value.length == 10)
                                                        return false;" type="number" class="form-control form-control-prepended" required oninvalid="setCustomValidity('لطفا کد ملی را به صورت عدد ده رقمی وارد کنید')" onchange="try {
                                                                    setCustomValidity('');
                                                                } catch (e) {
                                                                }">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <p class="">کد ملی:</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group input-group-merge">
                                                                    <input name="phone_num" onKeyPress="if (this.value.length == 11)
                                                        return false;" type="number" class="form-control form-control-prepended" required oninvalid="setCustomValidity('لطفا شماره همراه را به صورت عدد یازده رقمی (با صفر) وارد کنید')" onchange="try {
                                                                    setCustomValidity('');
                                                                } catch (e) {
                                                                }">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">
                                                                            <p class="">شماره همراه:</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="col-md-6"><button style="width: 100%" type="sybmit" class="btn btn-success">ثبت نام</button></div>
                                                        <div class="col-md-6"><button style="width: 100%" type="button" class="btn btn-info" data-dismiss="modal">انصراف</button></div>
                                                    </div>
                                                </form>
                                            <?php endif; ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /End modal reg -->
                            <div class="card col-lg-12 p-0 justify-content-center">
                                <ul class="accordion accordion--boxed js-accordion list-group-flush" id="course-toc3">
                                    <li class="accordion__item open">
                                        <a class="accordion__toggle" data-toggle="collapse" data-parent="#course-toc3" href="#course-toc-3">
                                            <span class="flex">هزینه و ظرفیت</span>
                                            <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                                        </a>
                                        <div class="accordion__menu">
                                            <ul class="list-unstyled collapse show" id="course-toc-3">
                                                <li class="accordion__menu-link active">
                                                    <h4 class="flex"> هزینه:   <span class="pull-right" ><?php echo $course[0]->course_tuition . " ";?>تومان</span></h4>

                                                </li>
                                                <li class="accordion__menu-link active">
                                                    <p class="flex">ظرفیت باقی مانده</p>
                                                    <span class="text-muted">
											<?php
                                            if ($course[0]->capacity !== '0') {
                                                if ($course[0]->capacity - $course[0]->count_std === 0) {
                                                    ?>
                                                    <span class="text-accent">تکمیل</span>
                                                <?php } else { ?>
                                                    <span class="text-warning"><?php echo $course[0]->capacity - $course[0]->count_std; ?></span>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <span class="label label-success">نامحدود</span>
                                            <?php } ?>

                                            </ul>
                                        </div>
                                    </li>
                            </div>
                        </li>
                    </div>
                    <div class="card col-lg-7 p-0">
                        <ul class="accordion accordion--boxed js-accordion list-group-flush" id="course-toc">
                            <li class="accordion__item open">
                                <a class="accordion__toggle" data-toggle="collapse" data-parent="#course-toc" href="#course-toc-1">
                                    <span class="flex">بررسی دوره</span>
                                    <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                                </a>
                                <div class="accordion__menu">
                                    <ul class="list-unstyled collapse show" id="course-toc-1">
                                        <li class="accordion__menu-link active">
                                            <p class="flex">مدرس</p>
                                            <span class="text-muted"><?= $course[0]->first_name . " " . $course[0]->last_name; ?></span>
                                        </li>
                                        <li class="accordion__menu-link active">
                                            <p class="flex">مدت زمان دوره</p>
                                            <span class="text-muted"><?= $course[0]->course_duration . " "; ?>ساعت</span>
                                        </li>
                                        <li class="accordion__menu-link active">
                                            <p class="flex">زمان هر جلسه</p>
                                            <span class="text-muted"><?= $course[0]->time_meeting . " "; ?>دقیقه</span>
                                        </li>
                                        <li class="accordion__menu-link active">
                                            <p class="flex">روش برگزاری</p>
                                            <span class="text-muted">
												<?php
                                                if ($course[0]->type_holding == '0') {?>
                                                    <span class="text-info">حضوری</span>
                                                <?php } else {?>
                                                    <span class="text-danger">آنلاین</span>
                                                <?php } ?>
                                        </span>
                                        </li>

                                        <li class="accordion__menu-link active">
                                            <p class="flex">تاریخ شروع</p>
                                            <span class="text-muted"><?= $course[0]->start_date ?></span>
                                        </li>
                                        <li class="accordion__menu-link active">
                                            <p class="flex">روزهای برگزاری</p>
                                            <span class="text-muted">
												<?php if ($course[0]->sat_status === '1'): ?>
                                                    <span class='text-info'>شنبه : </span><span><?php echo htmlspecialchars(substr($course[0]->sat_clock, 0, 5), ENT_QUOTES); ?></span>
                                                <?php endif; ?>

                                                <?php if ($course[0]->sun_status === '1'): ?>
                                                    <span class='text-info'>یکشنبه : </span><span><?php echo htmlspecialchars(substr($course[0]->sun_clock, 0, 5), ENT_QUOTES); ?></span>
                                                <?php endif; ?>

                                                <?php if ($course[0]->mon_status === '1'): ?>
                                                    <span class='text-info'>دوشنبه : </span><span><?php echo htmlspecialchars(substr($course[0]->mon_clock, 0, 5), ENT_QUOTES); ?></span>
                                                <?php endif; ?>

                                                <?php if ($course[0]->tue_status === '1'): ?>
                                                    <span class='text-info'>سه شنبه : </span><span><?php echo htmlspecialchars(substr($course[0]->tue_clock, 0, 5), ENT_QUOTES); ?></span>
                                                <?php endif; ?>

                                                <?php if ($course[0]->wed_status === '1'): ?>
                                                    <span class='text-info'>چهارشنبه : </span><span><?php echo htmlspecialchars(substr($course[0]->wed_clock, 0, 5), ENT_QUOTES); ?></span>
                                                <?php endif; ?>

                                                <?php if ($course[0]->thu_status === '1'): ?>
                                                    <span class='text-info'>پنج شنبه : </span><span><?php echo htmlspecialchars(substr($course[0]->thu_clock, 0, 5), ENT_QUOTES); ?></span>
                                                <?php endif; ?>

                                                <?php if ($course[0]->fri_status === '1'): ?>
                                                    <span class='text-info'>جمعه: </span><span><?php echo htmlspecialchars(substr($course[0]->fri_clock, 0, 5), ENT_QUOTES); ?></span>
                                                <?php endif; ?>
                                        </span>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="accordion__item open">
                                <a class="accordion__toggle" data-toggle="collapse" data-parent="#course-toc" href="#course-toc-2">
                                    <span class="flex">توضیحات دوره <?php echo $course[0]->lesson_name; ?></span>
                                    <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                                </a>
                                <div class="accordion__menu">
                                    <ul class="list-unstyled collapse show" id="course-toc-2">
                                        <li class="accordion__menu-link">
                                            <p class="lead text-black-50 measure-hero-lead" style="text-align:justify;"><?php echo $course[0]->course_description; ?></p>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="reg" class="w3-modal" onclick="this.style.display = 'none'">

        <div class="w3-modal-content w3-animate-zoom">
            <div class="modal-header" style="height: 40px">
                <span class="w3-button w3-hover-red w3-display-topright">&times;</span>
            </div>
            <img id="img01" style="width:100%">
        </div>
    </div>

    <div class="bg-white">
        <div class="pt-32pt pt-lg-64pt pb-16pt pb-lg-32pt">
            <div class="container page__container">
                <h4>بازخورد دانشجو</h4>
                <div class="row">
                    <div class="col-md-3 mb-32pt mb-md-0">
                        <div class="display-1">4.7</div>
                        <div class="rating rating-32">
                            <span class="rating__item"><span class="material-icons">star</span></span>
                            <span class="rating__item"><span class="material-icons">star</span></span>
                            <span class="rating__item"><span class="material-icons">star</span></span>
                            <span class="rating__item"><span class="material-icons">star</span></span>
                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                        </div>
                        <p class="text-muted">20 امتیاز</p>
                    </div>
                    <div class="col-md-9">

                        <div class="row align-items-center mb-8pt">
                            <div class="col-md-9 col-sm-6">
                                <div class="progress">
                                    <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="75" style="width: 75%" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 d-none d-sm-flex align-items-center">
                                <div class="rating rating-24 mr-8pt">
                                    <span class="rating__item"><span class="material-icons">star</span></span>
                                    <span class="rating__item"><span class="material-icons">star</span></span>
                                    <span class="rating__item"><span class="material-icons">star</span></span>
                                    <span class="rating__item"><span class="material-icons">star</span></span>
                                    <span class="rating__item"><span class="material-icons">star</span></span>
                                </div>
                                <span class="text-muted">75%</span>
                                <span class="material-icons icon-16pt ml-8pt">close</span>
                            </div>
                        </div>
                        <div class="row align-items-center mb-8pt">
                            <div class="col-md-9 col-sm-6">
                                <div class="progress">
                                    <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="16" style="width: 16%" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 d-none d-sm-flex align-items-center">
                                <div class="rating rating-24 mr-8pt">
                                    <span class="rating__item"><span class="material-icons">star</span></span>
                                    <span class="rating__item"><span class="material-icons">star</span></span>
                                    <span class="rating__item"><span class="material-icons">star</span></span>
                                    <span class="rating__item"><span class="material-icons">star</span></span>
                                    <span class="rating__item"><span class="material-icons">star_border</span></span>
                                </div>
                                <p class="text-muted">16%</p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-8pt">
                            <div class="col-md-9 col-sm-6">
                                <div class="progress">
                                    <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="12" style="width: 12%" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 d-none d-sm-flex align-items-center">
                                <div class="rating rating-24 mr-8pt">
                                    <span class="rating__item"><span class="material-icons">star</span></span>
                                    <span class="rating__item"><span class="material-icons">star</span></span>
                                    <span class="rating__item"><span class="material-icons">star</span></span>
                                    <span class="rating__item"><span class="material-icons">star_border</span></span>
                                    <span class="rating__item"><span class="material-icons">star_border</span></span>
                                </div>
                                <p class="text-muted">12%</p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-8pt">
                            <div class="col-md-9 col-sm-6">
                                <div class="progress">
                                    <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="9" style="width: 9%" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 d-none d-sm-flex align-items-center">
                                <div class="rating rating-24 mr-8pt">
                                    <span class="rating__item"><span class="material-icons">star</span></span>
                                    <span class="rating__item"><span class="material-icons">star</span></span>
                                    <span class="rating__item"><span class="material-icons">star_border</span></span>
                                    <span class="rating__item"><span class="material-icons">star_border</span></span>
                                    <span class="rating__item"><span class="material-icons">star_border</span></span>
                                </div>
                                <p class="text-muted">9%</p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-8pt">
                            <div class="col-md-9 col-sm-6">
                                <div class="progress">
                                    <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 d-none d-sm-flex align-items-center">
                                <div class="rating rating-24 mr-8pt">
                                    <span class="rating__item"><span class="material-icons">star</span></span>
                                    <span class="rating__item"><span class="material-icons">star_border</span></span>
                                    <span class="rating__item"><span class="material-icons">star_border</span></span>
                                    <span class="rating__item"><span class="material-icons">star_border</span></span>
                                    <span class="rating__item"><span class="material-icons">star_border</span></span>
                                </div>
                                <p class="text-muted">0%</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-section bg-gradient-purple border-top-2">
        <div class="container page__container p-0-xs">
            <div class="row col-lg-9 mx-auto">
                <div class="col-sm-6 text-center d-flex flex-column justify-content-center">
                    <h4 class="text-white mb-8pt">باز کردن کتابخانه</h4>
                    <p class="text-white-70 mb-24pt mb-sm-0">دسترسی به جزوه ها، کتاب ها، مقالات و مطالب علمی اساتید و کارشناسان کلیه آموزشگاه ها</p>
                </div>
                <div class="col-sm-6 d-flex flex-column align-items-center justify-content-center">
                    <!--                        <a href="" class="btn btn-outline-white mb-8pt">برای همه دوره ها را تماشا کنید تومان9/ماه</a>-->
                    <p class="text-white-70 mb-0">یک حساب کاربری دارید؟ <a href="<?= base_url('portal'); ?>" class="text-white text-underline">ورود</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- // END Header Layout Content -->
</div>
<!-- // END Header Layout -->


<!-- Modal insert otp code -->
<?php if ($this->session->flashdata('authentication') || $this->session->flashdata('error-otp')): ?>
    <script>
        $(document).ready(function () {
            $('#Auth').modal({
                show: false,
                backdrop: 'static'
            });
            $('#Auth').modal('show');
        });
    </script>
    <div class="w3-modal" id="Auth" style="background-color: rgba(0,0,0,0.8)" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="text-align: center">
                <div class="modal-header">
                    <h4 class="col-12 modal-title text-center">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        <span>احراز هویت</span>
                    </h4>
                </div>
                <form action="<?= base_url('user-authentication');?>" method="post">
                    <div class="modal-body">

                        <?php if($this->session->flashdata('error-otp')):?>
                            <div class="alert alert-accent" role="alert"><?= $this->session->flashdata('error-otp');?></div>
                        <? endif; ?>

                        <p>کد ارسال شده به شماره همراه خود را وارد کنید:</p>
                        <div class="col-lg">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                            <div class="was-validated">
                                <div class="form-group">
                                    <div class="input-group input-group-merge">
                                        <input name="user_otp" onKeyPress="if (this.value.length == 4) return false;"  min="1000" max="9999" type="number" class="form-control form-control-prepended is-valid" required oninvalid="setCustomValidity('لطفا کد را وارد کنید')" onchange="try { setCustomValidity(''); } catch (e) { }">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <p>کداحراز هویت:</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin: 15px" id="myTimer"></div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-6"><button style="width: 100%" type="sybmit" class="btn btn-success">ثبت نام</button></div>
                        <div class="col-md-6"><button style="width: 100%" id="myBtn" disabled class="btn btn-info" onclick="document.getElementById('resend').submit();">ارسال مجدد کد</button></div>
                    </div>
                </form>
                <form id='resend' style="display:none" action="<?php echo base_url('resend-otp'); ?>" method="post">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input type="hidden" name="national_code" value="<?php echo $this->session->userdata('user_nc'); ?>">
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- / End modal -->

<!-- modal for pre registered and not exist phone number -->
<?php if ($this->session->flashdata('pre-registered')): ?>
    <script>
        $(document).ready(function () {
            $('#pre-registered').modal('show');
        });
    </script>
    <!-- Modal reg course -->
    <div class="w3-modal" id="pre-registered" style="background-color: rgba(0,0,0,0.8)" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="text-align: center">
                <div class="modal-header">
                    <h4 class="col-12 modal-title text-center">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        <span>وضعیت ثبت نام</span>
                    </h4>
                </div>
                <?php if($this->session->flashdata('notExistPhoneNum')): ?>
                    <div class="modal-body">
                        <div class="card border-left-4 border-left-accent card-sm mb-lg-32pt">
                            <div class="card-body pl-16pt">
                                <div class="media flex-wrap align-items-center">
                                    <div class="media-body text-accent" style="min-width: 180px">
                                        <span>شماره ای که در زیر مشاهده می کنید قبلا برای کد ملی شما ثبت شده است:</span><br>
                                        <span dir="ltr"><?= $this->session->flashdata('notExistPhoneNum'); ?></span><br>
                                        <span>این شماره با شماره همراهی که وارد کردید مطابقت ندارد لطفا یا از شماره قبل استفاده کنید و یا از طریق پشتیبانی برای تغییر شماره اقدام فرمایید</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--										<span>جهت مشاهده وضعیت دوره ثبت نامی دکمه ورود به پروفایل را انتخاب کنید.</span>-->
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-6"><button data-toggle="modal" data-target="#reg" style="width: 100%" type="button" class="btn btn-success" data-dismiss="modal">دوباره امتحان می کنم</button></div>
                        <div class="col-md-6"><button style="width: 100%" type="button" class="btn btn-info" data-dismiss="modal">انصراف</button></div>
                    </div>
                <?php else: ?>
                    <div class="modal-body">
                        <div class="card border-left-4 border-left-accent card-sm mb-lg-32pt">
                            <div class="card-body pl-16pt">
                                <div class="media flex-wrap align-items-center">
                                    <div class="media-body text-accent" style="min-width: 180px">
                                        <?= $this->session->flashdata('pre-registered'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span>جهت مشاهده وضعیت دوره ثبت نامی دکمه ورود به پروفایل را انتخاب کنید.</span>
                    </div>
                    <div class="modal-footer">
                        <a style="width: 100%" href="<?= base_url('portal/profile'); ?>" class="btn btn-info">ورود به پروفایل</a>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- / End modal -->


<!-- modal for get user information -->
<?php if ($this->session->flashdata('get-user-information') || $this->session->flashdata('error-user-information')): ?>
    <script>
        $(document).ready(function () {
            $('#get-user-information').modal({
                show: false,
                backdrop: 'static'
            });
            $('#get-user-information').modal('show');
        });
    </script>

    <div class="w3-modal bd-example-modal-lg" id="get-user-information" style="background-color: rgba(0,0,0,0.8)" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h4 class="col-12 modal-title text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <span>فرم ثبت نام</span>
                    </h4>
                </div>
                <form class="form-horizontal" action="<?= base_url('course-registration'); ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

                        <?php if($this->session->flashdata('error-user-information')):?>
                            <div class="alert alert-accent" role="alert"><?= $this->session->flashdata('error-user-information');?></div>
                        <? endif; ?>

                        <div class="was-validated">
                            <div class="form-row">
                                <div class="col-12 col-md-6 mb-3">
                                    <input type="text" name="first_name" class="form-control" id="validationSample01" placeholder="نام" required oninvalid="setCustomValidity('لطفا نام را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <input type="text" name="last_name" class="form-control" id="validationSample02" placeholder="نام خانوادگی" required oninvalid="setCustomValidity('لطفا نام خانوادگی را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                </div>
                            </div>
                        </div>
                        <div class="was-validated">
                            <div class="form-row">
                                <div class="col-12 col-md-6 mb-3">
                                    <input type="text" name="father_name" class="form-control" id="validationSample01" placeholder="نام پدر" required oninvalid="setCustomValidity('لطفا نام پدر را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <input type="text" name="birthday" class="auto-close-example form-control" id="validationSample02" placeholder="تاریخ تولد" required oninvalid="setCustomValidity('لطفا تاریخ تولد را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }" onkeyup="
                                                                var date = this.value;
                                                                if (date.match(/^\d{4}$/) !== null) {
                                                                    this.value = date + '-';
                                                                } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                                    this.value = date + '-';
                                                                }" maxlength="10">
                                </div>
                            </div>
                        </div>
                        <div class="was-validated">
                            <div class="form-row">
                                <div class="col-12 col-md-6 mb-3">
                                    <input name="national_code" onKeyPress="if (this.value.length == 10)
                                                            return false;"  readonly type="number" value="<?= $this->session->userdata('data')['user_nc']; ?>" class="form-control form-control-prepended is-valid" required>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <input name="phone_num" onKeyPress="if (this.value.length == 11)
                                                            return false;" readonly type="number" value="<?= $this->session->userdata('data')['phone_num']; ?>" class="form-control form-control-prepended is-valid" required >
                                </div>
                            </div>
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
<?php endif; ?>
<!-- / End modal -->

<!-- modal for registration completed -->
<?php if ($this->session->flashdata('registration-completed')): ?>
    <script>
        $(document).ready(function () {
            $('#registration-completed').modal('show');
        });
    </script>
    <div class="w3-modal" id="registration-completed" style="background-color: rgba(0,0,0,0.8)" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="text-align: center">
                <div class="modal-header">
                    <h4 class="col-12 modal-title text-center">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        <span>وضعیت ثبت نام</span>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="card border-left-4 border-left-accent card-sm mb-lg-32pt">
                        <div class="card-body pl-16pt">
                            <div class="media flex-wrap align-items-center">
                                <div class="media-body text-accent" style="min-width: 180px">
                                    <?= $this->session->flashdata('registration-completed'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span>جهت مشاهده وضعیت دوره ثبت نامی دکمه ورود به پروفایل را انتخاب کنید.</span>
                </div>
                <div class="modal-footer">
                    <a style="width: 100%" href="<?= base_url('portal/profile'); ?>" class="btn btn-info">ورود به پروفایل</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- / End modal -->

