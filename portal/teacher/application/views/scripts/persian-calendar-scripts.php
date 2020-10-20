<!--<script type="text/javascript" src="--><?php //echo base_url(); ?><!--assets/persian-calendar/persian-date.min.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo base_url(); ?><!--assets/persian-calendar/persian-datepicker.min.js"></script>-->
<!--<script type="text/javascript">-->
<!--  $(document).ready(function() {-->
<!--    $(".start-date").pDatepicker({-->
<!--      "format": "YYYY-MM-DD",-->
<!--      "autoClose": true,-->
<!--      "onlyTimePicker": false,-->
<!--      "onlySelectOnDate": true,-->
<!--      "calendarType": "persian",-->
<!--      "inputDelay": 800,-->
<!--      "observer": false,-->
<!--      "calendar": {-->
<!--        "persian": {-->
<!--          "locale": "en",-->
<!--          "showHint": true,-->
<!--          "leapYearMode": "algorithmic"-->
<!--        }-->
<!--      },-->
<!--      "navigator": {-->
<!--        "enabled": true,-->
<!--        "scroll": {-->
<!--          "enabled": true-->
<!--        },-->
<!--        "text": {-->
<!--          "btnNextText": "<",-->
<!--          "btnPrevText": ">"-->
<!--        }-->
<!--      }-->
<!--    });-->
<!--	  $(".birth-date").pDatepicker({-->
<!--		  "format": "YYYY-MM-DD",-->
<!--		  "autoClose": true,-->
<!--		  "onlyTimePicker": false,-->
<!--		  "onlySelectOnDate": true,-->
<!--		  "calendarType": "persian",-->
<!--		  "inputDelay": 800,-->
<!--		  "observer": false,-->
<!--		  "calendar": {-->
<!--			  "persian": {-->
<!--				  "locale": "en",-->
<!--				  "showHint": true,-->
<!--				  "leapYearMode": "algorithmic"-->
<!--			  }-->
<!--		  },-->
<!--		  "navigator": {-->
<!--			  "enabled": true,-->
<!--			  "scroll": {-->
<!--				  "enabled": true-->
<!--			  },-->
<!--			  "text": {-->
<!--				  "btnNextText": "<",-->
<!--				  "btnPrevText": ">"-->
<!--			  }-->
<!--		  }-->
<!--	  });-->
<!--  });-->
<!--</script>-->
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


    <?php if($this->session->userdata('shift_status') != 3): ?>
    var time6 = document.getElementById('fri_clock');
    var time5 = document.getElementById('thu_clock');
    var time4 = document.getElementById('wed_clock');
    var time3 = document.getElementById('tue_clock');
    var time2 = document.getElementById('mon_clock');
    var time1 = document.getElementById('sun_clock');
    var time0 = document.getElementById('sat_clock');

    var timepicker = new TimePicker(['sat_clock', 'sun_clock', 'mon_clock', 'tue_clock', 'wed_clock', 'thu_clock', 'fri_clock'], {
        lang: 'en',
        theme: 'dark',
    });
    timepicker.on('change', function (evt) {
        var value = (evt.hour || '00') + ':' + (evt.minute || '00');

        if (evt.element.id === 'fri_clock') {
            time6.value = value;
        } else if (evt.element.id === 'thu_clock') {
            time5.value = value;
        } else if (evt.element.id === 'wed_clock') {
            time4.value = value;
        } else if (evt.element.id === 'tue_clock') {
            time3.value = value;
        } else if (evt.element.id === 'mon_clock') {
            time2.value = value;
        } else if (evt.element.id === 'sun_clock') {
            time1.value = value;
        } else if (evt.element.id === 'sat_clock') {
            time0.value = value;
        }
    });
    <?php else: ?>
    var time6 = document.getElementById('fri_clock');
    var time5 = document.getElementById('thu_clock');
    var time4 = document.getElementById('wed_clock');
    var time3 = document.getElementById('tue_clock');
    var time2 = document.getElementById('mon_clock');
    var time1 = document.getElementById('sun_clock');
    var time0 = document.getElementById('sat_clock');
    var clock6 = document.getElementById('fri_clock_2');
    var clock5 = document.getElementById('thu_clock_2');
    var clock4 = document.getElementById('wed_clock_2');
    var clock3 = document.getElementById('tue_clock_2');
    var clock2 = document.getElementById('mon_clock_2');
    var clock1 = document.getElementById('sun_clock_2');
    var clock0 = document.getElementById('sat_clock_2');

    var timepicker = new TimePicker(['sat_clock', 'sun_clock', 'mon_clock', 'tue_clock', 'wed_clock', 'thu_clock', 'fri_clock',
        'sat_clock_2', 'sun_clock_2', 'mon_clock_2', 'tue_clock_2', 'wed_clock_2', 'thu_clock_2', 'fri_clock_2'], {
        lang: 'en',
        theme: 'dark',
    });
    timepicker.on('change', function (evt) {
        var value = (evt.hour || '00') + ':' + (evt.minute || '00');

        if (evt.element.id === 'fri_clock') {
            time6.value = value;
        } else if (evt.element.id === 'thu_clock') {
            time5.value = value;
        } else if (evt.element.id === 'wed_clock') {
            time4.value = value;
        } else if (evt.element.id === 'tue_clock') {
            time3.value = value;
        } else if (evt.element.id === 'mon_clock') {
            time2.value = value;
        } else if (evt.element.id === 'sun_clock') {
            time1.value = value;
        } else if (evt.element.id === 'sat_clock') {
            time0.value = value;
        } else if (evt.element.id === 'fri_clock_2') {
            clock6.value = value;
        } else if (evt.element.id == 'thu_clock_2') {
            clock5.value = value;
        } else if (evt.element.id == 'wed_clock_2') {
            clock4.value = value;
        } else if (evt.element.id == 'tue_clock_2') {
            clock3.value = value;
        } else if (evt.element.id == 'mon_clock_2') {
            clock2.value = value;
        } else if (evt.element.id == 'sun_clock_2') {
            clock1.value = value;
        } else if (evt.element.id == 'sat_clock_2') {
            clock0.value = value;
        }
    });
    <?php endif; ?>

</script>
