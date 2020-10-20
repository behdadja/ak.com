<div class="row" style="background-color: #e3e3ff; margin-bottom: 30px;border-radius: 50px 0">
    <div style="padding: 20px">
        <div class="panel" style="background-color: white;line-height:30px; border-radius: 50px 0">
            <div class="panel-body" style="padding: 5px;font-size: 13px">
                <div class="col-sm-1 p-t-10">
                    <div class="panel-info">
                        <?php if ($students[0]->pic_name === ''): ?>
                            <img src="<?php echo base_url(); ?>assets/images/icons/student-icon.png" height="70" alt="user" class="img-circle">
                        <?php else: ?>
                            <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo htmlspecialchars($students[0]->pic_name, ENT_QUOTES) ?>" height="70" alt="user" class="img-circle">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-sm-11">
                    <div class="col-sm-4 panel-info">
                        <span>نام و نام خانوادگی: </span>
                        <span
                            class="counter m-t-5"><?php echo $full_name = $students[0]->first_name . ' ' . $students[0]->last_name; ?></span>
                    </div>
                    <div class="col-sm-4 panel-info">
                        <span>کد ملی: </span>
                        <span class="counter m-t-5"><?php echo $students[0]->national_code; ?></span>
                    </div>
                    <div class="col-sm-4 panel-info">
                        <span>تاریخ تولد: </span>
                        <input readonly value="<?php echo $students[0]->birthday; ?>" style="border: none; width: 80px; background-color: white">
                        <!--<span class="counter m-t-5"><?php echo $students[0]->birthday; ?></span>-->
                    </div>
                    <div class="col-sm-4 panel-info">
                        <span>شماره همراه: </span>
                        <span class="counter m-t-5"><?php echo $phone_num = $students[0]->phone_num; ?></span>
                    </div>
                    <div class="col-sm-4 panel-info">
                        <span>شماره تماس: </span>
                        <span class="counter text-right m-t-5"><?php echo $students[0]->tell; ?></span>
                    </div>
                    <div class="col-sm-4 panel-info">
                        <span>نام پدر: </span>
                        <span class="counter m-t-5"><?php echo $students[0]->father_name; ?></span>
                    </div>
                    <div class="col-sm-8">
                        <span>آدرس: </span>
                        <span
                            class="counter m-t-5"><?php echo $students[0]->province . " - " . $students[0]->city . " - " . $students[0]->street; ?></span>
                    </div>
                    <div class="col-sm-4">
                        <span>کد پستی: </span>
                        <span class="counter m-t-5"><?php echo $students[0]->postal_code; ?></span>
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
                            if (!empty($financial_state) && $financial_state[0]->final_situation === '-1') {
                                echo 'bg-danger';
                            } else {
                                echo 'bg-success';
                            }
                            ?>"><i class="glyphicon glyphicon-usd"></i>
                            </span>
                        </li>
                        <li class="col-last">
                            <h3 class="counter text-right m-t-15"><?php
                                if (!empty($financial_state)) {
                                    echo htmlspecialchars(number_format($financial_state[0]->final_amount), ENT_QUOTES);
                                }
                                ?></h3></li>
                        <li class="col-middle">
                            <h6>وضعیت مالی </h6>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-6 row-in-br">
                    <ul class="col-in">
                        <li>
                            <span class="circle circle-md bg-success"><i class="mdi mdi-folder-multiple"></i></span>
                        </li>
                        <li class="col-last"><h3 class="counter text-right m-t-15"><?php echo sizeof($courses); ?></h3></li>
                        <li class="col-middle">
                            <h6>تعداد دوره ها</h6>
                        </li>

                    </ul>
                </div>
                <div class="col-lg-4 col-sm-6 row-in-br">
                    <ul class="col-in">
                        <li>
                            <span class="circle circle-md bg-warning"><i class="mdi mdi-pencil-box"></i></span>
                        </li>
                        <li class="col-last"><h3 class="counter text-right m-t-15"><?php echo sizeof($exams); ?></h3></li>
                        <li class="col-middle">
                            <h6>تعداد آزمون ها</h6>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="col-md-2"></div>
<div class="col-md-8">
    <!-- Nav tabs -->
    <ul class="nav customtab nav-tabs" role="tablist">
        <li style="width: 25%" role="presentation" class="active text-center"><a aria-expanded="true" data-toggle="tab" role="tab" aria-controls="course"  href="#course">دوره های ثبت نامی</a></li>
        <li style="width: 25%" role="presentation" class="text-center"><a aria-expanded="false" data-toggle="tab" role="tab" aria-controls="exam"  href="#exam">آزمون های ثبت نامی</a></li>
        <li style="width: 25%" role="presentation" class="text-center"><a aria-expanded="false" data-toggle="tab" role="tab" aria-controls="online_payment"  href="#online_payment">پرداخت های اینترنتی</a></li>
        <li style="width: 25%" role="presentation" class="text-center"><a aria-expanded="false" data-toggle="tab" role="tab" aria-controls="payment"  href="#payment">پرداخت های انتقالی</a></li>
    </ul>
