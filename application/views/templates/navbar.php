

<!-- Header -->

<div id="header" class="mdk-header bg-dark js-mdk-header mb-0" data-effects="waterfall blend-background" data-fixed data-condenses>
    <div class="mdk-header__content">

        <div class="navbar navbar-expand-sm navbar-dark bg-footer pr-0 pr-md-16pt" id="navbar" data-primary >

            <!-- Navbar toggler -->
            <button class="navbar-toggler navbar-toggler-right d-block d-md-none" type="button" data-toggle="sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Brand -->
            <a href="<?php echo base_url('./'); ?>" class="navbar-brand">
                <img class="navbar-brand-icon mr-0 mr-md-8pt" src="<?php echo base_url('images/admin_logo.png'); ?>" width="30">
                <span class="d-none d-md-block">آموزکده</span>
            </a>

            <button class="btn btn-black mr-16pt" data-toggle="modal" data-target="#courses">دوره ها <i class="material-icons">arrow_drop_down</i></button>

            <form class="search-form search-form--black search-form-courses d-none d-md-flex" action="#">
                <input type="text" class="form-control" placeholder="چه چیزی میخواهید یاد بگیرید؟">
                <button class="btn" type="submit" role="button"><i class="material-icons">search</i></button>
            </form>

            <!-- Main Navigation -->

            <ul class="nav navbar-nav ml-auto flex-nowrap" style="white-space: nowrap;">
                <?php if (empty($this->session->userdata('session_id'))) : ?>
                    <li class="ml-16pt nav-item">
                        <a href="<?php echo base_url('portal'); ?>" class="nav-link">
                            <i class="material-icons text-success">lock_open</i>
                            <span class="sr-only">ورود</span>
                        </a>
                    </li>
                <?php else : ?>
                    <li class="col-sm-12 ml-16pt nav-item">
                        <a href="<?php echo base_url('portal'); ?>" class="nav-link">
                            <i class="fa fa-share-square text-success"></i>
                            <span class="sr-only">مدیریت حساب</span>
                        </a>
                    </li>
                    <li class="col-sm-12 ml-16pt nav-item">
                        <a class="nav-link" onclick="event.preventDefault();document.getElementById('logged_out').submit();">
                            <i class="material-icons text-warning">lock</i>
                            <span class="sr-only">خروج</span>
                        </a>
                        <form id='logged_out' style="display:hidden" action="<?php echo base_url('portal/logout'); ?>" method="post">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                            <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($this->session->userdata('session_id')); ?>">
                        </form>
                    </li>
                <?php endif; ?>
            </ul>



            <!-- // END Main Navigation -->

        </div>

    </div>
</div>

<!-- // END Header -->

<!-- Header Layout Content -->

<div class="navbar navbar-expand-sm navbar-mini navbar-dark bg-dark d-none d-sm-flex p-0">
    <div class="container-fluid">

        <!-- Main Navigation -->
        <ul class="nav navbar-nav flex-nowrap">
            <li class="nav-item dropdown">
                <a class="nav-link" href="<?php echo base_url('../') ?>">خانه</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#">دوره های آموزشی</a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">امکانات آموزشی</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">مقالات آموزشی</a>
                    <a class="dropdown-item" href="#">مسیر یادگیری</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="<?= base_url('about-us') ?>">درباره ما</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="<?= base_url('contact-us') ?>">تماس با ما</a>
            </li>
            <!--            <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">ابزارک ها</a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="ui-buttons.html">دکمه ها</a>
                                <a class="dropdown-item" href="ui-charts.html">نمودار ها</a>
                                <a class="dropdown-item" href="ui-avatars.html">آواتار ها</a>
                                <a class="dropdown-item" href="ui-forms.html">فرم ها</a>
                                <a class="dropdown-item" href="ui-loaders.html">لودر ها</a>
                                <a class="dropdown-item" href="ui-tables.html">جداول</a>
                                <a class="dropdown-item" href="ui-cards.html">کارت ها</a>
                                <a class="dropdown-item" href="ui-icons.html">ایکون ها</a>
                                <a class="dropdown-item" href="ui-tabs.html">زبانه ها</a>
                                <a class="dropdown-item" href="ui-alerts.html">هشدار ها</a>
                                <a class="dropdown-item" href="ui-badges.html">نشانه ها</a>
                                <a class="dropdown-item" href="ui-progress.html">پیشرفت</a>
                                <a class="dropdown-item" href="ui-pagination.html">صفحه بندی</a>
                            </div>
                        </li>-->
        </ul>
        <!-- // END Main Navigation -->

    </div>
