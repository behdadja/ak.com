<div class="row" style="background-color: #e3e3ff; margin-bottom: 30px;border-radius: 50px 0">
    <div style="padding: 20px">
        <div class="panel" style="background-color: white;line-height:30px; border-radius: 50px 0">
            <div class="panel-body" style="padding: 5px;font-size: 13px">
                <div class="col-sm-1 p-t-10">
                    <div class="panel-info">
                        <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo htmlspecialchars($employers[0]->pic_name, ENT_QUOTES) ?>"
                             height="70" alt="user" class="img-circle">
                    </div>
                </div>
                <div class="col-sm-11">
                    <div class="col-sm-4 panel-info">
                        <span>نام و نام خانوادگی: </span>
                        <span class="counter m-t-5"><?php echo $full_name = $employers[0]->first_name . ' ' . $employers[0]->last_name; ?></span>
                    </div>
                    <div class="col-sm-4 panel-info">
                        <span>کد ملی: </span>
                        <span class="counter m-t-5"><?php echo $employers[0]->national_code; ?></span>
                    </div>
                    <div class="col-sm-4 panel-info">
                        <span>تاریخ تولد: </span>
                        <input readonly value="<?php echo $employers[0]->birthday; ?>" style="border: none; width: 80px;">
                        <!--<span class="counter m-t-5"><?php echo $employers[0]->birthday; ?></span>-->
                    </div>
                    <div class="col-sm-4 panel-info">
                        <span>شماره همراه: </span>
                        <span class="counter m-t-5"><?php echo $phone_num = $employers[0]->phone_num; ?></span>
                    </div>
                    <div class="col-sm-4 panel-info">
                        <span>شماره تماس: </span>
                        <span class="counter text-right m-t-5"><?php echo $employers[0]->tell; ?></span>
                    </div>
                    <div class="col-sm-4 panel-info">
                        <span>نام پدر: </span>
                        <span class="counter m-t-5"><?php echo $employers[0]->father_name; ?></span>
                    </div>
                    <div class="col-sm-8">
                        <span>آدرس: </span>
                        <span class="counter m-t-5"><?php echo $employers[0]->province . ' - ' . $employers[0]->city . ' - ' . $employers[0]->street; ?></span>
                    </div>
                    <div class="col-sm-4">
                        <span>کد پستی: </span>
                        <span class="counter m-t-5"><?php echo $employers[0]->postal_code; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="white-box">
                <div class="col-lg-4 col-sm-6 b-0">
                    <ul class="col-in">
                        <li>
                            <span class="circle circle-md <?php
                            if (!empty($financial_state) && $financial_state[0]->final_amount > 0) {
                                echo 'bg-success';
                            } else {
                                echo 'bg-info';
                            }
                            ?>"><i class="glyphicon glyphicon-usd"></i>
                            </span>
                        </li>
                        <li class="col-last">
                            <h3 class="counter text-right m-t-15">
                                <?php
                                if (!empty($financial_state)):
                                    echo number_format($financial_state[0]->final_amount);
                                else:
                                    echo '0';
                                endif;
                                ?>

                            </h3>
                        </li>
                        <li class="col-middle">
                            <h6>وضعیت مالی </h6>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-6 row-in-br  b-r-none">
                    <ul class="col-in">
                        <li>
                            <span class="circle circle-md bg-info"><i class="glyphicon glyphicon-user"></i></span>
                        </li>
                        <li class="col-last">
                            <h3 class="counter text-right m-t-15">
                                <?php
                                $count = 0;
                                foreach ($courses as $course) {
                                    $count += $course->count_std;
                                }
                                echo $count;
                                ?>
                            </h3>
                        </li>
                        <li class="col-middle">
                            <h6>تعداد <?php echo $this->session->userdata('studentDName') . " ها"; ?></h6>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-6 row-in-br">
                    <ul class="col-in">
                        <li>
                            <span class="circle circle-md bg-warning"><i class="mdi mdi-folder-multiple"></i></span>
                        </li>
                        <li class="col-last">
                            <h3 class="counter text-right m-t-15"><?php echo sizeof($courses); ?></h3>
                        </li>
                        <li class="col-middle">
                            <h6>تعداد دوره ها</h6>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3"></div>
