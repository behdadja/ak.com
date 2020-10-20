<div class="col-sm-12">
    <div class="white-box">
        <div class="table-responsive">
            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">کد <?php echo $this->session->userdata('studentDName');?></th>
                        <th>نام و نام خانوادگی</th>
                        <th class="text-center">شماره همراه</th>
                        <th class="text-center">کد ملی</th>
                        <th class="text-center">ابزار</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">کد <?php echo $this->session->userdata('studentDName');?></th>
                        <th>نام و نام خانوادگی</th>
                        <th class="text-center">شماره همراه</th>
                        <th class="text-center">کد ملی</th>
                        <th class="text-center">ابزار</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if ($students_info): ?>
                        <?php foreach ($students_info as $student): ?>
                            <tr>
                                <td class="text-center"><?php echo htmlspecialchars($student->student_id, ENT_QUOTES) ?></td>
                                <td>
                                    <img src="<?php echo base_url(); ?>assets/profile-picture/thumb/<?php echo htmlspecialchars($student->pic_name, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                                    <?php echo htmlspecialchars($student->first_name . ' ' . $student->last_name, ENT_QUOTES); ?>
                                </td>
                                <td class="text-center"><?php echo htmlspecialchars($student->phone_num, ENT_QUOTES) ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($student->national_code, ENT_QUOTES) ?></td>
                                <td class="text-nowrap text-center">

                                    <a href="basic-table.html#" onclick="event.preventDefault();document.getElementById('detail_<?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="جزئیات"> <i class="mdi mdi-account-card-details m-r-10"></i> </a>
                                    <form class="" id='detail_<?php echo htmlspecialchars($student->national_code); ?>' style="display:none" action="<?php echo base_url('financial/student-inquiry'); ?>" method="post">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                        <input type="hidden" name="national_code" value="<?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach;
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