</div>
<!-- // END Header Layout Content -->


<!-- // END Header Layout -->

<!-- Modal -->
<div class="modal" id="courses" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-i8-plus bg-body pr-0">
                        <div class="py-16pt pl-16pt menu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#courses-development" data-toggle="tab">فنی و حرفه ای</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#courses-design" data-toggle="tab">هنری</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#courses-photography" data-toggle="tab">کنکور و درسی</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#courses-business" data-toggle="tab">زبان</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#courses-business" data-toggle="tab">کسب و کار</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-6 col-i8-plus-auto tab-content">


                        <div id="courses-development" class="tab-pane show active">
                            <div class="row no-gutters">
                                <div class="col-md-6 p-0">
                                    <div class="p-24pt d-flex h-100 flex-column">
                                        <div class="flex">
                                            <h5>دوره ها</h5>
                                            <ul class="nav flex-column mb-24pt">

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">توسعه وب</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">جاوااسکریپت</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">اچ تی ام ال</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">سی اس اس</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">وردپرس</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">پی اچ پی</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">توسعه آی او اس</a>
                                                </li>

                                            </ul>
                                        </div>
                                        <div>
                                            <a href="library.html" class="btn btn-block text-center btn-secondary">کتابخانه</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 p-0">
                                    <div class="p-24pt d-flex h-100 flex-column">
                                        <div class="flex">
                                            <h5>مسیرهای یادگیری</h5>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/angular_40x40.png" alt="زاویه ای" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">زاویه ای</span>
                                                        <span class="text-muted d-flex lh-1">24 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/swift_40x40.png" alt="سوئیفت" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">سوئیفت</span>
                                                        <span class="text-muted d-flex lh-1">22 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/react_40x40.png" alt="واکنش بومی" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">واکنش بومی</span>
                                                        <span class="text-muted d-flex lh-1">18 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/wordpress_40x40.png" alt="وردپرس" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">وردپرس</span>
                                                        <span class="text-muted d-flex lh-1">13 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-24pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/devops_40x40.png" alt="ابزارهای توسعه" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">ابزارهای توسعه</span>
                                                        <span class="text-muted d-flex lh-1">5 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="paths.html" class="btn btn-block text-center btn-outline-secondary">مسیرهای یادگیری</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="courses-design" class="tab-pane">
                            <div class="row no-gutters">
                                <div class="col-md-6 p-0">
                                    <div class="p-24pt d-flex h-100 flex-column">
                                        <div class="flex">
                                            <h5>دوره ها</h5>
                                            <ul class="nav flex-column mb-24pt">

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">تصویر</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">مهارت های طراحی</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">تکنیک های طراحی</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">طرح بندی صفحه</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">پروژه ها</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">ر</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">تایپوگرافی</a>
                                                </li>

                                            </ul>
                                        </div>
                                        <div>
                                            <a href="library.html" class="btn btn-block text-center btn-secondary">کتابخانه</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 p-0">
                                    <div class="p-24pt d-flex h-100 flex-column">
                                        <div class="flex">
                                            <h5>مسیرهای یادگیری</h5>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/angular_40x40.png" alt="زاویه ای" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">زاویه ای</span>
                                                        <span class="text-muted d-flex lh-1">24 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/swift_40x40.png" alt="سوئیفت" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">سوئیفت</span>
                                                        <span class="text-muted d-flex lh-1">22 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/react_40x40.png" alt="واکنش بومی" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">واکنش بومی</span>
                                                        <span class="text-muted d-flex lh-1">18 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/wordpress_40x40.png" alt="وردپرس" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">وردپرس</span>
                                                        <span class="text-muted d-flex lh-1">13 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-24pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/devops_40x40.png" alt="ابزارهای توسعه" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">ابزارهای توسعه</span>
                                                        <span class="text-muted d-flex lh-1">5 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="paths.html" class="btn btn-block text-center btn-outline-secondary">مسیرهای یادگیری</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="courses-photography" class="tab-pane">
                            <div class="row no-gutters">
                                <div class="col-md-6 p-0">
                                    <div class="p-24pt d-flex h-100 flex-column">
                                        <div class="flex">
                                            <h5>دوره ها</h5>
                                            <ul class="nav flex-column mb-24pt">

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">دوربین ها</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">پردازش خام</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">پوشش</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">کامپوزیت</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">پرتره</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">مدیریت عکس</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">روشنایی</a>
                                                </li>

                                            </ul>
                                        </div>
                                        <div>
                                            <a href="library.html" class="btn btn-block text-center btn-secondary">کتابخانه</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 p-0">
                                    <div class="p-24pt d-flex h-100 flex-column">
                                        <div class="flex">
                                            <h5>مسیرهای یادگیری</h5>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/angular_40x40.png" alt="زاویه ای" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">زاویه ای</span>
                                                        <span class="text-muted d-flex lh-1">24 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/swift_40x40.png" alt="سوئیفت" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">سوئیفت</span>
                                                        <span class="text-muted d-flex lh-1">22 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/react_40x40.png" alt="واکنش بومی" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">واکنش بومی</span>
                                                        <span class="text-muted d-flex lh-1">18 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/wordpress_40x40.png" alt="وردپرس" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">وردپرس</span>
                                                        <span class="text-muted d-flex lh-1">13 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-24pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/devops_40x40.png" alt="ابزارهای توسعه" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">ابزارهای توسعه</span>
                                                        <span class="text-muted d-flex lh-1">5 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="paths.html" class="btn btn-block text-center btn-outline-secondary">مسیرهای یادگیری</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="courses-marketing" class="tab-pane">
                            <div class="row no-gutters">
                                <div class="col-md-6 p-0">
                                    <div class="p-24pt d-flex h-100 flex-column">
                                        <div class="flex">
                                            <h5>دوره ها</h5>
                                            <ul class="nav flex-column mb-24pt">

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">کسب و کار کوچک</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">بازاریابی</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">بازاریابی سازمانی</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">بازاریابی محتوا</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">بازاریابی آنلاین</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">بازاریابی رسانه های اجتماعی</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">تبلیغات</a>
                                                </li>

                                            </ul>
                                        </div>
                                        <div>
                                            <a href="library.html" class="btn btn-block text-center btn-secondary">کتابخانه</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 p-0">
                                    <div class="p-24pt d-flex h-100 flex-column">
                                        <div class="flex">
                                            <h5>مسیرهای یادگیری</h5>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/angular_40x40.png" alt="زاویه ای" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">زاویه ای</span>
                                                        <span class="text-muted d-flex lh-1">24 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/swift_40x40.png" alt="سوئیفت" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">سوئیفت</span>
                                                        <span class="text-muted d-flex lh-1">22 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/react_40x40.png" alt="واکنش بومی" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">واکنش بومی</span>
                                                        <span class="text-muted d-flex lh-1">18 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/wordpress_40x40.png" alt="وردپرس" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">وردپرس</span>
                                                        <span class="text-muted d-flex lh-1">13 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-24pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/devops_40x40.png" alt="ابزارهای توسعه" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">ابزارهای توسعه</span>
                                                        <span class="text-muted d-flex lh-1">5 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="paths.html" class="btn btn-block text-center btn-outline-secondary">مسیرهای یادگیری</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="courses-business" class="tab-pane">
                            <div class="row no-gutters">
                                <div class="col-md-6 p-0">
                                    <div class="p-24pt d-flex h-100 flex-column">
                                        <div class="flex">
                                            <h5>دوره ها</h5>
                                            <ul class="nav flex-column mb-24pt">

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">مهارت های کسب و کار</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">بهره وری</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">ارتباطات</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">رهبری</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">مدیریت</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">توسعه حرفه ای</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link px-0" href="library.html">صفحات گسترده</a>
                                                </li>

                                            </ul>
                                        </div>
                                        <div>
                                            <a href="library.html" class="btn btn-block text-center btn-secondary">کتابخانه</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 p-0">
                                    <div class="p-24pt d-flex h-100 flex-column">
                                        <div class="flex">
                                            <h5>مسیرهای یادگیری</h5>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/angular_40x40.png" alt="زاویه ای" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">زاویه ای</span>
                                                        <span class="text-muted d-flex lh-1">24 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/swift_40x40.png" alt="سوئیفت" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">سوئیفت</span>
                                                        <span class="text-muted d-flex lh-1">22 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/react_40x40.png" alt="واکنش بومی" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">واکنش بومی</span>
                                                        <span class="text-muted d-flex lh-1">18 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-16pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/wordpress_40x40.png" alt="وردپرس" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">وردپرس</span>
                                                        <span class="text-muted d-flex lh-1">13 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="mb-24pt">
                                                <a href="path.html" class="media">
                                                    <img src="<?php echo base_url(); ?>assets/images/paths/devops_40x40.png" alt="ابزارهای توسعه" class="media-left rounded">
                                                    <span class="media-body">
                                                        <span class="card-title text-body d-block mb-0">ابزارهای توسعه</span>
                                                        <span class="text-muted d-flex lh-1">5 دوره</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="paths.html" class="btn btn-block text-center btn-outline-secondary">مسیرهای یادگیری</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>

