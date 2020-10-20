<div class="col-sm-12">
    <div class="white-box">
        <h3 class="box-title">مدیریت کردن همه آزمون ها</h3>
        <div class="table-responsive">
            <?php if ($this->session->flashdata('success-insert')) : ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('success-insert'); ?></div>
            <?php endif; ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">کد آزمون</th>
                        <th class="text-center">نوع آزمون</th>
                        <th class="text-center">هزینه</th>
                        <th class="text-nowrap text-center">ابزار</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($exams_type_info)): ?>
                        <?php foreach ($exams_type_info as $exam_type): ?>
                            <tr>
                                <td class="text-center"><?php echo htmlspecialchars($exam_type->exam_id, ENT_QUOTES); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($exam_type->exam_type, ENT_QUOTES); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($exam_type->exam_cost, ENT_QUOTES); ?></td>
                                <td class="text-nowrap text-center">
                                    <button type="button" class="btn bg-light" id="edit_click_<?php echo htmlspecialchars($exam_type->exam_id); ?>" onclick="document.getElementById('edit_click_<?php echo htmlspecialchars($exam_type->exam_id); ?>').addEventListener('click', function (event) {
                                                event.preventDefault();
                                                document.getElementById('edit_<?php echo htmlspecialchars($exam_type->exam_id); ?>').submit();
                                            });" data-toggle="tooltip" data-original-title="ویرایش"> <i class="fa fa-pencil text-inverse m-r-10"></i> </button>
                                    <form class="" id='edit_<?php echo htmlspecialchars($exam_type->exam_id); ?>' style="display:none" action="<?php echo base_url(); ?>enrollment/edit-exam-type" method="post">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                        <input type="hidden" name="exam_id" value="<?php echo htmlspecialchars($exam_type->exam_id, ENT_QUOTES); ?>">
                                    </form>
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
