<div class="col-sm-12">
    <div class="white-box">
        <!-- errors -->
        <?php if ($this->session->flashdata('success-insert')) : ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success-insert'); ?></div>
        <?php endif; ?>
            <?php if ($this->session->flashdata('success-update')) : ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success-update'); ?></div>
        <?php endif; ?>
            <!-- / errors -->
            
        <div class="table-responsive">
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">کد مدیریتی</th>
                        <th>نام و نام خانوادگی</th>
                        <th class="text-center">شماره همراه</th>
                        <th class="text-center">کد ملی</th>
                        <th class="text-center">واحد فعالیت</th>
                        <th class="text-center">وضعیت</th>
                        <th class="text-center">ابزار</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">کد مدیریتی</th>
                        <th>نام و نام خانوادگی</th>
                        <th class="text-center">شماره همراه</th>
                        <th class="text-center">کد ملی</th>
                        <th class="text-center">واحد فعالیت</th>
                        <th class="text-center">وضعیت </th>
                        <th class="text-center">ابزار</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if (!empty($managers_info)): ?>
                        <?php foreach ($managers_info as $manager): ?>
                            <tr>
                                <td class="text-center"><?php echo htmlspecialchars($manager->manager_id, ENT_QUOTES) ?></td>
                                <td>
                                    <b>
                                        <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo htmlspecialchars($manager->pic_name, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                                        <?php echo htmlspecialchars($manager->first_name . ' ' . $manager->last_name, ENT_QUOTES); ?>
                                    </b>
                                </td>
                                <td class="text-center"><?php echo htmlspecialchars($manager->phone_num, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($manager->national_code, ENT_QUOTES) ?></td>
                                <td class="text-center">
                                    <?php
                                    if ($manager->activity_unit === '1') {
                                        echo "مدیریت";
                                    } elseif ($manager->activity_unit === '2') {
                                        echo "مالی و حسابداری";
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($manager->manager_activated === '0'): ?>
                                        <span class="label label-danger">غیره فعال</span>
                                    <?php else: ?>
                                        <span class="label label-success">فعال</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-nowrap text-center">
                                    <a href="basic-table.html#" onclick="event.preventDefault();document.getElementById('edit_<?php echo htmlspecialchars($manager->national_code, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="ویرایش"> <i class="mdi mdi-pencil text-inverse"></i> </a>
                                    <form class="" id='edit_<?php echo htmlspecialchars($manager->national_code); ?>' style="display:none" action="<?php echo base_url(); ?>users/edit-personnel" method="post">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                        <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($manager->national_code, ENT_QUOTES); ?>">
                                    </form>|
                                    <a href="basic-table.html#" data-toggle="tooltip" data-original-title="جزئیات"> <i class="mdi mdi-account-card-details"></i> </a>|
                                    <?php if ($manager->manager_activated === '1'): ?>
                                        <a href="basic-table.html#" onclick="event.preventDefault();document.getElementById('unactive_<?php echo htmlspecialchars($manager->national_code, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="غیر فعال کردن"> <i class="fa fa-close text-danger"></i> </a>
                                        <form class="" id='unactive_<?php echo htmlspecialchars($manager->national_code); ?>' style="display:none" action="<?php echo base_url(); ?>users/edit_activated_personnel" method="post">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                            <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($manager->national_code, ENT_QUOTES); ?>">
                                        </form>
                                    <?php else: ?>
                                        <a href="basic-table.html#" onclick="event.preventDefault();document.getElementById('active_<?php echo htmlspecialchars($manager->national_code, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="فعال کردن"> <i class="mdi mdi-check-circle-outline text-success"></i> </a>
                                        <form class="" id='active_<?php echo htmlspecialchars($manager->national_code); ?>' style="display:none" action="<?php echo base_url(); ?>users/edit_activated_personnel" method="post">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                            <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($manager->national_code, ENT_QUOTES); ?>">
                                        </form>
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
