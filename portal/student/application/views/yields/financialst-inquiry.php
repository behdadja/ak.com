
<style>
	@media print {
		/* on modal open bootstrap adds class "modal-open" to body, so you can handle that case and hide body */
		body.modal-open {
			visibility: hidden;
		}
		/*body.modal-open .modal .modal-header,*/
		body.modal-open .modal .modal-body {
			visibility: visible; /* make visible modal body and header */
		}
	}
</style>


<?php require_once 'jdf.php'; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <div class="row row-in">
                <div class="col-md-4 col-sm-12 row-in-br b-r-none">
                    <ul class="col-in">
                        <li>
                            <span class="circle circle-md <?php
                            if (!empty($financial_state) && $financial_state[0]->final_situation === '-1') {
                                echo 'bg-danger';
                            } else {
                                echo 'bg-success';
                            }
                            ?>"><i class="ti-clipboard"></i></span>
                        </li>
                        <li class="col-last"><h3 class="counter text-right m-t-15"><?php
                                if (!empty($financial_state)) {
                                    echo htmlspecialchars(number_format($financial_state[0]->final_amount), ENT_QUOTES);
                                }
                                ?></h3></li>
                        <li class="col-middle">
                            <h6>وضعیت مالی </h6>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-12 row-in-br">
                    <ul class="col-in">
                        <li>
                            <span class="circle circle-md bg-success"><i class=" ti-shopping-cart"></i></span>
                        </li>
                        <li class="col-last"><h3 class="counter text-right m-t-15"><?= sizeof($courses); ?></h3></li>
                        <li class="col-middle">
                            <h6>تعداد دوره ها</h6>
                        </li>

                    </ul>
                </div>
                <div class="col-md-4 col-sm-12 row-in-br">
                    <ul class="col-in">
                        <li>
                            <span class="circle circle-md bg-warning"><i class="fa fa-dollar"></i></span>
                        </li>
                        <li class="col-last"><h3 class="counter text-right m-t-15"><?= sizeof($exams); ?></h3></li>
                        <li class="col-middle">
                            <h6>تعداد آزمون ها</h6>
                        </li>

                    </ul>
                </div>
<!--                                <div class="col-md-3 col-sm-6 row-in-br b-r-none">-->
<!--                    <ul class="col-in">-->
<!--                        <li>-->
<!--                            <span class="circle circle-md bg-info"><i class="ti-wallet"></i></span>-->
<!--                        </li>-->
<!--                        <li class="col-last"><h3 class="counter text-right m-t-15">--><?php
//                                if (!empty($wallet_stock)) {
//                                    echo htmlspecialchars($wallet_stock[0]->wallet_stock, ENT_QUOTES);
//                                }
//                                ?><!--</h3></li>-->
<!--                        <li class="col-middle">-->
<!--                            <h6>موجودی کیف </h6>-->
<!--                        </li>-->
<!---->
<!--                    </ul>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</div>
<section class="m-t-40">

