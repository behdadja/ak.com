<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <div class="row row-in">
                <div class="col-md-4 col-sm-12 row-in-br b-r-none">
                    <ul class="col-in">
                        <?php
                        ?>
                        <li>
                            <span class="circle circle-md <?php
                            if (!empty($financial_state)) {
                                if ($financial_state[0]->final_amount > 0) {
                                    echo 'bg-success';
                                } else {
                                    echo 'bg-info';
                                }
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
                <div class="col-md-4 col-sm-12 row-in-br b-r-none">
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
                <div class="col-md-4 col-sm-12 row-in-br b-r-none">
                    <ul class="col-in">
                        <li>
                            <span class="circle circle-md bg-success"><i class="glyphicon glyphicon-briefcase"></i></span>
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
<section class="m-t-40">
    <div class="sttabs tabs-style-linebox">
        <nav>
            <ul>
                <li><a href="tab-stylish.html#section-linebox-1"><span>وضعیت مالی دوره ها</span></a></li>
                <li><a href="tab-stylish.html#section-linebox-2"><span>لیست پرداخت ها</span></a></li>
            </ul>
        </nav>
        <div class="content-wrap text-center">
            <section id="section-linebox-1">
                <div class="col-sm-12">
                    <div class="white-box">
                        <div class="table-responsive">
                            <table id="example24" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">کد دوره</th>
                                        <th>نام دوره</th>
                                        <th class="text-center">نوع دستمزد</th>
                                        <th class="text-center">مقدار</th>
                                        <th class="text-center">تعداد <?php echo $this->session->userdata('studentDName'); ?></th>
                                        <th class="text-danger text-center">دستمزد دوره</th>
                                        <th class="text-center">دریافتی</th>
                                        <th class="text-center">مانده</th>
                                        <th class="text-center">وضعیت</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">کد دوره</th>
                                        <th>نام دوره</th>
                                        <th class="text-center">نوع دستمزد</th>
                                        <th class="text-center">مقدار</th>
                                        <th class="text-center">تعداد <?php echo $this->session->userdata('studentDName'); ?></th>
                                        <th class="text-danger text-center">دستمزد دوره</th>
                                        <th class="text-center">دریافتی</th>
                                        <th class="text-center">مانده</th>
                                        <th class="text-center">وضعیت</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    if (!empty($courses)):
                                        foreach ($courses as $course):
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?></td>
                                                <td class="pull-left">
                                                    <img src="<?php echo base_url(); ?>./assets/course-picture/thumb/<?php echo htmlspecialchars($course->course_pic, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                                                    <?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?></td>
                                                <td>
                                                    <?php
                                                    if ($course->type_pay === '0'):
                                                        echo 'درصدی';
                                                    elseif ($course->type_pay === '1'):
                                                        echo 'ساعتی';
                                                    elseif ($course->type_pay === '2'):
                                                        echo 'ماهیانه(_)';
                                                    endif;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($course->type_pay === '0') {
                                                        echo $course->value_pay . ' %';
                                                    } elseif ($course->type_pay === '1') {
                                                        echo number_format($course->value_pay) . ' $';
                                                    } elseif ($course->type_pay === '2') {
                                                        echo '_';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($course->count_std, ENT_QUOTES); ?></td>
                                                <td>
                                                    <?php
                                                    if ($course->type_pay === '2') {
                                                        echo '_';
                                                    } else {
                                                        echo number_format($course->course_amount);
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($course->type_pay === '2') {
                                                        echo '_';
                                                    } else {
                                                        echo number_format($course->amount_received);
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($course->type_pay === '2') {
                                                        echo '_';
                                                    } else {
                                                        echo number_format($course->course_amount - $course->amount_received);
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if ($course->course_amount === $course->amount_received): ?>
                                                        <div class="label label-danger">
                                                            تسویه
                                                        </div>
                                                    <?php elseif ($course->course_amount > $course->amount_received): ?>
                                                        <div class="label label-success">
                                                            بستانکار
                                                        </div>
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
            </section>
            <section id="section-linebox-2">
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
                                                <td><?php echo htmlspecialchars(number_format($pouse_info->course_pouse_amount), ENT_QUOTES); ?></td>
                                                <td><?php echo htmlspecialchars($pouse_info->transaction_number, ENT_QUOTES); ?></td>
                                                <td><?php echo htmlspecialchars($pouse_info->date_payment, ENT_QUOTES); ?></td>
                                                <td><?php echo htmlspecialchars($pouse_info->course_id, ENT_QUOTES); ?></td>
                                                <td>کارت</td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    endif;
                                    if (!empty($course_cash)):
                                        foreach ($course_cash as $cash_info):
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars(number_format($cash_info->course_amount_of_pay), ENT_QUOTES); ?></td>
                                                <td><?php echo htmlspecialchars($cash_info->course_cash_pay_id, ENT_QUOTES); ?></td>
                                                <td><?php echo htmlspecialchars($cash_info->date_payment, ENT_QUOTES); ?></td>
                                                <td><?php echo htmlspecialchars($cash_info->course_id, ENT_QUOTES); ?></td>
                                                <td>نقد</td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    endif;
                                    if (!empty($course_check)):
                                        foreach ($course_check as $ckeck_info):
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars(number_format($ckeck_info->check_amount), ENT_QUOTES); ?></td>
                                                <td><?php echo htmlspecialchars($ckeck_info->serial_number, ENT_QUOTES); ?></td>
                                                <td><?php echo htmlspecialchars($ckeck_info->check_date, ENT_QUOTES); ?></td>
                                                <td><?php echo htmlspecialchars($ckeck_info->course_id, ENT_QUOTES); ?></td>
                                                <td>چک</td>
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
            </section>
        </div>
        <!-- /content -->
    </div>
    <!-- /tabs -->
</section>
