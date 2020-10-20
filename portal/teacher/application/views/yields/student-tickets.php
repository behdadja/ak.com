
<div class="row">
    <div class="col-lg-12">
        <div class="white-box">
            <h3 class="box-title m-b-0"><?= 'تیکت های '.$this->session->userdata('studentDName') ?></h3>
            <table id="demo-foo-accordion" class="table m-b-0">
                <thead>
                <tr>
                    <th class="text-center">کد</th>
                    <th class="text-center">عنوان</th>
                    <th class="text-center">فرستنده</th>
                    <th class="text-center">گیرنده</th>
                    <th class="text-center">وضعیت</th>
                    <th class="text-center">زمان ایجاد</th>
                    <th class="text-center">آخرین به روزرسانی</th>
                    <th class="text-center">مشاهده</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($manager_tickets)):
                    foreach ($manager_tickets as $value):
                        $count = 0;
                        if(!empty($answer_tickets)){
                            foreach ($answer_tickets as $answer) {
                                if ($answer->answer_id == $value->ticket_id && $answer->ticket_status == '0' ) {
                                    $count ++;
                                }
                            }
                        }
                        ?>
                        <tr>
                            <td class="text-center"><?= htmlspecialchars($value->ticket_id, ENT_QUOTES) ?></td>
                            <td class="text-center"><?= htmlspecialchars($value->ticket_title, ENT_QUOTES) ?></td>
                            <?php if ($value->sender_type === 'std'):?>
                                <td class="text-center">
                                    <?php
                                    foreach ($student_info as $item) {
                                        if($item->national_code == $value->sender_nc){
                                            $student_name = $item->first_name . ' ' . $item->last_name;
                                        }
                                    }
                                    echo htmlspecialchars($student_name . ' (' . $this->session->userdata('studentDName') . ')', ENT_QUOTES);
                                    ?>
                                </td>
                            <?php else: ?>
                                <td class="text-center text-danger">شما</td>
                            <?php endif; ?>
                            <?php if ($value->receiver_type === 'std'):?>
                                <td class="text-center">
                                    <?php
                                    foreach ($student_info as $item) {
                                        if($item->national_code == $value->receiver_nc){
                                            $student_name = $item->first_name . ' ' . $item->last_name;
                                        }
                                    }
                                    echo htmlspecialchars($student_name . ' (' . $this->session->userdata('studentDName') . ')', ENT_QUOTES);
                                    ?>
                                </td>
                            <?php else: ?>
                                <td class="text-center text-danger">شما</td>
                            <?php endif; ?>
                            <td class="text-center">
                                <?php if ($value->readed_status === '0' && $value->answer_status === '0'): ?>
                                    <span style="font-size: small" class="label label-<?php if($count == 0){ echo 'warning';}else{ echo 'danger';} ?>">خوانده نشده
                                        <?php if($count > 0):?>
                                            <span style="color: black; font-size: small" class="label label-default"><?= $count ?></span>
                                        <?php endif; ?>
                                    </span>
                                <?php elseif ($value->readed_status === '1' && $value->answer_status === '0'): ?>
                                    <span style="font-size: small" class="label label-primary">در انتظار پاسخ
                                        <?php if($count > 0):?>
                                            <span style="color: black; font-size: small" class="label label-default"><?= $count ?></span>
                                        <?php endif; ?>
                                    </span>
                                <?php elseif ($value->readed_status === '1' && $value->answer_status === '1'): ?>
                                    <span style="font-size: small" class="label label-success">پاسخ <?= htmlspecialchars($this->session->userdata('studentDName'), ENT_QUOTES) ?>
                                        <?php if($count > 0):?>
                                            <span style="color: black; font-size: small" class="label label-default"><?= $count ?></span>
                                        <?php endif; ?>
                                    </span>
                                <?php elseif ($value->readed_status === '1' && $value->answer_status === '2'): ?>
                                    <span style="font-size: small" class="label label-info">پاسخ <?= htmlspecialchars($this->session->userdata('teacherDName'), ENT_QUOTES) ?>
                                        <?php if($count > 0):?>
                                            <span style="color: black; font-size: small" class="label label-default"><?= $count ?></span>
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center"><?= htmlspecialchars($value->created_at, ENT_QUOTES) ?></td>
                            <td class="text-center"><?= htmlspecialchars($value->last_update, ENT_QUOTES) ?></td>
                            <td class="text-center"><a href="<?= base_url('teacher/tickets/info-student-tickets/' . $value->ticket_id); ?>"><i class="glyphicon glyphicon-new-window text-info"></i></a></td>
                        </tr>
                    <?php
                    endforeach;
                else:
                    ?>
                    <tr>
                        <td class="text-danger text-center">تیکتی موجود نمی باشد</td>
                    </tr>
                <?php
                endif;
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.row -->
