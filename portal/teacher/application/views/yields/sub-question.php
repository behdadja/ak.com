<h4 class="text-danger text-center">ثبت سوالات آزمون</h4>
<?php if ($this->session->flashdata('success')) { ?>
    <div class="row">
        <div class="alert alert-success">
            <?php echo htmlspecialchars($this->session->flashdata('success'), ENT_QUOTES); ?>
        </div>
    </div>
<?php } ?>
<form class="form-horizontal" action="<?= base_url(); ?>teacher/exams/insert-question" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

    <div class="form-group has-warning">
        <label class="col-md-12">صورت سوال</label>
        <div class="col-md-12">
            <textarea name="body" class="form-control" rows="5"></textarea>
            <?php if (validation_errors() && form_error('body')): ?>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <button class="btn btn-block btn-danger disabled"><?php echo form_error('body'); ?></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group has-success">
        <div class="col-md-6">
            <label class="col-md-6">گزینه یک<span class="help"></span></label>
            <input name="first_ch" type="text" class="form-control" value="">
            <?php if (validation_errors() && form_error('first_ch')): ?>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <button class="btn btn-block btn-danger disabled"><?php echo form_error('first_ch'); ?></button>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <label class="col-md-6">گزینه دو<span class="help"></span></label>
            <input name="second_ch" type="text" class="form-control" value="">
            <?php if (validation_errors() && form_error('second_ch')): ?>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <button class="btn btn-block btn-danger disabled"><?php echo form_error('second_ch'); ?></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group has-error">
        <div class="col-md-6">
            <label class="col-md-6">گزینه سه<span class="help"></span></label>
            <input name="third_ch" type="text" class="form-control" value="">
            <?php if (validation_errors() && form_error('third_ch')): ?>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <button class="btn btn-block btn-danger disabled"><?php echo form_error('third_ch'); ?></button>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <label class="col-md-6">گزینه چهار<span class="help"></span></label>
            <input name="fourth_ch" type="text" class="form-control" value="">
            <?php if (validation_errors() && form_error('fourth_ch')): ?>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <button class="btn btn-block btn-danger disabled"><?php echo form_error('fourth_ch'); ?></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4">
            <label class="col-md-6">پاسخ صحیح<span class="help"></span></label>
            <select class="form-control" name="correct_answer">
                <option value="">انتخاب کنید</option>
                <option value="1">گزینه یک</option>
                <option value="2">گزینه دو</option>
                <option value="3">گزینه سه</option>
                <option value="4">گزینه چهار</option>
            </select>
            <?php if (validation_errors() && form_error('correct_answer')): ?>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <button class="btn btn-block btn-danger disabled"><?php echo form_error('correct_answer'); ?></button>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
            <label class="col-md-6">سختی سوال<span class="help"></span></label>
            <select class="form-control" name="difficulty">
                <option value="">انتخاب کنید</option>
                <?php if (!empty($question_difficulty)): ?>
                    <?php foreach ($question_difficulty as $key => $value): ?>
                        <option value="<?= $value->difficulty_id; ?>"><?= $value->difficulty_title; ?></option>
                        <?php
                    endforeach;
                endif;
                ?>
            </select>
            <?php if (validation_errors() && form_error('difficulty')): ?>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <button class="btn btn-block btn-danger disabled"><?php echo form_error('difficulty'); ?></button>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
            <label class="col-md-6">انتخاب درس<span class="help"></span></label>
            <select class="form-control" name="lesson">
                <option value="">انتخاب کنید</option>
                <?php if (!empty($lessons)): ?>
                    <?php foreach ($lessons as $key => $value): ?>
                        <option value="<?= $value->lesson_id; ?>"><?= $value->lesson_name; ?></option>
                        <?php
                    endforeach;
                endif;
                ?>
            </select>
            <?php if (validation_errors() && form_error('lesson')): ?>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <button class="btn btn-block btn-danger disabled"><?php echo form_error('lesson'); ?></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">ثبت</button>
</form>
