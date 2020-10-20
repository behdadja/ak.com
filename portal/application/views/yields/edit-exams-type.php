<div class="col-md-12">
    <div class="white-box">

        <!--.row-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">ویرایش آزمون با کد : <?php
                        if (!empty($exam_type_info)) {
                            echo htmlspecialchars($exam_type_info[0]->exam_id, ENT_QUOTES);
                        }
                        ?></div>
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body">
                            <?php if ($this->session->flashdata('success-insert')) : ?>
                                <div class="alert alert-success"><?php echo $this->session->flashdata('success-insert'); ?></div>
                            <?php endif; ?>
                            <form action="<?php echo base_url(); ?>enrollment/update-exam" method="post" name="class_register">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                                <div class="form-body">
                                    <h3 class="box-title">اطلاعات درس</h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger ">نوع آزمون</label>
                                                <input disabled type="text" name="exam_type" id="exam_type" class="form-control" placeholder="" required="" value="<?php echo htmlspecialchars($exam_type_info[0]->exam_type, ENT_QUOTES); ?>"> <span class="help-block"></span> </div>
                                            <input type="hidden" name="exam_id" value="<?php echo htmlspecialchars($exam_type_info[0]->exam_id, ENT_QUOTES); ?>">
                                            <?php if (validation_errors() && form_error('lesson_name')): ?>
                                                <div class="alert alert-danger"><?php echo form_error('lesson_name'); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> هزینه آزمون</label>
                                            <input type="number" name="exam_tuition" id="exam_tuition" class="form-control" placeholder="" value="<?php echo htmlspecialchars($exam_type_info[0]->exam_cost, ENT_QUOTES); ?>" required=""> <span class="help-block">به تومان وارد نمایید</span> </div>
                                        <?php if (validation_errors() && form_error('exam_tuition')): ?>
                                            <div class="alert alert-danger"><?php echo form_error('exam_tuition'); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!--/row-->
                                <div class="col-md-12">
                                    <div class="form-actions">
                                        <button type="submit" style="float:left" class="btn btn-success"> <i class="fa fa-check"></i>ویرایش آزمون</button>
                                    </div>
                                </div>

                        </div></form>
                    </div>
                </div>
            </div>
        </div>
        <!--./row-->
    </div>
</div>
</div>
