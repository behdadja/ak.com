<style>
    /* for remove icon input with type:number */
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<div class="container page__container" style="margin: 50px auto 50px auto">
    <div class="page-headline text-center">
            <h3>اطلاعات تماس</h3>
        </div>
    <div class="row">
        <div class="col-md-7">
            <div><span class="fa fa-user-tie w3-xlarge" style="margin: auto auto 15px 20px;padding: 12px;background-color: #efe24b ;border-radius: 30px"></span><span> اسماعیل ایلانی</span></div>
            <div><span class="fa fa-phone w3-xlarge" style="margin: auto auto 15px 20px;padding: 12px;background-color: #9cf ;border-radius: 30px"></span><span> 07191013320 - 09378451002</span></div>
            <div><span class="fa fa-envelope w3-xlarge" style="margin: auto auto 15px 20px;padding: 12px;background-color: #efe24b ;border-radius: 30px"></span><span> info@amoozkadeh.com</span></div>
            <div><span class="fa fa-map-signs w3-xlarge" style="margin: auto auto 15px 20px;padding: 12px;background-color: #9cf ;border-radius: 30px"></span><span> شیراز، خیابان اردیبهشت شرقی، برج IT، طبقه ۲، واحد ۲۶</span></div>
            <div><span class="fa fa-clock w3-xlarge" style="margin: auto auto 15px 20px;padding: 12px;background-color: #efe24b ;border-radius: 30px"></span><span> ساعت کاری: شنبه تا چهارشنبه : ۸:۰۰ - ۱۷:۰۰ | پنجشنبه ها : ۸:۰۰ - ۱۴:۰۰</span></div>
        </div>
        <div class="col-md-5">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3468.2510585577666!2d52.52491591444674!3d29.625450682036707!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fb212772fa1f23f%3A0xe034e8f2902a6582!2z2KjYsdisIElUINi024zYsdin2LI!5e0!3m2!1sen!2s!4v1582370738375!5m2!1sen!2s" frameborder="0" style="border: #b1b1b1 solid thick;width: 100%;height:280px;border-radius: 5px" allowfullscreen=""></iframe>
        </div>
    </div>
</div>

<div class="mdk-box mdk-box--bg-gradient-primary bg-dark js-mdk-box position-relative overflow-hidden" style="height: auto" data-effects="parallax-background blend-background">
    <div class="mdk-box__bg">
        <div class="mdk-box__bg-front" style="background-image: url(<?php echo base_url(); ?>assets/images/1280_work-station-straight-on-view.jpg);"></div>
    </div>
    <div class="mdk-box__content">
        <div class="container page__container py-32pt">
            <div class="row align-items-center text-center text-md-left">

                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card" style=" background-color: rgba(0,0,0,0.4)">
                        <div class="card-body">
                            <form class="form-horizontal" action="<?= base_url('send-user-mesg'); ?>" method="post" style="padding: 30px">
                                <h4 class="text-center text-white">
                                    <span>با ما در ارتباط باشید</span>
                                </h4>
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                <div class="was-validated">
                                    <input type="text" name="full_name" class="form-control form-control-prepended is-valid" placeholder="نام و نام خانوادگی" required oninvalid="setCustomValidity('لطفا نام را وارد کنید')" onchange="try {
                                                setCustomValidity('');
                                            } catch (e) {
                                            }">
                                    <div class="invalid-feedback"><?= form_error('full_name'); ?></div>
                                    <input type="email" name="email" class="form-control form-control-prepended is-valid" placeholder="ایمیل" required oninvalid="setCustomValidity('لطفا ایمیل را وارد کنید')" onchange="try {
                                                setCustomValidity('');
                                            } catch (e) {
                                            }">
                                    <div class="invalid-feedback"><?= form_error('email'); ?></div>
                                    <input name="phone_num" onKeyPress="if (this.value.length == 11)
                                                return false;" min="09000000000" max="09999999999" type="number" placeholder="شماره همراه" class="form-control form-control-prepended is-valid" required oninvalid="setCustomValidity('لطفا شماره همراه را به صورت عدد یازده رقمی وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                    <div class="invalid-feedback"><?= form_error('phone_num'); ?></div>
                                    <textarea rows="7" name="mesg" placeholder="متن پیام شما" class="form-control form-control-prepended is-valid" required oninvalid="setCustomValidity('لطفا متن پیام را وارد کنید')" onchange="try {
                                                setCustomValidity('');
                                            } catch (e) {
                                            }"></textarea>
                                    <div class="invalid-feedback"><?= form_error('mesg'); ?></div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success form-control" style="width: 100%">ارسال</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
</div>
