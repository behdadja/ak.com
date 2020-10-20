<style>
    .clickable:hover {
        background-color: #e5e5e5;
        cursor: pointer;
    }
</style>
<!--<style type="text/css">-->
<!--	.sammy-nowrap-2 {-->
<!--		max-width: 200px;-->
<!--		/*padding: 0.4em;*/-->
<!--		/*margin-bottom: 0.4em;*/-->
<!--		white-space: nowrap;-->
<!--		overflow: hidden;-->
<!--		text-overflow: ellipsis;-->
<!--	}-->
<!--	.sammy-nowrap-2 :hover {-->
<!--		overflow:visible;-->
<!--	}-->
<!---->
<!--</style>-->
<!--<link href="assets/css/main.css" rel="stylesheet">-->
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
                <!-- Header -->
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo m-l-10" href="<?= base_url('./../'); ?>">
                        <!-- Logo icon image, you can use font-icon also -->
                        <!--This is dark logo icon-->
                        <span class="visible-xs"><i><img src="<?php echo base_url(); ?>../images/admin_logo.png" height="40" weigth="40" alt="logo"/></i></span><span class="hidden-xs"><img src="<?php echo base_url(); ?>../images/admin_logo.png" height="40" weigth="40" alt="logo"/>  آموزکده</span>
                        <!--This is light logo icon-->
                        <!--<img src="<?php echo base_url(); ?>./../images/admin_logo.png" alt="home" class="light-logo" />-->
                    </a>
                </div>
                <!-- /Logo -->
                <!-- Search input and Toggle icon -->
                <ul class="nav navbar-top-links navbar-left">
                    <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>
                    <?php if ($this->session->userdata('status') !== '0'): ?>
<!--                        <div class="sammy-nowrap-2" class="m-t-20 m-l-40">-->
<!--                            <h4><a style="color: whitesmoke" href="--><?//= base_url('profile'); ?><!--"><i class="ti-home ti-menu m-r-10"></i>--><?php //echo $this->session->userdata('academyDName') . " " . $this->session->userdata('academy_name'); ?><!--</a></h4>-->
<!--                        </div>-->
					<div class="m-t-20 m-l-40">
						<h4><a style="color: whitesmoke" href="<?= base_url('profile'); ?>" ><i  class="ti-home m-r-10"></i>خانه</a></h4>
					</div>
                    <?php endif; ?>
                </ul>
                <!-- / Header -->
                <?php if ($this->session->userdata('status') !== '0'): ?>
                    <div class="col-sm-2 pull-right">
                        <ul class="nav navbar-top-links navbar-right pull-right">

                            <li class="dropdown">
                                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="<?= base_url(); ?>"> <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo $this->session->userdata('manage_pic'); ?>" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?php echo htmlspecialchars(ucwords($this->session->userdata('name')), ENT_QUOTES); ?></b><span class="caret"></span> </a>
                                <ul class="dropdown-menu dropdown-user animated flipInY">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo $this->session->userdata('manage_pic'); ?>" alt="user" /></div>
                                            <div class="u-text text-center">
                                                <h5 style="padding-top : 20%"><?php echo ucwords($this->session->userdata('full_name')); ?></h5>
                                            </div>
										</div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?= base_url('profile'); ?>"><i class="ti-settings"></i> مدیریت</a></li>
                                    <li><a href="<?= base_url('profile/user-profile'); ?>"><i class="icon-user"></i> پروفایل</a></li>
                                    <li><a href="<?= base_url('edit-profile'); ?>"><i class="icon-note"></i> ویرایش پروفایل</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?= base_url('../'); ?>"><i class="ti-home"></i> آموزکده</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="" onclick="event.preventDefault();document.getElementById('logged_out').submit();"><i class="fa fa-power-off"></i> خروج</a></li>
                                    <form class="" id='logged_out' style="display:hidden" action="<?php echo base_url(); ?>logout" method="post">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                        <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($this->session->userdata('session_id')); ?>">
                                    </form>
                                </ul>
                                <!-- /.dropdown-user -->
                            </li>
                            <!-- /.dropdown -->
                        </ul>

                <?php else: ?>
                    <div class="col-sm-1 m-t-20 pull-right">
                        <a href="" class="text-white" onclick="event.preventDefault();document.getElementById('logged_out').submit();"><i class="fa fa-power-off text-danger"></i> خروج</a>
                        <form class="" id='logged_out' style="display: hidden" action="<?php echo base_url(); ?>logout" method="post">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                            <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($this->session->userdata('session_id')); ?>">
                        </form>
                    </div>
					<div class="col-sm-1 m-t-20 pull-right">
						<a href="<?= base_url('edit-profile') ?>" class="text-white"><i class="fa fa-pen text-success"></i> ویرایش</a>
					</div>
                <?php endif; ?>
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
                    <h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu">منو</span></h3>
                </div>
                <?php if ($this->session->userdata('status') !== '0'): ?>
                    <ul class="nav" id="side-menu">
                        <li> <a href="#" class="waves-effect"><i class="mdi mdi-school fa-fw"></i> <span class="hide-menu">بخش آموزش<span class="fa arrow"></span> <span class="label label-rouded label-info pull-right">3</span> </span></a>
                            <ul  class="nav nav-second-level collapse" aria-expanded="true" style="">
                                <li><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-presentation fa-fw"></i> <span class="hide-menu">کلاس ها</span><span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li> <a href="<?php echo base_url(); ?>training/create-new-class-page"><i class="icon-plus fa-fw"></i> <span class="hide-menu">ایجاد کلاس جدید</span></a></li>
                                        <li> <a href="<?php echo base_url(); ?>training/manage-classes"><i class="ti-menu fa-fw"></i> <span class="hide-menu">مدیریت کلاس ها</span></a></li>
