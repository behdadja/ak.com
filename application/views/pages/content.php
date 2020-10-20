
<!doctype html>
<html lang="fa">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="keywords" content="HTML5,CSS3,HTML,Template,multi-page,Raque - Education & LMS HTML Template" >
	<meta name="description" content="Raque - Education & LMS HTML Template">
	<meta name="author" content="Barat Hadian">

	<!-- Links of CSS files -->
	<link rel="stylesheet" href="assets/css/bootstrap..min.css">
	<link rel="stylesheet" href="assets/css/boxicons.min.css">
	<link rel="stylesheet" href="assets/css/flaticon.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="assets/css/odometer.min.css">
	<link rel="stylesheet" href="assets/css/meanmenu.min.css">
	<link rel="stylesheet" href="assets/css/animate.min.css">
	<link rel="stylesheet" href="assets/css/nice-select.min.css">
	<link rel="stylesheet" href="assets/css/viewer.min.css">
	<link rel="stylesheet" href="assets/css/slick.min.css">
	<link rel="stylesheet" href="assets/css/magnific-popup.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/rtl.css">
	<link rel="stylesheet" href="assets/css/responsive.css">

	<title>آموز کده ،سامانه مدیریت آموزشگاه ها</title>

	<link rel="icon" type="image/png" href="assets/img/favicon.png">
</head>

<body>

<!-- Preloader -->
<div class="preloader">
	<div class="loader">
		<div class="shadow"></div>
		<div class="box"></div>
	</div>
</div>
<!-- End Preloader -->

<!-- Start Header Area -->
<header class="header-area p-relative">

	<div class="top-header top-header-style-four">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-8 col-md-8">
					<br>
					<br>
				</div>

				<div class="col-lg-4 col-md-4">
					<ul class="top-header-login-register">
						<?php if (!$this->session->userdata('session_id')){ ?>
							<li><a href="<?php echo base_url('portal'); ?>"><i class='bx bx-log-in'></i>ورود به پورتال</a></li>
							<li><a href="<?= base_url('guide'); ?>"><i class='bx bx-log-in-circle'></i> راهنما</a></li>
						<?php } else { ?>
							<li><a href="<?php echo base_url('portal'); ?>"><i class='bx bx-log-in-circle'></i> پورتال</a></li>
						<?php } ?>


					</ul>
				</div>
			</div>
		</div>
	</div>



	<!-- Start Navbar Area -->
	<div class="navbar-area navbar-style-three">
		<div class="raque-responsive-nav">
			<div class="container">
				<div class="raque-responsive-menu">
					<div class="logo">
						<a href="#">
							<img src="assets/img/admin_logo.png" alt="logo"  height="50" width="50" style="padding: 2px;">
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="raque-nav">

			<div class="container">
				<nav class="navbar navbar-expand-md navbar-light">
					<a class="navbar-brand" href="#">
						<img src="assets/img/admin_logo.png" alt="logo" height="50" width="50" style="padding: 2px;">
					</a>

					<div class="collapse navbar-collapse mean-menu">
						<ul class="navbar-nav">

							<li class="nav-item"><a href="#" class="nav-link">خانه</a></li>

							<li class="nav-item"><a href="#" class="nav-link">دوره های آموزشی <i class='bx bx-chevron-down'></i></a>
								<ul class="dropdown-menu">
									<li class="nav-item"><a href="#" class="nav-link">دسته بندی دوره های آموزشی <i class='bx bx-chevron-left'></i></a>
										<ul class="dropdown-menu">
											<li class="nav-item"><a href="courses-category-style-1.html" class="nav-link">دسته بندی 1</a></li>

											<li class="nav-item"><a href="courses-category-style-2.html" class="nav-link">دسته بندی 2</a></li>

											<li class="nav-item"><a href="courses-category-style-3.html" class="nav-link">دسته بندی 3</a></li>
										</ul>
									</li>

									<li class="nav-item"><a href="courses-list.html" class="nav-link">لیست دوره ها</a></li>

									<li class="nav-item"><a href="#" class="nav-link">دوره های شبکه ای 1 <i class='bx bx-chevron-left'></i></a>
										<ul class="dropdown-menu">
											<li class="nav-item"><a href="courses-2-columns-style-1.html" class="nav-link">2 ستونی</a></li>

											<li class="nav-item"><a href="courses-3-columns-style-1.html" class="nav-link">3 ستونی</a></li>

											<li class="nav-item"><a href="courses-4-columns-style-1.html" class="nav-link">4 ستونی تمام عرض</a></li>
										</ul>
									</li>

									<li class="nav-item"><a href="#" class="nav-link">دوره های شبکه ای 2 <i class='bx bx-chevron-left'></i></a>
										<ul class="dropdown-menu">
											<li class="nav-item"><a href="courses-2-columns-style-2.html" class="nav-link">2 ستونی</a></li>

											<li class="nav-item"><a href="courses-3-columns-style-2.html" class="nav-link">3 ستونی</a></li>

											<li class="nav-item"><a href="courses-4-columns-style-2.html" class="nav-link">4 ستونی تمام عرض</a></li>
										</ul>
									</li>

									<li class="nav-item"><a href="#" class="nav-link">دوره های شبکه ای 3 <i class='bx bx-chevron-left'></i></a>
										<ul class="dropdown-menu">
											<li class="nav-item"><a href="courses-2-columns-style-3.html" class="nav-link">2 ستونی</a></li>

											<li class="nav-item"><a href="courses-3-columns-style-3.html" class="nav-link">3 ستونی</a></li>

											<li class="nav-item"><a href="courses-4-columns-style-3.html" class="nav-link">4 ستونی تمام عرض</a></li>
										</ul>
									</li>

									<li class="nav-item"><a href="#" class="nav-link">جزئیات دوره های آموزشی <i class='bx bx-chevron-left'></i></a>
										<ul class="dropdown-menu">
											<li class="nav-item"><a href="single-courses.html" class="nav-link">جزئیات دوره های آموزشی 1</a></li>

											<li class="nav-item"><a href="single-courses-2.html" class="nav-link">جزئیات دوره های آموزشی 2</a></li>
										</ul>
									</li>

									<li class="nav-item"><a href="my-account.html" class="nav-link">حساب کاربری من</a></li>
								</ul>
							</li>

							<li class="nav-item"><a href="#" class="nav-link">امکانات آموزشی <i class='bx bx-chevron-down'></i></a>
								<ul class="dropdown-menu">
									<li class="nav-item"><a href="#" class="nav-link">مقالات آموزشی</a></li>

									<li class="nav-item"><a href="#" class="nav-link">مسیر یادگیری</a></li>

								</ul>
							</li>


							<li class="nav-item"><a href="<?= base_url('contact-us') ?>" class="nav-link">تماس با ما</a></li>
						</ul>
						<div class="others-option">

							<div class="search-box d-inline-block">
								<i class='bx bx-search'></i>
							</div>
						</div>
					</div>
				</nav>
			</div>
		</div>
	</div>
	<!-- End Navbar Area -->



