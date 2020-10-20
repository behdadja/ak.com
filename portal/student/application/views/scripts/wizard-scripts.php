<!-- Form Wizard JavaScript -->
    <script src="<?= base_url(); ?>student/assets/bower_components/jquery-wizard-master/dist/jquery-wizard.min.js"></script>
    <!-- FormValidation -->
    <script src="<?= base_url(); ?>student/assets/bower_components/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript">
        (function () {
            $('#exampleBasic').wizard({
                onFinish: function () {
                    swal("پیام اتمام نصب!", "لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.");
                }
            });
            $('#exampleBasic2').wizard({
                onFinish: function () {
                    swal("پیام اتمام نصب!", "لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.");
                }
            });
            $('#accordion').wizard({
                step: '[data-toggle="collapse"]'
                , buttonsAppendTo: '.panel-collapse'
                , templates: {
                    buttons: function () {
                        var options = this.options;
                        return '<div class="panel-footer"><ul class="pager">' + '<li class="previous">' + '<a href="form-wizard.html#' + this.id + '" data-wizard="back" role="button">' + options.buttonLabels.back + '</a>' + '</li>' + '<li class="next">' + '<a href="form-wizard.html#' + this.id + '" data-wizard="next" role="button">' + options.buttonLabels.next + '</a>' + '<a href="form-wizard.html#' + this.id + '" data-wizard="finish" role="button">' + options.buttonLabels.finish + '</a>' + '</li>' + '</ul></div>';
                    }
                }
                , onBeforeShow: function (step) {
                    step.$pane.collapse('show');
                }
                , onBeforeHide: function (step) {
                    step.$pane.collapse('hide');
                }
                , onFinish: function () {
                    swal("پیام اتمام نصب!", "لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.");
                }
            });
        })();
    </script>
