

    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="login-register">
        <div class="login-box login-sidebar" style="padding: 20px 20px 0 20px">
            <div class="white-box">
                <form class="form-horizontal form-material" id="loginform" action="<?php echo base_url(); ?>student/login" method='post'>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <?php if ($this->session->flashdata('invalid-info')) : ?>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <button class="btn btn-block btn-danger disabled">	<?php echo $this->session->flashdata('invalid-info'); ?></button>
                        </div>
                    <?php endif; ?>
                    <a href="javascript:void(0)" class="text-center db"><img src="<?php echo base_url(); ?>student/assets/images/logo/logo.png" alt="Home" /><br/></a>

                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name='national_code' required="10" placeholder="کد ملی ">
                        </div>
                        <?php if (validation_errors()): ?>
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <button class="btn btn-block btn-danger disabled"><?php echo form_error('national_code'); ?></button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name='password' placeholder="رمز عبور">
                        </div>
                        <?php if (validation_errors()): ?>
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <button class="btn btn-block btn-danger disabled"><?php echo form_error('password'); ?></button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <select name="academy_id" id="academy_id" class="form-control" >
                            <?php if (!empty($schools)): ?>
                                <?php foreach ($schools as $school): ?>
                                    <option value="<?php echo htmlspecialchars($school->academy_id, ENT_QUOTES); ?>"><?php echo htmlspecialchars($school->academy_name, ENT_QUOTES); ?></option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                        <!-- خطایی تعریف نشده
                        <?php if (validation_errors()): ?>
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <button class="btn btn-block btn-danger disabled"><?php echo form_error('password'); ?></button>
                            </div>
                        <?php endif; ?> 
                        -->
                    </div>
                    
                    <div class="form-group" style="padding-right: 20px">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup"> من را به خاطر بسپار </label>
                            </div>
                            <a href="javascript:void(0)" id="to-recover" class="pull-right"><i class="fa fa-lock m-r-5"></i> پسورد خود را فراموش کرده اید؟</a> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">ورود</button>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <a href="<?= base_url(); ?>"><button type="button" class="btn btn-success btn-block" name="button">ورود به پنل مدیریت</button></a>
                            </br>
                            <a href="<?= base_url(); ?>teacher"><button type="button" class="btn btn-primary btn-block" name="button">ورود به پنل استاد</button></a>
                        </div>
                    </div>
                </form>
                <form class="form-horizontal" id="recoverform" action="index.html">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>بازیابی پسورد</h3>
                            <p class="text-muted">ایمیل خود را وارد کنید و دستورالعمل ها به شما ارسال می شود! </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">ریست</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
