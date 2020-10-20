$(document).ready(function () {
                $("#academy1").click(function () {
                    var academy_id = $(this).data("custom-value");
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
                $("#academy2").click(function () {
                    var academy_id = $(this).data("custom-value");
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
                $("#academy3").click(function () {
                    var academy_id = $(this).data("custom-value");
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
                $("#academy4").click(function () {
                    var academy_id = $(this).data("custom-value");
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

            ///////////////////////////////////////////////////////////////////////////////////

// $(document).ready(function () {
//     $('a[name="group"]').on('change', function () {
//         var grp = $(this).val();
//         if (grp) {
//             $.ajax({
//                 url: 'dropdown/group/' + grp,
//                 type: "GET",
//                 dataType: "json",
//                 success: function (data) {
//                     $('select[name="stnd"]').empty();
//                     $.each(data, function (key, value) {
//                         $('select[name="stnd"]').append('<option value="' + value.standard_id + '">' + value.standard_name + '</option>');
//                     });
//                 }
//             });
//         } else {
//             $('select[name="stnd"]').empty();
//         }
//     });
// });
