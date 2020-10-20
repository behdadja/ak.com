<!DOCTYPE html>
<html lang="fa-IR" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!--title-->
    <title><?php
        if (!empty($title)) {
            echo htmlspecialchars($title, ENT_QUOTES);
        }
        ?></title>
    <!-- description -->
    <meta name="description" content="اولين سامانه مديريت آموزشگاه در ايران با امکانات وسيع و آسان، آموزکده، آموزش مجازی amoozkadeh">
    <!-- keywords -->
    <meta name="keywords" content="amoozkadeh، آموزش مجازی، ویدئو کنفرانس، فنی و حرفه ای، آموزشگاه زبان، آموزشگاه هنر ،آموزکده، مديريت آموزشگاه، حسابداري آموزشگاه، اپليکيشن آموزشگاه ، دوره، آموزش، شيراز، بهترين آموزشگاه شيراز، بهترين استاد شيراز، جديدترين دوره ها، آموزش برنامه نويسي ">
    <!--google meta tags-->
    <meta name="language" content="persian">
    <meta name="google" content="notranslate">
    <link rel="canonical" href="https://www.amoozkadeh.com" >
    <!--theme-color-->
    <meta name="theme-color" content="#17CEC4">
    <!-- favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="https://amoozkadeh.com/assets/favicon/favicon.ico">

    <meta property="og:site_name" content="آموزکده">
    <meta property="og:title" content="آموزکده، مديريت اموزشگاه، حسابداري آموزشگاه، اپليکيشن آموزشگاه، آموزش مجازی amoozkadeh ، دوره، آموزش، شيراز، ">
    <meta property="og:description" content="آموزکده، مديريت اموزشگاه، حسابداري آموزشگاه، اپليکيشن آموزشگاه، amoozkadeh ، دوره، آموزش، شيراز، بهترين آموزشگاه شيراز، بهترين استاد شيراز، جديدترين دوره ها، آموزش برنامه نويسي">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.amoozkadeh.com">
    <meta property="og:image" content="https://www.amoozkadeh.com/images/admin_logo.png">
    <meta property="og:locale" content="fa_IR">

    <meta name="twitter:widgets:csp" content="on">
    <meta name="twitter:title" content="آموزکده، مديريت اموزشگاه، حسابداري آموزشگاه، اپليکيشن آموزشگاه، amoozkadeh ، دوره، آموزش، شيراز،">
    <meta name="twitter:description" content="آموزکده، مديريت اموزشگاه، حسابداري آموزشگاه، اپليکيشن آموزشگاه، amoozkadeh ، دوره، آموزش، شيراز، بهترين آموزشگاه شيراز، بهترين استاد شيراز، جديدترين دوره ها، آموزش برنامه نويسي">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@amoozkadeh">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="آموزکده">
    <meta name="apple-mobile-web-app-title" content="آموزکده">
    <meta name="msapplication-navbutton-color" content="#201C40">
    <meta name="apple-mobile-web-app-status-bar-style" content="#201C40">

    <meta name="google-site-verification" content="KCa7dyVJHFakfCG10DpqXIOl2CIuytk6QOLURKfBp1M" >

    <!--/////////////////////////// home \\\\\\\\\\\\\\\\\\\\\\\\\\\\-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <!-- box for upload pictures -->
    <link href="<?php echo base_url(); ?>portal/assets/bower_components/dropify/dist/css/dropify.min.css" rel="stylesheet">

    <!-- register form multi step -->
    <link href="<?php echo base_url(); ?>assets/css/newCascadeStyleSheet.css" rel="stylesheet" type="text/css">

    <!-- Perfect Scrollbar -->
    <link type="text/css" href="<?php echo base_url(); ?>assets/vendor/perfect-scrollbar.css" rel="stylesheet">

    <!-- Fix Footer CSS -->
    <link type="text/css" href="<?php echo base_url(); ?>assets/vendor/fix-footer.css" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="<?php echo base_url(); ?>assets/css/material-icons.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link type="text/css" href="<?php echo base_url(); ?>assets/css/fontawesome.css" rel="stylesheet">

    <!-- Preloader -->
    <link type="text/css" href="<?php echo base_url(); ?>assets/css/preloader.css" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="<?php echo base_url(); ?>assets/css/app.css" rel="stylesheet">


    <!-- slider header and academy -->
    <!--        <link href="<?php echo base_url(); ?>assets/slider/css/uikit-rtl.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/slider/css/uikit-rtl.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/slider/css/uikit.css" rel="stylesheet" type="text/css"/>-->
    <link href="<?php echo base_url(); ?>assets/slider/css/uikit.min.css" rel="stylesheet" type="text/css">

    <!-- for modals -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <!-- for modal pictures in pages guide -->
    <link href="<?php echo base_url(); ?>assets/css/w3.css" rel="stylesheet" type="text/css">

    <?php
    if (!empty($links)) {
        $this->load->view('links/' . $links);
    }
    ?>
    <?php
    if (!empty($secondLinks)) {
        $this->load->view('links/' . $secondLinks);
    }
    ?>
    <?php
    if (!empty($thirdLinks)) {
        $this->load->view('links/' . $thirdLinks);
    }
    ?>

</head>


<body>


<!DOCTYPE html>
<html lang="en">


<style>
    /* for modal / bug fix - no overlay */
    .modal-backdrop {
        display: none;
    }

</style>
<style>
    .button{
        margin-bottom: 10px;
    }
