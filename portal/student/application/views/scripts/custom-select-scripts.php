
<script src="<?php echo base_url(); ?>assets/bower_components/switchery/dist/switchery.min.js"></script>
<script>
    jQuery(document).ready(function () {
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());
        });

        const sat_check = $("#sat_check");
        const sun_check = $("#sun_check");
        const mon_check = $("#mon_check");
        const tue_check = $("#tue_check");
        const wed_check = $("#wed_check");
        const thu_check = $("#thu_check");
        sat_check.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="sat_clock"]').prop("disabled", false);
            } else {
                $('form input[id="sat_clock"]').prop("disabled", true);
            }
        });
        sun_check.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="sun_clock"]').prop("disabled", false);
            } else {
                $('form input[id="sun_clock"]').prop("disabled", true);
            }
        });
        mon_check.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="mon_clock"]').prop("disabled", false);
            } else {
                $('form input[id="mon_clock"]').prop("disabled", true);
            }
        });
        tue_check.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="tue_clock"]').prop("disabled", false);
            } else {
                $('form input[id="tue_clock"]').prop("disabled", true);
            }
        });
        wed_check.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="wed_clock"]').prop("disabled", false);
            } else {
                $('form input[id="wed_clock"]').prop("disabled", true);
            }
        });
        thu_check.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="thu_clock"]').prop("disabled", false);
            } else {
                $('form input[id="thu_clock"]').prop("disabled", true);
            }
        });
    });
</script>
