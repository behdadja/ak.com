

<div class="col-sm-12">
    <div class="white-box">
		<div class="alert alert-info text-center"><?= 'لیست '.$this->session->userdata('studentDName').' های دوره '.'<span style="background-color:steelblue;border-radius:50px;padding:5px 15px 5px 15px">'. $course[0]->lesson_name.'</span>' ?></div>

		<div class="col-md-3"></div>
		<div class="col-md-6">
			<!-- Nav tabs -->
			<ul class="nav customtab nav-tabs" role="tablist">
				<li style="width: 50%" role="presentation" class="active text-center"><a aria-expanded="true" data-toggle="tab" role="tab" aria-controls="reg_manage"  href="#reg_manage">ثبت نام به وسیله مدیر</a></li>
				<li style="width: 50%" role="presentation" class="text-center"><a aria-expanded="false" data-toggle="tab" role="tab" aria-controls="reg_site"  href="#reg_site">ثبت نام از طریق سایت</a></li>
			</ul>
		</div>
		<div class="col-md-3"></div>
		<!-- Tab panes -->
		<div class="col-md-12 tab-content">
			<div role="tabpanel" class="tab-pane fade active in" id="reg_manage">
				<div class="table-responsive">
					<?php if ($this->session->flashdata('enroll-e')) : ?>
						<div class="alert alert-danger"><?php echo $this->session->flashdata('enroll-e'); ?></div>
					<?php endif; ?>

					<table  id="example26" class="display nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th class="text-center">کد <?php echo $this->session->userdata('studentDName');?></th>
							<th>نام و نام خانوادگی</th>
							<th style="text-align: center">کدملی</th>
							<th style="text-align: center">شماره همراه</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($studentListOfCourse)) {
							foreach ($studentListOfCourse as $student):
								if($student->reg_site == '0'):?>
								<tr>
									<td class="text-center"><?php echo htmlspecialchars($student->student_id, ENT_QUOTES) ?></td>
									<td>
										<img src="<?php echo base_url('assets/profile-picture/thumb/'.htmlspecialchars($student->pic_name, ENT_QUOTES)); ?>" height="32" alt="user" class="img-circle">
										<?php echo htmlspecialchars($student->first_name . ' ' . $student->last_name, ENT_QUOTES); ?>
									</td>
									<td class="text-center">
										<?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?>
									</td>
									<td class="text-center"><?php echo htmlspecialchars($student->phone_num, ENT_QUOTES); ?></td>
								</tr>
							<?php endif;
							endforeach;
						}else {
							?>
							<tr>
								<td class="text-danger text-center">
									کاربری ثبت نام نکرده است. لطفا شکیبا باشید
								</td>
								<td class="text-danger">*</td>
								<td class="text-danger text-center">*</td>
								<td class="text-danger text-center">*</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>

			</div>
			<div role="tabpanel" class="tab-pane fade in" id="reg_site">
				<div class="table-responsive">
					<?php if ($this->session->flashdata('enroll-e')) : ?>
						<div class="alert alert-danger"><?php echo $this->session->flashdata('enroll-e'); ?></div>
					<?php endif; ?>

					<table  id="example23" class="display nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th class="text-center">کد <?php echo $this->session->userdata('studentDName');?></th>
							<th>نام و نام خانوادگی</th>
							<th style="text-align: center">کدملی</th>
							<th style="text-align: center">شماره همراه</th>
							<?php if($course[0]->type_holding == '1'): ?>
							<th style="text-align: center"> تایید یا عدم تایید دسترسی</th>
							<?php endif; ?>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($studentListOfCourse)) {
							foreach ($studentListOfCourse as $student):
								if($student->reg_site == '1' || $student->reg_site == '2'): ?>
								<tr>
									<td class="text-center"><?php echo htmlspecialchars($student->student_id, ENT_QUOTES) ?></td>
									<td>
										<img src="<?php echo base_url('assets/profile-picture/thumb/'.htmlspecialchars($student->pic_name, ENT_QUOTES)); ?>" height="32" alt="user" class="img-circle">
										<?php echo htmlspecialchars($student->first_name . ' ' . $student->last_name, ENT_QUOTES); ?>
									</td>
									<td class="text-center">
										<?php echo htmlspecialchars($student->national_code, ENT_QUOTES); ?>
									</td>
									<td class="text-center"><?php echo htmlspecialchars($student->phone_num, ENT_QUOTES); ?></td>
									<?php if($course[0]->type_holding == '1'): ?>
										<td class="text-center">
											<?php if($student->reg_site == '1'):?>
												<a href="" onclick="event.preventDefault(); document.getElementById('reg-access_<?= htmlspecialchars($student->student_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="تایید دسترسی"> <i class="fa fa-plus-square text-success"></i> </a>
											<?php elseif($student->reg_site == '2'):?>
												<a href="" onclick="event.preventDefault(); document.getElementById('reg-access_<?= htmlspecialchars($student->student_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" data-original-title="عدم دسترسی"> <i class="fa fa-minus-square text-danger"></i> </a>
											<?php endif;?>
											<form class="" id='reg-access_<?= htmlspecialchars($student->student_id); ?>' style="display:none" action="<?= base_url('enrollment/registration-of-access'); ?>" method="post">
												<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
												<input type="hidden" name="course_student_id" value="<?= htmlspecialchars($student->course_student_id, ENT_QUOTES); ?>"/>
												<input type="hidden" name="course_id" value="<?= htmlspecialchars($student->course_id, ENT_QUOTES); ?>"/>
											</form>
										</td>
									<?php endif; ?>
								</tr>
							<?php endif;
							endforeach;
						}else {
							?>
							<tr>
								<td class="text-danger text-center">
									کاربری ثبت نام نکرده است. لطفا شکیبا باشید
								</td>
								<td class="text-danger">*</td>
								<td class="text-danger text-center">*</td>
								<td class="text-danger text-center">*</td>
								<td class="text-danger text-center">*</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-actions">
			</div>
		</div>
    </div>
</div>