</header>
<!-- End Header Area -->

<?php if (!empty($yield) && $yield === 'dashboard'): ?>

<!-- search-box-layout -->
<div class="search-overlay">
	<div class="d-table">
		<div class="d-table-cell">
			<div class="search-overlay-layer"></div>
			<div class="search-overlay-layer"></div>
			<div class="search-overlay-layer"></div>

			<div class="search-overlay-close">
				<span class="search-overlay-close-line"></span>
				<span class="search-overlay-close-line"></span>
			</div>

			<div class="search-overlay-form">
				<form>
					<input type="text" class="input-search" placeholder="جستجو ...">
					<button type="submit"><i class='bx bx-search-alt'></i></button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- search-box-layout end -->

<!-- Start Main Banner -->
<div class="hero-banner bg-white">
	<div class="d-table">
		<div class="d-table-cell">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-lg-6 col-md-12">
						<div class="hero-banner-content black-color">
							<section class="main-banner-wrapper">
								<div class="container">
									<div class="banner-wrapper-content">
										<h1>آموزکده سامانه مدیریت آموزشگاه <a href="#" class="typewrite" data-period="2000" data-type='[ "طراحی وب", "وب", "کدنویسی", "php?>" ]'><span class="wrap"></span></a> </h1>
										<p>سامانه مدیریت آموزشگاه آموزکده، سامانه ای جامع، قدرتمند، کاربردی و دقیق برای مدیریت هر آموزشگاه با هر زمینه فعالیت</p>

										<form>
											<input type="text" class="input-search" placeholder="چه چیزی میخواهی یاد بگیری؟">
											<button type="button">جستجو</button>
										</form>
									</div>
								</div>
							</section>
						</div>
					</div>

					<div class="col-lg-6 col-md-12">
						<div class="hero-banner-image text-center">
							<img src="assets/img/banner.jpg" alt="image">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Main Banner -->
