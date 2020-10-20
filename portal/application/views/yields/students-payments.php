<?php if ($this->session->flashdata('success_request')){ ?>
<div class="alert alert-success"> <?= $this->session->flashdata('success_request'); ?></div>
<?php } ?>
<?php if ($this->session->flashdata('failed_request')){ ?>
    <div class="alert alert-warning"> <?= $this->session->flashdata('failed_request'); ?></div>
<?php } ?>
<div class="col-sm-12">

    <div class="table-responsive">
        <table id="example23" class="display nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="text-center">کد <?php echo $this->session->userdata('studentDName');?></th>
                <th>نام و نام خانوادگی</th>
                <th class="text-center">کد ملی</th>
                <th class="text-center">کد پرداخت</th>
                <th class="text-center">شماره رسید</th>
                <th class="text-center">مبلغ پرداختی</th>
                <th class="text-center">تاریخ پرداخت</th>
                <th class="text-center">کد دوره</th>
                <th class="text-center">کد آزمون</th>
                <th class="text-center">رسید پرداخت</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th class="text-center">کد <?php echo $this->session->userdata('studentDName');?></th>
                <th>نام و نام خانوادگی</th>
                <th class="text-center">کد ملی</th>
                <th class="text-center">کد پرداخت</th>
                <th class="text-center">شماره رسید</th>
                <th class="text-center">مبلغ پرداختی</th>
                <th class="text-center">تاریخ پرداخت</th>
                <th class="text-center">کد دوره</th>
                <th class="text-center">کد آزمون</th>
                <th class="text-center">رسید پرداخت</th>
            </tr>
            </tfoot>
            <tbody>
            <?php if ($online_payments): ?>
                <?php foreach ($online_payments as $o_pay): ?>
                    <tr>
                        <td class="text-center"><?php echo htmlspecialchars($o_pay->student_id, ENT_QUOTES) ?></td>
                        <td>
                            <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo htmlspecialchars($o_pay->pic_name, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                            <?php echo htmlspecialchars($o_pay->first_name . ' ' . $o_pay->last_name, ENT_QUOTES); ?>
                        </td>
                        <td class="text-center"><?php echo htmlspecialchars($o_pay->national_code, ENT_QUOTES) ?></td>

                        <td class="text-center"><?php echo htmlspecialchars($o_pay->online_payments_id, ENT_QUOTES); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($o_pay->verify_code, ENT_QUOTES); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars(number_format($o_pay->paid_amount), ENT_QUOTES); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($o_pay->date_payment, ENT_QUOTES); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($o_pay->course_id, ENT_QUOTES); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($o_pay->exam_id, ENT_QUOTES); ?></td>
                        <td class="text-center">
                            <a data-toggle="modal" data-target="#exampleModal1_<?php echo $o_pay->online_payments_id ?>" data-whatever="@getbootstrap" class="glyphicon glyphicon-print"></a>
                            <div class="modal fade" id="exampleModal1_<?php echo $o_pay->online_payments_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="exampleModalLabel1">پرداخت آنلاین دوره</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <h3>کد پرداخت : <label><?php echo $o_pay->online_payments_id; ?></label></h3>
                                                <h3>شماره رسید: <label><?php echo $o_pay->verify_code; ?></label></h3>
                                                <h3>مبلغ پرداختی: <label><?php echo number_format($paid += $o_pay->paid_amount); ?></label></h3>
                                                <h3>تاریخ پرداخت : <label><?php echo $o_pay->date_payment; ?></label></h3>
                                                <h3>کد دوره : <label><?php echo $o_pay->course_id; ?></label></h3>
                                                <?php if ($o_pay->exam_id !== null): ?>
                                                    <h3>کد آزمون : <label><?php echo $o_pay->exam_id; ?></label></h3>
                                                <?php endif; ?>
                                                <h3>نوع پرداخت: <label>آنلاین</label></h3>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
                                                <button type="submit" class="btn btn-primary">پرینت</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach;
            endif;
            ?>
            </tbody>
        </table>
        <br>
        <br>
        <div class="col-md-4" style="background-color: lightgreen">
            <?php if (isset($paid)){ ?>
            <h4 class="text-center">  مجموع پرداخت ها: <?php echo $paid.' '.' تومان'?></h4>
            <?php }else{ ?>
                <h4 class="text-center">  مجموع پرداخت ها: 0</h4>
           <?php } ?>
        </div>
        <div class="col-md-2">
            <a href=" <?= base_url('reckon_request') ?> "><button type="button" class="btn btn-primary">درخواست تسویه پرداخت ها</button></a>
<!--            <input type="hidden" name="--><?php //echo $this->security->get_csrf_token_name(); ?><!--" value="--><?php //echo $this->security->get_csrf_hash(); ?><!--" />-->
        </div>
    </div>
</div>