<!--										<li><a href="--><?php //echo base_url(); ?><!--online_classes" class="waves-effect"><i class="glyphicon glyphicon-edit fa-fw"></i> <span class="hide-menu">کلاس های در حال اجرا</span></a></li>-->
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-book-open-page-variant fa-fw"></i> <span class="hide-menu">درس ها</span><span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li> <a href="<?php echo base_url('new-lesson'); ?>"><i class="icon-plus fa-fw"></i> <span class="hide-menu">ایجاد درس جدید</span></a></li>
                                        <!--<li> <a href="<?php echo base_url(); ?>training/create-new-lesson"><i class="icon-plus fa-fw"></i> <span class="hide-menu">ایجاد درس جدید</span></a></li>-->
                                        <li> <a href="<?php echo base_url(); ?>training/manage-lessons"><i class="ti-menu fa-fw"></i> <span class="hide-menu">مدیریت درس ها</span></a></li>
<!--										--><?php //if($this->session->userdata('type_academy') != 1 ):?>
<!--										<li> <a href="--><?php //echo base_url(); ?><!--default-test"><i class="ti-menu fa-fw"></i> <span class="hide-menu">آزمون پیشفرض</span></a></li>-->
<!--										--><?php //endif; ?>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-folder-multiple fa-fw"></i> <span class="hide-menu">دوره ها</span><span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li> <a href="<?php echo base_url(); ?>training/create-new-course-page"><i class="icon-plus fa-fw"></i> <span class="hide-menu">ایجاد دوره جدید</span></a></li>
                                        <li> <a href="<?php echo base_url(); ?>training/manage-courses"><i class="ti-menu fa-fw"></i> <span class="hide-menu">مدیریت دوره ها</span></a></li>
                                    </ul>
                                </li>
