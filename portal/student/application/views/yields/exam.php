<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">آزمون آنلاین <?= $examQ[0]->lesson_name; ?></h3>
            <p class="text-muted m-b-30 font-13 alert alert-warning">همه سوالات را مرحله به مرحله پاسخ داده و روی دکمه تایید کلیک کنید.</p>
            <div id="exampleBasic2" class="wizard">
                <ul class="wizard-steps" role="tablist">
                    <?php
                    $i = 1;
                    foreach ($examQ as $key => $question):
                        ?>
                        <li class="<?php
                        if ($i === 1) {
                            echo "active";
                        }
                        ?>" role="tab">
                            <h4><span><?= $i; ?></span></h4>
                        </li>
                        <?php
                        $i++;
                    endforeach;
                    ?>
                    <li role="tab">
                        <h4><span>پایان</span></h4>
                    </li>
                </ul>
                <form class="form-horizontal" action="<?= base_url(); ?>student/exams/correction-of-exam" method="post">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input type="hidden" name="exam_code" value="<?= $examQ[0]->exam_code; ?>">
                    <div class="wizard-content">
                        <?php
                        $j = 1;
                        foreach ($examQ as $key => $question):
                            ?>
                            <div class="wizard-pane <?php
                            if ($j === 1) {
                                echo "active";
                            }
                            ?>" role="tabpanel">
                                <input type="hidden" name="question_id_<?= $j; ?>" value="<?= $question->question_id; ?>">
                                <div class="form-group has-warning">
                                    <label class="col-md-12">سوال شماره <?= $j; ?></label>
                                    <div class="col-md-12">
                                        <textarea name="body" disabled class="form-control" rows="5"><?= $question->question_body; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-check">
                                    1) <input class="form-check-input" type="radio" name="question_<?= $j; ?>" id="first_choice" value="1">
                                    <label class="form-check-label" for="first_choice">
                                        <?= $question->first_choice; ?>
                                    </label>
                                </div>
                                <div class="form-check">
                                    2) <input class="form-check-input" type="radio" name="question_<?= $j; ?>" id="second_choice" value="2">
                                    <label class="form-check-label" for="second_choice">
                                        <?= $question->second_choice; ?>
                                    </label>
                                </div>
                                <div class="form-check disabled">
                                    3) <input class="form-check-input" type="radio" name="question_<?= $j; ?>" id="third_choice" value="3">
                                    <label class="form-check-label" for="third_choice">
                                        <?= $question->third_choice; ?>
                                    </label>
                                </div>
                                <div class="form-check disabled">
                                    4) <input class="form-check-input" type="radio" name="question_<?= $j; ?>" id="fourth_choice" value="4">
                                    <label class="form-check-label" for="fourth_choice">
                                        <?= $question->fourth_choice; ?>
                                    </label>
                                </div>

                            </div>
                            <?php
                            $j++;
                        endforeach;
                        ?>
                        <div class="wizard-pane" role="tabpanel">
                            <button type="submit" class="btn btn-success">پایان</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
