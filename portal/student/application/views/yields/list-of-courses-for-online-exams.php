<div class="col-sm-12">
    <div class="white-box">
        <h2 class="box-title m-b-0 text-success">دوره هایی که آزمون آنلاین دارند : </h2>
        <hr>
        <div class="table-responsive">
            <?php if ($this->session->flashdata('enroll-e')) : ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('enroll-e'); ?></div>
            <?php endif; ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">کد دوره</th>
                        <th class="text-center">نام درس</th>
                        <th class="text-center">کد آزمون</th>
                        <th class="text-nowrap text-center">شروع آزمون</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($courses_list)) { ?>
                        <?php foreach ($courses_list as $course): ?>
                            <tr>
                                <td class="text-center"><?php echo htmlspecialchars($course->course_id, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($course->exam_code, ENT_QUOTES) ?></td>
                                <td class="text-nowrap text-center">
                                    <button onclick="document.getElementById('en_course_<?= $course->course_id; ?>').submit()" data-toggle="tooltip" data-original-title="شروع آزمون"> <i class="mdi mdi-account-multiple-plus text-inverse m-r-10"></i> </button>
                                    <form class="" id="en_course_<?= $course->course_id; ?>" style="display:none;" action="/student/exams/start-online-exam" method="post">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                        <input type="hidden" name="exam_code" value="<?= $course->exam_code; ?>">
                                    </form>
                                </td>
                            </tr>


                            <?php
                        endforeach;
                    }else {
                        ?>
                        <tr>
                            <td class="text-danger text-center">
                                هیچ آزمونی تعریف نشده است.
                            </td>
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
