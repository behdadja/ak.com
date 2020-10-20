<div class="col-sm-12">
    <div class="white-box">
        <h3 class="box-title">مدیریت کلاس ها</h3>
        <div class="table-responsive">

            <?php if ($this->session->flashdata('success-delete')) : ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('success-delete'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('success-insert')) : ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('success-insert'); ?></div>
            <?php endif; ?>
                <?php if ($this->session->flashdata('success-update')) : ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('success-update'); ?></div>
            <?php endif; ?>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">کد کلاس</th>
                        <th class="text-center">نام کلاس</th>
                        <th class="text-center">توضیحات</th>
                        <th class="text-nowrap text-center">ابزار</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($classes_info)): ?>
                        <?php foreach ($classes_info as $class_info): ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo htmlspecialchars($class_info->class_id, ENT_QUOTES); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo htmlspecialchars($class_info->class_name, ENT_QUOTES); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo htmlspecialchars($class_info->class_description, ENT_QUOTES); ?>
                                </td>
                                <td class="text-nowrap text-center">
                                    <a href="#" onclick="event.preventDefault();document.getElementById('edit_<?php echo htmlspecialchars($class_info->class_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="ویرایش"> <i class="mdi mdi-pencil text-info m-r-10"></i> </a>|
                                    <form class="" id='edit_<?php echo htmlspecialchars($class_info->class_id); ?>' style="display:none" action="<?php echo base_url(); ?>training/edit-class" method="post">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                        <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_info->class_id, ENT_QUOTES); ?>">
                                    </form>

                                    <a href="#" data-toggle="modal" data-target="#delet_<?php echo $class_info->class_id; ?>"><i class="fa fa-close text-danger m-l-10" data-toggle="tooltip" data-original-title="حذف"></i></a>
                                    <div id="delet_<?php echo $class_info->class_id; ?>" class="modal fade bs-example-modal-sm" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: #edf0f2">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="myModalLabel">حذف کلاس</h4>
                                                </div>
                                                <form action="<?php echo base_url('training/delete-class'); ?>" method="post">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                        <div class="form-group">
                                                            <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_info->class_id, ENT_QUOTES); ?>">
                                                            <p> <?php echo "از حذف " . $class_info->class_name . " اطمینان دارید؟" ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success" style="width: 50%">بله</button>
                                                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal" style="width: 50%">خیر</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

        <!--                                    <a href="#" onclick="event.preventDefault();document.getElementById('delete_<?php echo htmlspecialchars($class_info->class_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="حذف"> <i class="fa fa-close text-danger"></i> </a>
                                            <form class="" id='delete_<?php echo htmlspecialchars($class_info->class_id); ?>' style="display:none" action="<?php echo base_url(); ?>training/delete-class" method="post">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_info->class_id, ENT_QUOTES); ?>">
                                            </form>-->
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