<br>
<br>
<br>
<br>
<!-- Start Courses Categories Area -->
<!--<section class="courses-categories-area pb-70">-->
<!--	<div class="container">-->
<!--		<div class="section-title text-left">-->
<!--			<span class="sub-title">دسته بندی دوره ها</span>-->
<!--			<h2>دسته بندی های گرایش را مرور کنید</h2>-->
<!--			<a href="courses-category-style-2.html" class="default-btn"><i class='bx bx-show-alt icon-arrow before'></i><span class="label">مشاهده همه</span><i class="bx bx-show-alt icon-arrow after"></i></a>-->
<!--		</div>-->
<!---->
<!--		<div class="courses-categories-slides owl-carousel owl-theme">-->
<!--			<div class="single-categories-courses-item bg1 mb-30">-->
<!--				<div class="icon">-->
<!--					<i class='bx bx-code-alt'></i>-->
<!--				</div>-->
<!--				<h3>توسعه دهنده وب</h3>-->
<!--				<span>60 دوره آموزش</span>-->
<!---->
<!--				<a href="#" class="learn-more-btn">بیشتر بدانید <i class='bx bx-book-reader'></i></a>-->
<!---->
<!--				<a href="#" class="link-btn"></a>-->
<!--			</div>-->
<!---->
<!--			<div class="single-categories-courses-item bg2 mb-30">-->
<!--				<div class="icon">-->
<!--					<i class='bx bx-camera'></i>-->
<!--				</div>-->
<!--				<h3>فتوگرافی </h3>-->
<!--				<span>21 دوره آموزش</span>-->
<!---->
<!--				<a href="#" class="learn-more-btn">بیشتر بدانید <i class='bx bx-book-reader'></i></a>-->
<!---->
<!--				<a href="#" class="link-btn"></a>-->
<!--			</div>-->
<!---->
<!--			<div class="single-categories-courses-item bg3 mb-30">-->
<!--				<div class="icon">-->
<!--					<i class='bx bx-layer'></i>-->
<!--				</div>-->
<!--				<h3>طراحی گرافیک</h3>-->
<!--				<span>58 دوره آموزش</span>-->
<!---->
<!--				<a href="#" class="learn-more-btn">بیشتر بدانید <i class='bx bx-book-reader'></i></a>-->
<!---->
<!--				<a href="#" class="link-btn"></a>-->
<!--			</div>-->
<!---->
<!--			<div class="single-categories-courses-item bg4 mb-30">-->
<!--				<div class="icon">-->
<!--					<i class='bx bxs-flag-checkered'></i>-->
<!--				</div>-->
<!--				<h3>زبان برنامه نویسی</h3>-->
<!--				<span>99 دوره آموزش</span>-->
<!---->
<!--				<a href="#" class="learn-more-btn">بیشتر بدانید <i class='bx bx-book-reader'></i></a>-->
<!---->
<!--				<a href="#" class="link-btn"></a>-->
<!--			</div>-->
<!---->
<!--			<div class="single-categories-courses-item bg5 mb-30">-->
<!--				<div class="icon">-->
<!--					<i class='bx bx-health'></i>-->
<!--				</div>-->
<!--				<h3>سلامتی و تندرستی</h3>-->
<!--				<span>21 دوره آموزش</span>-->
<!---->
<!--				<a href="#" class="learn-more-btn">بیشتر بدانید <i class='bx bx-book-reader'></i></a>-->
<!---->
<!--				<a href="#" class="link-btn"></a>-->
<!--			</div>-->
<!---->
<!--			<div class="single-categories-courses-item bg6 mb-30">-->
<!--				<div class="icon">-->
<!--					<i class='bx bx-line-chart'></i>-->
<!--				</div>-->
<!--				<h3>مهارت تجاری</h3>-->
<!--				<span>49 دوره آموزش</span>-->
<!---->
<!--				<a href="#" class="learn-more-btn">بیشتر بدانید <i class='bx bx-book-reader'></i></a>-->
<!---->
<!--				<a href="#" class="link-btn"></a>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--	<div id="particles-js-circle-bubble-2"></div>-->
<!--</section>-->
<!-- End Courses Categories Area -->

