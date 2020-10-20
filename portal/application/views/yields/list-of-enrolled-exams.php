<div class="col-sm-12">
    <div class="white-box">
        <div class="table-responsive">
            <h2 class="text-info">لیست <?php echo $this->session->userdata('studentDName') . " های"; ?> ثبت نامی برای آزمون :</h2>
            <?php if ($this->session->flashdata('del-exist-exam')) : ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('del-exist-exam'); ?></div>
            <?php endif; ?>
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>نام و نام خانوادگی</th>
                        <th style="text-align: center">کدملی</th>
                        <th style="text-align: center">شماره همراه</th>
                        <th style="text-align: center">کد دوره</th>
                        <th style="text-align: center">نام دوره</th>
                        <th style="text-align: center">شهریه آزمون</th>
                        <th style="text-align: center">تاریخ برگزاری آزمون</th>
                        <th style="text-align: center">ابزار</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>نام و نام خانوادگی</th>
                        <th style="text-align: center">کدملی</th>
                        <th style="text-align: center">شماره همراه</th>
                        <th style="text-align: center">کد دوره</th>
                        <th style="text-align: center">نام دوره</th>
                        <th style="text-align: center">شهریه آزمون</th>
                        <th style="text-align: center">تاریخ برگزاری آزمون</th>
                        <th style="text-align: center">ابزار</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if (!empty($enrolled_exams)): ?>
                        <?php foreach ($enrolled_exams as $enrolled_exam): ?>
                            <tr>
                                <td>
                                    <a href="contact-detail.html">
                                        <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo htmlspecialchars($enrolled_exam->pic_name, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                                        <?php echo htmlspecialchars($enrolled_exam->first_name . ' ' . $enrolled_exam->last_name, ENT_QUOTES); ?>
                                    </a>
                                </td>
                                <td class="text-cenetr"><?php echo htmlspecialchars($enrolled_exam->national_code, ENT_QUOTES) ?></td>
                                <td class="text-cenetr"><?php echo htmlspecialchars($enrolled_exam->phone_num, ENT_QUOTES) ?></td>
                                <td class="text-cenetr"><?php echo htmlspecialchars($enrolled_exam->lesson_id, ENT_QUOTES) ?></td>
                                <td class="text-cenetr"><?php echo htmlspecialchars($enrolled_exam->lesson_name, ENT_QUOTES) ?></td>
                                <td class="text-cenetr"><?php echo htmlspecialchars($enrolled_exam->exam_cost, ENT_QUOTES) ?></td>
                                <td class="text-cenetr"><?php echo htmlspecialchars($enrolled_exam->exam_date, ENT_QUOTES) ?></td>
                                <td class="text-nowrap text-center">
                                    <a href="basic-table.html#" onclick="event.preventDefault();document.getElementById('del_<?php echo htmlspecialchars($enrolled_exam->national_code, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="حذف"> <i class="fa fa-close text-inverse m-r-10"></i> </a>
                                    <form class="" id='del_<?php echo htmlspecialchars($enrolled_exam->national_code); ?>' style="display:none" action="<?php echo base_url(); ?>enrollment/delete-exam-student" method="post">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                        <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($enrolled_exam->national_code, ENT_QUOTES); ?>">
                                        <input type="hidden" name="exam_student_code" value="<?php echo htmlspecialchars($enrolled_exam->exam_student_id, ENT_QUOTES); ?>">
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
