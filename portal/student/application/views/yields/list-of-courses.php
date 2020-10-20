<div class="col-sm-12">
    <div class="white-box">
        <h2 class="box-title m-b-0 text-success">یکی از دوره های موجود را جهت ثبت نام انتخاب نمایید : </h2>
        <hr>
        <div class="table-responsive">
            <?php if ($this->session->flashdata('enroll-e')) : ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('enroll-e'); ?></div>
            <?php endif; ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">کد دوره</th>
                        <th class="text-center">نام درس</th>
                        <th class="text-center">مدت زمان (ساعت)</th>
                        <th class="text-center">شهریه کل</th>
                        <th class="text-center">روز و ساعت برگزای دوره</th>
                        <th class="text-center">تاریخ شروع کلاس ها</th>
                        <th class="text-nowrap text-center">ثبت نام</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($courses_list)) { ?>
                        <?php foreach ($courses_list as $course): ?>
                            <tr>
                                <td class="text-center"><?php echo htmlspecialchars($course->course_id, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($course->course_duration, ENT_QUOTES) ?>  ساعت</td>
                                <td class="text-center"><?php echo htmlspecialchars($course->course_tuition, ENT_QUOTES) ?>  تومان</td>
                                <td class="text-center" style="width: 200px">
                                    <?php if ($course->sat_status === '1'): ?>
                                        <span class='text-info'>شنبه : </span><span><?php echo htmlspecialchars($course->sat_clock, ENT_QUOTES); ?></span>
                                    <?php endif; ?>

                                    <?php if ($course->sun_status === '1'): ?>
                                        <span class='text-info'>یکشنبه : </span><span><?php echo htmlspecialchars($course->sun_clock, ENT_QUOTES); ?></span>
                                    <?php endif; ?>

                                    <?php if ($course->mon_status === '1'): ?>
                                        <span class='text-info'>دوشنبه : </span><span><?php echo htmlspecialchars($course->mon_clock, ENT_QUOTES); ?></span>
                                    <?php endif; ?>

                                    <?php if ($course->tue_status === '1'): ?>
                                        <span class='text-info'>سه شنبه : </span><span><?php echo htmlspecialchars($course->tue_clock, ENT_QUOTES); ?></span>
                                    <?php endif; ?>

                                    <?php if ($course->wed_status === '1'): ?>
                                        <span class='text-info'>چهارشنبه : </span><span><?php echo htmlspecialchars($course->wed_clock, ENT_QUOTES); ?></span>
                                    <?php endif; ?>

                                    <?php if ($course->thu_status === '1'): ?>
                                        <span class='text-info'>پنج شنبه : </span><span><?php echo htmlspecialchars($course->thu_clock, ENT_QUOTES); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?php echo htmlspecialchars($course->start_date, ENT_QUOTES); ?></td>
                                <td class="text-nowrap text-center">
                                    <button onclick="document.getElementById('en_course_<?= $course->course_id; ?>').submit()" data-toggle="tooltip" data-original-title="ثبت نام"> <i class="mdi mdi-account-multiple-plus text-inverse m-r-10"></i> </button>
                                    <form class="" id="en_course_<?= $course->course_id; ?>" style="display:none;" action="<?php echo base_url('student/courses/enroll-course'); ?>" method="post">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                        <input type="hidden" name="course_code" value="<?= $course->course_id; ?>">
                                        <input type="hidden" name="lesson_id" value="<?= $course->lesson_id; ?>">
                                        <input type="hidden" name="course_cost" value="<?= $course->course_tuition; ?>">
                                    </form>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    }else {
                        ?>
                        <tr>
                            <td class="text-danger text-center">
                                دوره ی جدیدی جهت ثبت نام وجود ندارد
                            </td>
                            <td class="text-danger text-center">*</td>
                            <td class="text-danger text-center">*</td>
                            <td class="text-danger text-center">*</td>
                            <td class="text-danger text-center">*</td>
                            <td class="text-danger text-center">*</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
