<div class="col-sm-12">
    <div class="white-box">
        <div class="alert alert-info text-center"><?= 'ثبت نام '.$this->session->userdata('studentDName').' در دوره '.'<span style="background-color:steelblue;border-radius:50px;padding:5px 15px 5px 15px">'. $course_info[0]->lesson_name.'</span>' ?></div>
        <div class="table-responsive">
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: center">کد <?php echo $this->session->userdata('studentDName'); ?></th>
                        <th>نام و نام خانوادگی</th>
                        <th style="text-align: center">کد ملی</th>
                        <th style="text-align: center">شماره همراه</th>
                        <th style="text-align: center">ثبت نام نهایی</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th style="text-align: center">کد <?php echo $this->session->userdata('studentDName'); ?></th>
                        <th>نام و نام خانوادگی</th>
                        <th style="text-align: center">کد ملی</th>
                        <th style="text-align: center">شماره همراه</th>
                        <th style="text-align: center">ثبت نام نهایی</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if (!empty($students_info) && !empty($course_info)): ?>
                        <?php foreach ($students_info as $student): ?>
                            <tr>
                                <td class="text-center"><?php echo htmlspecialchars($student->student_id, ENT_QUOTES) ?></td>
                                <td>
                                    <a href="contact-detail.html">
                                        <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo htmlspecialchars($student->pic_name, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                                        <?php echo htmlspecialchars($student->first_name . ' ' . $student->last_name, ENT_QUOTES); ?>
                                    </a>
                                </td>
                                <td class="text-center"><?php echo htmlspecialchars($student->national_code, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($student->phone_num, ENT_QUOTES) ?></td>
                                <td class="text-nowrap text-center">
                                    <a href="#" onclick="event.preventDefault();document.getElementById('final_reg_<?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="ثبت نام"> <i class="mdi mdi-account-check text-inverse m-r-10"></i> </a>
                                    <form class="" id='final_reg_<?php echo htmlspecialchars($student->national_code); ?>' style="display:none" action="<?php echo base_url(); ?>enrollment/enroll-course" method="post">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_info[0]->course_id, ENT_QUOTES) ?>">
                                        <input type="hidden" name="lesson_name" value="<?php echo htmlspecialchars($course_info[0]->lesson_name, ENT_QUOTES) ?>">
                                        <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?>">
                                        <input type="hidden" name="phone_num" value="<?php echo htmlspecialchars($student->phone_num, ENT_QUOTES) ?>">
                                        <input type="hidden" name="full_name" value="<?php echo htmlspecialchars($student->first_name . ' ' . $student->last_name, ENT_QUOTES) ?>">
                                    </form>
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
