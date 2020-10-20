<div class="col-sm-12">
    <div class="white-box">
        <div class="table-responsive">
            <h2 class="text-info">سوالات من</h2>
            <?php if ($this->session->flashdata('error-upload')) : ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('error-upload'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('insert-success')) : ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('insert-success'); ?></div>
            <?php endif; ?>
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>نام درس</th>
                        <th class="text-center">کد سوال</th>
                        <th class="text-center">صورت سوال</th>
                        <th class="text-center">ابزار</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>نام درس</th>
                        <th class="text-center">کد سوال</th>
                        <th class="text-center">صورت سوال</th>
                        <th class="text-center">ابزار</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if (!empty($myQuestions)): ?>
                        <?php foreach ($myQuestions as $question): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($question->lesson_name, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($question->question_id, ENT_QUOTES) ?></td>
                                <td class="text-center"><?= word_limiter($question->question_body, 12) ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url(); ?>teacher/exams/edit-question/<?= $question->question_id; ?>/<?= word_limiter($question->question_body, 4); ?>">
                                        <i class="mdi mdi-border-color"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
