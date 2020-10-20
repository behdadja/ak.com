
<div class="container-fluid page__container page-section">
	<div class="card mb-32pt p-24pt">
		<div class="card-body">
			<div class="row">
				<div class="table-responsive" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>
					<div class="search-form search-form--light mb-3 col-md-3">
						<input type="text" class="form-control search" id="myInput" placeholder="جستجو">
						<button class="btn" type="button" role="button"><i class="material-icons">search</i></button>
					</div>
					<table class="table table-flush">
						<thead>
						<tr>
							<th>کد</th>
							<th>نام دانشجو</th>
							<th>کد ملی</th>
							<th>موبایل</th>
							<th>تلفن</th>
							<th>آدرس</th>
							<th>ابزار</th>
						</tr>
						</thead>
						<tbody class="list" id="search">
						<?php
						if (!empty($students)):
							foreach ($students as $student):
								?>
								<tr>
									<td><?= $student->student_id; ?></td>
									<td width='220'>
										<div class="media align-items-center">
											<div class="avatar avatar-sm mr-3">
												<img src="<?= base_url('portal/assets/profile-picture/thumb/' . $student->pic_name) ?>" alt="Avatar" class="avatar-img rounded-circle">
											</div>
											<div class="media-body">
												<strong class="js-lists-values-employee-name"><?= $student->first_name . " " . $student->last_name ?></strong>
											</div>
										</div>
									</td>
									<td><?= $student->national_code; ?></td>
									<td><?= $student->phone_num; ?></td>
									<td><?= $student->tell; ?></td>
									<td style="max-width: 400px"><?= $student->street; ?></td>
									<td style="min-width: 150px">
										<a data-toggle="tooltip" data-placement="bottom" title="ویرایش" onclick="document.getElementById('edit_<?= $student->student_id ?>').submit();" class="text-primary"><i class="fa fa-pen mr-16pt"></i></a>
										<form id='edit_<?= $student->student_id ?>' action="<?= base_url('edit-student'); ?>" style="display:none" method="post">
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
											<input type="hidden" name="student_id" value="<?= $student->student_id ?>">
										</form>
										<a href="#" data-toggle="tooltip" data-placement="bottom" title="حذف" class="text-danger"><i class="fa fa-times mr-16pt"></i></a>

										<a data-toggle="tooltip" data-placement="bottom" title="ورود به حساب کاربری" onclick="document.getElementById('login_<?= $student->national_code ?>').submit();" class="text-success"><i class="fa fa-user"></i></a>
										<form id='login_<?= $student->national_code ?>' action="<?= base_url('login-to-student-profile'); ?>" style="display:none" method="post">
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
											<input type="hidden" name="national_code" value="<?= $student->national_code ?>">
										</form>
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
	</div>
</div>
<!---->
<!---->
<?php //if (!empty('update-msg')): ?>
<!--	<div class="container" style="direction: rtl;font-family: samim">-->
<!--		<div id="modal" class="modal fade" role="dialog">-->
<!--			<div class="modal-dialog">-->
<!--				<div class="modal-content">-->
<!--					<div class="modal-header" style="background-color: #edf0f2">-->
<!--						<button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--						<h4 class="modal-title">مدیریت پایگاه داده</h4>-->
<!--					</div>-->
<!--					<div class="modal-body">-->
<!--						<p>ویرایش  با موفقیت انجام شد</p>-->
<!--					</div>-->
<!--					<div class="modal-footer" style="background-color: #edf0f2">-->
<!--						<a class="btn btn-success" data-dismiss="modal">تایید</a>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<?php //endif; ?>
<!---->
<?php //if (!empty ($this->session->flashdata('update-msg'))): ?>
<!--	<div id="modal" class="modal fade" role="dialog">-->
<!--		<div class="modal-dialog">-->
<!--			<div class="modal-content">-->
<!--				<div class="modal-header" style="background-color: #edf0f2">-->
<!--					<button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--					<h4 class="modal-title">مدیریت پایگاه داده</h4>-->
<!--				</div>-->
<!--				<div class="modal-body">-->
<!--					<p>--><?//= $this->session->flashdata('update-msg')?><!--</p>-->
<!--				</div>-->
<!--				<div class="modal-footer" style="background-color: #edf0f2">-->
<!--					<a class="btn btn-success" data-dismiss="modal">تایید</a>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<?php //endif; ?>

<!-- script for search -->
<script>
	$(document).ready(function () {
		$("#myInput").on("keyup", function () {
			var value = $(this).val().toLowerCase();
			$("#search tr").filter(function () {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
	});
</script>
<!-- / script for search -->
