<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
<title>خطای دسترسی</title>
<!-- Bootstrap Core CSS -->
<link href="<?php echo base_url(); ?>portal/assets/bower_components/bootstrap-rtl-master/dist/css/bootstrap-rtl.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="<?php echo base_url(); ?>portal/assets/css/animate.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="<?php echo base_url(); ?>portal/assets/css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="<?php echo base_url(); ?>portal/assets/css/colors/default.css" id="theme"  rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body>
<!-- Preloader -->

<section id="wrapper" class="error-page">
  <div class="error-box">
    <div class="error-body text-center">
      <h1 class="text-info">403</h1>
      <h3 class="text-uppercase">خطای دسترسی</h3>
      <p class="text-muted m-t-30 m-b-30 text-uppercase">شما اجازه دسترسی به این قسمت را ندارید</p>
      <?php if($this->session->flashdata('warning-msg')): ?>
        <p class="text-bold text-warning m-t-30 m-b-30 text-uppercase"><?php echo htmlspecialchars($this->session->flashdata('warning-msg', ENT_QUOTES)); ?></p>
      <?php else: ?>
        <p class="text-muted m-t-30 m-b-30 text-uppercase">لطفا ابتدا دارد شوید</p>
      <?php endif; ?>
      <a href="<?php echo base_url(); ?>portal" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">ورود</a>
	</div>
    <footer class="footer text-center">کپی رایت 1398 © همه حقوق برای شرکت یوتاب پارس محفوظ است.</footer>
  </div>
</section>
<!-- jQuery -->
<script src="<?php echo base_url(); ?>portal/assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>portal/assets/bower_components/bootstrap-rtl-master/dist/js/bootstrap-rtl.min.js"></script>


</body>
</html>