<!-- Start Courses Area -->
<section class="courses-area pt-100 pb-70">
	<div class="container">
		<div class="section-title text-left">
			<span class="sub-title">دوره ها را کشف کنید</span>
			<h2>جدیدترین دوره ها</h2>
			<a href="courses-2-columns-style-2.html" class="default-btn"><i class='bx bx-show-alt icon-arrow before'></i><span class="label">همه دوره ها</span><i class="bx bx-show-alt icon-arrow after"></i></a>
		</div>

<!--		<div class="shorting-menu">-->
<!--			<button class="filter" data-filter="all">همه (06)</button>-->
<!--			<button class="filter" data-filter=".business">تجاری (02)</button>-->
<!--			<button class="filter" data-filter=".design">طراحی (05)</button>-->
<!--			<button class="filter" data-filter=".development">توسعه دهنده (04)</button>-->
<!--			<button class="filter" data-filter=".language">زبان خارجه (02)</button>-->
<!--			<button class="filter" data-filter=".management">مدیریت (03)</button>-->
<!--			<button class="filter" data-filter=".photography">عکاسی (04)</button>-->
<!--		</div>-->
		<div class="shorting">
			<div class="row">

		<?php foreach ($courses as $course) { ?>

				<div class="col-lg-4 col-md-6 mix business design language">
					<div class="single-courses-item mb-30">
						<div class="courses-image">
							<a href="single-courses.html" class="d-block"><img src="<?php echo base_url('portal/assets/course-picture/thumb/' . $course->course_pic); ?>" alt="image"></a>
						</div>

						<div class="courses-content">
							<div class="d-flex justify-content-between align-items-center">
								<div class="course-author d-flex align-items-center">
									<img src="<?php echo base_url('portal/assets/course-picture/thumb/' . $course->course_pic); ?>" class="shadow" alt="image">
									<span><?= $course->first_name.' '.$course->last_name ?></span>
								</div>

								<div class="courses-rating">
									<div class="review-stars-rated">
										<i class='bx bxs-star'></i>
										<i class='bx bxs-star'></i>
										<i class='bx bxs-star'></i>
										<i class='bx bxs-star'></i>
										<i class='bx bxs-star-half'></i>
									</div>

									<div class="rating-total">
										4.5 (2)
									</div>
								</div>
							</div>

							<h3><a href="single-courses.html" class="d-inline-block"><?= $course->lesson_name ?></a></h3>
							<p><?= $course->lesson_description ?></p>
						</div>

						<div class="courses-box-footer">
							<ul>
								<li class="students-number">
									<i class='bx bx-user'></i> <?= $course->capacity ?> دانشجو
								</li>

								<li class="courses-price">
									<?= $course->course_tuition .' تومان' ?>
								</li>
							</ul>
						</div>
					</div>
				</div>
		<?php } ?>

			</div>
		</div>
	</div>
</section>
<!-- End Courses Area -->

<!-- Start Team Area -->
<section class="team-area ptb-100">
	<div class="container">
		<div class="section-title">
			<span class="sub-title">ارتباطات را برقرار کنید</span>
			<h2>آموزشگاه ها</h2>
			<p>لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است.</p>
		</div>

		<div class="team-slides owl-carousel owl-theme">

			<?php foreach ($academys as $academy) { ?>

				<div class="single-instructor-box mb-30">
					<div class="image">
						<img src="<?= base_url('portal/assets/profile-picture/thumb/' . $academy->logo); ?>" alt="image" height="200" width="150">

						<ul class="social">
							<li><a href="#" target="_blank"><i class="bx bxl-facebook"></i></a></li>
							<li><a href="#" target="_blank"><i class="bx bxl-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="bx bxl-linkedin"></i></a></li>
							<li><a href="#" target="_blank"><i class="bx bxl-instagram"></i></a></li>
						</ul>
					</div>

					<div class="content">
						<h3><a href="single-instracademy_display_nameuctor.html"><?= $academy->academy_display_name.' '.$academy->academy_name ?></a></h3>
						<span><?= $academy->m_first_name.' '.$academy->m_last_name ?></span>
					</div>
				</div>

			<?php } ?>



		</div>
	</div>

	<div id="particles-js-circle-bubble-3"></div>
</section>
<!-- End Team Area -->