<div class="col-md-6">
    <!-- Nav tabs -->
    <ul class="nav customtab nav-tabs" role="tablist">
        <li style="width: 50%" role="presentation" class="active text-center"><a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab"  href="#tab1">وضعیت مالی دوره ها</a></li>
        <li style="width: 50%" role="presentation" class="text-center"><a aria-controls="profile" data-toggle="tab" role="tab" aria-expanded="false"  href="#tab2">لیست پرداخت ها</a></li>
    </ul>
</div>
<div class="col-md-3"></div>
<!-- Tab panes -->
<div class="col-md-12 tab-content">
    <div role="tabpanel" class="tab-pane fade active in" id="tab1">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="table-responsive">
                    <table id="example24" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">کد دوره</th>
                                <th class="text-center">نام دوره</th>
                                <th class="text-center">نوع دستمزد</th>
                                <th class="text-center">مقدار</th>
                                <th class="text-center">تعداد <?php echo $this->session->userdata('studentDName'); ?></th>
                                <th class="text-danger text-center">دستمزد هر دوره</th>
                                <th class="text-center">دریافتی</th>
                                <th class="text-center">مانده</th>
                                <th class="text-center">پرداخت</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="text-center">کد دوره</th>
                                <th class="text-center">نام دوره</th>
                                <th class="text-center">نوع دستمزد</th>
                                <th class="text-center">مقدار</th>
                                <th class="text-center">تعداد <?php echo $this->session->userdata('studentDName'); ?></th>
                                <th class="text-danger text-center">دستمزد هر دوره</th>
                                <th class="text-center">دریافتی</th>
                                <th class="text-center">مانده</th>
                                <th class="text-center">پرداخت</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if (!empty($courses)):
                                foreach ($courses as $course):
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php
                                            if ($course->type_pay === '0'):
                                                echo 'درصدی';
                                            elseif ($course->type_pay === '1'):
                                                echo 'ساعتی';
                                            elseif ($course->type_pay === '2'):
                                                echo 'ماهیانه(_)';
                                            endif;
                                            ?>
                                        </td>
                                        <td class="text-center"><?php
                                            if ($course->type_pay === '0') {
                                                echo $course->value_pay . ' %';
                                            } elseif ($course->type_pay === '1') {
                                                echo number_format($course->value_pay) . ' $';
                                            } elseif ($course->type_pay === '2') {
                                                echo '_';
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center"><?php echo htmlspecialchars($course->count_std, ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php
                                            if ($course->type_pay === '2') {
                                                echo '_';
                                            } else {
                                                echo number_format($course->course_amount);
                                            }
                                            if ($course->type_course === '1' && $course->type_pay === '0' && $course->type_tuition === '0') {
                                                ?>
                                                <a href="#" data-toggle="modal" data-target="#modal_<?php echo $course->course_amount; ?>"> <i class="btn btn-default mdi mdi-pencil" data-toggle="tooltip" data-original-title="ویرایش مبلغ"></i> </a>
                                                <!-- .modal -->
                                                <div id="modal_<?php echo $course->course_amount; ?>" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="myModalLabel">ویرایش مبلغ دستمزد این دوره:</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?php echo base_url('users/edit-course-amount'); ?>" method="post">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <div class="form-group">
                                                                        <label>مبلغ جدید:</label>
                                                                        <input type="number" name="course_amount" class="form-control" value="<?php echo $course->course_amount ?>">
                                                                        <input type="hidden" name="course_master" value="<?php echo $course->course_master ?>">
                                                                        <input type="hidden" name="course_id" value="<?php echo $course->course_id ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <button class="form-control btn btn-success">ثبت</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">بستن</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }
                                            ?>
                                        </td>
                                        <td class="text-center"><?php
                                            if ($course->type_pay === '2') {
                                                echo '_';
                                            } else {
                                                echo number_format($course->amount_received);
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center"><?php
                                            if ($course->type_pay === '2') {
                                                echo '_';
                                            } else {
                                                echo number_format($balance = $course->course_amount - $course->amount_received);
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            if ($course->type_pay === '2') {
                                                echo '_';
                                            } else {
                                                if ($course->course_amount > $course->amount_received):
                                                    ?>
                                                    <!-- *********************** -->
                                                    <button type="button" data-toggle="modal" data-target="#payment_<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>" class="btn btn-default"> <i class="fa fa-check"></i></button>
                                                    <div id="payment_<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                    <h4 class="modal-title text-center" id="myModalLabel">پرداخت</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <section>
                                                                        <div class="sttabs tabs-style-flip">
                                                                            <nav>
                                                                                <ul >
                                                                                    <li><a href="#pouse" class="sticon fa fa-credit-card"><span>کارتخوان</span></a></li>
                                                                                    <li><a href="#cash" class="sticon fa fa-money"><span>نقد</span></a></li>
                                                                                    <li><a href="#check" class="sticon glyphicon glyphicon-edit"><span>چک</span></a></li>
                                                                                </ul>
                                                                            </nav>
                                                                            <div class="content-wrap">
                                                                                <!-- کارتخوان -->
                                                                                <section id="pouse" >
                                                                                    <form action="<?php echo base_url(); ?>financial/pouse-course-pay-em" method="post">
                                                                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                        <input type="hidden" name="course_master" value="<?php echo htmlspecialchars($course->course_master, ENT_QUOTES); ?>" class="form-control">
                                                                                        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>" class="form-control">
                                                                                        <input type="hidden" name="full_name"value="<?php echo htmlspecialchars($full_name, ENT_QUOTES); ?>"class="form-control">
                                                                                        <input type="hidden" name="phone_num"value="<?php echo htmlspecialchars($phone_num, ENT_QUOTES); ?>"class="form-control">
                                                                                        <input type="hidden" name="lesson_name"value="<?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?>"class="form-control">
                                                                                        <input type="hidden" name="lesson_id"value="<?php echo htmlspecialchars($course->lesson_id, ENT_QUOTES); ?>"class="form-control">
                                                                                        <input type="hidden" name="amount_received"value="<?php echo htmlspecialchars($course->amount_received, ENT_QUOTES); ?>"class="form-control">
                                                                                        <input type="hidden" name="course_employee_id"value="<?php echo htmlspecialchars($course->course_employee_id, ENT_QUOTES); ?>"class="form-control">
                                                                                        <div class="form-group">
                                                                                            <label for="amount">مبلغ پرداختی : </label>
                                                                                            <input type="number" name="amount" max="<?php echo htmlspecialchars($balance, ENT_QUOTES); ?>" class="form-control" id="amount">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="transaction_num">شماره تراکنش : (شماره رسید)</label>
                                                                                            <input type="number" name="transaction_num" class="form-control" id="transaction_num">
                                                                                        </div>
                                                                                        <div class="form-group" style="margin-bottom: -10px">
                                                                                            <button style="width: 50%" type="submit" class="btn btn-success form-control">ثبت</button>
                                                                                            <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </section>
                                                                                <!-- نقد -->
                                                                                <section id="cash">
                                                                                    <form action="<?php echo base_url(); ?>financial/cash-course-pay-em" method="post">
                                                                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                        <div class="form-group">
                                                                                            <label for="amount">مبلغ پرداختی : </label>
                                                                                            <input type="number" name="amount" max="<?php echo htmlspecialchars($balance, ENT_QUOTES); ?>" class="form-control" id="amount">
                                                                                            <input type="hidden" name="course_master" value="<?php echo htmlspecialchars($course->course_master, ENT_QUOTES); ?>" class="form-control">
                                                                                            <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                                            <input type="hidden" name="lesson_id" value="<?php echo htmlspecialchars($course->lesson_id, ENT_QUOTES); ?>">
                                                                                            <input type="hidden" name="full_name"value="<?php echo htmlspecialchars($full_name, ENT_QUOTES); ?>"class="form-control">
                                                                                            <input type="hidden" name="phone_num"value="<?php echo htmlspecialchars($phone_num, ENT_QUOTES); ?>"class="form-control">
                                                                                            <input type="hidden" name="lesson_name"value="<?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?>"class="form-control">
                                                                                            <input type="hidden" name="lesson_id"value="<?php echo htmlspecialchars($course->lesson_id, ENT_QUOTES); ?>"class="form-control">
                                                                                            <input type="hidden" name="amount_received"value="<?php echo htmlspecialchars($course->amount_received, ENT_QUOTES); ?>"class="form-control">
                                                                                            <input type="hidden" name="course_employee_id"value="<?php echo htmlspecialchars($course->course_employee_id, ENT_QUOTES); ?>"class="form-control">
                                                                                        </div>
                                                                                        <div class="form-group" style="margin-bottom: -10px">
                                                                                            <button style="width: 50%" type="submit" style="" class="btn btn-success form-control">ثبت</button>
                                                                                            <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </section>
                                                                                <!-- چک -->
                                                                                <section id="pouse">
                                                                                    <form action="<?php echo base_url(); ?>financial/check_course_pay_em" method="post">
                                                                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                        <div class="form-group">
                                                                                            <label for="amount">مبلغ چک : </label>
                                                                                            <input type="number" name="amount" max="<?php echo htmlspecialchars($balance, ENT_QUOTES); ?>" class="form-control" id="amount">
                                                                                            <input type="hidden" name="course_master" value="<?php echo htmlspecialchars($course->course_master, ENT_QUOTES); ?>" class="form-control">
                                                                                            <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>" class="form-control">
                                                                                            <input type="hidden" name="full_name"value="<?php echo htmlspecialchars($full_name, ENT_QUOTES); ?>"class="form-control">
                                                                                            <input type="hidden" name="phone_num"value="<?php echo htmlspecialchars($phone_num, ENT_QUOTES); ?>"class="form-control">
                                                                                            <input type="hidden" name="lesson_name"value="<?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?>"class="form-control">
                                                                                            <input type="hidden" name="lesson_id"value="<?php echo htmlspecialchars($course->lesson_id, ENT_QUOTES); ?>"class="form-control">
                                                                                            <input type="hidden" name="amount_received"value="<?php echo htmlspecialchars($course->amount_received, ENT_QUOTES); ?>"class="form-control">
                                                                                            <input type="hidden" name="course_employee_id"value="<?php echo htmlspecialchars($course->course_employee_id, ENT_QUOTES); ?>"class="form-control">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="serial_num">شماره سریال چک : </label>
                                                                                            <input type="number" name="serial_num" class="form-control" id="serial_num">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="check_date">تاریخ چک : </label>
                                                                                            <input type="date" name="check_date" class="form-control start-date" id="check_date">
                                                                                        </div>
                                                                                        <div class="form-group" style="margin-bottom: -10px">
                                                                                            <button style="width: 50%" type="submit" class="btn btn-success form-control">ثبت چک</button>
                                                                                            <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </section>
                                                                            </div>
                                                                            <!-- /content -->
                                                                        </div>
                                                                        <!-- /tabs -->
                                                                    </section>                                                                                                  
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                    </div>
                                                    <!-- ************************ -->                                                                                                                                                                     
                                                <?php else: ?>
                                                    <div class="label label-success">تسویه</div>
                                                <?php
                                                endif;
                                            }
                                            ?>
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
    </div>
    <div role="tabpanel" class="tab-pane fade" id="tab2">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="table-responsive">
                    <table id="example26" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">مبلغ پرداختی</th>
                                <th class="text-center">شماره (تراکنش یا چک)</th>
                                <th class="text-center">تاریخ پرداخت</th>
                                <th class="text-center">کد دوره</th>
                                <th class="text-center">نوع پرداخت</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="text-center">مبلغ پرداختی</th>
                                <th class="text-center">شماره (تراکنش یا چک)</th>
                                <th class="text-center">تاریخ پرداخت</th>
                                <th class="text-center">کد دوره</th>
                                <th class="text-center">نوع پرداخت</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if (!empty($course_pouse)):
                                foreach ($course_pouse as $pouse_info):
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlspecialchars(number_format($pouse_info->course_pouse_amount), ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($pouse_info->transaction_number, ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($pouse_info->date_payment, ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($pouse_info->course_id, ENT_QUOTES); ?></td>
                                        <td class="text-center">کارت</td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            if (!empty($course_cash)):
                                foreach ($course_cash as $cash_info):
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlspecialchars(number_format($cash_info->course_amount_of_pay), ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($cash_info->course_cash_pay_id, ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($cash_info->date_payment, ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($cash_info->course_id, ENT_QUOTES); ?></td>
                                        <td class="text-center">نقد</td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            if (!empty($course_check)):
                                foreach ($course_check as $ckeck_info):
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlspecialchars(number_format($ckeck_info->check_amount), ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($ckeck_info->serial_number, ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($ckeck_info->check_date, ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($ckeck_info->course_id, ENT_QUOTES); ?></td>
                                        <td class="text-center">چک</td>
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
    </div>
</div>