<!--	<a href="" data-toggle="modal" data-target="#modal_course">modal</a>-->
	<?php if ($this->session->flashdata('success_payment')): ?>
		<script>
			$(document).ready(function () {
				$('#modal_course').modal('show');
			});
		</script>
        <div class="modal modal-open fade" id="modal_course" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title text-center" id="exampleModalLabel1">مدیریت پرداخت ها</h4>
					</div>
                    <div class="modal-body text-center" style="border: #000000 solid thin" id="printableArea">
                        <div class="form-group">
							<h4 style="color: #22ad22" class="modal-title" id="exampleModalLabel1">رسید پرداخت</h4>
							<hr style="width: 70%">
                            <h4 style="color: #32cd32">پرداخت با موفقیت انجام شد</h4><hr style="width: 50%">
							<h3>شماره رسید : <label><?= $this->session->userdata('payment_id'); ?></label></h3>
							<h3>شماره تراکنش : <label><?= $this->session->userdata('verify_code'); ?></label></h3>
							<h3>مبلغ : <label><?= $this->session->userdata('paid_amount').' تومان'; ?></label></h3>
							<h3>تاریخ پرداخت : <label><?= $this->session->userdata('date_payment'); ?></label></h3>
                            <h3>کد دوره : <label><?= $this->session->userdata('course_id'); ?></label></h3>
                        </div>
                    </div>
                    <div class="modal-footer"><button style="width: 49%" type="button" class="btn btn-primary" onclick="js:window.print()">پرینت</button>
                        <button style="width: 48%" type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

	<script type="text/javascript">
		function printDiv(printableArea) {
			var printContents = document.getElementById(printableArea).innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
		}
	</script>

    <?php if ($this->session->flashdata('failed_payment')): ?>
        <script>
            $(document).ready(function () {
                $('#modal_2').modal('show');
            });
        </script>
        <div class="container text-center" style="direction: rtl;font-family: samim">
            <div id="modal_2" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">عملیات پرداخت</h4>
                        </div>
                        <div class="modal-body">
                            <h4 style="color: red"><?php echo $this->session->flashdata('failed_payment'); ?></h4>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-success" data-dismiss="modal">بستن</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('update-successfully-msg')): ?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('update-successfully-msg'); ?>
        </div>
    <?php endif; ?>
            <!--  افزودن به کیف پول
                        <section id="section-linebox-5">
                            <div class="col-md-12">
                                <div class="white-box">
                                    .row
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
                                                            /row
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>-->
        </div>
        <!-- content -->
    </div>
    <!-- tabs  -->
