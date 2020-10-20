<!-- All Jquery -->
<!-- ============================================================== -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-rtl-master/dist/js/bootstrap-rtl.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="<?php echo base_url(); ?>assets/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
<!--slimscroll JavaScript -->
<script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?php echo base_url(); ?>assets/js/waves.js"></script>
<!--Counter js -->
<script src="<?php echo base_url(); ?>assets/bower_components/waypoints/lib/jquery.waypoints.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/counterup/jquery.counterup.min.js"></script>
<!--Morris JavaScript -->
<script src="<?php echo base_url(); ?>assets/bower_components/raphael/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/morrisjs/morris.js"></script>
<!-- Calendar JavaScript -->
<script src="<?php echo base_url(); ?>assets/bower_components/moment/moment.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url(); ?>assets/js/custom.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jasny-bootstrap.js"></script>
<!-- Custom tab JavaScript -->
<script src="<?php echo base_url(); ?>assets/js/cbpFWTabs.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/toast-master/js/jquery.toast.js"></script>
<!--Style Switcher -->
<script src="<?php echo base_url(); ?>assets/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
<!-- JS for Form login step by step -->
<script src="<?php echo base_url(); ?>assets/js/login-scripts.js" type="text/javascript"></script>

<script type="text/javascript">
    (function () {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
            new CBPFWTabs(el);
        });
    })();
</script>


<?php
if (!empty($scripts)) {
    $this->load->view('scripts/' . $scripts);
}
?>
<?php
if (!empty($secondScripts)) {
    $this->load->view('scripts/' . $secondScripts);
}
?>
<?php
if (!empty($thirdScripts)) {
    $this->load->view('scripts/' . $thirdScripts);
}
?>

<!---start GOFTINO code--->
<script type="text/javascript">
  !function(){var a=window,d=document;function g(){var g=d.createElement("script"),s="https://www.goftino.com/widget/5gCcDG",l=localStorage.getItem("goftino");g.type="text/javascript",g.async=!0,g.src=l?s+"?o="+l:s;d.getElementsByTagName("head")[0].appendChild(g);}"complete"===d.readyState?g():a.attachEvent?a.attachEvent("onload",g):a.addEventListener("load",g,!1);}();
</script>
<!---end GOFTINO code--->