</style>
<style>
    .back{
        background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('images/about-us.jpg');
        -webkit-background-size: cover;
        -moz-background-size:  cover;
        -o-background-size: cover;
        background-size: cover;
    }
</style>
<?php if ($this->session->flashdata('authentication') || $this->session->flashdata('error-validation') || $this->session->flashdata('fail')) {?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#form').modal('show');
        });
    </script>
<?php } ?>
<body class="back">
<br><br><br><br>
<div class="container p-3 my-6 border text-center bg-dark col-lg-3" >
    <form class="form" action="<?= base_url('numCheck'); ?>" method="post">
        <!--				<form name="phoneNum" action="--><?//= base_url('')?><!--" method="post">-->
        <div class="container p-6 my-6 text-center bg-dark m-2">
            <label for="phone" class="text-light ">کدملی را وارد نمایید</label>
        </div>

        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		<input type="text" class="form-control" name='na_code' placeholder="کد ملی " onKeyPress="if (this.value.length == 10) return false;" max="9999999999"> <span class="glyphicon glyphicon-ok form-control-feedback"></span>
        <br>
        <button type="submit" name="submit" class="btn btn-info btn-lg btn m-20pt " >ارسال کد</button>
    </form>
</div>


<!-- modal -->
<div class="w3-modal bd-example-modal-lg" id="form" style="background-color: rgba(0,0,0,0.8)" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">


            <?php if ($this->session->flashdata('authentication')):?>
                <div class="modal-header">
                    <h4 class="col-12 modal-title text-center">
                        <span>کد ارسال شده را وارد نمایید</span>
                    </h4>
                </div>
			<div class="modal-body">
                <form method="post" action="<?= base_url('isValid')?>">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input type="text" name="validate_code" placeholder="****" <?php if($this->session->userdata('code')){ echo 'value="'.$this->session->userdata('code')['otp'].'"';}?>>
                    <div>
                        <button type="submit" style="margin: auto" class="btn btn-block btn-success mt-2" >تایید</button>
                    </div>

                </form>
<!--                <br>-->
<!--                --><?php
//                $ok = $this->session->userdata('code');
//                echo $ok['otp'];
//                ?>
			</div>
            <?php elseif ($this->session->flashdata('error-validation')):?>
                <div class="modal-header">
                    <h4 class="col-12 modal-title text-center">
                        <span>شما به این قسمت دسترسی ندارید</span>
                    </h4>
                </div>

            <?php elseif ($this->session->flashdata('fail')):?>
                <div class="modal-header">
                    <h4 class="col-12 modal-title text-center">
                        <span>ورودی نامعتبر</span>
                    </h4>
                </div>

            <?Php endif; ?>
            <div class="modal-footer">
                <button type="button" style="margin: auto" class="btn btn-block btn-info" data-dismiss="modal">انصراف</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- / modal for demo -->

<!--/////////////////////////// home \\\\\\\\\\\\\\\\\\\\\\\\\\\\-->

<script src="<?php echo base_url(); ?>assets/bower_components/dropify/dist/js/dropify.min.js"></script>

<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>assets/vendor/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap.min.js"></script>

<!-- Perfect Scrollbar -->
<script src="<?php echo base_url(); ?>assets/vendor/perfect-scrollbar.min.js"></script>

<!-- DOM Factory -->
<script src="<?php echo base_url(); ?>assets/vendor/dom-factory.js"></script>

<!-- MDK -->
<script src="<?php echo base_url(); ?>assets/vendor/material-design-kit.js"></script>

<!-- Fix Footer -->
<script src="<?php echo base_url(); ?>assets/vendor/fix-footer.js"></script>

<!-- Chart.js -->
<script src="<?php echo base_url(); ?>assets/vendor/Chart.min.js"></script>

<!-- App JS -->
<script src="<?php echo base_url(); ?>assets/js/app.js"></script>

<!-- Highlight.js -->
<script src="<?php echo base_url(); ?>assets/js/hljs.js"></script>

<!-- slider header and academys -->
<script src="<?php echo base_url(); ?>assets/slider/js/uikit-icons.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/slider/js/uikit-icons.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/slider/js/uikit.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/slider/js/uikit.min.js" type="text/javascript"></script>

<!-- for modal courses -->
<script src="<?php echo base_url(); ?>assets/js/dropdown-script.js" type="text/javascript"></script>
<!-- JS for timer register -->
<script src="<?php echo base_url(); ?>assets/js/timer-scripts.js" type="text/javascript"></script>



<?php
if (!empty($scripts)) {
    $this->load->view('scripts/' . $scripts);
}
if (!empty($secondScripts)) {
    $this->load->view('scripts/' . $secondScripts);
}
if (!empty($thirdScripts)) {
    $this->load->view('scripts/' . $thirdScripts);
}
?>

<!---start GOFTINO code--->
<script type="text/javascript">
    !function(){var a=window,d=document;function g(){var g=d.createElement("script"),s="https://www.goftino.com/widget/5gCcDG",l=localStorage.getItem("goftino");g.type="text/javascript",g.async=!0,g.src=l?s+"?o="+l:s;d.getElementsByTagName("head")[0].appendChild(g);}"complete"===d.readyState?g():a.attachEvent?a.attachEvent("onload",g):a.addEventListener("load",g,!1);}();
</script>
<!---end GOFTINO code--->

</body>
</html>
