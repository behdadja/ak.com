<div class="page-section border-bottom-2">
	<div class="container page__container">


		<?php if (!empty($results)):?>
			<h3>نتایج یافت شده برای <span class="text-accent"><?= ' '. $keyword;?></span></h3>
		<div class="row">
			<?php foreach ($results as $course): ?>

					<div class="col-sm-6 col-md-4 col-lg-3" height="400">
						<div class="card card--elevated card-course overlay js-overlay mdk-reveal js-mdk-reveal " data-partial-height="40" data-toggle="popover" data-trigger="click">
							<a href="#" class="js-image" data-position="center">
								<img src="<?php echo base_url('portal/assets/course-picture/thumb/' . $course->course_pic); ?>" style="height: 200px" alt="course">
								<span class="overlay__content">
                                                        <span class="overlay__action d-flex flex-column text-center">
                                                            <i class="material-icons">play_circle_outline</i>
                                                            <small>پیش نمایش دوره</small>
                                                        </span>
                                                    </span>
							</a>
<!--							<span class="corner-ribbon corner-ribbon--default-right-top corner-ribbon--shadow bg-accent text-white">جدید</span>-->
							<div class="mdk-reveal__content">
								<div class="card-body">
									<div class="d-flex">
										<div class="flex">
											<a class="card-title" href="#"><?php echo $course->lesson_name; ?></a>
											<small class="text-black-50 font-weight-bold mb-4pt"><?php echo $course->first_name . " " . $course->last_name; ?></small>
										</div>
										<a href="#" class="ml-4pt material-icons text-black-20 card-course__icon-favorite">favorite</a>
									</div>
									<div class="d-flex">
										<div class="rating flex">
											<span class="rating__item"><span class="material-icons">star</span></span>
											<span class="rating__item"><span class="material-icons">star</span></span>
											<span class="rating__item"><span class="material-icons">star</span></span>
											<span class="rating__item"><span class="material-icons">star</span></span>
											<span class="rating__item"><span class="material-icons">star_border</span></span>
										</div>
										<small class="text-black-50"><?php echo $course->course_duration . " "; ?>ساعت</small>
									</div>
								</div>
							</div>
						</div>
						<div class="popoverContainer d-none">
							<div class="media">
								<div class="media-left">
									<img src="<?php echo base_url('portal/assets/course-picture/thumb/' . $course->course_pic); ?>"  style="height: 50px; width: 50px" alt="دوره" class="rounded">
								</div>
								<div class="media-body">
									<div class="card-title text-body mb-0"><?php echo $course->lesson_name; ?></div>
									<p class="lh-1">
										<span class="text-black-50 small">مدرس </span>
										<span class="text-black-50 small font-weight-bold"><?php echo $course->first_name . " " . $course->last_name; ?></span>
									</p>
								</div>
							</div>
							<?php
							foreach ($course_academy as $acm):
								if ($course->academy_id === $acm->academy_id):
									foreach ($provinces as $prv):
										if ($prv->id == $acm->province):
											$province = $prv->name;
										endif;
									endforeach;
									foreach ($citys as $ct):
										if ($ct->id == $acm->city):
											$city = $ct->name;
										endif;
									endforeach;
									?>
									<p class="my-16pt text-black-70"><?php echo $acm->academy_display_name . " " . $acm->academy_name . " (" . $province . "-" . $city . ")" ?></p>
									<?php
									break;
								endif;
							endforeach;
							?>
							<div class="mb-16pt">
								<div class="d-flex align-items-center">
									<span class="material-icons icon-16pt text-black-50 mr-8pt">check</span>
									<p class="flex text-black-50 lh-1 mb-0"><small><?php echo $course->course_description; ?></small></p>
								</div>
							</div>

							<div class="row align-items-center">
								<div class="col-auto">
									<div class="d-flex align-items-center mb-4pt">
										<span class="material-icons icon-16pt text-black-50 mr-4pt">access_time</span>
										<p class="flex text-black-50 lh-1 mb-0"><small><?php echo $course->course_duration . " "; ?>ساعت</small></p>
									</div>
									<div class="d-flex align-items-center mb-4pt">
										<span class="material-icons icon-16pt text-black-50 mr-4pt">play_circle_outline</span>
										<p class="flex text-black-50 lh-1 mb-0"><small><?php echo $course->time_meeting . " "; ?>دقیقه</small></p>
									</div>
									<div class="d-flex align-items-center mb-4pt">
										<span class="fa fa-dollar-sign icon-16pt text-black-50 mr-4pt"></span>
										<p class="flex text-black-50 lh-1 mb-0"><small><?php echo $course->course_tuition . " "; ?>تومان</small></p>
									</div>
								</div>
								<div class="col text-right">
									<a href="<?= base_url('course-detail/' . $course->academy_id . '/' . $course->course_id ); ?>" class="btn btn-primary">جزئیات</a>
								</div>
							</div>
						</div>
					</div>
			<?php
			endforeach;
		else: ?>
					<div class="alert alert-accent" role="alert">نتیجه ای برای <strong><?= $keyword ?></strong> یافت نشد</div>
			</div>
		<?php endif; ?>
	</div>
</div>