<!-- Start Funfacts Area -->
<!--<section class="funfacts-area pt-100">-->
<!--	<div class="container">-->
<!--		<div class="funfacts-inner">-->
<!--			<div class="row">-->
<!--				<div class="col-lg-3 col-md-3 col-6">-->
<!--					<div class="single-funfact">-->
<!--						<div class="icon">-->
<!--							<i class='bx bxs-group'></i>-->
<!--						</div>-->
<!--						<h3 style="direction: ltr;" class="odometer" data-count="50">00</h3>-->
<!--						<p>مربیان خبره</p>-->
<!--					</div>-->
<!--				</div>-->
<!---->
<!--				<div class="col-lg-3 col-md-3 col-6">-->
<!--					<div class="single-funfact">-->
<!--						<div class="icon">-->
<!--							<i class='bx bx-book-reader'></i>-->
<!--						</div>-->
<!--						<h3 style="direction: ltr;" class="odometer" data-count="1754">00</h3>-->
<!--						<p>تمام دوره ها</p>-->
<!--					</div>-->
<!--				</div>-->
<!---->
<!--				<div class="col-lg-3 col-md-3 col-6">-->
<!--					<div class="single-funfact">-->
<!--						<div class="icon">-->
<!--							<i class='bx bx-user-pin'></i>-->
<!--						</div>-->
<!--						<h3 style="direction: ltr;" class="odometer" data-count="8190">00</h3>-->
<!--						<p>دانش آموزان راضی</p>-->
<!--					</div>-->
<!--				</div>-->
<!---->
<!--				<div class="col-lg-3 col-md-3 col-6">-->
<!--					<div class="single-funfact">-->
<!--						<div class="icon">-->
<!--							<i class='bx bxl-deviantart'></i>-->
<!--						</div>-->
<!--						<h3 style="direction: ltr;" class="odometer" data-count="654">00</h3>-->
<!--						<p>رویداد خلاقانه</p>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!---->
<!--			<div id="particles-js-circle-bubble"></div>-->
<!--		</div>-->
<!--	</div>-->
<!--</section>-->
<!--<!-- End Funfacts Area -->-->
<!--<br>-->
<!--<br>-->
<!--<!-- Start Partner Area -->-->
<!--<section class="partner-area pb-100">-->
<!--	<div class="container">-->
<!--		<div class="section-title">-->
<!--			<h2>شرکت و همکاران ما</h2>-->
<!--		</div>-->
<!---->
<!--		<div class="partner-slides owl-carousel owl-theme">-->
<!--			<div class="single-partner-item">-->
<!--				<a href="#" class="d-block">-->
<!--					<img src="assets/img/partner/7.png" alt="image">-->
<!--				</a>-->
<!--			</div>-->
<!---->
<!--			<div class="single-partner-item">-->
<!--				<a href="#" class="d-block">-->
<!--					<img src="assets/img/partner/8.png" alt="image">-->
<!--				</a>-->
<!--			</div>-->
<!---->
<!--			<div class="single-partner-item">-->
<!--				<a href="#" class="d-block">-->
<!--					<img src="assets/img/partner/9.png" alt="image">-->
<!--				</a>-->
<!--			</div>-->
<!---->
<!--			<div class="single-partner-item">-->
<!--				<a href="#" class="d-block">-->
<!--					<img src="assets/img/partner/10.png" alt="image">-->
<!--				</a>-->
<!--			</div>-->
<!---->
<!--			<div class="single-partner-item">-->
<!--				<a href="#" class="d-block">-->
<!--					<img src="assets/img/partner/11.png" alt="image">-->
<!--				</a>-->
<!--			</div>-->
<!---->
<!--			<div class="single-partner-item">-->
<!--				<a href="#" class="d-block">-->
<!--					<img src="assets/img/partner/12.png" alt="image">-->
<!--				</a>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</section>-->
<!-- End Partner Area -->

