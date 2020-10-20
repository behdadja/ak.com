
<!-- for input start_date and input birthday -->
<script type="text/javascript" src="<?php echo base_url(); ?>portal/assets/persian-calendar/persian-date.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>portal/assets/persian-calendar/persian-datepicker.min.js"></script>

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
