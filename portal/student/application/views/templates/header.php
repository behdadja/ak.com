<!DOCTYPE html>
<html lang="en" dir="rtl">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>student/assets/images/favicon.png">
        <title><?php
            if (!empty($title)) {
                echo htmlspecialchars($title, ENT_QUOTES);
            }
            ?></title>
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url(); ?>student/assets/bower_components/bootstrap-rtl-master/dist/css/bootstrap-rtl.min.css" rel="stylesheet">
        <!-- Menu CSS -->
        <link href="<?php echo base_url(); ?>student/assets/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
        <!-- toast CSS -->
        <link href="<?php echo base_url(); ?>student/assets/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
        <!-- morris CSS -->
        <link href="<?php echo base_url(); ?>student/assets/bower_components/morrisjs/morris.css" rel="stylesheet">
        <!-- chartist CSS -->
        <link href="<?php echo base_url(); ?>student/assets/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>student/assets/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
        <!-- Calendar CSS -->
        <link href="<?php echo base_url(); ?>student/assets/bower_components/calendar/dist/fullcalendar.css" rel="stylesheet" />
        <!-- animation CSS -->
        <link href="<?php echo base_url(); ?>student/assets/css/animate.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?php echo base_url(); ?>student/assets/css/style.css" rel="stylesheet">
        <!-- color CSS -->
        <link href="<?php echo base_url(); ?>student/assets/css/colors/blue-dark.css" id="theme" rel="stylesheet">
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
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        
        <!-- modal online payment -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <a href="../../libraries/jdf.php"></a>
    </head>