<!-- Start Become Instructor & Partner Area -->
<!--        <section class="become-instructor-partner-area">-->
<!--            <div class="container-fluid">-->
<!--                <div class="row">-->
<!--                    <div class="col-lg-6 col-md-6">-->
<!--                        <div class="become-instructor-partner-content bg-color">-->
<!--                            <h2>تبدیل به یک مربی شوید</h2>-->
<!--                            <p>از میان صدها دوره رایگان انتخاب کنید یا مدرک را با قیمت دستیابی به موفقیت کسب کنید. با سرعت خود بیاموزید.</p>-->
<!--                            <a href="login.html" class="default-btn"><i class='bx bx-plus-circle icon-arrow before'></i><span class="label">اکنون بپذیر</span><i class="bx bx-plus-circle icon-arrow after"></i></a>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="col-lg-6 col-md-6">-->
<!--                        <div class="become-instructor-partner-image bg-image1 jarallax" data-jarallax='{"speed": 0.3}'>-->
<!--                            <img src="assets/img/become-instructor.jpg" alt="image">-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="col-lg-6 col-md-6">-->
<!--                        <div class="become-instructor-partner-image bg-image2 jarallax" data-jarallax='{"speed": 0.3}'>-->
<!--                            <img src="assets/img/become-partner.jpg" alt="image">-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="col-lg-6 col-md-6">-->
<!--                        <div class="become-instructor-partner-content">-->
<!--                            <h2>شریک شدن</h2>-->
<!--                            <p>از میان صدها دوره رایگان انتخاب کنید یا مدرک را با قیمت دستیابی به موفقیت کسب کنید. با سرعت خود بیاموزید.</p>-->
<!--                            <a href="login.html" class="default-btn"><i class='bx bx-plus-circle icon-arrow before'></i><span class="label"> ما</span><i class="bx bx-plus-circle icon-arrow after"></i></a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->
<!-- End Become Instructor & Partner Area -->

<!-- Start Testimonials Area -->
<!--        <section class="testimonials-area pt-100">-->
<!--            <div class="container">-->
<!--                <div class="section-title">-->
<!--                    <span class="sub-title">مشتریان</span>-->
<!--                    <h2>آنچه دانشجویان می گویند</h2>-->
<!--                </div>-->

<!--                <div class="testimonials-slides owl-carousel owl-theme">-->
<!--                    <div class="single-testimonials-item">-->
<!--                        <p>لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است. لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است.</p>-->

<!--                        <div class="info">-->
<!--                            <img src="assets/img/user1.jpg" class="shadow rounded-circle" alt="image">-->
<!--                            <h3>جان اسمیت</h3>-->
<!--                            <span>دانشجو</span>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="single-testimonials-item">-->
<!--                        <p>لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است. لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است.</p>-->

<!--                        <div class="info">-->
<!--                            <img src="assets/img/user2.jpg" class="shadow rounded-circle" alt="image">-->
<!--                            <h3>جان اسمیت</h3>-->
<!--                            <span>دانشجو</span>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="single-testimonials-item">-->
<!--                        <p>لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است. لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است.</p>-->

<!--                        <div class="info">-->
<!--                            <img src="assets/img/user3.jpg" class="shadow rounded-circle" alt="image">-->
<!--                            <h3>جان اسمیت</h3>-->
<!--                            <span>دانشجو</span>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="single-testimonials-item">-->
<!--                        <p>لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است. لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد. لورم ایپسوم به مدت 40 سال استاندارد صنعت بوده است.</p>-->

<!--                        <div class="info">-->
<!--                            <img src="assets/img/user4.jpg" class="shadow rounded-circle" alt="image">-->
<!--                            <h3>جان اسمیت</h3>-->
<!--                            <span>دانشجو</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->
<!-- End Testimonials Area -->

<!-- Start Blog Area -->
<!--        <section class="blog-area pt-100 pb-70">-->
<!--            <div class="container">-->
<!--                <div class="section-title text-left">-->
<!--                    <span class="sub-title">اخبار را کاوش کنید</span>-->
<!--                    <h2>آخرین اخبار ما</h2>-->
<!--                    <a href="blog-style-1.html" class="default-btn"><i class='bx bx-book-reader icon-arrow before'></i><span class="label">خواندن همه</span><i class="bx bx-book-reader icon-arrow after"></i></a>-->
<!--                </div>-->

<!--                <div class="blog-slides owl-carousel owl-theme">-->
<!--                    <div class="single-blog-post mb-30">-->
<!--                        <div class="post-image">-->
<!--                            <a href="single-blog.html" class="d-block">-->
<!--                                <img src="assets/img/blog/1.jpg" alt="image">-->
<!--                            </a>-->

<!--                            <div class="tag">-->
<!--                                <a href="#">یادگیری</a>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="post-content">-->
<!--                            <ul class="post-meta">-->
<!--                                <li class="post-author">-->
<!--                                    <img src="assets/img/user1.jpg" class="d-inline-block rounded-circle mr-2" alt="image">-->
<!--                                    توسط: <a href="#" class="d-inline-block">استیون اسمیت</a>-->
<!--                                </li>-->
<!--                                <li><a href="#">30 دی 1398</a></li>-->
<!--                            </ul>-->
<!--                            <h3><a href="single-blog.html" class="d-inline-block">لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد.</a></h3>-->
<!--                            <a href="single-blog.html" class="read-more-btn">ادامه خواندن <i class='bx bx-left-arrow-alt'></i></a>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="single-blog-post mb-30">-->
<!--                        <div class="post-image">-->
<!--                            <a href="single-blog.html" class="d-block">-->
<!--                                <img src="assets/img/blog/2.jpg" alt="image">-->
<!--                            </a>-->