<!--                                <li><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-pencil-box fa-fw"></i> <span class="hide-menu">آزمون ها</span><span class="fa arrow"></span></a>-->
<!--                                    <ul class="nav nav-third-level">-->
<!--                                        <li> <a href="--><?php //echo base_url(); ?><!--enrollment/create-exam"><i class="icon-plus fa-fw"></i> <span class="hide-menu">ایجاد آزمون جدید</span></a></li>-->
<!--                                        <li><a href="--><?php //echo base_url(); ?><!--enrollment/all-of-exams"><i class="fa-fw">2</i> <span class="hide-menu">ویرایش هزینه آزمون ها</span></a></li>-->
<!--                                        <li><a href="--><?php //echo base_url(); ?><!--enrollment/before-reg-exam"><i class="fa-fw">3</i> <span class="hide-menu">ثبت نام در آزمون</span></a></li>-->
<!--                                        <li><a href="--><?php //echo base_url(); ?><!--enrollment/registration-exam-list"><i class="fa-fw">4</i> <span class="hide-menu">ثبت نامی های آزمون </span></a></li>-->
<!--                                        <li> <a href="#"><i class="icon-plus fa-fw"></i> <span class="hide-menu">ایجاد آزمون جدید</span></a></li>-->
<!--                                        <li> <a href="#"><i class="ti-menu fa-fw"></i> <span class="hide-menu">مدیریت آزمون ها</span></a></li>-->
<!--                                    </ul>-->
<!--                                </li>-->
                            </ul>
                        </li>

                        <li> <a href="#" class="waves-effect"><i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">بخش کاربران<span class="fa arrow"></span> <span class="label label-rouded label-primary pull-right">3</span> </span></a>
                            <ul  class="nav nav-second-level collapse" aria-expanded="true" style="">
                                <li><a href="javascript:void(0)" class="waves-effect"><i class="icon-graduation fa-fw"></i> <span class="hide-menu"><?php echo $this->session->userdata('studentDName') . " ها"; ?></span><span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li> <a data-toggle="modal" data-target="#new-std" href=""><i class="icon-user-follow fa-fw"></i> <span class="hide-menu">ایجاد <?php echo $this->session->userdata('studentDName2'); ?> جدید</span></a></li>
                                        <li> <a href="<?php echo base_url(); ?>users/manage-students"><i class="icon-grid fa-fw"></i> <span class="hide-menu">مدیریت <?php echo $this->session->userdata('studentDName') . " ها"; ?></span></a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" class="waves-effect"><i class="ti-user fa-fw"></i> <span class="hide-menu"><?php echo $this->session->userdata('teacherDName') . " ها"; ?></span><span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li> <a href="<?php echo base_url(); ?>users/create-new-employee-page"><i class="icon-user-follow fa-fw"></i> <span class="hide-menu">ثبت <?php echo $this->session->userdata('teacherDName'); ?> جدید</span></a></li>
                                        <li> <a href="<?php echo base_url(); ?>users/manage-employers"><i class="icon-grid fa-fw"></i> <span class="hide-menu">مدیریت <?php echo $this->session->userdata('teacherDName') . " ها"; ?></span></a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" class="waves-effect"><i class="icon-user-following fa-fw"></i> <span class="hide-menu">کارمندها</span><span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li> <a href="<?php echo base_url(); ?>users/create-new-personnel"><i class="icon-user-follow fa-fw"></i> <span class="hide-menu">ثبت کارمند جدید</span></a></li>
                                        <li> <a href="<?php echo base_url(); ?>users/manage-personnels"><i class="icon-grid fa-fw"></i> <span class="hide-menu">مدیریت کارمندها</span></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li> <a href="#" class="waves-effect"><i class="mdi mdi-cash-multiple fa-fw"></i> <span class="hide-menu">مالی و حسابداری<span class="fa arrow"></span><span class="label label-rouded label-danger pull-right">3</span> </span></a>
                            <ul  class="nav nav-second-level collapse" aria-expanded="true" style="">
                                <li>
                                    <a href="<?php echo base_url(); ?>financial/finan-get-student-nc" class="waves-effect"><i class="ti-money fa-fw"></i> <span class="hide-menu">وضعیت مالی <?php echo $this->session->userdata('studentDName'); ?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>users/manage-employers-pay" class="waves-effect"><i class="ti-money fa-fw"></i> <span class="hide-menu">وضعیت مالی <?php echo $this->session->userdata('teacherDName'); ?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>financial/manage-courses-check" class="waves-effect"><i class="glyphicon glyphicon-edit fa-fw"></i> <span class="hide-menu">مدیریت چک ها</span></a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>financial/students-payments" class="waves-effect"><i class="glyphicon glyphicon-edit fa-fw"></i> <span class="hide-menu">پرداخت ها</span></a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>wallet" class="waves-effect"><i class="fa fa-wallet"></i></i> <span class="hide-menu"> وضعیت مالی آموزشگاه </span></a>
                                </li>
                            </ul>
                        </li>

                        <li> <a href="#" class="waves-effect"><i class="mdi mdi-forum fa-fw"></i> <span class="hide-menu">تیکت و اطلاعیه<span class="fa arrow"></span><span class="label label-rouded label-info pull-right">4</span></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-ticket fa-fw"></i> <span class="hide-menu">ارسال تیکت</span><span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li> <a href="<?php echo base_url(); ?>tickets/to-student"><i class="mdi mdi-ticket-account fa-fw"></i> <span class="hide-menu">به <?php echo $this->session->userdata('studentDName'); ?></span></a></li>
                                        <li> <a href="<?php echo base_url(); ?>tickets/to-employee"><i class="mdi mdi-ticket-account fa-fw"></i> <span class="hide-menu">به <?php echo $this->session->userdata('teacherDName'); ?></span></a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" class="waves-effect"><i class="ti-menu fa-fw"></i> <span class="hide-menu">مشاهده تیکت ها</span><span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li> <a href="<?php echo base_url(); ?>tickets/student-tickets"><i class="mdi mdi-ticket-account fa-fw"></i> <span class="hide-menu"><?php echo 'تیکت های ' . $this->session->userdata('studentDName'); ?></span></a></li>
                                        <li> <a href="<?php echo base_url(); ?>tickets/employee-tickets"><i class="mdi mdi-ticket-account fa-fw"></i> <span class="hide-menu"><?php echo 'تیکت های ' . $this->session->userdata('teacherDName'); ?></span></a></li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo base_url('send-announcement'); ?>" class="waves-effect"><i class="mdi mdi-presentation fa-fw"></i> <span class="hide-menu">ارسال اطلاعیه</span></a>
                                <li><a href="<?php echo base_url('manage-announcement'); ?>" class="waves-effect"><i class="mdi mdi-presentation fa-fw"></i> <span class="hide-menu">مشاهده اطلاعیه ها</span></a>
                            </ul>
                        </li>

