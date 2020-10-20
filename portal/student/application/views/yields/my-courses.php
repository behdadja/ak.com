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
                    <th class="text-center">روش برگزاری</th>
                    <th class="text-center">جلسات</th>
                </tr>
                </tfoot>
                <tbody>
                <?php if (!empty($courses)): ?>
                    <?php
                    foreach ($courses as $course):
                        $course_id = $course->course_id;
                        $student_nc = $course->student_nc;
                        ?>
                        <tr>
                            <td class="text-center"><?php echo htmlspecialchars($course_id, ENT_QUOTES) ?></td>
                            <td class="pull-left">
                                <img src="<?php echo base_url(); ?>./assets/course-picture/thumb/<?php echo htmlspecialchars($course->course_pic, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
                                <?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?>
                            </td>
                            <td class="text-center"><?php echo htmlspecialchars($course->course_duration, ENT_QUOTES) ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($course->time_meeting, ENT_QUOTES) ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($course->start_date, ENT_QUOTES) ?></td>
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
								if ($course->type_holding == '0'):?>
									<span class="text-primery">حضوری</span>
								<?php else:
									if($course->reg_site == '0' || $course->reg_site == '2'): ?>
										<span><a class="btn btn-info btn-rounded" href="#" onclick="event.preventDefault();document.getElementById('class_online_<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="ورود به کلاس آنلاین"> آنلاین </a></span>
										<form class="" id='class_online_<?php echo htmlspecialchars($course->course_id); ?>' style="display:none" action="<?php echo base_url(); ?>student/test" method="post">
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
											<input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course->course_id, ENT_QUOTES); ?>">
										</form>
									<?php elseif($course->reg_site == '1'): ?>
										<span><a class="btn btn-danger btn-rounded" href="" data-toggle="modal" data-target="#course-online_<?= $course->course_id ?>"><i data-toggle="tooltip" data-original-title="عدم دسترسی">آنلاین</i></a></span>
										<div id="course-online_<?= $course->course_id; ?>" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header" style="background-color: #edf0f2">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
														<h4 class="modal-title" id="myModalLabel">لینک کلاس آنلاین شما</h4>
													</div>
													<div class="modal-body">
														<span class="text-danger"> عدم دسترسی</span>
														<p class="text-info">برای دسترسی به کلاس آنلاین باید دسترسی شما توسط مدیر آموزشگاه تایید شود.</p>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">بستن</button>
													</div>
												</div>
											</div>
										</div>
									<?php endif;
								endif; ?>
                            </td>

                            <td class="text-center">
                                <a alt="default" data-toggle="modal" data-target="#modal_<?php echo htmlspecialchars($course_id, ENT_QUOTES) ?>"> <i class="glyphicon glyphicon-equalizer"></i> </a>
                                <!-- /.modal -->
                                <div id="modal_<?php echo htmlspecialchars($course_id, ENT_QUOTES) ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">جلسات دوره <?php echo htmlspecialchars($course->lesson_name, ENT_QUOTES) ?></h4> </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered" style="text-align: center">
                                                    <thead>
                                                    <tr>
                                                        <th style="text-align: center">لیست جلسات</th>
                                                        <th style="text-align: center">غیبت</th>
                                                        <th style="text-align: center">فایل آموزشی</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    if (!empty($attendancelist)) {
                                                        foreach ($attendancelist as $more):
                                                            if ($more->meeting_number != null && $course_id == $more->course_id):
                                                                $meeting = $more->meeting_number;
                                                                ?>
                                                                <tr>
                                                                    <?php if ($more->course_id == $course->course_id) { ?>
                                                                        <td>
                                                                            جلسه
                                                                            <?php echo htmlspecialchars($meeting, ENT_QUOTES); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            foreach ($attendancelist as $more2):
                                                                                if ($more2->meeting_number == null && $course_id == $more2->course_id && $student_nc == $more2->student_nc && $more2->meeting_number_std == $more->meeting_number):
                                                                                    ?>
                                                                                    <i class="text-danger glyphicon glyphicon-ok"></i>
                                                                                <?php
                                                                                endif;
                                                                            endforeach;
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <a alt="default" data-toggle="modal" data-target="#file_<?= $more->course_id . $meeting; ?>"> <i class="glyphicon glyphicon-open"></i> </a>
                                                                            <!-- /.modal -->
                                                                            <div id="file_<?= $more->course_id . $meeting; ?>" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                            <h4 class="modal-title">دوره  <?php echo $course->lesson_name; ?> جلسه  <?php echo $meeting; ?></h4> </div>
                                                                                        <div class="modal-body">
                                                                                            <table class="table table-bordered" style="text-align: center">
                                                                                                <thead>
                                                                                                <tr>
                                                                                                    <th style="text-align: center">عنوان فایل</th>
                                                                                                    <th style="text-align: center">دانلود</th>
                                                                                                </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                <?php
                                                                                                if (!empty($awareness_subject)):
                                                                                                    foreach ($awareness_subject as $as):
                                                                                                        if ($as->course_id === $more->course_id && $as->meeting_number === $meeting):
                                                                                                            ?>
                                                                                                            <tr>
                                                                                                                <td>
                                                                                                                    <label><?php echo $as->awareness_subject_title; ?></label>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    <a class="btn btn-success" href="<?php echo base_url('/assets/awareness/' . $as->file_name); ?>"><?php echo $as->file_name; ?></a>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        <?php
                                                                                                        endif;
                                                                                                    endforeach;
                                                                                                else:
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td class="text-danger text-center">
                                                                                                            فایلی ثبت نشده است
                                                                                                        </td>
                                                                                                        <td class="text-danger text-center">
                                                                                                            ***
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                <?php endif; ?>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-info" data-dismiss="modal">بستن</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </td>
                                                                    <?php } ?>
                                                                </tr>
                                                            <?php
                                                            endif;
                                                        endforeach;
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td class="text-danger text-center">
                                                                جلسه ای ثبت نشده است
                                                            </td>
                                                            <td class="text-danger text-center">
                                                                ***
                                                            </td>
                                                            <td class="text-danger text-center">
                                                                ***
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
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
