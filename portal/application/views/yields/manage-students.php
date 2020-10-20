<div class="col-sm-12">
    <div class="white-box">
        <?php if ($this->session->flashdata('success-insert')) : ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success-insert'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('success-update')) : ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success-update'); ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">کد <?php echo $this->session->userdata('studentDName'); ?></th>
                        <th>نام و نام خانوادگی</th>
                        <th class="text-center">شماره همراه</th>
                        <th class="text-center">کد ملی</th>
                        <th class="text-center">وضعیت ثبت نام</th>
                        <th class="text-center">وضعیت <?php echo $this->session->userdata('studentDName'); ?></th>
                        <th class="text-center">ابزار</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">کد <?php echo $this->session->userdata('studentDName'); ?></th>
                        <th>نام و نام خانوادگی</th>
                        <th class="text-center">شماره همراه</th>
                        <th class="text-center">کد ملی</th>
                        <th class="text-center">وضعیت ثبت نام</th>
                        <th class="text-center">وضعیت <?php echo $this->session->userdata('studentDName'); ?></th>
                        <th class="text-center">ابزار</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if ($students_info): ?>
                        <?php foreach ($students_info as $student): ?>
                            <tr>
                                <td class="text-center"><?php echo htmlspecialchars($student->student_id, ENT_QUOTES) ?></td>
                                <td>
                                    <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo htmlspecialchars($student->pic_name, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                                    <!--<img src="<?php echo base_url('assets/profile-picture/thumb/' . $student->pic_name); ?>" height="32" alt="student" class="img-circle">-->
                                    <?php echo htmlspecialchars($student->first_name . ' ' . $student->last_name, ENT_QUOTES); ?>
                                </td>
                                <td class="text-center"><?php echo htmlspecialchars($student->phone_num, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($student->national_code, ENT_QUOTES) ?></td>
                                <td class="text-center">
                                    <?php if ($student->student_status === '0'): ?>
                                        <span class="label label-danger">پیش ثبت نام</span>
                                    <?php else: ?>
                                        <span class="label label-success">ثبت نام نهایی</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($student->student_activated === '0'): ?>
                                        <span class="label label-danger">غیره فعال</span>
                                    <?php else: ?>
                                        <span class="label label-success">فعال</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-nowrap text-center">
                                    <a href="#" onclick="event.preventDefault();document.getElementById('edit_<?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="ویرایش"> <i class="mdi mdi-pencil text-inverse"></i> </a>|
                                    <form class="" id='edit_<?php echo htmlspecialchars($student->national_code); ?>' style="display:none" action="<?php echo base_url(); ?>users/edit-student" method="post">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                        <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?>">
                                    </form>
                                    <a href="#" onclick="event.preventDefault();document.getElementById('detail_<?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="جزئیات"><i class="mdi mdi-account-card-details m-r-5"></i></a>|
                                    <form class="" id='detail_<?php echo htmlspecialchars($student->national_code); ?>' style="display:none" action="<?php echo base_url('financial/student-inquiry'); ?>" method="post">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                        <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?>">
                                    </form>
                                    <?php if ($student->student_activated === '1'): ?>
                                        <a href="#" onclick="event.preventDefault();document.getElementById('unactive_<?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="غیر فعال کردن"> <i class="fa fa-close text-danger"></i> </a>
                                        <form class="" id='unactive_<?php echo htmlspecialchars($student->national_code); ?>' style="display:none" action="<?php echo base_url(); ?>users/edit_activated_student" method="post">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                            <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?>">
                                        </form>
                                    <?php else: ?>
                                        <a href="#" onclick="event.preventDefault();document.getElementById('active_<?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="فعال کردن"> <i class="mdi mdi-check-circle-outline text-success"></i> </a>
                                        <form class="" id='active_<?php echo htmlspecialchars($student->national_code); ?>' style="display:none" action="<?php echo base_url(); ?>users/edit_activated_student" method="post">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                            <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?>">
                                        </form>
                                    <?php endif; ?>

                                </td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
