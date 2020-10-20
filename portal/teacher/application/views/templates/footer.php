<!-- All Jquery -->
<!-- ============================================================== -->

<script src="<?php echo base_url();?>student/assets/bower_components/jquery/dist/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		$("button#inquiry_btn").click(function(z){

			var data = $("form#inquiry-form").serialize();
			$.ajax({
				type: "post",
				dataType: 'json',
				url: '<?php echo base_url(); ?>profile/inquiry',
				data: data,
				success: function(data){
					if (data.exist){
						$("div#inq_res").css('display', 'block');
						setTimeout(function() { $("div#inq_res").hide(); }, 3);
						// location.reload(true);
					}if(data.notexist){
						$("div#inq_table").css('display', 'none');
						$("div#pre_register_table").css('display', 'block');
					}
				}
			});
		});
	})
</script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url();?>student/assets/bower_components/bootstrap-rtl-master/dist/js/bootstrap-rtl.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="<?php echo base_url();?>student/assets/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
<!--slimscroll JavaScript -->
<script src="<?php echo base_url();?>student/assets/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?php echo base_url();?>student/assets/js/waves.js"></script>
<!--Counter js -->
<script src="<?php echo base_url();?>student/assets/bower_components/waypoints/lib/jquery.waypoints.js"></script>
<script src="<?php echo base_url();?>student/assets/bower_components/counterup/jquery.counterup.min.js"></script>
<!--Morris JavaScript -->
<script src="<?php echo base_url();?>student/assets/bower_components/raphael/raphael-min.js"></script>
<script src="<?php echo base_url();?>student/assets/bower_components/morrisjs/morris.js"></script>
<!-- chartist chart -->

<!-- Calendar JavaScript -->
<script src="<?php echo base_url();?>student/assets/bower_components/moment/moment.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url();?>student/assets/js/custom.min.js"></script>
<!-- Custom tab JavaScript -->
<script src="<?php echo base_url();?>student/assets/js/cbpFWTabs.js"></script>
<?php if(!empty($scripts)){$this->load->view('scripts/'.$scripts);} ?>
<?php if(!empty($secondScripts)){$this->load->view('scripts/'.$secondScripts);} ?>
<?php if(!empty($thirdScripts)){$this->load->view('scripts/'.$thirdScripts);} ?>
<script type="text/javascript">
    (function () {
            [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
            new CBPFWTabs(el);
        });
    })();
</script>
<script src="<?php echo base_url();?>student/assets/bower_components/toast-master/js/jquery.toast.js"></script>
<!--Style Switcher -->

</body>

</html>
