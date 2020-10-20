<div class="col-sm-12">
    <div class="white-box">
        <div class="table-responsive">
            <h2 class="text-info">آزمون های من</h2>
            <?php if ($this->session->flashdata('del-exist-lesson')) : ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('del-exist-lesson'); ?></div>
            <?php endif; ?>
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>نام و نام خانوادگی</th>
                        <th class="text-center">کدملی</th>
                        <th class="text-center">نوع آزمون</th>
                        <th class="text-center">هزینه آزمون</th>
                        <th class="text-center">زمان آزمون</th>
                        <th class="text-center">آزمون دوره</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>نام و نام خانوادگی</th>
                        <th class="text-center">کدملی</th>
                        <th class="text-center">نوع آزمون</th>
                        <th class="text-center">هزینه آزمون</th>
                        <th class="text-center">زمان آزمون</th>
                        <th class="text-center">آزمون دوره</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if (!empty($exams)): ?>
                        <?php foreach ($exams as $exam): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($exam->first_name . ' ' . $exam->last_name, ENT_QUOTES); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($exam->national_code, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($exam->exam_type, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($exam->exam_cost, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($exam->exam_date, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($exam->course_description, ENT_QUOTES) ?></td>
                            </tr>
                        <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
