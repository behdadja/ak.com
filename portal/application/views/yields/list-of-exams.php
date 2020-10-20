<div class="col-sm-12">
    <div class="white-box">
        <h2 class="box-title m-b-0 text-success">یکی از آزمون های زیر را جهت ثبت نام <?php echo $this->session->userdata('studentDName');?> انتخاب نمایید</h2>
        <hr>
        <div class="table-responsive">
            <?php if ($this->session->flashdata('enroll-exist')) : ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('enroll-exist'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('enroll-exist-exam')) : ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('enroll-exist-exam'); ?></div>
            <?php endif; ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="text-align: center">کد آزمون</th>
                        <th style="text-align: center">نام درس</th>
                        <th style="text-align: center">هزینه آزمون</th>
                        <th style="text-align: center">تاریخ برگزاری آزمون</th>
                        <th style="text-align: center" class="text-nowrap">ثبت نام</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($exams_list)): ?>
                        <?php foreach ($exams_list as $exam): ?>
                            <tr>
                                <td class="text-cenetr"><?php echo htmlspecialchars($exam->exam_id, ENT_QUOTES) ?></td>
                                <td class="text-cenetr"><?php echo htmlspecialchars($exam->lesson_name, ENT_QUOTES) ?></td>
                                <td class="text-cenetr"><?php echo htmlspecialchars($exam->exam_cost, ENT_QUOTES) ?></td>
                                <td class="text-cenetr"><?php echo htmlspecialchars($exam->start_date, ENT_QUOTES) ?></td>
                                <td class="text-nowrap text-center">
                                    <a href="<?php echo base_url(); ?>enrollment/exam/<?php echo htmlspecialchars($exam->lesson_id, ENT_QUOTES) ?>/<?php echo urlencode(preg_replace('/\s+/', '-', str_replace(array('(', ')', '.'), '', $exam->exam_id))) ?>">
                                        <button style="border:0; background-color: white" alt="default" data-toggle="modal" data-target="#modal_<?php echo htmlspecialchars($exam->lesson_id, ENT_QUOTES) ?>">
                                            <i class="mdi mdi-account-multiple-plus text-inverse m-r-10"></i>
                                        </button>
                                    </a>
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



