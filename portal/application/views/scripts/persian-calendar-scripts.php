
<!-- for input start_date and input birthday -->
<script type="text/javascript" src="<?= base_url(); ?>assets/persian-calendar/persian-date.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/persian-calendar/persian-datepicker.min.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('.auto-close-example').pDatepicker({
			"format": "YYYY-MM-DD",
			initialValue: false,
			viewMode: 'year',
			autoClose: true,
			checkYear: function(year){
				return year >= 1300;
			}
		});
	});
</script>
<!-- end -->

<!-- Times in page create new course -->
<script src="<?= base_url(); ?>assets/test/timepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
	var time6 = document.getElementById('fri_clock');
	var time5 = document.getElementById('thu_clock');
	var time4 = document.getElementById('wed_clock');
	var time3 = document.getElementById('tue_clock');
	var time2 = document.getElementById('mon_clock');
	var time1 = document.getElementById('sun_clock');
	var timepicker = new TimePicker(['sat_clock', 'sun_clock', 'mon_clock', 'tue_clock', 'wed_clock', 'thu_clock', 'fri_clock'], {
		lang: 'en',
		theme: 'dark',
	});
	timepicker.on('change', function (evt) {
		var value = (evt.hour || '00') + ':' + (evt.minute || '00');

		if (evt.element.id === 'fri_clock') {
			time6.value = value;
		}else if (evt.element.id === 'thu_clock') {
			time5.value = value;
		}else if (evt.element.id === 'wed_clock') {
			time4.value = value;
		}else if (evt.element.id === 'tue_clock') {
			time3.value = value;
		}else if (evt.element.id === 'mon_clock') {
			time2.value = value;
		} else if (evt.element.id === 'sun_clock') {
			time1.value = value;
		} else {
			evt.element.value = value;
		}
	});
</script>
<!-- end -->

<!-- for input days -->
<!--<script src="--><?//= base_url(); ?><!--assets/test/bootstrap-datetimepicker.min.js" type="text/javascript"></script>-->
<!--<script type="text/javascript">-->
<!--	$(function () {-->
<!--		$('#datetimepicker0').datetimepicker({-->
<!--			format: "hh:mm",-->
<!--			pickDate: false,-->
<!--			enableRTL: true-->
<!--			// orientation: left,-->
<!--		});-->
<!--		$('#datetimepicker1').datetimepicker({-->
<!--			"format": "hh:mm",-->
<!--			pickDate: false-->
<!--		});-->
<!--		$('#datetimepicker2').datetimepicker({-->
<!--			"format": "hh:mm",-->
<!--			pickDate: false-->
<!--		});-->
<!--		$('#datetimepicker3').datetimepicker({-->
<!--			"format": "hh:mm",-->
<!--			pickDate: false-->
<!--		});-->
<!--		$('#datetimepicker4').datetimepicker({-->
<!--			"format": "hh:mm",-->
<!--			pickDate: false-->
<!--		});-->
<!--		$('#datetimepicker5').datetimepicker({-->
<!--			"format": "hh:mm",-->
<!--			pickDate: false-->
<!--		});-->
<!--		$('#datetimepicker6').datetimepicker({-->
<!--			"format": "hh:mm",-->
<!--			pickDate: false-->
<!--		});-->
<!--	});-->
<!--</script>-->
<!-- end -->


