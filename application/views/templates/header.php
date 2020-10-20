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