</section>
<div class="col-md-12 col-lg-12 col-xs-12">
    <div class="white-box">

        <!-- Nav tabs -->
        <ul class="nav customtab2 nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="tabs.html#home6" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"></span><span> دوره های ثبت نامی</span></a></li>
            <li role="presentation" class=""><a href="tabs.html#profile6" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"></span><span> آزمون های ثبت نامی</span></a></li>
            <li role="presentation" class=""><a href="tabs.html#messages6" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"></span><span>پرداخت های اینترنتی</span></a></li>
            <li role="presentation" class=""><a href="tabs.html#settings6" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"></span><span>پرداخت های انتقالی</span></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade active in" id="home6">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <table role="table" class="table table-striped">
                                <thead role="rowgroup">
                                <tr role="row">
                                    <th role="columnheader" class="text-center">نام دوره</th>
                                    <th role="columnheader" class="text-center">مانده</th>
                                    <th role="columnheader" class="text-center">پرداخت آنلاین</th>
                                    <th role="columnheader" class="text-center">جزئیات</th>
                                </tr>
                                </thead>
                                <tbody role="rowgroup">
                                <?php if (!empty($courses)): ?>
                                    <?php foreach ($courses as $course):
                                        ?>
                                        <tr role="row">
                                            <td role="cell" class="text-center"> <img src="<?php echo base_url(); ?>./assets/course-picture/thumb/<?php echo htmlspecialchars($course->course_pic, ENT_QUOTES) ?>" height="32" alt="course-pic" class="img-circle">
                                                <?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?>
                                            </td>
                                            <td role="cell" class="text-center"> <?php
                                                $remained = $course->course_cost - ($course->course_cost_pay + $course->amount_off);
                                                echo htmlspecialchars(number_format($remained), ENT_QUOTES);
                                                ?>
                                            </td>
                                            <td role="cell" class="text-center">
                                                <?php if ($course->course_cost > ($course->course_cost_pay + $course->amount_off)): ?>
                                                    <button data-toggle="modal" data-target="#exampleModal_<?php echo $course->course_id ?>" data-whatever="@getbootstrap" type="button" class="btn btn-success" name="button"><i class="fa fa-check"></i></button>
                                                    <div class="modal fade" id="exampleModal_<?php echo $course->course_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title" id="exampleModalLabel1">پرداخت آنلاین دوره</h4> </div>
                                                                <form method="post" action="<?php echo base_url('student/financialst/pay'); ?>">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label for="online_amount">مبلغ مورد نظر را به <span style="color: red">تومان</span> وارد نمایید: </label>
                                                                            <input type="number" name="online_amount" max="<?php echo htmlspecialchars($course->course_cost - $course->course_cost_pay - $course->amount_off, ENT_QUOTES); ?>" id="online_amount" class="form-control">
                                                                            <input type="hidden" name="course_student_id" value="<?php echo htmlspecialchars($course->course_student_id, ENT_QUOTES); ?>" class="form-control">
                                                                            <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>" class="form-control">
                                                                            <input type="hidden" name="lesson_name" value="<?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES); ?>" class="form-control">
                                                                            <input type="hidden" name="date_payment" value="<?php echo jdate('H:i:s - Y/n/j'); ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button style="width: 49%" type="submit" class="btn btn-primary">پرداخت</button>
                                                                        <button style="width: 49%" type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <button type="button" disabled style="" class="btn btn-success"> <i class="fa fa-check"></i>تسویه شده</button>
                                                <?php endif; ?>
                                            </td>
                                            <td role="cell" class="text-center">
                                                <a href="" data-toggle="modal" data-target="#details_<?= $course->course_id ?>" >جزئیات</a>
                                                <div id="details_<?= $course->course_id ?>" class="modal fade">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="col-md-6 col-sm-12 m-b-10" style=" padding:2%;height: 55px; background-color: #d3d9df" >
                                                                    <h5 class="text-center">کد دوره : <span class="m-l-10"><?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?></span></h5>
                                                                </div>
                                                                <div class="col-md-6 col-sm-12 m-b-10" style=" padding:2%;height: 55px; background-color: #e6e7e0">
                                                                    <h5 class="text-center">شهریه دوره (تومان) : <span class="m-l-10"><?php echo htmlspecialchars(number_format($course->course_cost), ENT_QUOTES); ?></span></h5>
                                                                </div>
                                                                <div class="col-md-6 col-sm-12 m-b-10" style=" padding:2%;height: 55px; background-color: #d3d9df">
                                                                    <h5 class="text-center">مقدار تخفیف : <span class="m-l-10" ><?php echo htmlspecialchars(number_format($course->amount_off), ENT_QUOTES); ?></span></h5>
                                                                </div>
                                                                <div class="col-md-6 col-sm-12 m-b-10" style=" padding:2%;height:55px;background-color: #e6e7e0">
                                                                    <h5 class="text-center">پرداختی :
                                                                        <?php echo htmlspecialchars(number_format($course->course_cost_pay), ENT_QUOTES); ?>
                                                                    </h5>
                                                                </div>
                                                                <div class="col-md-12 col-sm-12 m-b-10" style=" padding:2%;height: 55px; background-color: #e6e7e0">
                                                                    <h5 class="text-center">وضعیت :
                                                                        <span class="m-l-10">
                                                                             <?php if ($course->course_cost > ($course->course_cost_pay + $course->amount_off)): ?>
                                                                                 <div class="label label-danger">بدهکار</div>
                                                                             <?php elseif ($course->course_cost == ($course->course_cost_pay + $course->amount_off)): ?>
                                                                                 <div class="label label-success">تسویه</div>
                                                                             <?php endif; ?>
                                                                        </span>
                                                                    </h5>
                                                                </div>
                                                                <div class="modal-footer" id="details">
                                                                    <button type="button" class="btn btn-danger m-l-40" data-dismiss="modal">بستن</button>
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
            <div role="tabpanel" class="tab-pane fade" id="profile6">
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
                                    <th class="text-danger text-center">شهریه آزمون(تومان)</th>
                                    <th class="text-info text-center">مقدار تخفیف</th>
                                    <th class="text-success text-center">پرداختی</th>
                                    <th class="text-center">مانده</th>
                                    <th class="text-center">وضعیت</th>
                                    <th class="text-center">پرداخت آنلاین</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th class="text-center">کد دوره</th>
                                    <th class="text-center">کد آزمون</th>
                                    <th class="text-danger text-center">شهریه آزمون(تومان)</th>
                                    <th class="text-info text-center">مقدار تخفیف</th>
                                    <th class="text-success text-center">پرداختی</th>
                                    <th class="text-center">مانده</th>
                                    <th class="text-center">وضعیت</th>
                                    <th class="text-center">پرداخت آنلاین</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php if (!empty($exams)): ?>
                                    <?php foreach ($exams as $exam): ?>
                                        <tr>
                                            <td class="text-center"><?= htmlspecialchars($exam->course_id, ENT_QUOTES); ?></td>
                                            <td class="text-center"><?= htmlspecialchars($exam->exam_id, ENT_QUOTES); ?></td>
                                            <td class="text-center"><?= htmlspecialchars(number_format($exam->exam_cost), ENT_QUOTES); ?></td>
                                            <td class="text-center"><?= htmlspecialchars(number_format($exam->amount_off), ENT_QUOTES); ?></td>
                                            <td class="text-center"><?= htmlspecialchars(number_format($exam->exam_cost_pay), ENT_QUOTES); ?></td>
                                            <td class="text-center"><?= htmlspecialchars(number_format($exam->exam_cost - ($exam->exam_cost_pay + $exam->amount_off)), ENT_QUOTES); ?></td>
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
                                                    <button data-toggle="modal"data-target="#online_exam_pay_<?php echo htmlspecialchars($exam->exam_id, ENT_QUOTES); ?>" data-whatever="@getbootstrap" class="btn btn-success"> <i class="fa fa-check"></i></button>
                                                    <div class="modal fade" id="online_exam_pay_<?php echo htmlspecialchars($exam->exam_id, ENT_QUOTES); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title" id="exampleModalLabel1">پرداخت آنلاین آزمون</h4> </div>
                                                                <form method="post" action="<?php echo base_url('student/financialst/pay'); ?>">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label for="recipient-name">مبلغ مورد نظر را به <span style="color: red">تومان</span> وارد نمایید: </label>
                                                                            <input type="number" name="online_amount" max="<?php echo $exam->exam_cost - ($exam->exam_cost_pay + $exam->amount_off) ?>" required class="form-control">
                                                                            <input type="hidden" name="course_id" value="<?php echo $exam->course_id ?>" class="form-control">
                                                                            <input type="hidden" name="exam_id" value="<?php echo $exam->exam_id ?>" class="form-control">
                                                                            <input type="hidden" name="exam_student_id" value="<?php echo htmlspecialchars($exam->exam_student_id, ENT_QUOTES); ?>" class="form-control">
                                                                            <input type="hidden" name="date_payment" value="<?php echo jdate('H:i:s - Y/n/j'); ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button style="width: 49%" type="submit" class="btn btn-primary">پرداخت</button>
                                                                        <button style="width: 49%" type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
                                                                    </div>
                                                                </form>
                                                            </div>
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
            </div>
            <div role="tabpanel" class="tab-pane fade" id="messages6">
                <div class="col-sm-12">
                    <div class="white-box">
                        <div class="table-responsive">
                            <table id="example24" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">شماره رسید</th>
                                    <th class="text-center">شماره تراکنش</th>
                                    <th class="text-center">مبلغ پرداختی</th>
                                    <th class="text-center">تاریخ پرداخت</th>
                                    <th class="text-center">کد دوره</th>
                                    <th class="text-center">کد آزمون</th>
                                    <th class="text-center">رسید پرداخت</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th class="text-center">شماره رسید</th>
                                    <th class="text-center">شماره تراکنش</th>
                                    <th class="text-center">مبلغ پرداختی (تومان)</th>
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
                                                <div class="modal modal-open fade" id="exampleModal1_<?php echo $o_pay->online_payments_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="exampleModalLabel1">مدیریت پرداخت ها</h4>
                                                            </div>
                                                            <div id="printThis">
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <h4 style="color: #22ad22" class="modal-title" id="exampleModalLabel1">رسید پرداخت</h4>
                                                                        <hr style="width: 70%">
                                                                        <h3>شماره رسید : <label><?php echo $o_pay->online_payments_id; ?></label></h3>
                                                                        <h3>شماره تراکنش: <label><?php echo $o_pay->verify_code; ?></label></h3>
                                                                        <h3>مبلغ پرداختی: <label><?php echo number_format($o_pay->paid_amount).' تومان'; ?></label></h3>
                                                                        <h3>تاریخ پرداخت : <label><?php echo $o_pay->date_payment; ?></label></h3>
                                                                        <h3>کد دوره : <label><?php echo $o_pay->course_id; ?></label></h3>
                                                                        <?php if ($o_pay->exam_id !== null): ?>
                                                                            <h3>کد آزمون : <label><?php echo $o_pay->exam_id; ?></label></h3>
                                                                        <?php endif; ?>
                                                                        <h3>نوع پرداخت: <label>آنلاین</label></h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <!--																		<button id="btnPrint" type="button" class="btn btn-default">Print</button>-->
                                                                <button style="width: 49%" type="button" class="btn btn-primary" onclick="js:window.print()">پرینت</button>
                                                                <button style="width: 49%" type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
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
            <div role="tabpanel" class="tab-pane fade" id="settings6">
                <div class="col-sm-12">
                    <div class="white-box">
                        <div class="table-responsive">
                            <table id="example26" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">شماره رسید</th>
                                    <th class="text-center">شماره(تراکنش یا چک)</th>
                                    <th class="text-center">مبلغ پرداختی (تومان)</th>
                                    <th class="text-center">تاریخ پرداخت</th>
                                    <th class="text-center">تاریخ چک</th>
                                    <th class="text-center">کد آزمون</th>
                                    <th class="text-center">کد دوره</th>
                                    <th class="text-center">نوع پرداخت</th>
                                    <th class="text-center">رسید پرداخت</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th class="text-center">شماره رسید</th>
                                    <th class="text-center">شماره (تراکنش یا چک)</th>
                                    <th class="text-center">مبلغ پرداختی (تومان)</th>
                                    <th class="text-center">تاریخ پرداخت</th>
                                    <th class="text-center">تاریخ چک</th>
                                    <th class="text-center">کد آزمون</th>
                                    <th class="text-center">کد دوره</th>
                                    <th class="text-center">نوع پرداخت</th>
                                    <th class="text-center">رسید پرداخت</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php if (!empty($course_pouse)): ?>
                                    <?php foreach ($course_pouse as $pouse_info): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($pouse_info->course_pouse_id, ENT_QUOTES); ?></td>
                                            <td><?php echo htmlspecialchars($pouse_info->transaction_number, ENT_QUOTES); ?></td>
                                            <td><?php echo htmlspecialchars(number_format($pouse_info->course_pouse_amount), ENT_QUOTES); ?></td>
                                            <td><?php echo htmlspecialchars($pouse_info->date_payment, ENT_QUOTES); ?></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo htmlspecialchars($pouse_info->course_id, ENT_QUOTES); ?></td>
                                            <td>کارت</td>
                                            <td>
                                                <a data-toggle="modal" data-target="#exampleModal2_<?php echo $pouse_info->transaction_number ?>" data-whatever="@getbootstrap" class="glyphicon glyphicon-print"></a>
                                                <div class="modal modal-open fade" id="exampleModal2_<?php echo $pouse_info->transaction_number ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="exampleModalLabel1">مدیریت پرداخت ها</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <h4 style="color: #22ad22" class="modal-title" id="exampleModalLabel1">رسید پرداخت</h4>
                                                                    <hr style="width: 70%">
                                                                    <h3>شماره رسید : <label><?= $pouse_info->course_pouse_id; ?></label></h3>
                                                                    <h3>شماره تراکنش : <label><?= $pouse_info->transaction_number; ?></label></h3>
                                                                    <h3>مبلغ پرداختی : <label><?= number_format($pouse_info->course_pouse_amount).' تومان'; ?></label></h3>
                                                                    <h3>تاریخ پرداخت : <label><?= $pouse_info->date_payment; ?></label></h3>
                                                                    <h3>کد دوره : <label><?= $pouse_info->course_id; ?></label></h3>
                                                                    <h3>نوع پرداخت : <label>کارت</label></h3>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button style="width: 49%" type="button" class="btn btn-primary" onclick="js:window.print()">پرینت</button>
                                                                <button style="width: 49%" type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
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
                                <?php if (!empty($course_cash)): ?>
                                    <?php foreach ($course_cash as $cash_info): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($cash_info->course_cash_pay_id, ENT_QUOTES); ?></td>
                                            <td></td>
                                            <td><?php echo htmlspecialchars(number_format($cash_info->course_amount_of_pay), ENT_QUOTES); ?></td>
                                            <td><?php echo htmlspecialchars($cash_info->date_payment, ENT_QUOTES); ?></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo htmlspecialchars($cash_info->course_id, ENT_QUOTES); ?></td>
                                            <td>نقد</td>
                                            <td>
                                                <a data-toggle="modal" data-target="#exampleModal2_<?php echo $cash_info->course_cash_pay_id ?>" data-whatever="@getbootstrap" class="glyphicon glyphicon-print"></a>
                                                <div class="modal modal-open fade" id="exampleModal2_<?php echo $cash_info->course_cash_pay_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="exampleModalLabel1">مدیریت پرداخت ها</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <h4 style="color: #22ad22" class="modal-title" id="exampleModalLabel1">رسید پرداخت</h4>
                                                                    <hr style="width: 70%">
                                                                    <h3>شماره رسید : <label><?php echo $cash_info->course_cash_pay_id; ?></label></h3>
                                                                    <h3>مبلغ پرداختی : <label><?php echo number_format($cash_info->course_amount_of_pay).' تومان'; ?></label></h3>
                                                                    <h3>تاریخ پرداخت : <label><?php echo $cash_info->date_payment; ?></label></h3>
                                                                    <h3>کد دوره : <label><?php echo $cash_info->course_id; ?></label></h3>
                                                                    <h3>نوع پرداخت : <label>نقد</label></h3>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button style="width: 49%" type="button" class="btn btn-primary" onclick="js:window.print()">پرینت</button>
                                                                <button style="width: 49%" type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        </tr>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                                <?php if (!empty($course_check)): ?>
                                    <?php foreach ($course_check as $ckeck_info): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($ckeck_info->check_pay_id, ENT_QUOTES); ?></td>
                                            <td><?php echo htmlspecialchars($ckeck_info->serial_number, ENT_QUOTES); ?></td>
                                            <td><?php echo htmlspecialchars(number_format($ckeck_info->check_amount), ENT_QUOTES); ?></td>
                                            <td><?php echo htmlspecialchars($ckeck_info->created_at, ENT_QUOTES); ?></td>
                                            <td><?php echo htmlspecialchars($ckeck_info->check_date, ENT_QUOTES); ?></td>
                                            <td></td>
                                            <td><?php echo htmlspecialchars($ckeck_info->course_id, ENT_QUOTES); ?></td>
                                            <td>چک</td>
                                            <td>
                                                <a data-toggle="modal" data-target="#exampleModal4_<?php echo $ckeck_info->serial_number ?>" data-whatever="@getbootstrap" class="glyphicon glyphicon-print"></a>
                                                <div class="modal modal-open fade" id="exampleModal4_<?php echo $ckeck_info->serial_number ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="exampleModalLabel1">مدیریت پرداخت ها</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <h4 style="color: #22ad22" class="modal-title" id="exampleModalLabel1">رسید پرداخت</h4>
                                                                    <hr style="width: 70%">
                                                                    <h3>شماره رسید : <label><?php echo $ckeck_info->check_pay_id; ?></label></h3>
                                                                    <h3>شماره چک : <label><?php echo $ckeck_info->serial_number; ?></label></h3>
                                                                    <h3>مبلغ چک : <label><?php echo number_format($ckeck_info->check_amount).' تومان'; ?></label></h3>
                                                                    <h3>تاریخ چک : <label><?php echo $ckeck_info->check_date; ?></label></h3>
                                                                    <h3>تاریخ پرداخت : <label><?php echo $ckeck_info->created_at; ?></label></h3>
                                                                    <h3>کد دوره : <label><?php echo $ckeck_info->course_id; ?></label></h3>
                                                                    <h3>نوع پرداخت : <label>چک</label></h3>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button style="width: 49%" type="button" class="btn btn-primary" onclick="js:window.print()">پرینت</button>
                                                                <button style="width: 49%" type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
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
        </div>
    </div>
</div>


