
<div class="container-fluid page__container page-section">
    <div class="card mb-32pt p-24pt">
        <div class="card-body">
            <div class="row">
                <div class="table-responsive" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>
                    <div class="search-form search-form--light mb-3 col-md-3">
                        <input type="text" class="form-control search" id="myInput" placeholder="جستجو">
                        <button class="btn" type="button" role="button"><i class="material-icons">search</i></button>
                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">نام دوره</th>
                            <th class="text-center">نام استاد</th>
                            <th class="text-center">وضعیت کلاس آنلاین</th>
                            <th class="text-center">تعداد شرکت کنندگان</th>
                            <th class="text-center">جزعیات</th>
                            <th class="text-center">ورود</th>
                        </tr>
                        </thead>
                        <tbody id="search">
                        <?php
                        $uniqe_class = $online_course;
                        if ($uniqe_class != null){

                            for ($i = 0 ; $i < count($uniqe_class) ; $i++){
                                ?>
                                <tr>
                                    <td class="text-center"><?= htmlspecialchars($uniqe_class[$i]->lesson_name , ENT_QUOTES); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($uniqe_class[$i]->first_name.' '.$uniqe_class[$i]->last_name , ENT_QUOTES); ?></td>
                                    <td class="text-center" style="color: green"><?= htmlspecialchars('کلاس در حال اجرا است', ENT_QUOTES) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($classes_info[$i]['participantCount'], ENT_QUOTES) ?></td>
                                    <td class="text-center" style="color: blue"> <a href="" onclick="event.preventDefault();document.getElementById('detail_<?php echo htmlspecialchars($classes_info[$i]['meetingID'], ENT_QUOTES); ?>').submit();" data-toggle="tooltip" >+</a>
                                        <form class="" id='detail_<?php echo htmlspecialchars($classes_info[$i]['meetingID']); ?>' style="display:none" action="<?php echo base_url('class_info'); ?>" method="post">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                            <input type="hidden" name="MID" value="<?php echo htmlspecialchars($classes_info[$i]['meetingName'], ENT_QUOTES); ?>">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                            <input type="hidden" name="server" value="<?php echo htmlspecialchars($uniqe_class[$i]->using_server, ENT_QUOTES); ?>">
                                        </form></td>
                                    <td class="text-center" style="color: blue"> <a href="" onclick="event.preventDefault();document.getElementById('online_<?php echo htmlspecialchars($classes_info[$i]['meetingID'], ENT_QUOTES); ?>').submit();" data-toggle="tooltip" >online</a>
                                        <form class="" id='online_<?php echo htmlspecialchars($classes_info[$i]['meetingID']); ?>' style="display:none" action="<?php echo base_url('online'); ?>" method="post">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                            <input type="hidden" name="MID" value="<?php echo htmlspecialchars($classes_info[$i]['meetingName'], ENT_QUOTES); ?>">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                            <input type="hidden" name="server" value="<?php echo htmlspecialchars($uniqe_class[$i]->using_server, ENT_QUOTES); ?>">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                            <input type="hidden" name="academy_id" value="<?php echo htmlspecialchars($uniqe_class[$i]->academy_id, ENT_QUOTES); ?>">
                                        </form></td>
                                </tr>
                                <?php
                            } ?>
                        <?php } else { ?>
                            <tr>
                                <td class="text-center" style="color: red"><?= htmlspecialchars('x' , ENT_QUOTES); ?></td>
                                <td class="text-center" style="color: red"><?= htmlspecialchars('x' , ENT_QUOTES); ?></td>
                                <td class="text-center" style="color: red"><?= htmlspecialchars('کلاسی وجود ندارد', ENT_QUOTES) ?></td>
                                <td class="text-center" style="color: red"><?= htmlspecialchars('0', ENT_QUOTES) ?></td>
                                <td class="text-center" style="color: red"><a href="#">+</a></td>
                                <td class="text-center" style="color: red"><a href="#">افلاین</a></td>
                            </tr>
                        <?php }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- script for search -->
<script>
    $(document).ready(function () {
        $("#myInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#search tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<!-- / script for search -->