</div>
<div class="col-md-2"></div>
<!-- Tab panes -->
<div class="col-md-12 tab-content">
    <div role="tabpanel" class="tab-pane fade active in" id="course">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="table-responsive">
                    <?php if ($this->session->flashdata('update-successfully-msg')): ?>
                        <div class="alert alert-success">
                            <?php echo $this->session->flashdata('update-successfully-msg'); ?>
                        </div>
                    <?php endif; ?>
                    <table id="example25" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">کد دوره</th>
                                <th class="text-center">نام دوره</th>
                                <th class="text-danger text-center">شهریه دوره</th>
                                <th class="text-info text-center">مقدار تخفیف</th>
                                <th class="text-success text-center">پرداختی</th>
                                <th class="text-center">مانده</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center"> نوع پرداخت</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="text-center">کد دوره</th>
                                <th class="text-center">نام دوره</th>
                                <th class="text-danger text-center">شهریه دوره</th>
                                <th class="text-info text-center">مقدار تخفیف</th>
                                <th class="text-success text-center">پرداختی</th>
                                <th class="text-center">مانده</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">نوع پرداخت</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($courses)): ?>
                                <?php foreach ($courses as $course): ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php
                                            echo htmlspecialchars(number_format($course->course_cost), ENT_QUOTES);
                                            if ($course->type_course === '1' && $course->type_pay === '0' && $course->type_tuition === '0') {
                                                ?>
                                                <a href="#" data-toggle="modal" data-target="#modal_<?php echo $course->course_cost; ?>"> <i class="btn btn-default mdi mdi-pencil" data-toggle="tooltip" data-original-title="ویرایش مبلغ"></i> </a>
                                                <!-- .modal -->
                                                <div id="modal_<?php echo $course->course_cost; ?>" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="myModalLabel">ویرایش مبلغ شهریه این دوره:</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?php echo base_url('users/edit-course-cost'); ?>" method="post">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <div class="form-group">
                                                                        <label>مبلغ جدید:</label>
                                                                        <input type="number" name="course_cost" class="form-control" value="<?php echo $course->course_cost ?>">
                                                                        <input type="hidden" name="student_nc" value="<?php echo $students[0]->national_code ?>">
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
                                            ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars(number_format($course->amount_off), ENT_QUOTES); ?></td>
                                        <td class="text-center"> <?php echo htmlspecialchars(number_format($course->course_cost_pay), ENT_QUOTES); ?> </td>
                                        <?php $balance = $course->course_cost - ($course->course_cost_pay + $course->amount_off); ?>
                                        <td class="text-center"><?php echo htmlspecialchars(number_format($balance), ENT_QUOTES); ?></td>
                                        <td class="text-center">
                                            <?php if ($course->course_cost > ($course->course_cost_pay + $course->amount_off)): ?>
                                                <div class="label label-danger">
                                                    بدهکار
                                                </div>
                                            <?php elseif ($course->course_cost == ($course->course_cost_pay + $course->amount_off)): ?>
                                                <div class="label label-success">
                                                    تسویه
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($course->course_cost > ($course->course_cost_pay + $course->amount_off)): ?>

                                                <!-- **************************************** -->
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
                                                                                <li><a href="#discount" class="sticon fa fa-percentage"><span>تخفیف</span></a></li>
                                                                            </ul>
                                                                        </nav>
                                                                        <div class="content-wrap">
                                                                            <!-- کارتخوان -->
                                                                            <section id="pouse" >
                                                                                <form action="<?php echo base_url(); ?>financial/pouse-course-pay" method="post">
                                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                    <div class="form-group">
                                                                                        <label for="amount">مبلغ پرداختی : </label>
                                                                                        <input type="number" name="amount" max="<?php echo htmlspecialchars($course->course_cost - $course->course_cost_pay - $course->amount_off, ENT_QUOTES); ?>" class="form-control" id="amount">
                                                                                        <input type="hidden" name="student_nc"value="<?php echo htmlspecialchars($course->student_nc, ENT_QUOTES); ?>"class="form-control">
                                                                                        <input type="hidden" name="course_student_id"value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>"class="form-control">
                                                                                        <input type="hidden" name="full_name"value="<?php echo htmlspecialchars($full_name, ENT_QUOTES); ?>"class="form-control">
                                                                                        <input type="hidden" name="phone_num"value="<?php echo htmlspecialchars($phone_num, ENT_QUOTES); ?>"class="form-control">
                                                                                        <input type="hidden" name="lesson_name"value="<?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?>"class="form-control">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="transaction_num">شماره تراکنش : (شماره رسید)</label>
                                                                                        <input type="number" name="transaction_num" class="form-control" id="transaction_num">
                                                                                    </div>
                                                                                    <div class="form-group" style="margin-bottom: -10px">
                                                                                        <button style="width: 50%" type="submit" style="" class="btn btn-success form-control">ثبت</button>
                                                                                        <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                    </div>
                                                                                </form>
                                                                            </section>
                                                                            <!-- نقد -->
                                                                            <section id="cash">
                                                                                <form action="<?php echo base_url(); ?>financial/cash-course-pay" method="post">
                                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                    <div class="form-group">
                                                                                        <label for="amount">مبلغ پرداختی : </label>
                                                                                        <input type="number" name="amount" max="<?php echo htmlspecialchars($course->course_cost - $course->course_cost_pay - $course->amount_off, ENT_QUOTES); ?>" class="form-control" id="amount">
                                                                                        <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($course->student_nc, ENT_QUOTES); ?>" class="form-control">
                                                                                        <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" class="form-control">
                                                                                        <input type="hidden" name="course_id" class="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
                                                                                        <input type="hidden" name="lesson_id" class="<?php echo htmlspecialchars($course->lesson_id, ENT_QUOTES); ?>">
                                                                                        <input type="hidden" name="full_name"value="<?php echo htmlspecialchars($full_name, ENT_QUOTES); ?>"class="form-control">
                                                                                        <input type="hidden" name="phone_num"value="<?php echo htmlspecialchars($phone_num, ENT_QUOTES); ?>"class="form-control">
                                                                                        <input type="hidden" name="lesson_name"value="<?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?>"class="form-control">
                                                                                    </div>
                                                                                    <div class="form-group" style="margin-bottom: -10px">
                                                                                        <button style="width: 50%" type="submit" style="" class="btn btn-success form-control">ثبت</button>
                                                                                        <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                    </div>
                                                                                </form>
                                                                            </section>
                                                                            <!-- چک -->
                                                                            <section id="pouse">
                                                                                <form action="<?php echo base_url(); ?>financial/check-course-pay" method="post">
                                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                    <div class="form-group">
                                                                                        <label for="amount">مبلغ چک : </label>
                                                                                        <input type="number" name="amount" max="<?php echo htmlspecialchars($course->course_cost - $course->course_cost_pay - $course->amount_off, ENT_QUOTES); ?>" class="form-control" id="amount">
                                                                                        <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($course->student_nc, ENT_QUOTES); ?>" class="form-control">
                                                                                        <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" class="form-control">
                                                                                        <input type="hidden" name="full_name"value="<?php echo htmlspecialchars($full_name, ENT_QUOTES); ?>"class="form-control">
                                                                                        <input type="hidden" name="phone_num"value="<?php echo htmlspecialchars($phone_num, ENT_QUOTES); ?>"class="form-control">
                                                                                        <input type="hidden" name="lesson_name"value="<?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?>"class="form-control">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="serial_num">شماره سریال چک :
                                                                                        </label>
                                                                                        <input type="number" name="serial_num" class="form-control" id="serial_num">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="check_date">تاریخ چک : </label>
                                                                                        <input type="text" name="check_date" class="form-control start-date" id="check_date">
                                                                                    </div>
                                                                                    <div class="form-group" style="margin-bottom: -10px">
                                                                                        <button style="width: 50%" type="submit" style="" class="btn btn-success form-control">ثبت</button>
                                                                                        <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                    </div>
                                                                                </form>
                                                                            </section>
                                                                            <!-- تخفیف -->
                                                                            <section id="discount">
                                                                                <div class="panel-group" id="accordion">
                                                                                    <div class="panel panel-black">
                                                                                        <a href="#" data-perform="panel-collapse">
                                                                                            <div class="panel-heading">
                                                                                                تخفیف به صورت درصد
                                                                                            </div>
                                                                                        </a>
                                                                                        <div class="panel-wrapper collapse in" aria-expanded="true">
                                                                                            <div class="panel-body">
                                                                                                <form action="<?php echo base_url(); ?>financial/insert_off_course" method="post">
                                                                                                    <div class="input-group form-group"> <span class="input-group-addon">درصد</span>
                                                                                                        <input type="number" placeholder="20" max="<?php echo (int) '100' - (($course->amount_off * (int) '100') / $course->course_cost); ?>" name="amount" class="form-control">
                                                                                                        <input type="hidden" value="1" name='switch'/>
                                                                                                    </div>
                                                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                    <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <input type="hidden" name="course_cost" value="<?php echo htmlspecialchars($course->course_cost, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <input type="hidden" name="student_nc"value="<?php echo htmlspecialchars($course->student_nc, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <input type="hidden" name="full_name"value="<?php echo htmlspecialchars($full_name, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <input type="hidden" name="phone_num"value="<?php echo htmlspecialchars($phone_num, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <input type="hidden" name="lesson_name"value="<?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <div class="form-group" style="margin-bottom: -10px">
                                                                                                        <button style="width: 50%" type="submit" style="" class="btn btn-success form-control">ثبت درصد تخفیف</button>
                                                                                                        <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                        <a href="#" data-perform="panel-collapse">
                                                                                            <div class="panel-heading" style="border-top: white thick solid">
                                                                                                تخفیف به صورت مبلغ
                                                                                            </div>
                                                                                        </a>
                                                                                        <div class="panel-wrapper collapse" aria-expanded="false">
                                                                                            <div class="panel-body">
                                                                                                <form action="<?php echo base_url(); ?>financial/insert_off_course" method="post">
                                                                                                    <div class="input-group form-group"> <span class="input-group-addon">مبلغ</span>
                                                                                                        <input type="number" name="amount"  class="form-control" placeholder="4500" max="<?php echo htmlspecialchars($course->course_cost - $course->course_cost_pay - $course->amount_off, ENT_QUOTES); ?>">
                                                                                                        <input type="hidden" value="2" name='switch'/>
                                                                                                    </div>
                                                                                                    <input type="hidden"name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                    <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <input type="hidden" name="course_cost" value="<?php echo htmlspecialchars($course->course_cost, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <input type="hidden" name="student_nc"value="<?php echo htmlspecialchars($course->student_nc, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <input type="hidden" name="full_name"value="<?php echo htmlspecialchars($full_name, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <input type="hidden" name="phone_num"value="<?php echo htmlspecialchars($phone_num, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <input type="hidden" name="lesson_name"value="<?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <div class="form-group" style="margin-bottom: -10px">
                                                                                                        <button style="width: 50%" type="submit" style="" class="btn btn-success form-control">ثبت مبلغ تخفیف</button>
                                                                                                        <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                                    </div>

                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
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
                                                <!-- **************************************** -->

                                            <?php elseif ($course->amount_off != 0): ?>
                                                                                                                                                                                                                                    <!--<button type="button" disabled style="" class="btn btn-success"> <i class="fa fa-check"></i>تسویه شده</button>-->
                                                <button type="button" data-toggle="modal"data-target="#sale2_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>"style="" class="btn btn-default"> <i class="fa fa-check"></i>تخفیف</button>
                                                <div id="sale2_<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>"class="modal fade" tabindex="-1" role="dialog"aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <!-- مدال جهت پنجره تخفیف  دوره-->
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"aria-hidden="true">×</button>
                                                                <h4 class="modal-title" id="myModalLabel">ثبت تخفیف</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="panel-group" id="accordion">
                                                                    <div class="panel panel-black">
                                                                        <a href="#" data-perform="panel-collapse">
                                                                            <div class="panel-heading">
                                                                                تخفیف به صورت درصد
                                                                            </div>
                                                                        </a>
                                                                        <div class="panel-wrapper collapse in" aria-expanded="true">
                                                                            <div class="panel-body">
                                                                                <form action="<?php echo base_url(); ?>financial/insert_off_course" method="post">
                                                                                    <div class="input-group form-group"> <span class="input-group-addon">درصد</span>
                                                                                        <input type="number" placeholder="20" max="<?php echo (int) '100' - (($course->amount_off * (int) '100') / $course->course_cost); ?>" name="amount" class="form-control">
                                                                                        <input type="hidden" value="1" name='switch'/>
                                                                                    </div>
                                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                    <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>"class="form-control">
                                                                                    <input type="hidden" name="course_cost" value="<?php echo htmlspecialchars($course->course_cost, ENT_QUOTES); ?>"class="form-control">
                                                                                    <input type="hidden" name="student_nc"value="<?php echo htmlspecialchars($course->student_nc, ENT_QUOTES); ?>"class="form-control">
                                                                                    <input type="hidden" name="full_name"value="<?php echo htmlspecialchars($full_name, ENT_QUOTES); ?>"class="form-control">
                                                                                    <input type="hidden" name="phone_num"value="<?php echo htmlspecialchars($phone_num, ENT_QUOTES); ?>"class="form-control">
                                                                                    <input type="hidden" name="lesson_name"value="<?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?>"class="form-control">
                                                                                    <div class="form-group" style="margin-bottom: -10px">
                                                                                        <button style="width: 50%" type="submit" style="" class="btn btn-success form-control">ثبت درصد تخفیف</button>
                                                                                        <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                        <a href="#" data-perform="panel-collapse">
                                                                            <div class="panel-heading" style="border-top: white thick solid">
                                                                                تخفیف به صورت مبلغ
                                                                            </div>
                                                                        </a>
                                                                        <div class="panel-wrapper collapse" aria-expanded="false">
                                                                            <div class="panel-body">
                                                                                <form action="<?php echo base_url(); ?>financial/insert_off_course" method="post">
                                                                                    <div class="input-group form-group"> <span class="input-group-addon">مبلغ</span>
                                                                                        <input type="number" name="amount"  class="form-control" placeholder="4500" max="<?php echo htmlspecialchars($course->course_cost - $course->course_cost_pay - $course->amount_off, ENT_QUOTES); ?>">
                                                                                        <input type="hidden" value="2" name='switch'/>
                                                                                    </div>
                                                                                    <input type="hidden"name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                    <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>"class="form-control">
                                                                                    <input type="hidden" name="course_cost" value="<?php echo htmlspecialchars($course->course_cost, ENT_QUOTES); ?>"class="form-control">
                                                                                    <input type="hidden" name="student_nc"value="<?php echo htmlspecialchars($course->student_nc, ENT_QUOTES); ?>"class="form-control">
                                                                                    <input type="hidden" name="full_name"value="<?php echo htmlspecialchars($full_name, ENT_QUOTES); ?>"class="form-control">
                                                                                    <input type="hidden" name="phone_num"value="<?php echo htmlspecialchars($phone_num, ENT_QUOTES); ?>"class="form-control">
                                                                                    <input type="hidden" name="lesson_name"value="<?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?>"class="form-control">
                                                                                    <div class="form-group" style="margin-bottom: -10px">
                                                                                        <button style="width: 50%" type="submit" style="" class="btn btn-success form-control">ثبت مبلغ تخفیف</button>
                                                                                        <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                    </div>

                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                    </div>
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
    </div>
    <div role="tabpanel" class="tab-pane fade" id="exam">
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
                                <th class="text-center">کد آزمون</th>
                                <th class="text-danger text-center">شهریه آزمون</th>
                                <th class="text-info text-center">مقدار تخفیف</th>
                                <th class="text-success text-center">پرداختی</th>
                                <th class="text-center">مانده</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">پرداخت
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="text-center">کد دوره</th>
                                <th class="text-center">کد آزمون</th>
                                <th class="text-danger text-center">شهریه آزمون</th>
                                <th class="text-info text-center">مقدار تخفیف</th>
                                <th class="text-success text-center">پرداختی</th>
                                <th class="text-center">مانده</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">پرداخت</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($exams)): ?>
                                <?php foreach ($exams as $exam): ?>
                                    <tr>
                                        <td class="text-center"><?php echo htmlspecialchars($exam->course_id, ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($exam->exam_id, ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars(number_format($exam->exam_cost), ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars(number_format($exam->amount_off), ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars(number_format($exam->exam_cost_pay), ENT_QUOTES); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars(number_format($exam->exam_cost - ($exam->exam_cost_pay + $exam->amount_off)), ENT_QUOTES); ?></td>
                                        <td class="text-center">
                                            <?php if ($exam->exam_cost > ($exam->exam_cost_pay + $exam->amount_off)): ?>
                                                <div class="label label-danger">
                                                    بدهکار
                                                </div>
                                            <?php elseif ($exam->exam_cost <= ($exam->exam_cost_pay + $exam->amount_off)): ?>
                                                <div class="label label-success">
                                                    تسویه
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($exam->exam_cost > ($exam->exam_cost_pay + $exam->amount_off)): ?>
                                                <button type="button" data-toggle="modal" data-target="#exam_pay_<?php echo htmlspecialchars($exam->exam_student_id, ENT_QUOTES); ?>" style="" class="btn btn-default"> <i class="fa fa-check"></i></button>
                                                <div id="exam_pay_<?php echo htmlspecialchars($exam->exam_student_id, ENT_QUOTES); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title" id="myModalLabel">پرداخت آزمون
                                                                </h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- *************************************************** -->
                                                                <section>
                                                                    <div class="sttabs tabs-style-flip">
                                                                        <nav>
                                                                            <ul >
                                                                                <li><a href="#pouse" class="sticon fa fa-credit-card"><span>کارتخوان</span></a></li>
                                                                                <li><a href="#cash" class="sticon fa fa-money"><span>نقد</span></a></li>
                                                                                <li><a href="#discount" class="sticon fa fa-percentage"><span>تخفیف</span></a></li>
                                                                            </ul>
                                                                        </nav>
                                                                        <div class="content-wrap">
                                                                            <!-- کارتخوان -->
                                                                            <section id="pouse" >
                                                                                <form action="<?php echo base_url(); ?>financial/pouse-exam-pay" method="post">
                                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                    <div class="form-group">
                                                                                        <label for="amount">مبلغ پرداختی : </label>
                                                                                        <input type="number" name="amount" max="<?php echo htmlspecialchars($exam->exam_cost - $exam->exam_cost_pay - $exam->amount_off, ENT_QUOTES); ?>" class="form-control" id="amount">
                                                                                        <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($exam->student_nc, ENT_QUOTES); ?>" class="form-control">
                                                                                        <input type="hidden" name="exam_student_id" value="<?php echo htmlspecialchars($exam->exam_student_id, ENT_QUOTES); ?>" class="form-control">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="transaction_num">شماره تراکنش : (شماره رسید)</label>
                                                                                        <input type="number" name="transaction_num" class="form-control" id="transaction_num">
                                                                                    </div>
                                                                                    <div class="form-group" style="margin-bottom: -10px">
                                                                                        <button style="width: 50%" type="submit" style="" class="btn btn-success form-control">ثبت</button>
                                                                                        <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                    </div>
                                                                                </form>
                                                                            </section>
                                                                            <!-- نقد -->
                                                                            <section id="cash">
                                                                                <form action="<?php echo base_url(); ?>financial/cash-exam-pay" method="post">
                                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                    <div class="form-group">
                                                                                        <label for="amount">مبلغ پرداختی : </label>
                                                                                        <input type="number" name="amount" max="<?php echo htmlspecialchars($exam->exam_cost - $exam->exam_cost_pay - $exam->amount_off, ENT_QUOTES); ?>" class="form-control" id="amount">
                                                                                        <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($exam->student_nc, ENT_QUOTES); ?>" class="form-control">
                                                                                        <input type="hidden" name="exam_student_id" value="<?php echo htmlspecialchars($exam->exam_student_id, ENT_QUOTES); ?>" class="form-control">
                                                                                        <input type="hidden" name="course_id" class="<?php echo htmlspecialchars($exam->course_id, ENT_QUOTES); ?>">
                                                                                        <input type="hidden" name="exam_id" class="<?php echo htmlspecialchars($exam->exam_id, ENT_QUOTES); ?>">
                                                                                    </div>
                                                                                    <div class="form-group" style="margin-bottom: -10px">
                                                                                        <button style="width: 50%" type="submit" style="" class="btn btn-success form-control">ثبت</button>
                                                                                        <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                    </div>
                                                                                </form>
                                                                            </section>
                                                                            <!-- تخفیف -->
                                                                            <section id="discount">
                                                                                <div class="panel-group" id="accordion">
                                                                                    <div class="panel panel-black">
                                                                                        <a href="#" data-perform="panel-collapse">
                                                                                            <div class="panel-heading">
                                                                                                تخفیف به صورت درصد
                                                                                            </div>
                                                                                        </a>
                                                                                        <div class="panel-wrapper collapse in" aria-expanded="true">
                                                                                            <div class="panel-body">
                                                                                                <form action="<?php echo base_url(); ?>financial/insert_off_exam" method="post">
                                                                                                    <div class="input-group form-group"> <span class="input-group-addon">درصد</span>
                                                                                                        <input type="number" name="amount" max="<?php echo (int) '100' - (($exam->amount_off * (int) '100') / $exam->exam_cost); ?>" class="form-control" id="amount">
                                                                                                        <input type="hidden" value="1" name='switch'/>
                                                                                                    </div>
                                                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                    <input type="hidden" name="exam_student_id" value="<?php echo htmlspecialchars($exam->exam_student_id, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <input type="hidden" name="exam_cost" value="<?php echo htmlspecialchars($exam->exam_cost, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($exam->student_nc, ENT_QUOTES); ?>" class="form-control">
                                                                                                    <div class="form-group" style="margin-bottom: -10px">
                                                                                                        <button style="width: 50%" type="submit" style="" class="btn btn-success form-control">ثبت درصد تخفیف</button>
                                                                                                        <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                        <a href="#" data-perform="panel-collapse">
                                                                                            <div class="panel-heading" style="border-top: white thick solid">
                                                                                                تخفیف به صورت مبلغ
                                                                                            </div>
                                                                                        </a>
                                                                                        <div class="panel-wrapper collapse" aria-expanded="false">
                                                                                            <div class="panel-body">
                                                                                                <form action="<?php echo base_url(); ?>financial/insert_off_exam" method="post">
                                                                                                    <div class="input-group form-group"> <span class="input-group-addon">مبلغ</span>
                                                                                                        <input type="number" name="amount" placeholder="45000" max="<?php echo $exam->exam_cost - ($exam->exam_cost_pay + $exam->amount_off); ?>"class="form-control" id="amount">
                                                                                                        <input type="hidden" value="2" name='switch'/>
                                                                                                    </div>
                                                                                                    <input type="hidden"name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                                    <input type="hidden" name="exam_student_id" value="<?php echo htmlspecialchars($exam->exam_student_id, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <input type="hidden" name="exam_cost" value="<?php echo htmlspecialchars($exam->exam_cost, ENT_QUOTES); ?>"class="form-control">
                                                                                                    <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($exam->student_nc, ENT_QUOTES); ?>" class="form-control">
                                                                                                    <div class="form-group" style="margin-bottom: -10px">
                                                                                                        <button style="width: 50%" type="submit" style="" class="btn btn-success form-control">ثبت مبلغ تخفیف</button>
                                                                                                        <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                                    </div>

                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </section>
                                                                        </div>
                                                                        <!-- /content -->
                                                                    </div>
                                                                    <!-- /tabs -->
                                                                </section>
                                                                <!-- **************************************************-->
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php elseif ($exam->amount_off !== '0'): ?>
                                                                                                            <!--<button type="button" disabled style="" class="btn btn-success"> <i class="fa fa-check"></i>تسویه شده</button>-->
                                                <button type="button" data-toggle="modal"data-target="#sale4_<?php echo htmlspecialchars($exam->exam_student_id, ENT_QUOTES); ?>"style="" class="btn btn-default"> <i class="fa fa-check"></i>تخفیف</button>
                                                <div id="sale4_<?php echo htmlspecialchars($exam->exam_student_id, ENT_QUOTES); ?>"class="modal fade" tabindex="-1" role="dialog"aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <!-- مدال جهت پنجره تخفیف  آزمون-->
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"aria-hidden="true">×</button>
                                                                <h4 class="modal-title" id="myModalLabel"تخفیف آزمون</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="panel-group" id="accordion">
                                                                <div class="panel panel-black">
                                                                    <a href="#" data-perform="panel-collapse">
                                                                        <div class="panel-heading">
                                                                            تخفیف به صورت درصد
                                                                        </div>
                                                                    </a>
                                                                    <div class="panel-wrapper collapse in" aria-expanded="true">
                                                                        <div class="panel-body">
                                                                            <form action="<?php echo base_url(); ?>financial/insert_off_exam" method="post">
                                                                                <div class="input-group form-group"> <span class="input-group-addon">درصد</span>
                                                                                    <input type="number" name="amount" max="<?php echo (int) '100' - (($exam->amount_off * (int) '100') / $exam->exam_cost); ?>" class="form-control" id="amount">
                                                                                    <input type="hidden" value="1" name='switch'/>
                                                                                </div>
                                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                <input type="hidden" name="exam_student_id" value="<?php echo htmlspecialchars($exam->exam_student_id, ENT_QUOTES); ?>"class="form-control">
                                                                                <input type="hidden" name="exam_cost" value="<?php echo htmlspecialchars($exam->exam_cost, ENT_QUOTES); ?>"class="form-control">
                                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($exam->student_nc, ENT_QUOTES); ?>" class="form-control">
                                                                                <div class="form-group" style="margin-bottom: -10px">
                                                                                    <button style="width: 50%" type="submit" style="" class="btn btn-success form-control">ثبت درصد تخفیف</button>
                                                                                    <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <a href="#" data-perform="panel-collapse">
                                                                        <div class="panel-heading" style="border-top: white thick solid">
                                                                            تخفیف به صورت مبلغ
                                                                        </div>
                                                                    </a>
                                                                    <div class="panel-wrapper collapse" aria-expanded="false">
                                                                        <div class="panel-body">
                                                                            <form action="<?php echo base_url(); ?>financial/insert_off_exam" method="post">
                                                                                <div class="input-group form-group"> <span class="input-group-addon">مبلغ</span>
                                                                                    <input type="number" name="amount" placeholder="45000" max="<?php echo $exam->exam_cost - ($exam->exam_cost_pay + $exam->amount_off); ?>"class="form-control" id="amount">
                                                                                    <input type="hidden" value="2" name='switch'/>
                                                                                </div>
                                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                <input type="hidden" name="exam_student_id" value="<?php echo htmlspecialchars($exam->exam_student_id, ENT_QUOTES); ?>"class="form-control">
                                                                                <input type="hidden" name="exam_cost" value="<?php echo htmlspecialchars($exam->exam_cost, ENT_QUOTES); ?>"class="form-control">
                                                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($exam->student_nc, ENT_QUOTES); ?>" class="form-control">
                                                                                <div class="form-group" style="margin-bottom: -10px">
                                                                                    <button style="width: 50%" type="submit" style="" class="btn btn-success form-control">ثبت مبلغ تخفیف</button>
                                                                                    <button style="width: 50%" type="button" class="btn btn-info form-control" data-dismiss="modal">انصراف</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="label label-success">تسویه</div>
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
</div>
<div role="tabpanel" class="tab-pane fade" id="online_payment">
    <div class="col-sm-12">
        <div class="white-box">
            <div class="table-responsive">
                <table id="example26" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
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
                        <?php if (!empty($online_payments)): ?>
                            <?php foreach ($online_payments as $o_pay): ?>
                                <tr>
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
                                                            <h3>مبلغ پرداختی: <label><?php echo number_format($o_pay->paid_amount); ?></label></h3>
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
<div role="tabpanel" class="tab-pane fade" id="payment">
    <div class="col-sm-12">
        <div class="white-box">
            <div class="table-responsive">
                <table id="example24" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">مبلغ پرداختی</th>
                            <th class="text-center">شماره (تراکنش یا چک)</th>
                            <th class="text-center">تاریخ پرداخت</th>
                            <th class="text-center">کد آزمون</th>
                            <th class="text-center">کد دوره</th>
                            <th class="text-center">نوع پرداخت</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="text-center">مبلغ پرداختی</th>
                            <th class="text-center">شماره (تراکنش یا چک)</th>
                            <th class="text-center">تاریخ پرداخت</th>
                            <th class="text-center">کد آزمون</th>
                            <th class="text-center">کد دوره</th>
                            <th class="text-center">نوع پرداخت</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php if (!empty($course_pouse)): ?>
                            <?php foreach ($course_pouse as $pouse_info): ?>
                                <tr>
                                    <td class="text-center"><?php echo htmlspecialchars(number_format($pouse_info->course_pouse_amount), ENT_QUOTES); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($pouse_info->transaction_number, ENT_QUOTES); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($pouse_info->date_payment, ENT_QUOTES); ?></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"><?php echo htmlspecialchars($pouse_info->course_id, ENT_QUOTES); ?></td>
                                    <td class="text-center">کارت</td>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                        ?>
                        <?php if (!empty($course_cash)): ?>
                            <?php foreach ($course_cash as $cash_info): ?>
                                <tr>
                                    <td class="text-center"><?php echo htmlspecialchars(number_format($cash_info->course_amount_of_pay), ENT_QUOTES); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($cash_info->course_cash_pay_id, ENT_QUOTES); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($cash_info->date_payment, ENT_QUOTES); ?></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"><?php echo htmlspecialchars($cash_info->course_id, ENT_QUOTES); ?></td>
                                    <td class="text-center">نقد</td>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                        ?>
                        <?php if (!empty($course_check)): ?>
                            <?php foreach ($course_check as $ckeck_info): ?>
                                <tr>
                                    <td class="text-center"><?php echo htmlspecialchars(number_format($ckeck_info->check_amount), ENT_QUOTES); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($ckeck_info->serial_number, ENT_QUOTES); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($ckeck_info->check_date, ENT_QUOTES); ?></td>
                                    <td class="text-center"></td>
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
<!--    <div role="tabpanel" class="tab-pane fade" id="off">
        <div class="col-md-12">
            <div class="white-box">
                 row
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
<?php if ($this->session->flashdata('success-insert')) : ?>
                                                                                                                                                                                                                            <div class="alert alert-success"><?php echo $this->session->flashdata('success-insert'); ?></div>
<?php endif; ?>
                                    <form action="#" method="post" name="class_register">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                        <h3 class="box-title">مبلغ مورد نظر را وارد کنید</h3>
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4">
                                                <hr>
                                                <input type="text" name="amount_wallet" id="course_duration" class="form-control" placeholder="25000" required=""> <span class="help-block">مبلغ به تومان است</span>
                                                <input type="hidden" name="student_nc" value="<?php echo htmlspecialchars($courses[0]->student_nc, ENT_QUOTES); ?>" class="form-control">
<?php if (validation_errors() && form_error('course_duration')): ?>
                                                                                                                                                                                                                            <div class="alert alert-danger"><?php echo form_error('course_duration'); ?></div>
<?php endif; ?>

                                                <button type="submit"class="btn btn-success" style="width:100%"> <i class="fa fa-check"></i> افزودن</button>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>
                                         end row
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
</div>