<!--                            <div class="tag">-->
<!--                                <a href="#">آموزشی</a>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="post-content">-->
<!--                            <ul class="post-meta">-->
<!--                                <li class="post-author">-->
<!--                                    <img src="assets/img/user2.jpg" class="d-inline-block rounded-circle mr-2" alt="image">-->
<!--                                    توسط: <a href="#" class="d-inline-block">استیون اسمیت</a>-->
<!--                                </li>-->
<!--                                <li><a href="#">30 دی 1398</a></li>-->
<!--                            </ul>-->
<!--                            <h3><a href="single-blog.html" class="d-inline-block">لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد.</a></h3>-->
<!--                            <a href="single-blog.html" class="read-more-btn">ادامه خواندن <i class='bx bx-left-arrow-alt'></i></a>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="single-blog-post mb-30">-->
<!--                        <div class="post-image">-->
<!--                            <a href="single-blog.html" class="d-block">-->
<!--                                <img src="assets/img/blog/3.jpg" alt="image">-->
<!--                            </a>-->

<!--                            <div class="tag">-->
<!--                                <a href="#">مدیریت</a>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="post-content">-->
<!--                            <ul class="post-meta">-->
<!--                                <li class="post-author">-->
<!--                                    <img src="assets/img/user3.jpg" class="d-inline-block rounded-circle mr-2" alt="image">-->
<!--                                    توسط: <a href="#" class="d-inline-block">استیون اسمیت</a>-->
<!--                                </li>-->
<!--                                <li><a href="#">30 دی 1398</a></li>-->
<!--                            </ul>-->
<!--                            <h3><a href="single-blog.html" class="d-inline-block">لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد.</a></h3>-->
<!--                            <a href="single-blog.html" class="read-more-btn">ادامه خواندن <i class='bx bx-left-arrow-alt'></i></a>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="single-blog-post mb-30">-->
<!--                        <div class="post-image">-->
<!--                            <a href="single-blog.html" class="d-block">-->
<!--                                <img src="assets/img/blog/4.jpg" alt="image">-->
<!--                            </a>-->

<!--                            <div class="tag">-->
<!--                                <a href="#">ایده یابی</a>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="post-content">-->
<!--                            <ul class="post-meta">-->
<!--                                <li class="post-author">-->
<!--                                    <img src="assets/img/user5.jpg" class="d-inline-block rounded-circle mr-2" alt="image">-->
<!--                                    توسط: <a href="#" class="d-inline-block">استیون اسمیت</a>-->
<!--                                </li>-->
<!--                                <li><a href="#">30 دی 1398</a></li>-->
<!--                            </ul>-->
<!--                            <h3><a href="single-blog.html" class="d-inline-block">لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد.</a></h3>-->
<!--                            <a href="single-blog.html" class="read-more-btn">ادامه خواندن <i class='bx bx-left-arrow-alt'></i></a>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="single-blog-post mb-30">-->
<!--                        <div class="post-image">-->
<!--                            <a href="single-blog.html" class="d-block">-->
<!--                                <img src="assets/img/blog/5.jpg" alt="image">-->
<!--                            </a>-->

<!--                            <div class="tag">-->
<!--                                <a href="#">کار و مهارت</a>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="post-content">-->
<!--                            <ul class="post-meta">-->
<!--                                <li class="post-author">-->
<!--                                    <img src="assets/img/user6.jpg" class="d-inline-block rounded-circle mr-2" alt="image">-->
<!--                                    توسط: <a href="#" class="d-inline-block">استیون اسمیت</a>-->
<!--                                </li>-->
<!--                                <li><a href="#">30 دی 1398</a></li>-->
<!--                            </ul>-->
<!--                            <h3><a href="single-blog.html" class="d-inline-block">لورم ایپسوم به سادگی ساختار چاپ و متن را در بر می گیرد.</a></h3>-->
<!--                            <a href="single-blog.html" class="read-more-btn">ادامه خواندن <i class='bx bx-left-arrow-alt'></i></a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->
<!-- End Blog Area -->


