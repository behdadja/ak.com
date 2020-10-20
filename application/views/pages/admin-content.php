

<!DOCTYPE html>
<html lang="en">


<style>
    /* for modal / bug fix - no overlay */
    .modal-backdrop {
        display: none;
    }

</style>
<body>

<div class="preloader">
    <div class="sk-double-bounce">
        <div class="sk-child sk-double-bounce1"></div>
        <div class="sk-child sk-double-bounce2"></div>
    </div>
</div>

<!-- Header Layout -->
<div class="mdk-header-layout js-mdk-header-layout">

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
                <ul class="nav navbar-nav ml-auto" style="white-space: nowrap;">
                    <?php if ($this->session->userdata('session_id')) : ?>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <span class="btn btn-black"><?= $this->session->userdata('full_name') ?><i class="ml-8pt"></i></span>
                        </a>
                        <a href="<?= base_url('logout');?>" class="nav-link">
                            <span class="btn btn-warning">خروج<i class="fa fa-sign-in-alt ml-8pt"></i></span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
                <!-- // END Main Navigation -->

            </div>

        </div>
    </div>

    <!-- // END Header -->

    <!-- Header Layout Content -->
    <div class="mdk-header-layout__content page-content">

        <!-- منوی بالا  -->
        <div class="navbar navbar-expand-sm navbar-mini navbar-dark bg-dark d-none d-sm-flex p-0">
            <div class="container-fluid">

                <!-- Main Navigation -->
                <ul class="nav navbar-nav flex-nowrap">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="<?= base_url('admin') ?>">خانه</a>
                    </li>
					<li class="nav-item dropdown">
						<a class="nav-link" href="<?= base_url('requests'); ?>">درخواست ها</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link" href="<?= base_url('manage-academys'); ?>">آموزشگاه ها</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link" href="<?= base_url('manage-teachers'); ?>">اساتید</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link" href="<?= base_url('manage-students'); ?>">دانشجوها</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link" href="<?= base_url('admin/running_classes'); ?>">کلاس های در حال اجرا</a>
					</li>

                    <li class="nav-item dropdown">
                        <a class="nav-link" href="<?= base_url('servers_info'); ?>">مدیریت سرور</a>
                    </li>
<!--                    <li class="nav-item dropdown">-->
<!--                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">امکانات آموزشی</a>-->
<!--                        <div class="dropdown-menu">-->
<!--                            <a class="dropdown-item" href="#">مقالات آموزشی</a>-->
<!--                            <a class="dropdown-item" href="#">مسیر یادگیری</a>-->
<!--                        </div>-->
<!--                    </li>-->
                </ul>
                <!-- // END Main Navigation -->

            </div>
        </div>
        <!-- / پایان منو -->

        <!-- =============================================================================== -->
        <!-- Page Content -->
        <!-- =============================================================================== -->

        <?php if (!empty($admin) && $admin === 'true'):?>

<!--            <a href="--><?//= base_url('manage-academys'); ?><!--" class="btn btn-info">آموزشگاه ها</a>-->
<!--            <a href="--><?//= base_url('online-course'); ?><!--" class="btn btn-success">دوره های آنلاین</a>-->


<!--			--><?php //if (validation_errors()): ?>
<!--				<div class="card">-->
<!--					<div class="card-body">-->
<!--						<div class="alert bg-accent text-white" role="alert">-->
<!--							اخطارهای زیر را بررسی کنید!-->
<!--						</div>-->
<!--						<div class="pl-16pt mb-16pt border-left-4 border-left-accent text-danger" style="border-radius: 0 4px 4px 0">--><?php //echo form_error('first_name'); ?><!--</div>-->
<!--					</div>-->
<!--				</div>-->
<!--			--><?php //endif; ?>

<!--		--><?//= $this->session->flashdata('error')?>
<!--		<form action="--><?//= base_url('adminator/test_validation')?><!--" method="post">-->
<!--			<input type="hidden" name="--><?php //echo $this->security->get_csrf_token_name(); ?><!--" value="--><?php //echo $this->security->get_csrf_hash(); ?><!--" />-->
<!--			<input name="first_name" class="form-control">-->
<!--			<button type="submit" class="btn btn-danger">test</button>-->
<!--		</form>-->


        <?php else: ?>
            <?php
            if (!empty($admin)) {
                $this->load->view('admin/' . $admin);
            } else {
                $this->load->view('errors/403');
            }
            ?>
        <?php endif; ?>

        <!-- =============================================================================== -->
        <!-- End Page Content -->
        <!-- =============================================================================== -->
    </div>
    <!-- // END Header Layout Content -->

</div>
<!-- // END Header Layout -->


<!-- فوتر-->
<div class="bg-white js-fix-footer border-top-2">
    <div class="bg-footer page-section py-lg-32pt">
        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <!-- justify-content-md-end -->
                    <p class="mb-8pt d-flex align-items-md-center">
                        <a href="#" class="text-white-70 mr-16pt">شرایط</a>
                        <a href="#" class="text-white-70">حریم خصوصی</a>
                    </p>

                    <p class="text-white-70">
                        <a href="http://yun.ir/qpt">
                            <i class="fa fa-mobile-alt ml-2"></i>
                            دانلود اپلیکیشن اندروید
                        </a>
                    </p>
                    <hr style="width: 70%">
                    <p class="text-white mb-0">کپی رایت 1398 &copy; همه حقوق برای شرکت یوتاب پارس محفوظ است.</p>
                </div>
                <div class="col-md-4 mb-md-32pt mb-md-0">
                    <p class="text-white-70"><strong>دنبال کردن ما</strong></p>
                    <nav class="nav nav-links nav--flush">
                        <a href="https://inestagram.com/amoozkadeh" class="nav-link mr-8pt"><img src="<?php echo base_url(); ?>assets/images/icon/footer/instagram.png" alt="instagram"></a>
                        <a href="https://aparat.com/amoozkadeh" class="nav-link mr-8pt"><img src="<?php echo base_url(); ?>assets/images/icon/footer/aparat.png" alt="aparat"></a>
                        <a href="https://t.me/amoozkadeh" class="nav-link mr-8pt"><img src="<?php echo base_url(); ?>assets/images/icon/footer/telegram2.png" alt="telegram"></a>
                        <a href="https://bale.ir/amoozkadeh" class="nav-link"><img src="<?php echo base_url(); ?>assets/images/icon/footer/bale2.png" alt="bale2"></a>
                    </nav>
                </div>
                <div class="col-md-2">
                    <!--<a target="_blank" href="https://trustseal.enamad.ir/?id=147962&amp;Code=aUAOhID01WmJYJLxeawQ"><img src="https://Trustseal.eNamad.ir/logo.aspx?id=147962&amp;Code=aUAOhID01WmJYJLxeawQ" alt="" style="cursor:pointer" id="aUAOhID01WmJYJLxeawQ"></a>-->
                    <a target="_blank" href="https://trustseal.enamad.ir/?id=147962&amp;Code=aUAOhID01WmJYJLxeawQ"><img src="<?= base_url('assets/images/enamad.png') ?>" alt="" style="cursor:pointer" id="aUAOhID01WmJYJLxeawQ"></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / پایان-->

</body>

</html>
