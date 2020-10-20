
<div class="col-sm-12">
    <div class="white-box">
        <div class="table-responsive">
            <?php if ($this->session->flashdata('update-successfully-msg')): ?>
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('update-successfully-msg'); ?>
                </div>
            <?php endif; ?>
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">کد دوره</th>
                        <th class="text-center">نام دوره</th>
                        <th class="text-danger text-center">شهریه دوره</th>
                        <th class="text-success text-center">پرداختی این دوره</th>
                        <th class="text-center">مانده</th>
                        <th class="text-center">وضعیت</th>
                        <th class="text-center">ابزار</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">کد دوره</th>
                        <th class="text-center">نام دوره</th>
                        <th class="text-danger text-center">شهریه دوره</th>
                        <th class="text-success text-center">پرداختی این دوره</th>
                        <th class="text-center">مانده</th>
                        <th class="text-center">وضعیت</th>
                        <th class="text-center">ابزار</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if (!empty($courses)): ?>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($course->course_cost, ENT_QUOTES); ?> 
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($course->course_cost_pay, ENT_QUOTES); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($course->course_cost - $course->course_cost_pay, ENT_QUOTES); ?>
                                </td>
                                <td>
                                    <?php if ($course->course_cost > $course->course_cost_pay): ?>
                                        <div class="label label-danger">
                                            بدهکار
                                        </div>
                                    <?php elseif ($course->course_cost === $course->course_cost_pay): ?>
                                        <div class="label label-success">
                                            تسویه
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($course->course_cost > $course->course_cost_pay): ?>
                                        <button type="button" data-toggle="modal" data-target="#check_pay_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" style="" class="btn btn-default"> <i class="fa fa-check"></i>پرداخت چک</button>
                                        <div id="check_pay_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            //مدال جهت پنجره پرداخت چک
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title" id="myModalLabel">پرداخت از طریق چک </h4> </div>
                                                    <div class="modal-body">
                                                        <form action="<?php echo base_url(); ?>financial/check-course-pay" method="post">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                                                            <div class="form-group">
                                                                <label for="amount">مبلغ چک : </label>
                                                                <input type="number" name="amount" max="<?php echo htmlspecialchars($course->course_cost, ENT_QUOTES); ?>" class="form-control" id="amount">
                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($course->student_nc, ENT_QUOTES); ?>" class="form-control">
                                                                <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" class="form-control">

                                                            </div>
                                                            <div class="form-group">
                                                                <label for="serial_num">شماره سریال چک : </label>
                                                                <input type="number" name="serial_num" class="form-control" id="serial_num">

                                                            </div>
                                                            <div class="form-group">
                                                                <label for="check_date">تاریخ چک : </label>
                                                                <input type="text" name="check_date" class="form-control start-date" id="check_date">

                                                            </div>
                                                            <div class="form-group">
                                                                <button type="submit" style="" class="btn btn-success form-control">ثبت چک</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">بستن</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>	
                                        </div>
                                        <button type="button" data-toggle="modal" data-target="#cash_pay_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" style="" class="btn btn-default"> <i class="fa fa-check"></i>پرداخت نقدی</button>
                                        <div id="cash_pay_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title" id="myModalLabel">پرداخت نقدی</h4> </div>
                                                    <div class="modal-body">
                                                        <form action="<?php echo base_url(); ?>financial/cash-course-pay" method="post">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                                                            <div class="form-group">
                                                                <label for="amount">مبلغ پرداختی : </label>
                                                                <input type="number" name="amount" max="<?php echo htmlspecialchars($course->course_cost, ENT_QUOTES); ?>" class="form-control" id="amount">
                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($course->student_nc, ENT_QUOTES); ?>" class="form-control">
                                                                <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" class="form-control">
                                                                <input type="hidden" name="course_id" class="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                <input type="hidden" name="lesson_id" class="<?php echo htmlspecialchars($course->lesson_id, ENT_QUOTES); ?>">

                                                            </div>
                                                            <div class="form-group">
                                                                <button type="submit" style="" class="btn btn-success form-control">پرداخت</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">بستن</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                        </div>
                                        <button type="button" data-toggle="modal" data-target="#pouse_pay_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" style="" class="btn btn-default"> <i class="fa fa-check"></i>پرداخت کارتخوان</button>
                                        <div id="pouse_pay_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title" id="myModalLabel">پرداخت کارتخوان</h4> </div>
                                                    <div class="modal-body">
                                                        <form action="<?php echo base_url(); ?>financial/pouse-course-pay" method="post">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                                                            <div class="form-group">
                                                                <label for="amount">مبلغ پرداختی : </label>
                                                                <input type="number" name="amount" max="<?php echo htmlspecialchars($course->course_cost, ENT_QUOTES); ?>" class="form-control" id="amount">
                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($course->student_nc, ENT_QUOTES); ?>" class="form-control">
                                                                <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" class="form-control">

                                                            </div>
                                                            <div class="form-group">
                                                                <label for="transaction_num">شماره تراکنش : (شماره رسید)</label>
                                                                <input type="number" name="transaction_num" class="form-control" id="transaction_num">
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="submit" style="" class="btn btn-success form-control">پرداخت</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">بستن</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <button type="button" disabled style="" class="btn btn-success"> <i class="fa fa-check"></i>تسویه شده</button>
                                    <?php endif; ?>
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