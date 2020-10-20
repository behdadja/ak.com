
<script src="<?php echo base_url(); ?>assets/bower_components/switchery/dist/switchery.min.js"></script>

<script>
    jQuery(document).ready(function () {
        // Switchery
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    $('.js-switch').each(function () {
        new Switchery($(this)[0], $(this).data());
    });
        
        const p1 = $("#p1");
        const p2 = $("#p2");
        p1.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="g1"]').prop("disabled", false);
                $('form input[id="g2"]').prop("disabled", true);
            } else {
                $('form input[id="g1"]').prop("disabled", true);
            }
        });
        p2.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="g2"]').prop("disabled", false);
                $('form input[id="g1"]').prop("disabled", true);
            } else {
                $('form input[id="g2"]').prop("disabled", true);
            }
        });
        //for create new course & edit course
        const s1 = $("#s1");
        const s2 = $("#s2");
        s1.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="t1"]').prop("disabled", false);
                $('form input[id="t2"]').prop("disabled", true);
            } else {
                $('form input[id="t1"]').prop("disabled", true);
            }
        });
        s2.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="t2"]').prop("disabled", false);
                $('form input[id="t1"]').prop("disabled", true);
            } else {
                $('form input[id="t2"]').prop("disabled", true);
            }
        });
        const a1 = $("#a1");
        const b1 = $("#b1");
        a1.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="a2"]').prop("disabled", false);
            } else {
                $('form input[id="a2"]').prop("disabled", true);
            }
        });
        b1.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="b2"]').prop("disabled", false);
            } else {
                $('form input[id="b2"]').prop("disabled", true);
            }
        });
        ////////////// چک باکس های سطح دسترسی در ثبت کارمند جدید\\\\\\\\\\\\\\\\\\
        const all_level = $("#all_level");
        const lesson = $("#lesson");
        const classs = $("#classs");
        const course = $("#course");
        const exam = $("#exam");
        const student = $("#student");
        const teacher = $("#teacher");
        const personnel = $("#personnel");
        const financial_std = $("#financial_std");
        const financial_thr = $("#financial_thr");
        const financial_prl = $("#financial_prl");
        const ticket_std = $("#ticket_std");
        const ticket_thr = $("#ticket_thr");
        const ticket_prl = $("#ticket_prl");

        all_level.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="lesson"]').prop("checked", true);
                $('form input[id="classs"]').prop("checked", true);
                $('form input[id="course"]').prop("checked", true);
                $('form input[id="exam"]').prop("checked", true);
                $('form input[id="student"]').prop("checked", true);
                $('form input[id="teacher"]').prop("checked", true);
                $('form input[id="personnel"]').prop("checked", true);
                $('form input[id="financial_std"]').prop("checked", true);
                $('form input[id="financial_thr"]').prop("checked", true);
                $('form input[id="financial_prl"]').prop("checked", true);
                $('form input[id="ticket_std"]').prop("checked", true);
                $('form input[id="ticket_thr"]').prop("checked", true);
                $('form input[id="ticket_prl"]').prop("checked", true);
            } else {
                $('form input[id="lesson"]').prop("checked", false);
                $('form input[id="classs"]').prop("checked", false);
                $('form input[id="course"]').prop("checked", false);
                $('form input[id="exam"]').prop("checked", false);
                $('form input[id="student"]').prop("checked", false);
                $('form input[id="teacher"]').prop("checked", false);
                $('form input[id="personnel"]').prop("checked", false);
                $('form input[id="financial_std"]').prop("checked", false);
                $('form input[id="financial_thr"]').prop("checked", false);
                $('form input[id="financial_prl"]').prop("checked", false);
                $('form input[id="ticket_std"]').prop("checked", false);
                $('form input[id="ticket_thr"]').prop("checked", false);
                $('form input[id="ticket_prl"]').prop("checked", false);
            }
        });
        ////////////// پایان\\\\\\\\\\\\\\\\\\


        const sat_check = $("#sat_check");
        const sun_check = $("#sun_check");
        const mon_check = $("#mon_check");
        const tue_check = $("#tue_check");
        const wed_check = $("#wed_check");
        const thu_check = $("#thu_check");
        const fri_check = $("#fri_check");
        sat_check.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="sat_clock"]').prop("disabled", false);
				$('form input[id="sat_clock"]').css('background-color', 'white');
            } else {
                $('form input[id="sat_clock"]').prop("disabled", true);
				$('form input[id="sat_clock"]').css('background-color', '#eee');
				$('form input[id="sat_clock"]').removeClass("bg-white");
            }
        });
        sun_check.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="sun_clock"]').prop("disabled", false);
				$('form input[id="sun_clock"]').css('background-color', 'white');
            } else {
                $('form input[id="sun_clock"]').prop("disabled", true);
				$('form input[id="sun_clock"]').css('background-color', '#eee');
				$('form input[id="sun_clock"]').removeClass("bg-white");
            }
        });
        mon_check.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="mon_clock"]').prop("disabled", false);
				$('form input[id="mon_clock"]').css('background-color', 'white');
            } else {
                $('form input[id="mon_clock"]').prop("disabled", true);
				$('form input[id="mon_clock"]').css('background-color', '#eee');
				$('form input[id="mon_clock"]').removeClass("bg-white");
            }
        });
        tue_check.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="tue_clock"]').prop("disabled", false);
				$('form input[id="tue_clock"]').css('background-color', 'white');
            } else {
                $('form input[id="tue_clock"]').prop("disabled", true);
				$('form input[id="tue_clock"]').css('background-color', '#eee');
				$('form input[id="tue_clock"]').removeClass("bg-white");
            }
        });
        wed_check.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="wed_clock"]').prop("disabled", false);
				$('form input[id="wed_clock"]').css('background-color', 'white');
            } else {
                $('form input[id="wed_clock"]').prop("disabled", true);
				$('form input[id="wed_clock"]').css('background-color', '#eee');
				$('form input[id="wed_clock"]').removeClass("bg-white");
            }
        });
        thu_check.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="thu_clock"]').prop("disabled", false);
				$('form input[id="thu_clock"]').css('background-color', 'white');
            } else {
                $('form input[id="thu_clock"]').prop("disabled", true);
				$('form input[id="thu_clock"]').css('background-color', '#eee');
				$('form input[id="thu_clock"]').removeClass("bg-white");
            }
        });
        fri_check.change(function () {
            var checkbox = event.target;
            if (checkbox.checked) {
                $('form input[id="fri_clock"]').prop("disabled", false);
				$('form input[id="fri_clock"]').css('background-color', 'white');
            } else {
                $('form input[id="fri_clock"]').prop("disabled", true);
				$('form input[id="fri_clock"]').css('background-color', '#eee');
				$('form input[id="fri_clock"]').removeClass("bg-white");
            }
        });
    }
    );
    function time() {
        $(document).ready(function () {
            $('input.timepicker').timepicker({timeFormat: 'HH:mm:ss'});
        });
    }


    $('#radioBtn a').on('click', function () {
        var sel = $(this).data('title');
        var tog = $(this).data('toggle');
        $('#' + tog).prop('value', sel);
        $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass('notActive');
        $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
    });
    ///// create new course

    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
        // This function will display the specified tab of the form...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        //... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "ایجاد دوره";
        } else {
            document.getElementById("nextBtn").innerHTML = "مرحله بعد";
        }
        //... and run a function that will display the correct step indicator:
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm())
            return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form...
        if (currentTab >= x.length) {
            // ... the form gets submitted:
            document.getElementById("regForm").submit();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }

    function validateForm() {
        // This function deals with validation of the form fields
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        // A loop that checks every input field in the current tab:
//  for (i = 0; i < y.length; i++) {
//    // If a field is empty...
//    if (y[i].value == "") {
//      // add an "invalid" class to the field:
//      y[i].className += " invalid";
//      // and set the current valid status to false
//      valid = false;
//    }
//  }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; // return the valid status
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class on the current step:
        x[n].className += " active";
    }
    
</script>
