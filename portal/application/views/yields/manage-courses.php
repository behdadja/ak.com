
<style>
    #fun ul{
        margin: -20px 0 -20px 0;
        padding: -20px 0 -20px 0
    }
</style>
<?php if ($this->session->flashdata('enroll-new')) : ?>
    <div class="alert alert-success"><?php echo $this->session->flashdata('enroll-new'); ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('enroll-exist')) : ?>
    <div class="alert alert-danger"><?php echo $this->session->flashdata('enroll-exist'); ?></div>
<?php endif; ?>
<div class="col-md-12 col-lg-12 col-xs-12">
	<div class="white-box">
<!--		<h3 class="box-title m-b-20">طراحی سفارشی تب2 <code class="font-12">customtab2</code></h3>-->
		<!-- Nav tabs -->
			<ul class="sttabs tabs-style-linebox">
				<li  class="<?php if(!$this->session->flashdata('course_active')){echo 'active';}?>"><a href="tabs.html#all"  role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"></span><span> تمام دوره ها</span></a></li>
				<li  class="<?php if($this->session->flashdata('course_active')){echo 'active';}?>"><a href="tabs.html#active"  role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"></span> <span>دوره های فعال</span></a></li>
				<li  class=""><a href="tabs.html#waiting"  role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"></span> <span>دوره های در انتظار</span></a></li>
				<li  class=""><a href="tabs.html#finished"  role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"></span> <span>دوره های غیر فعال</span></a></li>
			</ul>
		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade <?php if(!$this->session->flashdata('course_active')){echo 'active in';}?>" id="all">
				<div class="col-sm-12">
					<div class="white-box">
						<?php if ($this->session->flashdata('success-insert')) : ?>
							<div class="alert alert-success"><?php echo $this->session->flashdata('success-insert'); ?></div>
						<?php endif; ?>
						<div class="table-responsive">
							<table style="direction: rtl" class="table table-striped" id="mt">
								<thead>
								<tr>
									<th class="text-center">کد دوره</th>
									<th class="text-center">نام درس</th>
									<th class="text-center">نام <?php echo $this->session->userdata('teacherDName'); ?></th>
									<th class="text-center">روز و ساعت برگزای دوره</th>
									<th class="text-center text-danger">تاریخ شروع دوره</th>
									<th class="text-center">زمان هر جلسه(دقیقه)</th>
									<th class="text-center">روش برگزاری</th>
									<th class="text-center">وضعیت دوره</th>
									<th class="text-center">ظرفیت باقی مانده</th>
									<th class="text-center">ابزار</th>
								</tr>
								</thead>
								<tbody id="myTable">
								<?php if (!empty($courses_info)): ?>
									<?php foreach ($courses_info as $course_info): ?>
										<tr>

											<td><?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?></td>
											<td class="pull-left">
												<img src="<?php echo base_url(); ?>assets/course-picture/thumb/<?php echo htmlspecialchars($course_info->course_pic, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
												<?php echo htmlspecialchars($course_info->lesson_name, ENT_QUOTES); ?>
											</td>

											<td><?php echo htmlspecialchars($course_info->first_name, ENT_QUOTES) . ' ' . htmlspecialchars($course_info->last_name, ENT_QUOTES); ?></td>
											<td style="width: 200px">
												<a href="<?= base_url('schedule-meetings/' . $course_info->course_id) ?>">
													<?php if ($course_info->sat_status === '1'): ?>
														<span class='text-info'>شنبه : </span><span><?php echo htmlspecialchars(substr($course_info->sat_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->sun_status === '1'): ?>
														<span class='text-info'>یکشنبه : </span><span><?php echo htmlspecialchars(substr($course_info->sun_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->mon_status === '1'): ?>
														<span class='text-info'>دوشنبه : </span><span><?php echo htmlspecialchars(substr($course_info->mon_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->tue_status === '1'): ?>
														<span class='text-info'>سه شنبه : </span><span><?php echo htmlspecialchars(substr($course_info->tue_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->wed_status === '1'): ?>
														<span class='text-info'>چهارشنبه : </span><span><?php echo htmlspecialchars(substr($course_info->wed_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->thu_status === '1'): ?>
														<span class='text-info'>پنج شنبه : </span><span><?php echo htmlspecialchars(substr($course_info->thu_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->fri_status === '1'): ?>
														<span class='text-info'>جمعه: </span><span><?php echo htmlspecialchars(substr($course_info->fri_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>
												</a>
											</td>
											<td><?php echo htmlspecialchars($course_info->start_date, ENT_QUOTES); ?></td>
											<td class="text-center"><?php echo htmlspecialchars($course_info->time_meeting, ENT_QUOTES); ?></td>
											<td class="text-center">
												<?php
												if ($course_info->type_holding == '0') {?>
													<span class="text-info">حضوری</span>
												<?php } else {?>
													<span class="text-danger">آنلاین</span>
												<?php } ?>
											</td>
											<td>
												<?php if ($course_info->course_status === '0'): ?>
													<span class="label label-warning">در انتظار </span>
												<?php elseif ($course_info->course_status === '1'): ?>
													<span class="label label-success">فعال</span>
												<?php else: ?>
													<span class="label label-primary">اتمام دوره</span>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<?php
												if ($course_info->capacity !== '0') {
													if ($course_info->capacity - $course_info->count_std === 0) {
														?>
														<span class="label label-danger">تکمیل</span>
													<?php } else { ?>
														<span class="label label-warning"><?php echo $course_info->capacity - $course_info->count_std; ?></span>
														<?php
													}
												} else {
													?>
													<span class="label label-success">نامحدود</span>
												<?php } ?>
											</td>
											<td>
												<!-- button for popover -->
												<div id="fun">
													<ul class="nav navbar-top-links navbar-right pull-right">
														<li class="dropdown">
															<a class="dropdown-toggle" data-toggle="dropdown" href=""><span class="glyphicon glyphicon-equalizer text-inverse"></span> </a>
															<ul class="dropdown-menu dropdown-user flipInY" style="border: cadetblue thick solid;border-radius: 0 20px 20px 20px">
																<li>
																	<div class="dw-user-box">
																		<div class="u-text" style="width: 260px">
																			<?php if ($course_info->course_status !== '2'): ?>
																				<a href="" onclick="event.preventDefault(); document.getElementById('edit_<?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="ویرایش"> <i class="mdi mdi-pencil text-inverse m-r-20"></i> </a>
																				<form class="" id='edit_<?php echo htmlspecialchars($course_info->course_id); ?>' style="display:none" action="<?php echo base_url(); ?>training/edit-course" method="post">
																					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																					<input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?>">
																				</form>

																				<a href="" data-toggle="modal" data-target="#delete_<?php echo $course_info->course_id; ?>"><i class="fa fa-close text-danger m-r-20" data-toggle="tooltip" data-original-title="حذف دوره"></i></a>
																			<?php endif; ?>

																			<?php if ($course_info->course_status === '0'): ?>
																				<a href="" data-toggle="modal" data-target="#start_<?php echo $course_info->course_id; ?>"><i class="glyphicon glyphicon-play text-success m-r-20" data-toggle="tooltip" data-original-title="فعالسازی دوره"></i></a>
																			<?php elseif ($course_info->course_status === '1'): ?>
																				<a href="" data-toggle="modal" data-target="#stop_<?php echo $course_info->course_id; ?>"><i class="glyphicon glyphicon-stop m-r-20" data-toggle="tooltip" data-original-title="اتمام دوره"></i></a>
																			<?php else: ?>
																				<i class="glyphicon glyphicon-saved text-info  m-r-20" data-toggle="tooltip" data-original-title="دوره به پایان رسیده"></i>
																			<?php endif; ?>
																			|
																			<?php if ($course_info->course_status !== '0'): ?>
																				<a style="padding-right: 10px" href="<?php echo base_url('training/list_of_meeting/' . $course_info->course_id . '/' . $course_info->course_status); ?>" data-toggle="tooltip" data-original-title="لیست جلسات" class="glyphicon glyphicon-equalizer m-l-10" ></a>
																			<?php endif; ?>
																			<a href="<?php echo base_url('enrollment/registration-of-course/'.$course_info->course_id); ?>" data-toggle="tooltip" data-original-title="ثبت نامی های دوره"> <i class="glyphicon glyphicon-list m-l-20 text-success"></i> </a>
																			<!--  <a href="" onclick="event.preventDefault(); document.getElementById('show_<?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="ثبت نامی های دوره"> <i class="glyphicon glyphicon-list m-l-20 text-success"></i> </a>
                                                                                <form class="" id='show_<?php echo htmlspecialchars($course_info->course_id); ?>' style="display:none" action="<?php echo base_url(); ?>enrollment/registration_of_course" method="post">
                                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                    <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?>"/>
                                                                                </form>  -->
																			<?php
																			if ($course_info->course_status !== '2'):
																				if ($course_info->capacity - $course_info->count_std !== 0 || $course_info->capacity == 0):
																					?>
																					<a href="<?php echo base_url('enrollment/course/' . $course_info->course_id . '/' . $course_info->lesson_name); ?>" data-toggle="tooltip" data-original-title="ثبت نام <?php echo $this->session->userdata('studentDName'); ?>"> <i class="mdi mdi-account-multiple-plus text-inverse m-l-20"></i> </a>
																				<?php
																				endif;
																			endif;
																			?>
																		</div>
																	</div>
																</li>
															</ul>
															<!-- /.dropdown-user -->
														</li>
														<!-- /.dropdown -->
													</ul>
												</div>
												<!-- / end button for popover -->
												<!-- modal delete course -->
												<div id="delete_<?php echo $course_info->course_id; ?>" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header" style="background-color: #edf0f2">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																<h4 class="modal-title" id="myModalLabel">حذف دوره</h4>
															</div>
															<form action="<?php echo base_url('training/delete-course'); ?>" method="post">
																<div class="modal-body">
																	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																	<input type="hidden" name="course_id" value="<?php echo $course_info->course_id ?>">
																	<p> <?php echo "از حذف دوره " . $course_info->lesson_name . " اطمینان دارید؟" ?></p>
																</div>
																<div class="modal-footer">
																	<div class="col-md-6">
																		<button type="submit" class="btn btn-success" style="width: 100%">بله</button>
																	</div>
																	<div class="col-md-6">
																		<button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">خیر</button>
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>
												<!-- end modal delete -->
												<!-- modal start course -->
												<div id="start_<?php echo $course_info->course_id; ?>" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<?php if ($course_info->type_course === '1' && ($course_info->type_pay === '0' || $course_info->type_pay === '1') && $course_info->type_tuition === '0' && $course_info->count_std === '0'): ?>
															<div class="modal-content">
																<div class="modal-header" style="background-color: #edf0f2">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	<h4 class="modal-title" id="myModalLabel">فعالسازی دوره</h4>
																</div>
																<div class="modal-body">
																	<p>
																		در مورد این دوره به دلیل به هم ریختن حساب مالی کاربران
																		<br>شما نمی توانید قبل از ثبت نام کردن دانشجو دوره را فعال کنید.
																		<br> لطفا ابتدا ثبت نام های خود را تکمیل کنید.
																	</p>
																</div>
																<div class="modal-footer">
																	<div class="col-md-6">
																		<a href="<?= base_url('enrollment/course/' . $course_info->course_id . '/' . $course_info->lesson_name); ?>" type="button" class="btn btn-success" style="width: 100%">ثبت نام <?php echo $this->session->userdata('studentDName'); ?></a>
																	</div>
																	<div class="col-md-6">
																		<button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">انصراف</button>
																	</div>
																</div>
															</div>
														<?php else: ?>
															<div class="modal-content">
																<div class="modal-header" style="background-color: #edf0f2">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	<h4 class="modal-title" id="myModalLabel">فعالسازی دوره</h4>
																</div>
																<form action="<?php echo base_url('training/start_course'); ?>" method="post">
																	<div class="modal-body">
																		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																		<input type="hidden" name="course_status" class="form-control" value="<?php echo $course_info->course_status ?>">
																		<input type="hidden" name="course_id" value="<?php echo $course_info->course_id ?>">
																		<input type="hidden" name="time_meeting" value="<?php echo $course_info->time_meeting ?>">
																		<p><?php echo "از فعالسازی دوره " . $course_info->lesson_name . " اطمینان دارید؟" ?></p>
																	</div>
																	<div class="modal-footer">
																		<div class="col-md-6">
																			<button type="submit" class="btn btn-success" style="width: 100%">بله</button></a>
																		</div>
																		<div class="col-md-6">
																			<button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">خیر</button>
																		</div>
																	</div>
																</form>
															</div>
														<?php endif; ?>
													</div>
												</div>
												<!-- end modal start -->
												<!-- modal stop course -->
												<div id="stop_<?php echo $course_info->course_id; ?>" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header" style="background-color: #edf0f2">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																<h4 class="modal-title" id="myModalLabel">اتمام دوره</h4>
															</div>
															<form action="<?php echo base_url('training/stop_course'); ?>" method="post">
																<div class="modal-body">
																	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																	<input type="hidden" name="course_id" value="<?php echo $course_info->course_id ?>">
																	<p><?php echo "از پایان دادن به دوره " . $course_info->lesson_name . " اطمینان دارید؟" ?></p>
																</div>
																<div class="modal-footer">
																	<div class="col-md-6">
																		<button type="submit" class="btn btn-success" style="width: 100%">بله</button>
																	</div>
																	<div class="col-md-6">
																		<button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">خیر</button>
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>
												<!-- / end modal stop -->
											</td>
										</tr>
									<?php
									endforeach;
								endif;
								?>
								</tbody>
							</table>
							<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%5 -->
							<div style="height: 60px"></div>
							<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%5 -->
						</div>
					</div>
				</div>

			</div>
			<div role="tabpanel" class="tab-pane fade <?php if($this->session->flashdata('course_active')){echo 'active in';}?>" id="active">
				<div class="col-sm-12">
					<div class="white-box">
						<div class="table-responsive">
							<?php if ($this->session->flashdata('success-insert')) : ?>
								<div class="alert alert-success"><?php echo $this->session->flashdata('success-insert'); ?></div>
							<?php endif; ?>
							<table class="table table-striped">
								<thead>
								<tr>
									<th class="text-center">کد دوره</th>
									<th class="text-center">نام درس</th>
									<th class="text-center">نام <?php echo $this->session->userdata('teacherDName'); ?></th>
									<th class="text-center">روز و ساعت برگزای دوره</th>
									<th class="text-center text-danger">تاریخ شروع دوره</th>
									<th class="text-center">زمان هر جلسه(دقیقه)</th>
									<th class="text-center">روش برگزاری</th>
									<th class="text-center">ظرفیت باقی مانده</th>
									<th class="text-center">ابزار</th>
								</tr>
								</thead>
								<tbody>
								<?php
								if (!empty($courses_info)):
									foreach ($courses_info as $course_info):
										if ($course_info->course_status === '0'):
											?>
											<tr>
												<td><?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?></td>
												<td class="pull-left">
													<img src="<?php echo base_url(); ?>assets/course-picture/thumb/<?php echo htmlspecialchars($course_info->course_pic, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
													<?php echo htmlspecialchars($course_info->lesson_name, ENT_QUOTES); ?>
												</td>
												<td><?php echo htmlspecialchars($course_info->first_name, ENT_QUOTES) . ' ' . htmlspecialchars($course_info->last_name, ENT_QUOTES); ?></td>
												<td style="width: 200px">
													<?php if ($course_info->sat_status === '1'): ?>
														<span class='text-info'>شنبه : </span><span><?php echo htmlspecialchars(substr($course_info->sat_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->sun_status === '1'): ?>
														<span class='text-info'>یکشنبه : </span><span><?php echo htmlspecialchars(substr($course_info->sun_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->mon_status === '1'): ?>
														<span class='text-info'>دوشنبه : </span><span><?php echo htmlspecialchars(substr($course_info->mon_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->tue_status === '1'): ?>
														<span class='text-info'>سه شنبه : </span><span><?php echo htmlspecialchars(substr($course_info->tue_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->wed_status === '1'): ?>
														<span class='text-info'>چهارشنبه : </span><span><?php echo htmlspecialchars(substr($course_info->wed_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->thu_status === '1'): ?>
														<span class='text-info'>پنج شنبه : </span><span><?php echo htmlspecialchars(substr($course_info->thu_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>
												</td>
												<td class="text-center"><?php echo htmlspecialchars($course_info->start_date, ENT_QUOTES); ?></td>
												<td class="text-center"><?php echo htmlspecialchars($course_info->time_meeting, ENT_QUOTES); ?></td>
												<td class="text-center">
													<?php
													if ($course_info->type_holding == '0') {?>
														<span class="text-info">حضوری</span>
													<?php } else {?>
														<span class="text-danger">آنلاین</span>
													<?php } ?>
												</td>
												<td class="text-center">
													<?php
													if ($course_info->capacity !== '0') {
														if ($course_info->capacity - $course_info->count_std === 0) {
															?>
															<span class="label label-danger">تکمیل</span>
														<?php } else { ?>
															<span class="label label-warning"><?php echo $course_info->capacity - $course_info->count_std; ?></span>
															<?php
														}
													} else {
														?>
														<span class="label label-success">نامحدود</span>
													<?php } ?>
												</td>
												<td class="text-nowrap">
													<!-- button for popover -->
													<div id="fun">
														<ul class="nav navbar-top-links navbar-right pull-right">
															<li class="dropdown">
																<a class="dropdown-toggle" data-toggle="dropdown" href=""><span class="glyphicon glyphicon-equalizer text-inverse"></span> </a>
																<ul class="dropdown-menu dropdown-user flipInY" style="border: cadetblue thick solid;border-radius: 0 20px 20px 20px">
																	<li>
																		<div class="dw-user-box">
																			<div class="u-text" style="width: 260px">

																				<a href="" onclick="event.preventDefault(); document.getElementById('edit3_<?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="ویرایش"> <i class="mdi mdi-pencil text-inverse m-r-20"></i> </a>
																				<form class="" id='edit3_<?php echo htmlspecialchars($course_info->course_id); ?>' style="display:none" action="<?php echo base_url(); ?>training/edit-course" method="post">
																					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																					<input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?>">
																				</form>

																				<a href="" data-toggle="modal" data-target="#delete3_<?php echo $course_info->course_id; ?>"><i class="fa fa-close text-danger m-r-20" data-toggle="tooltip" data-original-title="حذف دوره"></i></a>

																				<a href="" data-toggle="modal" data-target="#start3_<?php echo $course_info->course_id; ?>"><i class="glyphicon glyphicon-play text-success m-r-20" data-toggle="tooltip" data-original-title="فعالسازی دوره"></i></a>
																				|
																				<?php if ($course_info->course_status !== '0'): ?>
																					<a style="padding-right: 10px" href="<?php echo base_url('training/list_of_meeting/' . $course_info->course_id . "/" . $course_info->course_status); ?>" data-toggle="tooltip" data-original-title="لیست جلسات" class="glyphicon glyphicon-equalizer m-l-10" ></a>
																				<?php endif; ?>
																				<a href="<?php echo base_url('enrollment/registration-of-course/'.$course_info->course_id); ?>" data-toggle="tooltip" data-original-title="ثبت نامی های دوره"> <i class="glyphicon glyphicon-list m-l-20 text-success"></i> </a>
																				<!--
																				<a href="" onclick="event.preventDefault(); document.getElementById('show_<?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="ثبت نامی های دوره"> <i class="glyphicon glyphicon-list m-l-20 text-success"></i> </a>
																				<form class="" id='show_<?php echo htmlspecialchars($course_info->course_id); ?>' style="display:none" action="<?php echo base_url(); ?>enrollment/registration_of_course" method="post">
																					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																					<input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?>"/>
																				</form>
																				-->

																				<?php if ($course_info->capacity - $course_info->count_std !== 0): ?>
																					<a href="<?php echo base_url('enrollment/course/' . $course_info->course_id . '/' . $course_info->lesson_name); ?>" data-toggle="tooltip" data-original-title="ثبت نام <?php echo $this->session->userdata('studentDName'); ?>"> <i class="mdi mdi-account-multiple-plus text-inverse m-l-20"></i> </a>
																				<?php endif; ?>
																			</div>
																		</div>
																	</li>
																</ul>
																<!-- /.dropdown-user -->
															</li>
															<!-- /.dropdown -->
														</ul>
													</div>
													<!-- / end button for popover -->
													<!-- modal delete course -->
													<div id="delete3_<?php echo $course_info->course_id; ?>" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header" style="background-color: #edf0f2">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	<h4 class="modal-title" id="myModalLabel">حذف دوره</h4>
																</div>
																<form action="<?php echo base_url('training/delete-course'); ?>" method="post">
																	<div class="modal-body">
																		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																		<input type="hidden" name="course_id" value="<?php echo $course_info->course_id ?>">
																		<p><?php echo "از حذف دوره " . $course_info->lesson_name . " اطمینان دارید؟" ?></p>
																	</div>
																	<div class="modal-footer">
																		<div class="col-md-6">
																			<button type="submit" class="btn btn-success" style="width: 100%">بله</button>
																		</div>
																		<div class="col-md-6">
																			<button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">خیر</button>
																		</div>
																	</div>
																</form>
															</div>
														</div>
													</div>
													<!-- / end modal delete course -->
													<!-- modal start course -->
													<div id="start3_<?php echo $course_info->course_id; ?>" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
														<div class="modal-dialog">
															<?php if ($course_info->type_course === '1' && ($course_info->type_pay === '0' || $course_info->type_pay === '1') && $course_info->type_tuition === '0' && $course_info->count_std === '0'): ?>
																<div class="modal-content">
																	<div class="modal-header" style="background-color: #edf0f2">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h4 class="modal-title" id="myModalLabel">فعالسازی دوره</h4>
																	</div>
																	<div class="modal-body">
																		<p>
																			در مورد این دوره به دلیل به هم ریختن حساب مالی کاربران
																			<br>شما نمی توانید قبل از ثبت نام کردن دانشجو دوره را فعال کنید.
																			<br> لطفا ابتدا ثبت نام های خود را تکمیل کنید.
																		</p>
																	</div>
																	<div class="modal-footer">
																		<div class="col-md-6">
																			<a href="<?= base_url('enrollment/course/' . $course_info->course_id . '/' . $course_info->lesson_name); ?>" type="button" class="btn btn-success" style="width: 100%">ثبت نام <?php echo $this->session->userdata('studentDName'); ?></a>
																		</div>
																		<div class="col-md-6">
																			<button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">انصراف</button>
																		</div>
																	</div>
																</div>
															<?php else: ?>
																<div class="modal-content">
																	<div class="modal-header" style="background-color: #edf0f2">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		<h4 class="modal-title" id="myModalLabel">فعالسازی دوره</h4>
																	</div>
																	<form action="<?php echo base_url('training/start_course'); ?>" method="post">
																		<div class="modal-body">
																			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																			<input type="hidden" name="course_status" class="form-control" value="<?php echo $course_info->course_status ?>">
																			<input type="hidden" name="course_id" value="<?php echo $course_info->course_id ?>">
																			<input type="hidden" name="time_meeting" value="<?php echo $course_info->time_meeting ?>">
																			<p><?php echo "از فعالسازی دوره " . $course_info->lesson_name . " اطمینان دارید؟" ?></p>
																		</div>
																		<div class="modal-footer">
																			<div class="col-md-6">
																				<button type="submit" class="btn btn-success" style="width: 100%">بله</button>
																			</div>
																			<div class="col-md-6">
																				<button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">خیر</button>
																			</div>
																		</div>
																	</form>
																</div>
															<?php endif; ?>
														</div>
													</div>
													<!-- / end modal start course -->
												</td>
											</tr>
										<?php
										endif;
									endforeach;
								endif;
								?>
								</tbody>
							</table>
							<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%5 -->
							<div style="height: 60px"></div>
							<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%5 -->
						</div>
					</div>
				</div>


			</div>
			<div role="tabpanel" class="tab-pane fade" id="waiting">
				<div class="col-sm-12">
					<div class="white-box">
						<div class="table-responsive">
							<?php if ($this->session->flashdata('success-insert')) : ?>
								<div class="alert alert-success"><?php echo $this->session->flashdata('success-insert'); ?></div>
							<?php endif; ?>
							<table class="table table-striped">
								<thead>
								<tr>
									<th class="text-center">کد دوره</th>
									<th class="text-center">نام درس</th>
									<th class="text-center">نام <?php echo $this->session->userdata('teacherDName'); ?></th>
									<th class="text-center">روز و ساعت برگزای دوره</th>
									<th class="text-center text-danger">تاریخ شروع دوره</th>
									<th class="text-center">زمان هر جلسه(دقیقه)</th>
									<th class="text-center">روش برگزاری</th>
									<th class="text-center">ظرفیت باقی مانده</th>
									<th class="text-center">ابزار</th>
								</tr>
								</thead>
								<tbody>
								<?php
								if (!empty($courses_info)):
									foreach ($courses_info as $course_info):
										if ($course_info->course_status === '1'):
											?>
											<tr>
												<td><?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?></td>
												<td class="pull-left">
													<img src="<?php echo base_url(); ?>assets/course-picture/thumb/<?php echo htmlspecialchars($course_info->course_pic, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
													<?php echo htmlspecialchars($course_info->lesson_name, ENT_QUOTES); ?>
												</td>
												<td><?php echo htmlspecialchars($course_info->first_name, ENT_QUOTES) . ' ' . htmlspecialchars($course_info->last_name, ENT_QUOTES); ?></td>
												<td style="width: 200px">
													<?php if ($course_info->sat_status === '1'): ?>
														<span class='text-info'>شنبه : </span><span><?php echo htmlspecialchars(substr($course_info->sat_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->sun_status === '1'): ?>
														<span class='text-info'>یکشنبه : </span><span><?php echo htmlspecialchars(substr($course_info->sun_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->mon_status === '1'): ?>
														<span class='text-info'>دوشنبه : </span><span><?php echo htmlspecialchars(substr($course_info->mon_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->tue_status === '1'): ?>
														<span class='text-info'>سه شنبه : </span><span><?php echo htmlspecialchars(substr($course_info->tue_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->wed_status === '1'): ?>
														<span class='text-info'>چهارشنبه : </span><span><?php echo htmlspecialchars(substr($course_info->wed_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->thu_status === '1'): ?>
														<span class='text-info'>پنج شنبه : </span><span><?php echo htmlspecialchars(substr($course_info->thu_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>
												</td>
												<td class="text-center"><?php echo htmlspecialchars($course_info->start_date, ENT_QUOTES); ?></td>
												<td class="text-center"><?php echo htmlspecialchars($course_info->time_meeting, ENT_QUOTES); ?></td>
												<td class="text-center">
													<?php
													if ($course_info->type_holding == '0') {?>
														<span class="text-info">حضوری</span>
													<?php } else {?>
														<span class="text-danger">آنلاین</span>
													<?php } ?>
												</td>
												<td class="text-center">
													<?php
													if ($course_info->capacity !== '0') {
														if ($course_info->capacity - $course_info->count_std === 0) {
															?>
															<span class="label label-danger">تکمیل</span>
														<?php } else { ?>
															<span class="label label-warning"><?php echo $course_info->capacity - $course_info->count_std; ?></span>
															<?php
														}
													} else {
														?>
														<span class="label label-success">نامحدود</span>
													<?php } ?>
												</td>
												<td>
													<!-- button for popover -->
													<div id="fun">
														<ul class="nav navbar-top-links navbar-right pull-right">
															<li class="dropdown">
																<a class="dropdown-toggle" data-toggle="dropdown" href=""><span class="glyphicon glyphicon-equalizer text-inverse"></span> </a>
																<ul class="dropdown-menu dropdown-user flipInY" style="border: cadetblue thick solid;border-radius: 0 20px 20px 20px">
																	<li>
																		<div class="dw-user-box">
																			<div class="u-text" style="width: 260px">

																				<a href="" onclick="event.preventDefault(); document.getElementById('edit2_<?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="ویرایش"> <i class="mdi mdi-pencil text-inverse m-r-20"></i> </a>
																				<form class="" id='edit2_<?php echo htmlspecialchars($course_info->course_id); ?>' style="display:none" action="<?php echo base_url(); ?>training/edit-course" method="post">
																					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																					<input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?>">
																				</form>

																				<a href="" data-toggle="modal" data-target="#delete2_<?php echo $course_info->course_id; ?>"><i class="fa fa-close text-danger m-r-20" data-toggle="tooltip" data-original-title="حذف دوره"></i></a>

																				<a href="" data-toggle="modal" data-target="#stop2_<?php echo $course_info->course_id; ?>"><i class="glyphicon glyphicon-stop m-r-20" data-toggle="tooltip" data-original-title="اتمام دوره"></i></a>
																				|

																				<a style="padding-right: 10px" href="<?php echo base_url('training/list_of_meeting/' . $course_info->course_id . "/" . $course_info->course_status); ?>" data-toggle="tooltip" data-original-title="لیست جلسات" class="glyphicon glyphicon-equalizer m-l-10" ></a>

																				<a href="<?php echo base_url('enrollment/registration-of-course/'.$course_info->course_id); ?>" data-toggle="tooltip" data-original-title="ثبت نامی های دوره"> <i class="glyphicon glyphicon-list m-l-20 text-success"></i> </a>
																				<!--
																				<a href="" onclick="event.preventDefault(); document.getElementById('show_<?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="ثبت نامی های دوره"> <i class="glyphicon glyphicon-list m-l-20 text-success"></i> </a>
																				<form class="" id='show_<?php echo htmlspecialchars($course_info->course_id); ?>' style="display:none" action="<?php echo base_url(); ?>enrollment/registration_of_course" method="post">
																					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																					<input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?>"/>
																				</form>
																				-->

																				<?php if ($course_info->capacity - $course_info->count_std !== 0): ?>
																					<a href="<?php echo base_url('enrollment/course/' . $course_info->course_id . '/' . $course_info->lesson_name); ?>" data-toggle="tooltip" data-original-title="ثبت نام <?php echo $this->session->userdata('studentDName'); ?>"> <i class="mdi mdi-account-multiple-plus text-inverse m-l-20"></i> </a>
																				<?php endif; ?>
																			</div>
																		</div>
																	</li>
																</ul>
																<!-- /.dropdown-user -->
															</li>
															<!-- /.dropdown -->
														</ul>
													</div>
													<!-- / end button for popover -->

													<div id="delete2_<?php echo $course_info->course_id; ?>" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header" style="background-color: #edf0f2">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	<h4 class="modal-title" id="myModalLabel">حذف دوره</h4>
																</div>
																<form action="<?php echo base_url('training/delete-course'); ?>" method="post">
																	<div class="modal-body">
																		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																		<input type="hidden" name="course_id" value="<?php echo $course_info->course_id ?>">
																		<p><?php echo "از حذف دوره " . $course_info->lesson_name . " اطمینان دارید؟" ?></p>
																	</div>
																	<div class="modal-footer">
																		<div class="col-md-6">
																			<button type="submit" class="btn btn-success" style="width: 100%">بله</button>
																		</div>
																		<div class="col-md-6">
																			<button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">خیر</button>
																		</div>
																	</div>
																</form>
															</div>
														</div>
													</div>

													<div id="stop2_<?php echo $course_info->course_id; ?>" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header" style="background-color: #edf0f2">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	<h4 class="modal-title" id="myModalLabel">اتمام دوره</h4>
																</div>
																<form action="<?php echo base_url('training/stop_course'); ?>" method="post">
																	<div class="modal-body">
																		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																		<input type="hidden" name="course_id" value="<?php echo $course_info->course_id ?>">
																		<p><?php echo "از پایان دادن به دوره " . $course_info->lesson_name . " اطمینان دارید؟" ?></p>
																	</div>
																	<div class="modal-footer">
																		<div class="col-md-6">
																			<button type="submit" class="btn btn-success" style="width: 100%">بله</button>
																		</div>
																		<div class="col-md-6">
																			<button type="button" class="btn btn-danger" style="width: 100%" data-dismiss="modal">خیر</button>
																		</div>
																	</div>
																</form>
															</div>
														</div>
													</div>
												</td>
											</tr>
										<?php
										endif;
									endforeach;
								endif;
								?>
								</tbody>
							</table>
							<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%5 -->
							<div style="height: 60px"></div>
							<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%5 -->
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="finished">
				<div class="col-sm-12">
					<div class="white-box">
						<div class="table-responsive">
							<?php if ($this->session->flashdata('success-insert')) : ?>
								<div class="alert alert-success"><?php echo $this->session->flashdata('success-insert'); ?></div>
							<?php endif; ?>
							<table class="table table-striped">
								<thead>
								<tr>
									<th class="text-center">کد دوره</th>
									<th class="text-center">نام درس</th>
									<th class="text-center">نام <?php echo $this->session->userdata('teacherDName'); ?></th>
									<th class="text-center">روز و ساعت برگزای دوره</th>
									<th class="text-center text-danger">تاریخ شروع دوره</th>
									<th class="text-center">زمان هر جلسه(دقیقه)</th>
									<th class="text-center">روش برگزاری</th>
									<th class="text-center">لیست جلسات</th>
								</tr>
								</thead>
								<tbody>
								<?php
								if (!empty($courses_info)):
									foreach ($courses_info as $course_info):
										if ($course_info->course_status === '2'):
											?>
											<tr>
												<td><?php echo htmlspecialchars($course_info->course_id, ENT_QUOTES); ?></td>
												<td class="pull-left">
													<img src="<?php echo base_url(); ?>assets/course-picture/thumb/<?php echo htmlspecialchars($course_info->course_pic, ENT_QUOTES) ?>" height="32" alt="user" class="img-circle">
													<?php echo htmlspecialchars($course_info->lesson_name, ENT_QUOTES); ?>
												</td>
												<td><?php echo htmlspecialchars($course_info->first_name, ENT_QUOTES) . ' ' . htmlspecialchars($course_info->last_name, ENT_QUOTES); ?></td>
												<td style="width: 200px">
													<?php if ($course_info->sat_status === '1'): ?>
														<span class='text-info'>شنبه : </span><span><?php echo htmlspecialchars(substr($course_info->sat_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->sun_status === '1'): ?>
														<span class='text-info'>یکشنبه : </span><span><?php echo htmlspecialchars(substr($course_info->sun_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->mon_status === '1'): ?>
														<span class='text-info'>دوشنبه : </span><span><?php echo htmlspecialchars(substr($course_info->mon_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->tue_status === '1'): ?>
														<span class='text-info'>سه شنبه : </span><span><?php echo htmlspecialchars(substr($course_info->tue_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->wed_status === '1'): ?>
														<span class='text-info'>چهارشنبه : </span><span><?php echo htmlspecialchars(substr($course_info->wed_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>

													<?php if ($course_info->thu_status === '1'): ?>
														<span class='text-info'>پنج شنبه : </span><span><?php echo htmlspecialchars(substr($course_info->thu_clock, 0, 5), ENT_QUOTES); ?></span>
													<?php endif; ?>
												</td>
												<td class="text-center">
													<?php echo htmlspecialchars($course_info->start_date, ENT_QUOTES); ?>
												</td>
												<td class="text-center"><?php echo htmlspecialchars($course_info->time_meeting, ENT_QUOTES); ?></td>
												<td class="text-center">
													<?php
													if ($course_info->type_holding == '0') {?>
														<span class="text-info">حضوری</span>
													<?php } else {?>
														<span class="text-danger">آنلاین</span>
													<?php } ?>
												</td>
												<td>
													<a href="<?php echo base_url('training/list_of_meeting/' . $course_info->course_id . "/" . $course_info->course_status); ?>" class="glyphicon glyphicon-equalizer" ></a>
												</td>
											</tr>
										<?php
										endif;
									endforeach;
								endif;
								?>
								</tbody>
							</table>
							<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%5 -->
							<div style="height: 60px"></div>
							<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%5 -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

