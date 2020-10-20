<!--<link rel="stylesheet" href="assets/css/media.css" type="text/css">-->
<?php //require_once 'jdf.php'; ?>
<body class="fix-header">
<!-- ============================================================== -->
<!-- Preloader -->
<!-- ============================================================== -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
    </svg>
</div>
<!-- ============================================================== -->
<!-- Wrapper -->
<!-- ============================================================== -->
<div id="wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header">
            <div class="top-left-part">
                <!-- Logo -->
                <a class="logo m-l-10" href="<?= base_url('./../'); ?>">
                    <!-- Logo icon image, you can use font-icon also -->
                    <!--This is dark logo icon-->
                    <span class="visible-xs"><i><img src="<?php echo base_url(); ?>./../images/admin_logo.png" height="40" weigth="40" alt="logo"/></i></span><span class="hidden-xs"><img src="<?php echo base_url(); ?>./../images/admin_logo.png" height="40" weigth="40" alt="logo"/>  آموزکده</span>
                    <!--This is light logo icon-->
                    <!--<img src="<?php echo base_url(); ?>./../images/admin_logo.png" alt="home" class="light-logo" />-->
                </a>
            </div>
            <!-- /Logo -->
            <!-- Search input and Toggle icon -->
            <ul class="nav navbar-top-links navbar-left">
                <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>
                <div class="m-t-20 m-l-40">
                    <h4><a style="color: whitesmoke" href="<?= base_url('teacher/profile'); ?>"><i class="ti-home ti-menu m-r-10"></i>خانه</a></h4>
                </div>
            </ul>
            <ul class="nav navbar-top-links navbar-right pull-right">

                <li class="dropdown">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="index.html#"> <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo $this->session->userdata('pic_name'); ?>" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?php echo htmlspecialchars(ucwords($this->session->userdata('name')), ENT_QUOTES); ?></b><span class="caret"></span> </a>
                    <ul class="dropdown-menu dropdown-user animated flipInY">
                        <li>
                            <div class="dw-user-box">
                                <div class="u-img">
                                    <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo $this->session->userdata('pic_name'); ?>" alt="user" />
                                </div>
                                <div class="u-text m-t-40">
                                    <h4><?php echo htmlspecialchars(ucwords($this->session->userdata('full_name')), ENT_QUOTES); ?></h4>
                                </div>
                            </div>
                        </li>
                        <li role="separator" class="divider"></li>

                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>teacher/profile"><i class="mdi mdi-account"></i> <span class="hide-menu">پروفایل شخصی</span></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url('teacher/edit-teacher-profile'); ?>"><i class="icon-note"></i> <span class="hide-menu">ویرایش پروفایل</span></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="" onclick="event.preventDefault();document.getElementById('logged_out').submit();"><i class="fa fa-power-off"></i> خروج</a></li>
                        <form class="" id='logged_out' style="display:hidden" action="<?php echo base_url(); ?>logout" method="post">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                            <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($this->session->userdata('session_id')); ?>">
                            <input type="hidden" name="academy_id" value="<?php echo htmlspecialchars($this->session->userdata('session_id')); ?>">
                        </form>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>

                <!-- /.dropdown -->
            </ul>
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>
    <!-- End Top Navigation -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav slimscrollsidebar">
            <div class="sidebar-head">
                <h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu">منو</span></h3> </div>
            <ul class="nav" id="side-menu">
                <!--                    <li class="user-pro">
                                            <a href="#" class="waves-effect"><img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo $this->session->userdata('pic_name'); ?>" alt="user-img" class="img-circle"> <span class="hide-menu"><?php echo htmlspecialchars(ucwords($this->session->userdata('name')), ENT_QUOTES); ?> <span class="fa arrow"></span></span>
                                            </a>
                                            <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                                                <li><a href="javascript:void(0)"><i class="fa fa-power-off"></i> <span class="hide-menu">خروج</span></a></li>
                                            </ul>
                                        </li>-->

                <li> <a href="<?php echo base_url(); ?>teacher/courses/my-courses" class="waves-effect"><i class="mdi mdi-folder-multiple fa-fw"></i> <span class="hide-menu">دوره های من<span class=""></span><span class="label label-rouded label-info pull-right"></span></span></a>
                    <!--                        <ul class="nav nav-second-level">
                                                    <li><a href="<?php echo base_url(); ?>teacher/courses/my-courses"><i class="fa-fw">1</i> <span class="hide-menu">دوره های من</span></a></li>
                                                </ul>-->
                </li>
                <!--                    <li> <a href="index.html#" class="waves-effect"><i class="mdi mdi-attachment fa-fw"></i> <span class="hide-menu">آموزشی<span class="fa arrow"></span><span class="label label-rouded label-danger pull-right">1</span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url(); ?>teacher/awareness/existing-courses"><i class="fa-fw">1</i> <span class="hide-menu">ارسال مطلب آموزشی</span></a></li>
                        </ul>
                    </li>-->
                <li> <a href="#" class="waves-effect"><i class="mdi mdi-pencil-box fa-fw"></i> <span class="hide-menu">آزمون آنلاین<span class="fa arrow"></span><span class="label label-rouded label-info pull-right"></span></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?php echo base_url(); ?>teacher/exams/sub-question"><i class="fa-fw">1</i> <span class="hide-menu">ثبت سوالات</span></a></li>
                        <li><a href="<?php echo base_url(); ?>teacher/exams/definition"><i class="fa-fw">2</i> <span class="hide-menu">تعریف آزمون</span></a></li>
                        <li><a href="<?php echo base_url(); ?>teacher/exams/my-questions"><i class="fa-fw">3</i> <span class="hide-menu">سوالات من</span></a></li>
                    </ul>
                </li>
                <li> <a href="<?php echo base_url(); ?>teacher/financialem/financial-situation" class="waves-effect"><i class="mdi mdi-cash-multiple fa-fw"></i> <span class="hide-menu">وضعیت مالی<span class="label label-rouded label-info pull-right"></span></span></a>
                </li>
                <!--                <li> <a href="#" class="waves-effect"><i class="mdi mdi-comment-multiple-outline fa-fw"></i> <span class="hide-menu">درخواست مرخصی<span class="fa arrow"></span><span class="label label-rouded label-info pull-right"></span></span></a>-->
                <!--                    <ul class="nav nav-second-level">-->
                <!--                        <li><a href="--><?php //echo base_url(); ?><!--teacher/tickets/leave-ticket"><i class="fa-fw">1</i> <span class="hide-menu">ارسال درخواست</span></a></li>-->
                <!--                        <li><a href="--><?php //echo base_url(); ?><!--teacher/tickets/all-leave-tickets-status"><i class="fa-fw">2</i> <span class="hide-menu">مشاهده وضعیت</span></a></li>-->
                <!--                    </ul>-->
                <!--                </li>-->
                <!--تیکت-->
                <li> <a href="#" class="waves-effect"><i class="mdi mdi-forum fa-fw"></i> <span class="hide-menu">تیکت ها<span class="fa arrow"></span><span class="label label-rouded label-danger pull-right"></span></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-ticket fa-fw"></i> <span class="hide-menu">ارسال تیکت</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li><a href="<?php echo base_url(); ?>teacher/tickets/to-student"><i class="mdi mdi-ticket-account fa-fw"></i> <span class="hide-menu">ارسال به <?php echo $this->session->userdata('studentDName'); ?></span></a></li>
                                <li><a href="<?php echo base_url(); ?>teacher/tickets/to-manager"><i class="mdi mdi-ticket-account fa-fw"></i> <span class="hide-menu">ارسال به مدیریت</span></a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0)" class="waves-effect"><i class="ti-menu fa-fw"></i> <span class="hide-menu">مشاهده تیکت ها</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li> <a href="<?= base_url('teacher/tickets/manager-tickets'); ?>"><i class="mdi mdi-ticket-account fa-fw"></i> <span class="hide-menu">تیکت های مدیریت</span></a></li>
                                <li> <a href="<?= base_url('teacher/tickets/student-tickets'); ?>"><i class="mdi mdi-ticket-account fa-fw"></i> <span class="hide-menu"><?= 'تیکت های ' . $this->session->userdata('studentDName'); ?></span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Left Sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- /.row -->
            <!-- ============================================================== -->
            <!-- Different data widgets -->
            <!-- ============================================================== -->
            <div class="m-t-20 m-l-20">
                <h4><a style="color: darkslateblue" href="<?= base_url('teacher/profile'); ?>"><?php echo $this->session->userdata('academyDName') . " " . $this->session->userdata('academy_name'); ?></a></h4>
            </div>
            <?php if (!empty($yield) && $yield === 'dashboard'): ?>

            <?php if ($this->session->flashdata('success-insert')) { ?>
                <div class="row">
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($this->session->flashdata('success-insert'), ENT_QUOTES); ?>
                    </div>
                </div>
            <?php } ?>

            </ul>
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">صفحه پروفایل</h4>
                </div>
            </div>
            <!-- /.row -->

            <!-- .row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4 m-b-20">
                        <div class="white-box" style="background-color: white">
                            <div class="user-bg" style="margin: auto">
                                <div><img width="100%" alt="user" src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?= $user_info[0]->pic_name ?>"></div>
                                <div class="overlay-box">
                                    <div class="user-content">
                                        <a href="javascript:void(0)"><img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?= $user_info[0]->pic_name ?>" class="thumb-lg img-circle" alt="img"></a>
                                        <h4 class="text-white"><?= $user_info[0]->first_name . ' ' . $user_info[0]->last_name ?></h4>
                                        <h5 class="text-white"></h5>
                                    </div>
                                    <button data-toggle="modal" data-target="#edit-pic" class="btn btn-default"> ویرایش تصویر پروفایل</button>
                                </div>
                            </div>
                            <div class="user-btm-box">
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-purple"><i class=""><?php
                                            if ($financial_situation[0]->final_situation === "1") {
                                                echo "بستانکار";
                                            } elseif ($financial_situation[0]->final_situation === "-1") {
                                                echo "بدهکار";
                                            } else {
                                                echo "تسویه";
                                            }
                                            ?></i></p>
                                    <h3><?= number_format($financial_situation[0]->final_amount); ?></h3>
                                    <a href="<?= base_url(); ?>teacher/financialem/financial-situation"><button type="button" class="btn btn-primary" name="button">جزئیات</button></a>
                                </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-blue"><i class="">دوره های من</i></p>
                                    <h3><?= $count_of_course; ?></h3>
                                    <a href="<?= base_url(); ?>teacher/courses/my-courses"> <button type="button" class="btn btn-info" name="button">مشاهده </button></a>
                                </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <p class="text-danger"><i class="">تیکت جدید</i></p>
                                    <h3><?= $count_of_tickets ?></h3>
                                    <a href="" data-toggle="modal" data-target="#choose_ticket" class="btn btn-danger" name="button">نمایش</a>

                                    <!-- modal choose ticket -->
                                    <div class="modal fade" id="choose_ticket" role="dialog">
                                        <div class="modal-dialog" style="margin-top: 150px">
                                            <div class="modal-content" style="border-radius: 30px 0 30px 0">
                                                <div class="modal-body" style="padding: 30px">
                                                    <div class="m-t-10">
                                                        <a href="<?= base_url('teacher/tickets/manager-tickets'); ?>" class="btn btn-primary btn-block"><h5 style="margin-top: 10px">تیکت های مدیریت</h5></a>
                                                    </div>
                                                    <div class="m-t-20">
                                                        <a href="<?= base_url('teacher/tickets/student-tickets'); ?>" class="btn btn-info btn-block"><h5 style="margin-top: 10px">تیکت های <?= $this->session->userdata('studentDName') ?></h5></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Modal -->
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading text-center">اطلاعیه ها</div>
                                    <div class="panel-body">

                                        <?php if(!empty($announcements) || !empty($announcements_crs)):
                                            if(!empty($announcements)):
                                                foreach($announcements as $item):
                                                    ?>
                                                    <div class="media" style="background-color: #edf1f5">
                                                        <div class="media-left">
                                                            <img src="<?= base_url('assets/profile-picture/thumb/' . $this->session->userdata('logo')); ?>" alt="logo" class="img-circle" style="width:45px">
                                                        </div>
                                                        <div class="media-body">
                                                            <h5 class="media-heading text-info">
                                                                <?= htmlspecialchars($item->title, ENT_QUOTES); ?>
                                                                <?php if($item->receiver == 'std'): ?>
                                                                    <small class="pull-right"><?= 'مربوط به همه '.htmlspecialchars($this->session->userdata('studentDName').' ها', ENT_QUOTES); ?></small>
                                                                <? elseif ($item->receiver == 'all'): ?>
                                                                    <small class="pull-right"><?= 'مربوط به همه '.htmlspecialchars($this->session->userdata('studentDName'), ENT_QUOTES).' ها و '.htmlspecialchars($this->session->userdata('teacherDName').' ها', ENT_QUOTES); ?></small>
                                                                <?php endif; ?>
                                                            </h5>
                                                            <hr>
                                                            <!--                                <h5>عنوان: --><?//= htmlspecialchars($item->title, ENT_QUOTES); ?><!--</h5>-->
                                                            <p><?= htmlspecialchars($item->body, ENT_QUOTES); ?></p>
                                                            <?php if(!empty($item->file_name) || $item->file_name != null):?>
                                                                <span class="pull-right">فایل ضمیمه:  <a href="<?= base_url('./assets/ticket-file/' . $item->file_name); ?>" class="btn btn-primary btn-outline btn-rounded"  alt="file">دانلود</a></span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endforeach;
                                            endif;
                                            if(!empty($announcements_crs)):
                                                foreach($announcements_crs as $crs):
                                                    ?>
                                                    <div class="media" style="background-color: #edf1f5">
                                                        <div class="media-left">
                                                            <img src="<?= base_url('assets/profile-picture/thumb/' . $this->session->userdata('logo')); ?>" alt="logo" class="img-circle" style="width:45px">
                                                        </div>
                                                        <div class="media-body">
                                                            <h5 class="media-heading text-info">
                                                                <?= htmlspecialchars($crs->title, ENT_QUOTES); ?>
                                                                <small class="pull-right"><?= 'مربوط به دوره '.htmlspecialchars($crs->lesson_name, ENT_QUOTES); ?></small>
                                                            </h5>
                                                            <hr>
                                                            <!--                                <h5>عنوان: --><?//= htmlspecialchars($item->title, ENT_QUOTES); ?><!--</h5>-->
                                                            <p><?= htmlspecialchars($crs->body, ENT_QUOTES); ?></p>
                                                            <?php if(!empty($crs->file_name) || $crs->file_name != null):?>
                                                                <span class="pull-right">فایل ضمیمه:  <a href="<?= base_url('./assets/ticket-file/' . $crs->file_name); ?>" class="btn btn-primary btn-outline btn-rounded"  alt="file">دانلود</a></span>
                                                            <?php endif; ?>

                                                        </div>
                                                    </div>
                                                <?php endforeach;
                                            endif;
                                        else:
                                            ?>
                                            <div class="text-center text-danger">اطلاعیه ای ثبت نشده است</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-xs-12" style="margin: auto auto 20px auto">
                        <div class="white-box p-20 m-20" style="background-color: white">
                            <ul class="nav nav-tabs tabs customtab">
                                <li class="tab">
                                    <a href="#my_courses" data-toggle="tab" > <span class="visible-xs"><i class="fa fa-book"></i></span> <span class="hidden-xs">درس های من</span> </a>
                                </li>
                                <li class="tab">
                                    <a href="#profile" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">پروفایل</span> </a>
                                </li>
                                <li class="tab">
                                    <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">تنظیمات</span> </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <?php if ($this->session->flashdata('reply-success')): ?>
                                    <div class="alert alert-success">
                                        <?= $this->session->flashdata('reply-success'); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('update-success')): ?>
                                    <div class="alert alert-success">
                                        <?= $this->session->flashdata('update-success'); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('user-not-exist')): ?>
                                    <div class="alert alert-danger">
                                        <?= $this->session->flashdata('user-not-exist'); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="tab-pane active" id="my_courses">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="white-box">

                                                <h2 class="text-info">دوره های من</h2>
                                                <?php if ($this->session->flashdata('del-exist-lesson')) : ?>
                                                    <div class="alert alert-danger"><?php echo $this->session->flashdata('del-exist-lesson'); ?></div>
                                                <?php endif; ?>
                                                <?php if ($this->session->flashdata('enroll')) : ?>
                                                    <div class="alert alert-success"><?php echo $this->session->flashdata('enroll'); ?></div>
                                                <?php endif; ?>
                                                <!--<table id="example23" class="display nowrap" cellspacing="0" width="100%">-->
                                                <table role="table" class="table table-striped">
                                                    <thead role="rowgroup">
                                                    <tr role="row">
                                                        <th role="columnheader" class="text-center">کد دوره</th>
                                                        <th role="columnheader" class="text-center">نام دوره</th>
                                                        <th role="columnheader" class="text-center">روش برگزاری</th>
                                                        <th role="columnheader" class="text-center">جزئیات</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody role="rowgroup">
                                                    <?php if (!empty($courses)):
                                                    $is_skyroom = TRUE;
                                                    ?>
                                                    <?php foreach ($courses as $course):
                                                    ?>
                                                    <tr role="row">
                                                        <td role="cell" class="text-center"><?php echo htmlspecialchars($course->course_id, ENT_QUOTES) ?></td>
                                                        <td role="cell" class="text-center" >
                                                            <img src="<?php echo base_url(); ?>./assets/course-picture/thumb/<?php echo htmlspecialchars($course->course_pic, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                                                            <?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?></td>
                                                        <td role="cell" class="text-center">
                                                            <?php
                                                            if ($course->type_holding == '0') {?>
                                                                <span class="text-primery">حضوری</span>
                                                            <?php } else {
                                                                if ($is_skyroom == FAlSE){ ?>
                                                                    <span><a class="btn btn-info btn-rounded" href="" onclick="event.preventDefault();document.getElementById('class_online_<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>').submit();"> آنلاین </a></span>
                                                                    <form class="" id='class_online_<?php echo htmlspecialchars($course->course_id); ?>' style="display:none" action="<?php echo base_url(); ?>teacher/test" method="post">
                                                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                    </form>
                                                                <?php } else {
                                                                    $url = $this->base->get_data('courses_employers', 'skyroom_url', array('employee_nc' => $course->course_master, 'course_id' => $course->course_id));
                                                                    if ($url[0]->skyroom_url == NULL) {?>
                                                                        <span><a class="btn btn-danger btn-rounded" href="#" > آنلاین </a></span>
                                                                    <?php } else {
                                                                    ?>
                                                                    <span><a class="btn btn-info btn-rounded" href="<?= $url[0]->skyroom_url ?>" > آنلاین </a></span>
                                                               <?php
                                                                    }
                                                                    }?>

                                                                <!--                                    <span><a class="btn btn-primary btn-rounded" href="" data-toggle="modal" data-target="#course-online_--><?//= $course->course_id ?><!--">آنلاین</a></span>-->
                                                            <?php } ?>

                                                            <!-- modal -->
                                                            <div class="modal fade" id="course-online_<?= $course->course_id; ?>" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header" style="background-color: #edf0f2">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel">لینک کلاس آنلاین شما</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <?php if($course->detail_online !== null):
                                                                                $detail_online = $course->detail_online;
                                                                                $detail_online = json_decode($detail_online);
                                                                                if($detail_online->link_teacher !== 'null'):
                                                                                    if($course->course_status === '1'):?>
                                                                                        <p class="">نام کاربری: <?= $detail_online->user ;?></p>
                                                                                        <p class="">رمز ورود: <?= $detail_online->pass ;?></p>
                                                                                    <?php elseif($course->course_status === '0'):?>
                                                                                        <p class="text-danger">دوره فعالسازی نشده است</p>
                                                                                    <?php else:?>
                                                                                        <p class="text-danger">دوره اتمام یافته است</p>
                                                                                    <?php
                                                                                    endif;
                                                                                else:?>
                                                                                    <p class="text-danger">کلاس آنلاین شما ایجاد نشده است</p>
                                                                                <?php
                                                                                endif;
                                                                            else:?>
                                                                                <p class="text-danger">کلاس آنلاین شما ایجاد نشده است</p>
                                                                            <?php endif;?>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <?php if($course->detail_online !== null):
                                                                                if($detail_online->link_teacher !== 'null'):
                                                                                    if($course->course_status === '1'):?>
                                                                                        <div class="col-md-8">
                                                                                            <a href="<?= $detail_online->link_teacher ?>" class="btn btn-success" style="width: 100%">ورود به کلاس آنلاین</a>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">بستن</button>
                                                                                        </div>
                                                                                    <?php else:?>
                                                                                        <div class="col-md-12">
                                                                                            <button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">بستن</button>
                                                                                        </div>
                                                                                    <?php
                                                                                    endif;
                                                                                else:?>
                                                                                    <div class="col-md-12">
                                                                                        <button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">بستن</button>
                                                                                    </div>
                                                                                <?php
                                                                                endif;
                                                                            else:?>
                                                                                <div class="col-md-12">
                                                                                    <button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">بستن</button>
                                                                                </div>
                                                                            <?php endif;?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td role="cell" class="text-center">
                                                            <a href="" data-toggle="modal" data-target="#details_<?= $course->course_id ?>" >جزئیات</a>
                                                            <div id="details_<?= $course->course_id ?>" class="modal fade">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <div class="col-md-6 col-sm-12 m-b-10" style=" padding:2%;height: 55px; background-color: #d3d9df" >
                                                                                <h5 class="text-center">مدت(ساعت) : <span class="m-l-10"><?php echo htmlspecialchars($course->course_duration, ENT_QUOTES) ?></span></h5>
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-12 m-b-10" style=" padding:2%;height: 55px; background-color: #e6e7e0">
                                                                                <h5 class="text-center">زمان جلسه(دقیقه) : <span class="m-l-10"><?php echo htmlspecialchars($course->time_meeting, ENT_QUOTES)?></span></h5>
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-12 m-b-10" style=" padding:2%;height: 55px; background-color: #d3d9df">
                                                                                <h5 class="text-center">شروع دوره : <span class="m-l-10" ><?php echo htmlspecialchars($course->start_date, ENT_QUOTES) ?></span></h5>
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-12 m-b-10" style=" padding:2%;height:55px;background-color: #e6e7e0">
                                                                                <h5 class="text-center">روز و ساعت برگزاری : <?php if ($course->sat_status === '1'): ?>
                                                                                        <span class='text-info'>شنبه : </span><span><?php echo htmlspecialchars(substr($course->sat_clock, 0, 5), ENT_QUOTES); ?></span>
                                                                                    <?php endif; ?>

                                                                                    <?php if ($course->sun_status === '1'): ?>
                                                                                        <span class='text-info'>یکشنبه : </span><span><?php echo htmlspecialchars(substr($course->sun_clock, 0, 5), ENT_QUOTES); ?></span>
                                                                                    <?php endif; ?>

                                                                                    <?php if ($course->mon_status === '1'): ?>
                                                                                        <span class='text-info'>دوشنبه : </span><span><?php echo htmlspecialchars(substr($course->mon_clock, 0, 5), ENT_QUOTES); ?></span>
                                                                                    <?php endif; ?>

                                                                                    <?php if ($course->tue_status === '1'): ?>
                                                                                        <span class='text-info'>سه شنبه : </span><span><?php echo htmlspecialchars(substr($course->tue_clock, 0, 5), ENT_QUOTES); ?></span>
                                                                                    <?php endif; ?>

                                                                                    <?php if ($course->wed_status === '1'): ?>
                                                                                        <span class='text-info'>چهارشنبه : </span><span><?php echo htmlspecialchars(substr($course->wed_clock, 0, 5), ENT_QUOTES); ?></span>
                                                                                    <?php endif; ?>

                                                                                    <?php if ($course->thu_status === '1'): ?>
                                                                                        <span class='text-info'>پنج شنبه : </span><span><?php echo htmlspecialchars(substr($course->thu_clock, 0, 5), ENT_QUOTES); ?></span>
                                                                                    <?php endif; ?>
                                                                                </h5>
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-12 m-b-10"  style="padding: 2%;height: 55px; background-color: #d3d9df">
                                                                                <h5 class="text-center">کلاس : <span class="m-l-10"><?php
                                                                                        if(!empty($classes)){
                                                                                        foreach ($classes as $class) {
                                                                                            if ($course->class_id === $class->class_id) {
                                                                                                ?>
                                                                                                <lable data-toggle="tooltip" data-original-title="<?php echo $class->class_description ?>">
                                                                                                            <?php echo htmlspecialchars($class->class_name, ENT_QUOTES); ?>
                                                                                                        </lable>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        }
                                                                                        ?></span>
                                                                                </h5>
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-12 m-b-10" style=" padding:2%;height:55px;background-color: #e6e7e0">
                                                                                <h5 class="text-center">نوع : <span class="m-l-10"><?php
                                                                                        if ($course->type_course == 1) {
                                                                                            echo "خصوصی";
                                                                                        } else {
                                                                                            echo "عمومی";
                                                                                        }
                                                                                        ?>
                                                                                                </span></h5>
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-12 m-b-10" style="padding: 2%;height: 55px; background-color: #d3d9df">
                                                                                <h5 class="text-center">تعداد<?php echo $this->session->userdata('studentDName'); ?>:<span class="m-l-10"><?php
                                                                                        $count = 0;
                                                                                        foreach ($count_student_course as $count_std):
                                                                                            if ($count_std->course_id === $course->course_id):
                                                                                                $count++;
                                                                                            endif;
                                                                                        endforeach;
                                                                                        echo htmlspecialchars($count, ENT_QUOTES);
                                                                                        ?></span> </h5>
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-12 m-b-10" style=" padding:2% ;height: 55px; background-color: #e6e7e0">
                                                                                <h5 class="text-center">جلسات : <span class="m-l-10"><?php if ($course->course_status === '1'): ?>
                                                                                            <a href="<?php echo base_url('teacher/courses/list_of_meeting/' . $course->course_id); ?>" class="glyphicon glyphicon-equalizer" ></a>
                                                                                        <?php elseif ($course->course_status === '0'): ?>
                                                                                            <span class="label label-warning">در انتظار</span>
                                                                                        <?php else: ?>
                                                                                            <span class="label label-danger">اتمام دوره</span>
                                                                                        <?php endif; ?></span></h5>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer" id="details">
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </td>
                            <td role="cell" class="text-center">
                                <!--                                --><?php //if ($course->course_status === '1'): ?>
                                <!--                                    <a href="--><?php //echo base_url('teacher/courses/list_of_meeting/' . $course->course_id); ?><!--" class="glyphicon glyphicon-equalizer" ></a>-->
                                <!--                                --><?php //elseif ($course->course_status === '0'): ?>
                                <!--                                    <span class="label label-warning">در انتظار</span>-->
                                <!--                                --><?php //else: ?>
                                <!--                                    <span class="label label-danger">اتمام دوره</span>-->
                                <!--                                --><?php //endif; ?>
                            </td>
                            </tr>
                            <?php
                            endforeach;
                            endif;
                            ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="profile">
                <div class="row m-l-5">
                    <div class="col-md-3 col-sm-6 b-r"> <strong>نام <?= $this->session->userdata('teacherDName'); ?></strong>
                        <br>
                        <p class="text-muted"><?= $user_info[0]->first_name . ' ' . $user_info[0]->last_name ?></p>
                    </div>
                    <div class="col-md-2 col-sm-6 b-r"> <strong>موبایل</strong>
                        <br>
                        <p class="text-muted"><?= $user_info[0]->phone_num ?></p>
                    </div>
                    <div class="col-md-3 col-sm-6 b-r"> <strong>کد ملی</strong>
                        <br>
                        <p class="text-muted"><?= $user_info[0]->national_code ?></p>
                    </div>
                    <div class="col-md-3 col-sm-6 b-r"> <strong>موقعیت</strong>
                        <br>
                        <p class="text-muted"><?= $user_info[0]->province . ' - ' . $user_info[0]->city ?></p>
                    </div>
                </div>
                <hr>
                <h4 class="font-bold m-t-30">دوره های فعال</h4>
                <hr>
                <?php if (!empty($courses)) { ?>
                    <?php foreach ($courses as $key => $course): $percent = mt_rand(0, 100); ?>
                        <h5><?= $course->lesson_name; ?><span class="pull-right"><?php echo $percent . '%'; ?></span></h5>
                        <div class="progress">
                            <div class="progress-bar progress-bar-<?php
                            $color = array('custom', 'primary', 'danger', 'info', 'warning');
                            $rnd = array_rand($color, 2);
                            echo $color[$rnd[0]];
                            ?>" role="progressbar" aria-valuenow="<?= $percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percent . '%'; ?>" > <span class="sr-only">50% Complete</span> </div>
                        </div>
                    <?php endforeach; ?>
                <?php } ?>
            </div>
            <div class="tab-pane" id="settings">
                <form class="form-horizontal form-material" action="<?php echo base_url(); ?>teacher/profile/change-phone-number" method="post">
                    <div class="form-group">
                        <label class="col-md-12">نام کامل</label>
                        <div class="col-md-12">
                            <input type="text" disabled placeholder="<?php echo $user_info[0]->first_name . ' ' . $user_info[0]->last_name ?>" class="form-control form-control-line">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">شماره موبایل</label>
                        <div class="col-md-12">
                            <input type="text" value="<?php echo $user_info[0]->phone_num ?>" name="change_phone" class="form-control form-control-line">
                        </div>
                        <?php if (validation_errors() && form_error('change_phone')): ?>
                            <div class="alert alert-danger">
                                <?php form_error('change_phone'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success">تغییر شماره همراه</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- /.row -->
<?php else: ?>
    <div class="row">
        <!-- col-md-3 -->
        <div class="col-md-12 col-lg-12">
            <div class="panel ">
                <div class="panel-body" style="margin-top:2%">
                    <!-- Start of Content -->
                    <?php
                    if (!empty($yield)) {
                        $this->load->view('yields/' . $yield);
                    } else {
                        $this->load->view('yields/dashboard');
                    }
                    ?>
                    <!-- End of Content -->
                </div>
            </div>
        </div>
        <!-- /col-md-3 -->
    </div>
<?php endif; ?>

<!--row -->
<!-- /.row -->

<!-- ============================================================== -->
<!-- wallet, & manage users widgets -->
<!-- ============================================================== -->
<!-- .row -->

<!-- /.row -->
<!-- ============================================================== -->
<!-- start right sidebar -->
<!-- ============================================================== -->
<div class="right-sidebar">
    <div class="slimscrollright">
        <div class="rpanel-title"> پنل تغییر رنگ <span><i class="ti-close right-side-toggle"></i></span> </div>
        <div class="r-panel-body">
            <ul id="themecolors" class="m-t-20">
                <li><b>نوار کناری روشن</b></li>
                <li><a href="javascript:void(0)" theme="default" class="default-theme">1</a></li>
                <li><a href="javascript:void(0)" theme="green" class="green-theme">2</a></li>
                <li><a href="javascript:void(0)" theme="gray" class="yellow-theme">3</a></li>
                <li><a href="javascript:void(0)" theme="blue" class="blue-theme">4</a></li>
                <li><a href="javascript:void(0)" theme="purple" class="purple-theme">5</a></li>
                <li><a href="javascript:void(0)" theme="megna" class="megna-theme">6</a></li>
                <li><b>نوار کناری تاریک</b></li>
                <br/>
                <li><a href="javascript:void(0)" theme="default-dark" class="default-dark-theme">7</a></li>
                <li><a href="javascript:void(0)" theme="green-dark" class="green-dark-theme">8</a></li>
                <li><a href="javascript:void(0)" theme="gray-dark" class="yellow-dark-theme">9</a></li>
                <li><a href="javascript:void(0)" theme="blue-dark" class="blue-dark-theme working">10</a></li>
                <li><a href="javascript:void(0)" theme="purple-dark" class="purple-dark-theme">11</a></li>
                <li><a href="javascript:void(0)" theme="megna-dark" class="megna-dark-theme">12</a></li>
            </ul>
            <ul class="m-t-20 chatonline">
                <li><b>گزینه گپ</b></li>
                <li>
                    <a href="javascript:void(0)"><img src="/tap/assets/images/users/varun.jpg" alt="user-img" class="img-circle"> <span>نیما لعل زاد <small class="text-success">آنلاین</small></span></a>
                </li>
                <li>
                    <a href="javascript:void(0)"><img src="/tap/assets/images/users/genu.jpg" alt="user-img" class="img-circle"> <span>حامد همایون <small class="text-warning">بیرون رفته</small></span></a>
                </li>
                <li>
                    <a href="javascript:void(0)"><img src="/tap/assets/images/users/ritesh.jpg" alt="user-img" class="img-circle"> <span>میلاد فراهانی <small class="text-danger">مشغول</small></span></a>
                </li>
                <li>
                    <a href="javascript:void(0)"><img src="/tap/assets/images/users/arijit.jpg" alt="user-img" class="img-circle"> <span>محسن چاووشی <small class="text-muted">آفلاین</small></span></a>
                </li>
                <li>
                    <a href="javascript:void(0)"><img src="/tap/assets/images/users/govinda.jpg" alt="user-img" class="img-circle"> <span>مسعود صادقلو <small class="text-success">آنلاین</small></span></a>
                </li>
                <li>
                    <a href="javascript:void(0)"><img src="/tap/assets/images/users/hritik.jpg" alt="user-img" class="img-circle"> <span>مسعود جهانی<small class="text-success">آنلاین</small></span></a>
                </li>
                <li>
                    <a href="javascript:void(0)"><img src="/tap/assets/images/users/john.jpg" alt="user-img" class="img-circle"> <span>مهدی جهانی<small class="text-success">آنلاین</small></span></a>
                </li>
                <li>
                    <a href="javascript:void(0)"><img src="/tap/assets/images/users/pawandeep.jpg" alt="user-img" class="img-circle"> <span>آرمین زارعی <small class="text-success">آنلاین</small></span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- end right sidebar -->
<!-- ============================================================== -->
</div>
<!-- /.container-fluid -->
<footer class="footer text-center">کپی رایت 1398 © همه حقوق برای شرکت یوتاب پارس محفوظ است.</footer>
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<div id="edit-pic" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">ویرایش تصویر پروفایل</h4>
            </div>
            <?php if($this->session->flashdata('upload-msg')): ?>
                <div class="modal-body">
                    <h4 class="text-center text-danger"><?= $this->session->flashdata('upload-msg') ?></h4>
                </div>
            <?php else: ?>
                <form class="form-horizontal" action="<?= base_url('teacher/teacher-update-pic'); ?>" enctype="multipart/form-data" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
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
            <?php endif; ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- end modal -->
<!-- include jQuery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<!-- include BlockUI -->
<script src="http://path/to/your/copy/of/jquery.blockUI.js"></script>
