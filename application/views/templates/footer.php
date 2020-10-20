
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