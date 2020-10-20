<div class="col-sm-12">
    <div class="white-box">
        <div class="table-responsive">
            <h2 class="text-info">دوره های من</h2>
            <?php if ($this->session->flashdata('del-exist-lesson')) : ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('del-exist-lesson'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('enroll')) : ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('enroll'); ?></div>
            <?php endif; ?>
            <!--<table id="example23" class="display nowrap" cellspacing="0" width="100%">-->
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="text-center">کد دوره</th>
                    <th>نام دوره</th>
                    <th class="text-center">مدت(ساعت)</th>
                    <th class="text-center">زمان جلسه(دقیقه)</th>
                    <th class="text-center">شروع دوره</th>
                    <th class="text-center" style="width: 200px">روز و ساعت برگزاری</th>
                    <th class="text-center">کلاس</th>
                    <th class="text-center">نوع</th>
                    <th class="text-center">تعداد <?php echo $this->session->userdata('studentDName'); ?></th>
                    <th class="text-center">روش برگزاری</th>
                    <th class="text-center">جلسات</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="text-center">کد دوره</th>
                    <th>نام دوره</th>
                    <th class="text-center">مدت(ساعت)</th>
                    <th class="text-center">زمان جلسه(دقیقه)</th>
                    <th class="text-center">شروع دوره</th>
                    <th class="text-center" style="width: 200px">روز و ساعت برگزاری</th>
                    <th class="text-center">کلاس</th>
                    <th class="text-center">نوع</th>
                    <th class="text-center">تعداد <?php echo $this->session->userdata('studentDName'); ?></th>
                    <th class="text-center">روش برگزاری</th>
                    <th class="text-center">جلسات</th>
                </tr>
                </tfoot>
                <tbody>
                <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $course): ?>
                        <tr>
                            <td class="text-center"><?php echo htmlspecialchars($course->course_id, ENT_QUOTES) ?></td>
                            <td class="pull-left">
                                <img src="<?php echo base_url(); ?>./assets/course-picture/thumb/<?php echo htmlspecialchars($course->course_pic, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                                <?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?></td>
                            <td class="text-center"> <?php echo htmlspecialchars($course->course_duration, ENT_QUOTES) ?> </td>
                            <td class="text-center"><?php echo htmlspecialchars($course->time_meeting, ENT_QUOTES) ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($course->start_date, ENT_QUOTES) ?> </td>
                            <td class="text-center" style="width: 200px">
                                <?php if ($course->sat_status === '1'): ?>
                                    <span class='text-info'>شنبه : </span><span><?php echo htmlspecialchars(substr($course->sat_clock, 0, 5), ENT_QUOTES); ?></span>
                                <?php endif; ?>

                                <?php if ($course->sun_status === '1'): ?>
                                    <span class='text-info'>یکشنبه : </span><span><?php echo htmlspecialchars(substr($course->sun_clock, 0, 5), ENT_QUOTES); ?></span>
                                <?php endif; ?>

                                <?php if ($course->mon_status === '1'): ?>
                                    <span class='text-info'>دوشنبه : </span><span><?php echo htmlspecialchars(substr($course->mon_clock, 0, 5), ENT_QUOTES); ?></span>
                                <?php endif; ?>

                                <?php if ($course->tue_status === '1'): ?>
                                    <span class='text-info'>سه شنبه : </span><span><?php echo htmlspecialchars(substr($course->tue_clock, 0, 5), ENT_QUOTES); ?></span>
                                <?php endif; ?>

                                <?php if ($course->wed_status === '1'): ?>
                                    <span class='text-info'>چهارشنبه : </span><span><?php echo htmlspecialchars(substr($course->wed_clock, 0, 5), ENT_QUOTES); ?></span>
                                <?php endif; ?>

                                <?php if ($course->thu_status === '1'): ?>
                                    <span class='text-info'>پنج شنبه : </span><span><?php echo htmlspecialchars(substr($course->thu_clock, 0, 5), ENT_QUOTES); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php
                                foreach ($classes as $class) {
                                    if ($course->class_id === $class->class_id) {
                                        ?>
                                        <lable data-toggle="tooltip" data-original-title="<?php echo $class->class_description ?>">
                                            <?php echo htmlspecialchars($class->class_name, ENT_QUOTES); ?>
                                        </lable>
                                        <?php
                                    }
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <?php
                                if ($course->type_course == 1) {
                                    echo "خصوصی";
                                } else {
                                    echo "عمومی";
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <?php
                                $count = 0;
                                foreach ($count_student_course as $count_std):
                                    if ($count_std->course_id === $course->course_id):
                                        $count++;
                                    endif;
                                endforeach;
                                echo htmlspecialchars($count, ENT_QUOTES);
                                ?>
                            </td>
                            <td class="text-center">
                                <?php
                                if ($course->type_holding == '0') {?>
                                    <span class="text-primery">حضوری</span>
                                <?php } else {?>
									<span><a class="btn btn-info btn-rounded" href="#" onclick="event.preventDefault();document.getElementById('class_online_<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="آنلاین"> آنلاین </a></span>
									<form class="" id='class_online_<?php echo htmlspecialchars($course->course_id); ?>' style="display:none" action="<?php echo base_url(); ?>teacher/test" method="post">
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
										<input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
									</form>
<!--                                    <span><a class="btn btn-primary btn-rounded" href="" data-toggle="modal" data-target="#course-online_--><?//= $course->course_id ?><!--">آنلاین</a></span>-->
                                <?php } ?>

                                <!-- modal -->
                                <div id="course-online_<?= $course->course_id; ?>" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #edf0f2">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">لینک کلاس آنلاین شما</h4>
                                            </div>
                                                <div class="modal-body">
                                                    <?php if($course->detail_online !== null):
                                                        $detail_online = $course->detail_online;
                                                        $detail_online = json_decode($detail_online);
                                                        if($detail_online->link_teacher !== 'null'):
                                                            if($course->course_status === '1'):?>
                                                                <p class="">نام کاربری: <?= $detail_online->user ;?></p>
                                                                <p class="">رمز ورود: <?= $detail_online->pass ;?></p>
                                                            <?php elseif($course->course_status === '0'):?>
                                                                <p class="text-danger">دوره فعالسازی نشده است</p>
                                                            <?php else:?>
                                                                <p class="text-danger">دوره اتمام یافته است</p>
                                                            <?php
                                                            endif;
                                                        else:?>
                                                            <p class="text-danger">کلاس آنلاین شما ایجاد نشده است</p>
                                                        <?php
                                                        endif;
                                                    else:?>
                                                        <p class="text-danger">کلاس آنلاین شما ایجاد نشده است</p>
                                                    <?php endif;?>
                                                </div>
                                            <div class="modal-footer">
                                                <?php if($course->detail_online !== null):
                                                    if($detail_online->link_teacher !== 'null'):
                                                        if($course->course_status === '1'):?>
                                                            <div class="col-md-8">
                                                                <a href="<?= $detail_online->link_teacher ?>" class="btn btn-success" style="width: 100%">ورود به کلاس آنلاین</a>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">بستن</button>
                                                            </div>
                                                        <?php else:?>
                                                            <div class="col-md-12">
                                                                <button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">بستن</button>
                                                            </div>
                                                        <?php
                                                        endif;
                                                    else:?>
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">بستن</button>
                                                        </div>
                                                    <?php
                                                    endif;
                                                else:?>
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">بستن</button>
                                                    </div>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>

                            <td class="text-center">
                                <?php if ($course->course_status === '1'): ?>
                                    <a href="<?php echo base_url('teacher/courses/list_of_meeting/' . $course->course_id); ?>" class="glyphicon glyphicon-equalizer" ></a>
                                <?php elseif ($course->course_status === '0'): ?>
                                    <span class="label label-warning">در انتظار</span>
                                <?php else: ?>
                                    <span class="label label-danger">اتمام دوره</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
<!--                                --><?php //if ($course->course_status === '1'): ?>
<!--                                    <a href="--><?php //echo base_url('teacher/courses/list_of_meeting/' . $course->course_id); ?><!--" class="glyphicon glyphicon-equalizer" ></a>-->
<!--                                --><?php //elseif ($course->course_status === '0'): ?>
<!--                                    <span class="label label-warning">در انتظار</span>-->
<!--                                --><?php //else: ?>
<!--                                    <span class="label label-danger">اتمام دوره</span>-->
<!--                                --><?php //endif; ?>
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
