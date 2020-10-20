<div class="col-md-12">
    <div class="white-box">
        <div class="row ">
            <?php if(!empty($sended_to_manager)){ ?>
            <?php $i = 1; foreach ($sended_to_manager as $key => $value) { ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mail_listing">
                <div class="media m-b-30 p-t-20">
                    <h4 class="font-bold m-t-0">وضعیت تیکت های ارسالی به مدیریت</h4>
                    <hr>
                    <a class="pull-left" href="inbox-detail.html#"> <img class="media-object thumb-sm img-circle" src="../plugins/images/users/pawandeep.jpg" alt=""> </a>
                    <div class="media-body"> <span class="media-meta pull-right">07:23 بعد از ظهر</span>
                    <h4 class="text-danger m-0"><?= $value->first_name.' '.$value->last_name; ?></h4> </div>
                </div>
                <div class="" style="border:1px solid;border-radius:5px;padding:5px;margin-bottom:1%;">
                    <p> <strong class="text-info">متن شما : </strong></br> <?= $value->emt_body; ?></p>
                    <?php if($value->answer_status === "1"): ?>
                        <p class="text-info" style="border:1px solid #00f3ff;margin-right:5%;padding-right:2%;margin-bottom:0;border-radius:5px;"> <strong class="text-danger">پاسخ استاد  : </strong></br> <?= $value->emt_body; ?></p>
                    <?php endif; ?>
                </div>
                <div class="b-all p-20">
                    <p class="p-b-20">وضعیت تیکت : <?php if($value->readed_status === "1"){echo "<span class='label label-primary'>خوانده شده</span>";}else{echo "<span class='label label-warning'>خوانده نشده</span>";} ?> وضعیت پاسخ : <?php if($value->answer_status === "1"){echo "<span class='label label-primary'>پاسخ داده شده</span>";}else{echo "<span class='label label-warning'>در انتظار پاسخ</span>";} ?></p>
                </div>
            </div>
            <?php } } ?>
        </div>
    </div>
</div>
