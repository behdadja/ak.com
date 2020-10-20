

<div class="bg-gradient-primary border-bottom-white py-32pt">
    <div class="container d-flex flex-column flex-md-row align-items-center text-center text-md-left">
        <img src="<?= base_url('portal/assets/profile-picture/thumb/' . $academy[0]->logo); ?>" width="104" class="mr-md-32pt mb-32pt mb-md-0" alt="academy">
        <div class="flex mb-32pt mb-md-0">
            <h2 class="text-white mb-0"><?= $academy[0]->academy_display_name . ' ' . $academy[0]->academy_name; ?></h2>
            <p class="lead text-white-50 d-flex align-items-center"><?= $academy[0]->number_of_course . ' دوره'; ?></p>
        </div>
        <!--<a href="" class="btn btn-outline-white">ویرایش حساب</a>-->
    </div>
</div>

<div class="navbar navbar-expand-sm navbar-dark-white bg-gradient-primary p-sm-0 ">
    <div class="container page__container">

        <!-- Navbar toggler -->
        <button class="navbar-toggler ml-n16pt" type="button" data-toggle="collapse" data-target="#navbar-submenu2">
            <!--<span class="material-icons">people_outline</span>-->
        </button>

        <div class="collapse navbar-collapse" id="navbar-submenu2">
            <div class="navbar-collapse__content pb-16pt pb-sm-0">
                <ul class="nav navbar-nav">

                    <!--                                <li class="nav-item active">
                                                        <a href="" class="nav-link">داشبورد</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="" class="nav-link">دوره ها</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="" class="nav-link">بحث ها</a>
                                                    </li>-->

                </ul>
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item">
                        <!--<a href="" class="nav-link">مشخصات</a>-->
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- دوره ها -->
<div class="page-section bg-white">
    <div class="container page__container">
        <div class="row align-items-end mb-16pt mb-md-32pt">
            <div class="col-md-auto mb-32pt mb-md-0">
                <div class="page-headline page-headline--title text-center text-md-left p-0">
                    <h2>دوره ها</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            if (!empty($courses)):
                foreach ($courses as $course):
                    if ($course->display_status_in_system == 2) {
                    ?>
                    <div class="col-sm-6 col-md-4 col-lg-3" height="400">
                        <div class="card card--elevated card-course overlay js-overlay mdk-reveal js-mdk-reveal " data-partial-height="40" data-toggle="popover" data-trigger="click">
                            <a href="#" class="js-image" data-position="center">
                                <img src="<?= base_url('portal/assets/course-picture/thumb/' . $course->course_pic); ?>" style="height: 200px" alt="course">
                                <span class="overlay__content">
                                    <span class="overlay__action d-flex flex-column text-center">
                                        <i class="material-icons">play_circle_outline</i>
                                        <small>پیش نمایش دوره</small>
                                    </span>
                                </span>
                            </a>
                            <span class="corner-ribbon corner-ribbon--default-right-top corner-ribbon--shadow bg-accent text-white">جدید</span>
                            <div class="mdk-reveal__content">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex">
                                            <a class="card-title" href="#"><?= $course->lesson_name; ?></a>
                                            <small class="text-black-50 font-weight-bold mb-4pt"><?= $course->first_name . " " . $course->last_name; ?></small>
                                        </div>
                                        <a href="#" class="ml-4pt material-icons text-black-20 card-course__icon-favorite">favorite</a>
                                    </div>
                                    <div class="d-flex">
                                        <div class="rating flex">
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                        </div>
                                        <small class="text-black-50"><?= $course->course_duration . " "; ?>ساعت</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="popoverContainer d-none">
                            <div class="media">
                                <div class="media-left">
                                    <img src="<?= base_url('portal/assets/profile-picture/thumb/' . $course->course_pic); ?>"  style="height: 50px; width: 50px" alt="دوره" class="rounded">
                                </div>
                                <div class="media-body">
                                    <div class="card-title text-body mb-0"><?= $course->lesson_name; ?></div>
                                    <p class="lh-1">
                                        <span class="text-black-50 small">مدرس </span>
                                        <span class="text-black-50 small font-weight-bold"><?= $course->first_name . " " . $course->last_name; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="d-flex align-items-center mb-4pt">
                                        <span class="material-icons icon-16pt text-black-50 mr-4pt">access_time</span>
                                        <p class="flex text-black-50 lh-1 mb-0"><small><?= $course->course_duration . " "; ?>ساعت</small></p>
                                    </div>
                                    <div class="d-flex align-items-center mb-4pt">
                                        <span class="material-icons icon-16pt text-black-50 mr-4pt">play_circle_outline</span>
                                        <p class="flex text-black-50 lh-1 mb-0"><small><?= $course->time_meeting . " "; ?>دقیقه</small></p>
                                    </div>
                                    <div class="d-flex align-items-center mb-4pt">
                                        <span class="fa fa-dollar-sign icon-16pt text-black-50 mr-4pt"></span>
                                        <p class="flex text-black-50 lh-1 mb-0"><small><?= $course->course_tuition . " "; ?>تومان</small></p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="material-icons icon-16pt text-black-50 mr-4pt">assessment</span>
                                        <p class="flex text-black-50 lh-1 mb-0"><small>کد دوره:<?= " " . $course->course_id; ?></small></p>
                                    </div>
                                </div>
                                <div class="col text-right">
                                    <a href="<?= base_url('course-detail/' . $course->academy_id . '/' . $course->course_id); ?>" class="btn btn-primary">ثبت نام</a>
                                </div>
                            </div>

                        </div>

                    </div>
                    <?php }
                endforeach;
                else:?>
            <p class="text-accent">هنوز دوره ای برای این آموزشگاه در سامانه ثبت نشده است.</p>
            <?php endif;?>
        </div>
    </div>
</div>
<!-- / پایان -->

<!-- تماس -->
<div class="border-bottom-2 py-16pt py-sm-24pt py-md-32pt">
    <div class="container page__container">
        <div class="row">
            <div class="col-md-6">
                <h4>تماس با آموزشگاه</h4>
                <p>مدیریت: <?= $academy[0]->m_first_name.' '.$academy[0]->m_last_name; ?></p>
                <p>موبایل: <?= $academy[0]->phone_num ?></p>
                <p>شماره تماس: <?= $academy[0]->tell ?></p>
                <p>آدرس: <?= $academy[0]->address ?></p>
            </div>
            <div class="col-md-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3468.2510585577666!2d52.52491591444674!3d29.625450682036707!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fb212772fa1f23f%3A0xe034e8f2902a6582!2z2KjYsdisIElUINi024zYsdin2LI!5e0!3m2!1sen!2s!4v1582370738375!5m2!1sen!2s" frameborder="0" style="border: #b1b1b1 solid thick;width: 100%;height:220px;border-radius: 10px" allowfullscreen=""></iframe>
                <div class="d-flex align-items-center">
                    <a href="#" class="text-accent fab fa-facebook-square font-size-24pt mr-8pt"></a>
                    <a href="#" class="text-accent fab fa-twitter-square font-size-24pt"></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / پایان -->
