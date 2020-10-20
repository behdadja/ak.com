
<html>
    <head>
        <link type="text/css" href="<?php echo base_url(); ?>assets/css/app.css" rel="stylesheet">
        <!-- for modals -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    </head>
    <body>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">خوشه</label>
                    <select size="10" class="form-control custom-select" name="academy">
                        <option value=""></option>
                        <option value="1">فنی و حرفه ای</option>
                        <option value="2">درسی و کنکور</option>
                        <option value="3">زبان</option>
                        <option value="4">هنر و موسیقی</option> 
                    </select>  
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">خوشه</label>
                    <select size="10" class="form-control custom-select" name="cluster"> 
                    </select>  
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">نام گروه</label>
                    <select size="10" class="form-control custom-select" name="group">
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">نام استاندارد</label>
                    <select size="10" class="form-control custom-select" name="stnd">
                    </select>
                </div>
            </div>
        </div>



        <script>
            $(document).ready(function () {
                $('select[name="academy"]').on('change', function () {
                    var academy_id = $(this).val();
                    if (academy_id) {
                        $.ajax({
                            url: 'dropdown/academy/' + academy_id,
                            type: "GET",
                            dataType: "json",
                            success: function (data) {
                                $('select[name="cluster"]').empty();
                                $('select[name="group"]').empty();
                                $('select[name="stnd"]').empty();
                                $.each(data, function (key, value) {
                                    $('select[name="cluster"]').append('<option value="' + value.cluster_id + '">' + value.cluster_name + '</option>');
                                });
                            }
                        });
                    } else {
                        $('select[name="cluster"]').empty();
                    }
                });
            });
            
            $(document).ready(function () {
                $('select[name="cluster"]').on('change', function () {
                    var clust = $(this).val();
                    if (clust) {
                        $.ajax({
                            url: 'dropdown/cluster/' + clust,
                            type: "GET",
                            dataType: "json",
                            success: function (data) {
                                $('select[name="group"]').empty();
                                $('select[name="stnd"]').empty();
                                $.each(data, function (key, value) {
                                    $('select[name="group"]').append('<option value="' + value.group_id + '">' + value.group_name + '</option>');
                                });
                            }
                        });
                    } else {
                        $('select[name="group"]').empty();
                    }
                });
            });

            $(document).ready(function () {
                $('select[name="group"]').on('change', function () {
                    var grp = $(this).val();
                    if (grp) {
                        $.ajax({
                            url: 'dropdown/group/' + grp,
                            type: "GET",
                            dataType: "json",
                            success: function (data) {
                                $('select[name="stnd"]').empty();
                                $.each(data, function (key, value) {
                                    $('select[name="stnd"]').append('<option value="' + value.standard_id + '">' + value.standard_name + '</option>');
                                });
                            }
                        });
                    } else {
                        $('select[name="stnd"]').empty();
                    }
                });
            });
        </script>
    </body>
</html>



