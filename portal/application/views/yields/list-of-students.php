<div class="col-sm-12">
    <div class="white-box">
        <div class="row">
            <?php foreach ($course_info as $student): ?>
                <div class="col-md-4">
                    <h2 class="box-title m-b-0 text-blue">دوره: <?php echo $student->lesson_name; ?></h2>
                </div>
                <div class="col-md-4">
                    <h2 class="box-title m-b-0 text-blue">جلسه: <?php echo $meeting; ?></h2>
                </div>
                <div class="col-md-4">
                    <div class="col-md-6">
                        <a href="<?php echo base_url('training/list_of_meeting/' . $student->course_id.'/'.$student->course_status); ?>" class="btn btn-primary" style="width: 100%;float:left;margin-top: 5px">لیست جلسات</a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?php echo base_url('training/manage-courses'); ?>" class="btn btn-primary" style="width: 100%;float:left;margin-top: 5px">دوره ها</a>
                    </div>
                </div>
                <?php $employer_nc = $student->course_master; ?>
            <?php endforeach; ?>
        </div>
        <br>
        <br>
        <div class="table-responsive">
            <?php if ($this->session->flashdata('enroll-e')) : ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('enroll-e'); ?></div>
            <?php endif; ?>
            <table class="table table-bordered center" style="text-align: center">
                <thead>
                    <tr>
                        <th style="text-align: center">نام و نام خانوادگی</th>
                        <th style="text-align: center">کدملی</th>
                        <th style="text-align: center">تعداد غیبت در دوره</th>
                        <th style="text-align: center">حضور و غیاب</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($studentListOfCourse)) :
                        foreach ($studentListOfCourse as $student):
                            $student_nc = $student->national_code;
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student->first_name . ' ' . $student->last_name, ENT_QUOTES); ?></td>
                                <td class="text_center"><?php echo htmlspecialchars($student_nc, ENT_QUOTES); ?></td>
                                <td class="text_center"><?php
                                    $count = 0;
                                    if (!empty($count_absence)) {
                                        foreach ($count_absence as $items) {
                                            if ($student_nc === $items->student_nc) {
                                                $count++;
                                            }
                                        }
                                    }echo $count;
                                    ?>
                                </td>
                                <td class="text_center">
                                    <?php
                                    if (!empty($absence_status)) {
                                        foreach ($absence_status as $as):
                                            $conditions = 0;
                                            if ($student_nc === $as->student_nc) {
                                                $conditions = 1;
                                                break;
                                            }
                                        endforeach;
                                        if ($conditions == 1) {
                                            ?>
                                            <form action = "<?php echo base_url('training/change_attendance'); ?>" method = "post">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value ="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($courseid, ENT_QUOTES); ?>">
                                                <input type="hidden" name="employer_nc" value="<?php echo htmlspecialchars($employer_nc, ENT_QUOTES); ?>">
                                                <input type="hidden" name="meeting" value="<?php echo htmlspecialchars($meeting, ENT_QUOTES); ?>">
                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_nc, ENT_QUOTES); ?>">
                                                <input type="hidden" name="conditions" value="<?php echo htmlspecialchars($conditions, ENT_QUOTES); ?>">
                                                <button type="submit" class="btn btn-danger">لغو غیبت</button>
                                            </form>
                                            <?php
                                        }

                                        if ($conditions == 0) {
                                            ?>
                                            <form action="<?php echo base_url('training/change_attendance'); ?>" method = "post">
                                                <input type="hidden" name ="<?php echo $this->security->get_csrf_token_name(); ?>" value = "<?php echo $this->security->get_csrf_hash(); ?>" />
                                                <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($courseid, ENT_QUOTES); ?>">
                                                <input type="hidden" name="employer_nc" value="<?php echo htmlspecialchars($employer_nc, ENT_QUOTES); ?>">
                                                <input type="hidden" name="meeting" value="<?php echo htmlspecialchars($meeting, ENT_QUOTES); ?>">
                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_nc, ENT_QUOTES); ?>">
                                                <input type="hidden" name="conditions" value="<?php echo htmlspecialchars($conditions, ENT_QUOTES); ?>">
                                                <button type="submit" class="btn btn-success">ثبت غیبت</button>
                                            </form>
                                            <?php
                                        }
                                    } else {
                                        $conditions = 0;
                                        ?>
                                        <form action="<?php echo base_url('training/change_attendance'); ?>" method = "post">
                                            <input type="hidden" name = "<?php echo $this->security->get_csrf_token_name(); ?>" value = "<?php echo $this->security->get_csrf_hash(); ?>" />
                                            <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($courseid, ENT_QUOTES); ?>">
                                            <input type="hidden" name="employer_nc" value="<?php echo htmlspecialchars($employer_nc, ENT_QUOTES); ?>">
                                            <input type="hidden" name="meeting" value="<?php echo htmlspecialchars($meeting, ENT_QUOTES); ?>">
                                            <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($student_nc, ENT_QUOTES); ?>">
                                            <input type="hidden" name="conditions" value="<?php echo htmlspecialchars($conditions, ENT_QUOTES); ?>">
                                            <button type="submit" class="btn btn-success">ثبت غیبت</button>
                                        </form>
                                    <?php } ?>
                                </td>
                            </tr>

                            <?php
//                            $my_array = array
//                                (
//                                'student_nc'=>$student_nc,
//                                'employer_nc'=>$employer_nc,
//                                'meeting'=>$meeting,
//                                'courseid'=>$courseid
//                            );
//                            $my_data[] = array($my_array);
                        endforeach;
                        ?>

                    <?php else: ?>
                        <tr>
                            <td class="text-danger text-center">
                                کاربری ثبت نام نکرده است. لطفا شکیبا باشید
                            </td>
                            <td class="text-danger text-center">*</td>
                            <td class="text-danger text-center">*</td>
                            <td class="text-danger text-center">*</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            <div class="form-actions">
            </div>
        </div>
    </div>
</div>