<?php else: ?>
	<?php
	if (!empty($yield)) {
		$this->load->view('yields/' . $yield);
	} else {
		$this->load->view('yields/dashboard');
	}
	?>
<?php endif; ?>
<!-- Start Footer Area -->
<footer class="footer-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-6 col-sm-6">
				<div class="single-footer-widget mb-30">
					<h3>تماس بگیرید</h3>

					<ul class="contact-us-link">
						<li>
							<i class='bx bx-map'></i>
							<a href="#" target="_blank">کشور شما ، استان و شهر شما ، محله و منطقه شما</a>
						</li>
						<li>
							<i class='bx bx-phone-call'></i>
							<a href="#">021-12345678</a>
						</li>
						<li>
							<i class='bx bx-envelope'></i>
							<a href="#">hello@raque.com</a>
						</li>
					</ul>

					<ul class="social-link">
						<li><a href="#" class="d-block" target="_blank"><i class='bx bxl-facebook'></i></a></li>
						<li><a href="#" class="d-block" target="_blank"><i class='bx bxl-twitter'></i></a></li>
						<li><a href="#" class="d-block" target="_blank"><i class='bx bxl-instagram'></i></a></li>
						<li><a href="#" class="d-block" target="_blank"><i class='bx bxl-linkedin'></i></a></li>
						<li><a href="#" class="d-block" target="_blank"><i class='bx bxl-pinterest-alt'></i></a></li>
					</ul>
				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6">
				<div class="single-footer-widget mb-30">
					<h3>پشتیبانی</h3>

					<ul class="support-link">
						<li><a href="#">حریم خصوصی</a></li>
						<li><a href="#">سوالات متداول</a></li>
						<li><a href="#">پشتیبانی</a></li>
						<li><a href="#">قوانین</a></li>
						<li><a href="#">شرایط و ضوابط</a></li>
						<li><a href="#">مقررات</a></li>
					</ul>
				</div>
			</div>

			<div class="col-lg-2 col-md-6 col-sm-6">
				<div class="single-footer-widget mb-30">
					<h3>لینکهای مفید</h3>

					<ul class="useful-link">
						<li><a href="#">طراحی وب</a></li>
						<li><a href="#">طراحی رابط کاربری</a></li>
						<li><a href="#">توسعه دهنده</a></li>
						<li><a href="#">برنامه وب</a></li>
						<li><a href="#">خبرنامه</a></li>
						<li><a href="#">توسعه یاب</a></li>
					</ul>
				</div>
			</div>

			<div class="col-lg-4 col-md-6 col-sm-6">
				<div class="single-footer-widget mb-30">
					<h3>خبرنامه</h3>

					<div class="newsletter-box">
						<p>برای دریافت آخرین اخبار و آخرین به روزرسانی های ما</p>

						<form class="newsletter-form" data-toggle="validator">
							<label>ایمیل شما:</label>
							<input type="email" class="input-newsletter" placeholder="ایمیل خود را وارد کنید" name="EMAIL" required autocomplete="off">
							<button type="submit">مشترک شدن</button>
							<div id="validator-newsletter" class="form-result"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="footer-bottom-area">
		<div class="container">
			<div class="logo">
				<a href="index.html" class="d-inline-block"><img src="assets/img/logo.png" alt="image"></a>
			</div>
			<p>کپی رایت 1399 <i class='bx bx-copyright'></i> تمام حقوق قالب محفوظ است. طراحی و توسعه توسط <a href="https://www.rtl-theme.com/author/barat/?aff=barat" target="_blank">Barat Hadian</a></p>
		</div>
	</div>
</footer>
<!-- End Footer Area -->

<div class="go-top"><i class='bx bx-up-arrow-alt'></i></div>

<!-- Links of JS files -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/mixitup.min.js"></script>
<script src="assets/js/parallax.min.js"></script>
<script src="assets/js/jquery.appear.min.js"></script>
<script src="assets/js/odometer.min.js"></script>
<script src="assets/js/particles.min.js"></script>
<script src="assets/js/meanmenu.min.js"></script>
<script src="assets/js/jquery.nice-select.min.js"></script>
<script src="assets/js/viewer.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/jquery.ajaxchimp.min.js"></script>
<script src="assets/js/form-validator.min.js"></script>
<script src="assets/js/contact-form-script.js"></script>
<script src="assets/js/main.js"></script>
</body>

</html>
