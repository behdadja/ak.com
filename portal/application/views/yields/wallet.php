<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h2 class="box-title m-b-0 text-center">گزارش وضعیت مالی آموزشگاه</h2>
            <div class="row col-md-6">
                <div class="col-sm-12 col-xs-12">
                    <form action="<?= base_url('online_payment') ?>" method="post">
                        <div class="form-group" >
                            <label for="exampleInputuname">مانده کیف پول</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ti-wallet"></i></div>
                                <input type="text" class="form-control" id="exampleInputuname" placeholder="" readonly> </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">شارژ ثابت ماهیانه</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ti-money"></i></div>
                                <input type="text" class="form-control" id="exampleInputEmail1"  value="<?= $this->session->userdata('const_tuition').' '.'هزار تومان'; ?>" readonly> </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputpwd1">تعداد ساعت کلاس های آنلاین برگزار شده</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ti-timer"></i></div>
                                <input type="text" class="form-control" id="exampleInputpwd1" value="<?= $this->session->userdata('seconds')/3600 ?>" readonly> </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputpwd2">تعداد دانش آموزهای ثبت نامی</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ti-user"></i></div>
                                <input type="text" class="form-control" id="exampleInputpwd2" value="<?= $this->session->userdata('number_of_std') ?>" readonly>
                            </div>
                            <span class="help-block"><small>تعداد دانش آموز * 2500 تومان</small></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">شارژ کیف پول</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ti-money"></i></div>
                                <input type="text" class="form-control" name="online_amount" id="exampleInputEmail1" placeholder="مبلغ مورد نظر را وارد کنید" > </div>
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        </div>
                         <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">ورود به درگاه بانک</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="white-box">
                <div class="panel panel-info">
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body">
                            <form class="form-horizontal" role="form">
                                <div class="form-body">
                                    <h3 class="box-title">لیست آخرین پرداخت ها</h3>
                                    <hr class="m-t-0 m-b-40">
                                    <?php if (!empty($manager_payments)) { ?>
                                    <?php foreach ($manager_payments as $pay){ ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">مبلغ پرداخت شده:</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static"> <?php echo htmlspecialchars($pay->paid_amount , ENT_QUOTES); ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">کد تایید:</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static"> <?php echo htmlspecialchars($pay->verify_code , ENT_QUOTES); ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">تاریخ پرداخت:</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static"> <?php echo htmlspecialchars($pay->date_payment , ENT_QUOTES); ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }
                                    }
                                    ?>
                                    <!--/row-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
