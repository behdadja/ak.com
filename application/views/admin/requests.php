<div class="container-fluid page__container page-section">
<div class="card mb-32pt">
	<ul class="nav nav-tabs nav-tabs-card">
		<li class="nav-item">
			<a class="nav-link active" href="#first" data-toggle="tab">نمایش دوره در آموزکده</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#second" data-toggle="tab">درخواست 2</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#third" data-toggle="tab">درخواست 3</a>
		</li>
	</ul>
	<div class="card-body tab-content">
		<div class="tab-pane active" id="first">
			<div class="card-body">
				<div class="row">
					<div class="table-responsive" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>
						<div class="search-form search-form--light mb-3 col-md-3">
							<input type="text" class="form-control search" id="myInput" placeholder="جستجو">
							<button class="btn" type="button" role="button"><i class="material-icons">search</i></button>
						</div>
						<?php if($this->session->flashdata('successfully')): ?>
							<div class="alert alert-success">
								<?= $this->session->flashdata('successfully'); ?>
							</div>
						<?php endif; ?>
						<?php if($this->session->flashdata('update')): ?>
							<div class="alert alert-success">
								<?= $this->session->flashdata('update'); ?>
							</div>
						<?php endif; ?>
						<table class="table table-flush">
							<thead>
							<tr>
								<th class="text-center">کد آموزشگاه</th>
								<th class="text-center">نام آموزشگاه</th>
								<th class="text-center">کد دوره</th>
								<th class="text-center">نام دوره</th>
								<th class="text-center">نام استاد</th>
								<th class="text-center">زمان ثبت</th>
								<th class="text-center">ابزار</th>
							</tr>
							</thead>
							<tbody class="list" id="search">
							<?php
							if (!empty($courses)):
								foreach ($courses as $item):
									?>
									<tr>
										<td class="text-center"><?= $item->academy_id; ?></td>
										<td class="text-center"><?= $item->academy_display_name . " " . $item->academy_name ?></td>
										<td class="text-center"><?= $item->course_id; ?></td>
										<td class="text-center"><?= $item->lesson_name; ?></td>
										<td class="text-center"><?= $item->first_name.' '.$item->last_name; ?></td>
										<td class="text-center"><?= $item->created_on; ?></td>
										<td class="text-center">
											<?php if($item->display_status_in_system == '1'): ?>
												<a data-toggle="tooltip" data-placement="bottom" title="تایید نمایش" onclick="document.getElementById('status_<?= $item->course_id ?>').submit();" class="text-success"><i class="fa fa-play-circle mr-16pt"></i></a>
											<?php else: ?>
												<a data-toggle="tooltip" data-placement="bottom" title="لغو نمایش" onclick="document.getElementById('status_<?= $item->course_id ?>').submit();" class="text-danger"><i class="fa fa-stop-circle mr-16pt"></i></a>
											<?php endif; ?>
											<form id='status_<?= $item->course_id ?>' action="<?= base_url('display-status-course-in-system'); ?>" style="display:none" method="post">
												<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
												<input type="hidden" name="course_id" value="<?= $item->course_id ?>">
												<input type="hidden" name="status" value="<?= $item->display_status_in_system ?>">
											</form>

											<a data-toggle="tooltip" data-placement="bottom" title="جزئیات" onclick="document.getElementById('detail_<?= $item->course_id ?>').submit();" class="text-info"><i class="fa fa-info-circle mr-16pt"></i></a>
											<form id='detail_<?= $item->course_id ?>' action="<?= base_url('details-course'); ?>" style="display:none" method="post">
												<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
												<input type="hidden" name="course_id" value="<?= $item->course_id ?>">
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
		<div class="tab-pane" id="second">
			درخواست 2
		</div>
		<div class="tab-pane" id="third">
			درخواست 3
		</div>
	</div>
</div>

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
