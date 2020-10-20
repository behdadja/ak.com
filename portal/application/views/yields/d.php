<style>
	#fun ul{
		margin: -20px 0 -20px 0;
		padding: -20px 0 -20px 0
	}
</style>

<div class="col-sm-12">
	<div class="white-box">
		<h3 class="box-title">آزمون پیشفرض</h3>
		<div class="table-responsive">

			<table id="example24" class="display nowrap" cellspacing="0" width="100%">
				<?php
				if (!empty($default_test)):
				foreach ($default_test as $item):
				$test= $item->test;
				$test = json_decode($test);
				if($this->session->userdata('academy_id') !== 1 && !empty($test)):
				?>
				<thead>
				<tr>
					<th class="text-center">کد آزمون</th>
					<th class="text-center">نام آزمون</th>
					<th class="text-center">بازه نمره</th>
					<th class="text-center">حد نصاب نمره قبولی</th>
					<th class="text-center">تاثیر در نمره نهایی(درصد)</th>
					<th class="text-center">ابزار</th>
				</tr>
				</thead>
				<tbody>
				<?php if(!empty($test->item_0)):?>
					<tr>
						<td class="text-center"><?= htmlspecialchars($test->item_0[0], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_0[1], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_0[2], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_0[3], ENT_QUOTES); ?></td>
					</tr>
				<?php endif;
				if(!empty($test->item_1)):?>
					<tr>
						<td class="text-center"><?= htmlspecialchars($test->item_1[0], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_1[1], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_1[2], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_1[3], ENT_QUOTES); ?></td>
					</tr>
				<?php endif;
				if(!empty($test->item_2)):?>
					<tr>
						<td class="text-center"><?= htmlspecialchars($test->item_2[0], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_2[1], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_2[2], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_2[3], ENT_QUOTES); ?></td>
					</tr>
				<?php endif;
				if(!empty($test->item_3)):?>
					<tr>
						<td class="text-center"><?= htmlspecialchars($test->item_3[0], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_3[1], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_3[2], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_3[3], ENT_QUOTES); ?></td>
					</tr>
				<?php endif;
				if(!empty($test->item_4)):?>
					<tr>
						<td class="text-center"><?= htmlspecialchars($test->item_4[0], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_4[1], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_4[2], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_4[3], ENT_QUOTES); ?></td>
					</tr>
				<?php endif;
				if(!empty($test->item_5)):?>
					<tr>
						<td class="text-center"><?= htmlspecialchars($test->item_5[0], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_5[1], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_5[2], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_5[3], ENT_QUOTES); ?></td>
					</tr>
				<?php endif;
				if(!empty($test->item_6)):?>
					<tr>
						<td class="text-center"><?= htmlspecialchars($test->item_6[0], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_6[1], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_6[2], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_6[3], ENT_QUOTES); ?></td>
					</tr>
				<?php endif;
				if(!empty($test->item_7)):?>
					<tr>
						<td class="text-center"><?= htmlspecialchars($test->item_7[0], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_7[1], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_7[2], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_7[3], ENT_QUOTES); ?></td>
					</tr>
				<?php endif;
				if(!empty($test->item_8)):?>
					<tr>
						<td class="text-center"><?= htmlspecialchars($test->item_8[0], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_8[1], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_8[2], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_8[3], ENT_QUOTES); ?></td>
					</tr>
				<?php endif;
				if(!empty($test->item_9)):?>
					<tr>
						<td class="text-center"><?= htmlspecialchars($test->item_9[0], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_9[1], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_9[2], ENT_QUOTES); ?></td>
						<td class="text-center"><?= htmlspecialchars($test->item_9[3], ENT_QUOTES); ?></td>
					</tr>
				<?php endif; ?>
				<tr>
					<a href="#" class="m-r-10" data-toggle="modal" data-target="#detail_<?php echo $item->lesson_id; ?>"><i class="fa fa-close text-danger m-l-5" data-toggle="tooltip" data-original-title="حذف"></i></a>|
					<div id="detail__<?php echo $item->lesson_id; ?>" class="modal fade bs-example-modal-sm" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header" style="background-color: #edf0f2">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title" id="myModalLabel">حذف درس</h4>
								</div>
								<form action="<?php echo base_url('training/delete-lesson'); ?>" method="post">
									<div class="modal-body">
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
										<div class="form-group">
											<input type="hidden" name="lesson_id" value="<?php echo htmlspecialchars($item->lesson_id, ENT_QUOTES); ?>">
											<p> <?php echo "از حذف درس " . $item->lesson_name . " اطمینان دارید؟" ?></p>
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-success" style="width: 50%">بله</button>
										<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal" style="width: 50%">خیر</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<a href="#" data-toggle="modal" data-target="#del_<?php echo $item->lesson_id; ?>"><i class="glyphicon glyphicon-equalizer text-inverse  m-l-5" data-toggle="tooltip" data-original-title="اطلاعات آزمون"></i></a>
					<div id="del_<?= $item->lesson_id; ?>" class="modal fade bs-example-modal-sm" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header" style="background-color: #edf0f2">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title" id="myModalLabel">درس <?= $item->lesson_name; ?></h4>
								</div>
								<form action="<?php echo base_url('training/delete-lesson'); ?>" method="post">
									<div class="modal-body">


									</div>

							</div>
						</div>
					</div>

				</tr>
				<?php
				endif;
				endforeach;
				endif;
				?>
				</tbody>
			</table>

		</div>
	</div>
</div>