<!--						<li><a href="--><?php //echo base_url(); ?><!--online_classes" class="waves-effect"><i class="glyphicon glyphicon-edit fa-fw"></i> <span class="hide-menu">کلاس های در حال اجرا</span></a></li>-->
                    </ul>
                <?php else: ?>
                    <ul class="nav" id="side-menu">
                        <li class="text-center"> <a href="#" class="waves-effect"><b class="text-danger">غیر قابل دسترس</b></a></li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->


        <!-- ============================================================== -->
        <!-- National Code Modal -->
        <!-- ============================================================== -->
        <div id="new-std" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center" style="background-color: #edf0f2">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">احراز هویت</h4>
                    </div>
                    <form action="<?php echo base_url('users/create-new-student-page'); ?>" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                            <div class="form-group">
                                <label>کد ملی فرد مورد نظر را وارد کنید:</label>
                                <input type="number" name="national_code" class="form-control" required  onKeyPress="if (this.value.length == 10)
                                            return false;" maxlength="10"  onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا کد ملی ده رقمی را وارد کنید')" onchange="try {
                                                        setCustomValidity('');
                                                    } catch (e) {
                                                    }">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <button type="submit" class="form-control btn btn-success">ادامه</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="form-control btn btn-danger" data-dismiss="modal">انصراف</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Error National Code Modal -->
        <?php if ($this->session->flashdata('national-code-msg')): ?>
            <script>
                $(document).ready(function () {
                    $('#error-nc').modal('show');
                });
            </script>
        <?php endif; ?>
        <div id="error-nc" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog text-center">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #edf0f2">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">احراز هویت</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-md-12 text-danger">
                                <?php echo $this->session->flashdata('national-code-msg'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button class="form-control btn btn-info" data-dismiss="modal">تایید</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End National Code Modal -->
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
				<div class="m-t-20 m-l-40">
					<h4><a style="color:darkslateblue;" href="<?= base_url('profile'); ?>"> <?php echo $this->session->userdata('academyDName') . " " . $this->session->userdata('academy_name'); ?></a></h4>
				</div>
                <?php if (!empty($yield) && $yield === 'dashboard'):?>
                    <div class="row m-t-20"></div>
                    <div class="row m-b-20 p-10" style="background-color: white;border-radius: 40px">
                        <div class="col-sm-12">
                            <div class="white-box">
                                <div class="col-lg-3 col-sm-6 row-in-br b-r-none">
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-danger"><i class="mdi mdi-account-multiple"></i></span>
                                        </li>
                                        <li class="col-last"><h4 class="counter text-right"><?= $studentsCount; ?></h4></li>
                                        <li class="col-middle">
											<a href="<?= base_url('users/manage-students') ?>">  <h5><?php echo $this->session->userdata('studentDName') . " ها"; ?></h5></a>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="163" aria-valuemin="0" aria-valuemax="100" style="width: 40%">

                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-sm-6 row-in-br b-r-none">
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-info"><i class="mdi mdi-folder-multiple"></i></span>
                                        </li>
                                        <li class="col-last"><h4 class="counter text-right"><?= $coursesCount; ?></h4></li>
                                        <li class="col-middle">
											<a href="<?= base_url('training/manage-course') ?>"> <h5>دوره های فعال</h5></a>
											<div class="progress">
												<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100" style="width: 40%"></div>
											</div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-sm-6 row-in-br b-r-none">
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-success"><i class="mdi mdi-pencil-box"></i></span>
                                        </li>
                                        <li class="col-last"><h4 class="counter text-right"><?= $examsCount; ?></h4></li>
                                        <li class="col-middle">
                                            <h5>آزمون ها</h5>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-sm-6 row-in-br b-r-none">
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-warning"><i class="fa fa-search-dollar"></i></span>
                                        </li>
                                        <li class="col-last"><h4 class="counter text-right"><?= $debtorsCount; ?></h4></li>
                                        <li class="col-middle">
                                            <h5>بدهکاران</h5>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100" style="width: 40%">

                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-t">
                        <div class="col-lg-6 col-md-6">
                            <div class="white-box p-20" style="background-color: white">
                                <h3 class="box-title"><small class="pull-right m-t-10 text-success"><i class="fa "></i> </small> ترافیک ماهانه سایت</h3>
                                <div class="stats-row">
                                    <div class="stat-item">
                                        <h6>تعداد کل بازدید های سه ماه اخیر</h6> <b><?php
                                            $result = 0;
                                            foreach ($viewsMonthWeb as $key => $sum) {
                                                $result += $sum;
                                            } echo $result;
                                            ?></b>
                                    </div>
                                </div>
                                <div id="spMonthViews"><canvas  style="display: inline-block; width: 335px; height: 50px; vertical-align: top;"></canvas></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="white-box p-20" style="background-color: white">
                                <h3 class="box-title"><small class="pull-right m-t-10 text-danger"><i class="fa "></i></small>ترافیک سایت</h3>
                                <div class="stats-row">
                                    <div class="stat-item">
                                        <h6>تعداد کل بازدیدهای هفته اخیر</h6>
                                        <b>
                                            <?php
                                            $result = 0;
                                            foreach ($viewsWeb as $key => $sum) {
                                                $result += $sum;
                                            } echo $result;
                                            ?>
                                        </b>
                                    </div>
                                </div>
                                <div id="spViews"><canvas style="display: inline-block; width: 335px; height: 50px; vertical-align: top;"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <?php if ($this->session->flashdata('success-insert')) { ?>
                        <div class="row">
                            <div class="alert alert-success">
                                <?php echo htmlspecialchars($this->session->flashdata('success-insert'), ENT_QUOTES); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('national-code-std')) { ?>
                        <div class="row">
                            <div class="alert alert-danger">
                                <?php echo htmlspecialchars($this->session->flashdata('national-code-std'), ENT_QUOTES); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <!-- col-md-3 -->
                        <div class="col-md-6 col-lg-6">
                            <div class="panel">
                                <div class="panel-body" style="margin-top:2%;height: 250px">
                                    <div class="white-box">
                                        <h3 class="box-title m-b-0 bg-info" style="padding-right:10px;">لیست بدهکاران</h3>

                                        <div class="table-responsive" style="overflow: auto;height: 182px">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>نام <?php echo $this->session->userdata('studentDName'); ?></th>
                                                        <th style="text-align: center">کد ملی</th>
                                                        <th style="text-align: center">مبلغ بدهی</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($debtors)) { ?>
                                                        <?php foreach ($debtors as $debtor) { ?>
                                                            <tr class="clickable" onclick="document.getElementById('financial_<?= $debtor->national_code; ?>').submit()" data-toggle="tooltip" data-original-title="نمایش جزئیات" data-placement="bottom">
                                                                <td><?php echo htmlspecialchars($debtor->first_name . ' ' . $debtor->last_name, ENT_QUOTES); ?></td>
                                                                <td class="text-center"><?php echo htmlspecialchars($debtor->national_code, ENT_QUOTES); ?></td>
                                                                <td class="text-center">
                                                                    <div class="label label-table label-danger">
                                                                        <?php echo htmlspecialchars($debtor->final_amount, ENT_QUOTES); ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <form id="financial_<?= $debtor->national_code; ?>" action="<?= base_url('financial/student-inquiry'); ?>" method="post">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                            <input type="hidden" name="national_code" value="<?= $debtor->national_code; ?>">
                                                        </form>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr><td>
                                                            اطلاعاتی جهت نمایش وجود ندارد
                                                        </td></tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="panel ">
                                <div class="panel-body" style="margin-top:2%;height: 250px">
                                    <div class="white-box">
                                        <h3 class="box-title m-b-0 bg-danger" style="padding-right:10px;">پیش ثبت نام ها</h3>

                                        <div class="table-responsive" style="overflow: auto;height: 182px">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>نام <?php echo $this->session->userdata('studentDName'); ?></th>
                                                        <th style="text-align: center">کد ملی</th>
                                                        <th style="text-align: center">وضعیت</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($pre_registration)) { ?>
                                                        <?php foreach ($pre_registration as $std): ?>
                                                            <tr class="clickable" onclick="document.getElementById('editStudent_<?= $std->national_code; ?>').submit()" data-toggle="tooltip" data-original-title="ویرایش" data-placement="bottom">
                                                                <td><?php echo htmlspecialchars($std->first_name . ' ' . $std->last_name, ENT_QUOTES); ?></td>
                                                                <td class="text-center"><?php echo htmlspecialchars($std->national_code, ENT_QUOTES); ?></td>
                                                                <td class="text-center">
                                                                    <div class="label label-table label-danger"> عدم ثبت در دوره و آزمون</div>
                                                                </td>
                                                            </tr>
                                                        <form id="editStudent_<?= $std->national_code; ?>" action="<?= base_url('users/edit-student'); ?>" method="post">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                            <input type="hidden" name="national_code" value="<?= $std->national_code; ?>">
                                                        </form>
                                                        <?php
                                                    endforeach;
                                                }else {
                                                    ?>
                                                    <tr><td>
                                                            اطلاعاتی جهت نمایش وجود ندارد
                                                        </td></tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="panel ">
                                <div class="panel-body" style="margin-top:2%;height: 250px">
                                    <div class="white-box">
                                        <h3 class="box-title m-b-0 bg-warning"  style="padding-right:10px;">چک های فردا</h3>

                                        <div class="table-responsive" style="overflow: auto;height: 182px">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>نام <?php echo $this->session->userdata('studentDName'); ?></th>
                                                        <th style="text-align: center">کد ملی</th>
                                                        <th style="text-align: center">مبلغ چک</th>
                                                        <th style="text-align: center">بابت</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <?php if (!empty($tomorrow_checks)) { ?>
                                                            <?php foreach ($tomorrow_checks as $check): ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($check->first_name . ' ' . $stu->last_name, ENT_QUOTES); ?></td>
                                                                <td class="text-center"><?php echo htmlspecialchars($check->national_code, ENT_QUOTES); ?></td>
                                                                <td class="text-center"><?php echo htmlspecialchars($check->check_amount, ENT_QUOTES); ?></td>
                                                                <td class="text-center">
                                                                    <div class="label label-table label-info">
                                                                        <?php if ($check->exam_student_id) { ?>
                                                                            <?php echo htmlspecialchars('آزمون با کد: ' . $check->exam_student_id, ENT_QUOTES); ?>
                                                                        <?php } else { ?>
                                                                            <?php echo htmlspecialchars('دوره با کد: ' . $check->course_student_id, ENT_QUOTES); ?>
                                                                        <?php } ?>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            <?php
                                                        endforeach;
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                اطلاعاتی جهت نمایش وجود ندارد
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <div class="col-md-4 col-lg-3">
                    <div class="panel wallet-widgets">
                        <div class="panel-body">
                            <ul class="side-icon-text">
                                <li class="m-0"><a href=""><span class="circle circle-md bg-success di vm"><i class="ti-plus"></i></span><span class="di vm"><h1 class="m-b-0">4500000 تومان</h1><h5 class="m-t-0">موجودی کیف پول شما</h5></span></a></li>
                            </ul>
                        </div>
                        <div id="morris-area-chart2" style="height:208px"></div>
                        <ul class="wallet-list">
                            <div data-toggle="modal" data-target="#payment" ><li><i class=" ti-wallet"></i><a href="javascript:void(0)">شارژ کیف پول</a></li></div>
                            <li><i class="icon-notebook"></i><a href="<?php echo base_url('wallet') ?>" >ریز حساب</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="payment" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">مبلغ مورد نظر را وارد کنید</h4> </div>
                    <div class="modal-body">
                        <form action="<?= base_url('online_payment') ?>" method="post">
                            <div class="form-group">
                                <label for="payment" class="control-label">مبلغ:</label>
                                <input type="number" class="form-control" name="online_amount">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                            </div>
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">بستن</button>
                            <button type="submit" class="btn btn-success waves-effect waves-light">ورود به درگاه بانک</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
                <!-- /col-md-3 -->
<!--                        <div class="col-md-6 col-lg-6">-->
<!--                            <div class="panel ">-->
<!--                                <div class="panel-body" style="margin-top:2%">-->
<!--                                    <div class="white-box">-->
<!--                                        <h3 class="box-title m-b-0 bg-success" style="padding-right:10px;">پیش ثبت نام</h3>-->
<!---->
<!--                                        <div class="table-responsive" id="inq_table">-->
<!--                                            <table class="table">-->
<!---->
<!--                                                <tbody>-->
<!--                                                    <tr>-->
<!--                                                        <td>استعلام</td>-->
<!--                                                        <td id="inq_td">-->
<!--                                                            <form id="inquiry-form" action="--><?php //echo base_url(); ?><!--profile/inquiry" method="post" class="form-group">-->
<!---->
<!--                                                                <div class="form-group">-->
<!--                                                                    <input type="text" onKeyPress="if (this.value.length == 10)-->
<!--                                                                                    return false;"-->
<!--                                                                           min="1000000000" max="9999999999" name="student_nc" class="form-control" required oninvalid="setCustomValidity('لطفا کد را وارد کنید')" onchange="try {-->
<!--                                                                                           setCustomValidity('');-->
<!--                                                                                       } catch (e) {-->
<!--                                                                                       }">-->
<!--                                                                </div>-->
<!--                                                            </form>-->
<!--                                                        </td>-->
<!--                                                        <td>-->
<!--                                                            <button type="button" style="padding: 8px; width: 100%" id="inquiry_btn" class="brn btn-primary">ارسال</button>-->
<!--                                                        </td>-->
<!--                                                    </tr>-->
<!--                                                </tbody>-->
<!--                                            </table>-->
<!--                                        </div>-->
<!--                                        <div class="table-responsive" id="pre_register_table" style="display:none;">-->
<!--                                            <table class="table">-->
<!--                                                <tbody>-->
<!---->
<!--                                                <form id="inquiry-form" action="--><?php //echo base_url(); ?><!--profile/pre-register-st" method="post" class="form-group">-->
<!---->
<!--                                                    <div class="form-group">-->
<!--                                                        <input type="text" name="first_name" required="" class="form-control" placeholder="نام">-->
<!--                                                    </div>-->
<!--                                                    <div class="form-group">-->
<!--                                                        <input type="text" name="last_name" required="" class="form-control" placeholder="نام خانوادگی">-->
<!--                                                    </div>-->
<!--                                                    <div class="form-group">-->
<!--                                                        <input type="text" name="national_code" required="" class="form-control" placeholder="کدملی ده رقمی را وارد نمایید">-->
<!--                                                    </div>-->
<!--                                                    <div class="form-group">-->
<!--                                                        <input type="text" name="phone_num" required="" class="form-control" placeholder="شماره همراه">-->
<!--                                                    </div>-->
<!--                                                    <div class="form-group">-->
<!--                                                        <button type="submit"  class="form-control btn btn-success">ثبت نام</button>-->
<!--                                                    </div>-->
<!--                                                </form>-->
<!---->
<!--                                                </tbody>-->
<!--                                            </table>-->
<!--                                        </div>-->
<!--                                        <div id="inq_res" class="alert alert-success text-light" style="display:none;">-->
<!--                                        </div >-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                        <!-- /col-md-3 -->
                    </div>
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
                <!--                <div class="right-sidebar">
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
                                </div>-->
                <!-- ============================================================== -->
                <!-- end right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center">کپی رایت 1398 &copy; همه حقوق برای شرکت یوتاب پارس محفوظ است.</footer>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->


    <script>
        $(document).ready(function () {
            $("button#inquiry_btn").click(function (z) {
                var data = $("form#inquiry-form").serialize();
                $.ajax({
                    type: "post",
                    dataType: 'json',
                    url: '<?php echo base_url(); ?>profile/inquiry',
                    data: data,
                    success: function (data) {
                        if (data.exist) {
                            $("div#inq_res").css('display', 'block');
                            $("div#inq_res").html("<a class='text-white' href='<?= base_url(); ?>financial/student-inquiry/" + data.exist + "' > کاربر مورد نظر وجود دارد، جهت ورود به پروفایل کاربر کلیک کنید</a>"
//                                $("div#inq_res").html("<a class='text-white' href='#' onclick="$('#studentInquery')"> کاربر مورد نظر وجود دارد، جهت ورود به پروفایل کاربر کلیک کنید</a>"
//                                "<form id='studentInquery' action='<?= base_url(); ?>financial/student-inquiry' method='post'>"
//                                "<input type='hidden' name='<?= $this->security->get_csrf_token_name(); ?>' value='<?php echo $this->security->get_csrf_hash(); ?>' />"
//                                "<input type='hidden' name='national_code' value='"data.exist"'>"
//                                "</form>"
                                    );
                            // setTimeout(function() { $("div#inq_res").hide(); }, 3000);
                            // location.reload(true);
                        }
                        if (data.notexist) {
                            $("div#inq_table").css('display', 'none');
                            $("div#pre_register_table").css('display', 'block');
                        }
                    }
                });
            });
        });
    </script>
