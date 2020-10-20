<div class="col-sm-12">
    <div class="white-box">
        <h3 class="box-title">مدیریت کردن چک های دریافتی بابت شهریه دوره ها</h3>
        <div class="table-responsive">
            <?php if ($this->session->flashdata('success-insert')) : ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('success-insert'); ?></div>
            <?php endif; ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">کد ملی <?php echo $this->session->userdata('studentDName'); ?></th>
                        <th class="text-center">کد دوره</th>
                        <th class="text-center">نام درس</th>
                        <th class="text-center">مبلغ چک</th>
                        <th class="text-center">تاریخ چک</th>
                        <th class="text-center">وضعیت چک</th>
                        <th class="text-nowrap text-center">ابزار</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($courses_checks)): ?>
                        <?php foreach ($courses_checks as $courses_check): ?>
                            <tr>
                                <td class="text-center"><?php echo htmlspecialchars($courses_check->student_nc, ENT_QUOTES); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($courses_check->course_id, ENT_QUOTES); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($courses_check->lesson_name, ENT_QUOTES); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($courses_check->check_amount, ENT_QUOTES); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($courses_check->check_date, ENT_QUOTES); ?></td>
                                <td class="text-center">
                                    <?php if ($courses_check->check_status === '0'): ?>
                                        <span class="label label-warning">پاس نشده</span>
                                    <?php elseif ($courses_check->check_status === '1'): ?>
                                        <span class="label label-success">پاس شده</span>
                                    <?php else: ?>
                                        <span class="label label-danger">برگشتی</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-nowrap text-center">
                                    <?php if ($courses_check->check_status === '0'): ?>
                                        <a href="#" onclick="event.preventDefault();document.getElementById('pass_<?php echo htmlspecialchars($courses_check->check_pay_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="پاس کردن"> <i class="fa fa-check text-info"></i> </a> | 
                                        <form class="" id='pass_<?php echo htmlspecialchars($courses_check->check_pay_id, ENT_QUOTES); ?>' style="display:none" action="<?php echo base_url(); ?>financial/pass-ckeck" method="post">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                            <input type="hidden" name="check_pay_id" value="<?php echo htmlspecialchars($courses_check->check_pay_id, ENT_QUOTES); ?>">
                                            <input type="hidden" name="where" value="course">
                                        </form>
                                        <a href="#" onclick="event.preventDefault();document.getElementById('return_<?php echo htmlspecialchars($courses_check->check_pay_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="برگشت زدن"> <i class="mdi mdi-redo-variant"></i> </a>
                                        <form class="" id='return_<?php echo htmlspecialchars($courses_check->check_pay_id, ENT_QUOTES); ?>' style="display:none" action="<?php echo base_url(); ?>financial/return-ckeck" method="post">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                            <input type="hidden" name="check_pay_id" value="<?php echo htmlspecialchars($courses_check->check_pay_id, ENT_QUOTES); ?>">
                                            <input type="hidden" name="download" value="course_check_pay">
                                        </form>
                                    <?php elseif ($courses_check->check_status === '1'): ?>
                                        <span class="label label-info">بایگانی شد</span>
                                    <?php else: ?>
                                        <span class="label label-default text-dark">برگشت</span>
                                    <?php endif; ?>

                                </td>
                            </tr>
                        <?php endforeach;
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
