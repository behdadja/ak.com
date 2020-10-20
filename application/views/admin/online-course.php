
<div class="container-fluid page__container page-section">
    <div class="card mb-32pt p-24pt">
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
                            <th class="text-center">کد دوره</th>
                            <th class="text-center">دوره</th>
                            <th class="text-center">کد ملی استاد</th>
                            <th class="text-center">موبایل استاد</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">ویرایش</th>
                        </tr>
                        </thead>
                        <tbody class="list" id="search">
                        <?php
                        if (!empty($online_course)):
                            foreach ($online_course as $item):
                                ?>
                                <tr>
                                    <td class="text-center"><?= $item->academy_id; ?></td>
                                    <td class="text-center"><?= $item->course_id; ?></td>
                                    <td class="text-center"><?= $item->lesson_name; ?></td>
                                    <td class="text-center"><?= $item->course_master; ?></td>
                                    <td class="text-center"><?= $item->phone_num; ?></td>
                                    <td class="text-center">
                                        <?php if($item->detail_online !== null):
                                            $detail_online = json_decode($item->detail_online);
                                            if($detail_online->link_teacher !== 'null'):?>
                                                <a href="" data-toggle="modal" data-target="#online-created_<?= $item->course_id; ?>">ایجاد شده</a>
                                                    <div class="w3-modal fade" id="online-created_<?= $item->course_id; ?>" style="background-color: rgba(0,0,0,0.8)" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content text-center">
                                                                <div class="modal-header" style="background-color: #edf0f2">
                                                                    <h4 class="col-12 modal-title text-center">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                        <span>مشخصات کلاس آنلاین</span>
                                                                    </h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p class="">نام کاربری: <?= $detail_online->user ;?></p>
                                                                    <p class="">رمز ورود: <?= $detail_online->pass ;?></p>
                                                                    <p class="">لینک استاد: <?= $detail_online->link_teacher ;?></p>
                                                                    <p class="">لینک دانشجو: <?= $detail_online->link_student ;?></p>
                                                                </div>
                                                                <div class="modal-footer" style="background-color: #edf0f2">
                                                                    <a class="btn btn-success" style="width: 100%" data-dismiss="modal">بستن</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php else:?>
                                                <a href="" data-toggle="modal" data-target="#online-create_<?= $item->course_id; ?>">ایجاد کردن</a>
                                                <div class="w3-modal fade" id="online-create_<?= $item->course_id; ?>" style="background-color: rgba(0,0,0,0.8)" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content text-center">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <h4 class="col-12 modal-title text-center">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                    <span>فرم مشخصات کلاس آنلاین</span>
                                                                </h4>
                                                            </div>
                                                            <!--					<form class="form-horizontal" action="--><?//= base_url('completing-course-registration'); ?><!--" method="post">-->
                                                            <form class="form-horizontal" action="<?= base_url('insert-link-online'); ?>" method="post">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="course_id" value="<?= $item->course_id ?>">
                                                                    <div class="was-validated">
                                                                        <div class="form-row">
                                                                            <div class="col-md-12 mb-3">
                                                                                <input type="text" name="user" class="form-control" placeholder="نام کاربری استاد" required oninvalid="setCustomValidity('لطفا نام کاربری استاد را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                                                                <div class="invalid-feedback"><?= $this->session->flashdata('error-validation')['user']; ?></div>
                                                                            </div>
                                                                            <div class="col-md-12 mb-3">
                                                                                <input type="text" name="pass" class="form-control" placeholder="رمز عبور استاد" required oninvalid="setCustomValidity('لطفا رمز عبور استاد را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                                                                <div class="invalid-feedback"><?= $this->session->flashdata('error-validation')['pass']; ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="was-validated">
                                                                        <div class="form-row">
                                                                            <div class="col-md-12 mb-3">
                                                                                <input type="text" name="link_teacher" class="form-control" placeholder="لینک استاد" required oninvalid="setCustomValidity('لطفا لینک استاد را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                                                                <div class="invalid-feedback"><?= $this->session->flashdata('error-validation')['link_teacher']; ?></div>
                                                                            </div>
                                                                            <div class="col-md-12 mb-3">
                                                                                <input type="text" name="link_student" class="form-control" placeholder="لینک دانشجو" required oninvalid="setCustomValidity('لطفا لینک دانشجو را وارد کنید')" onchange="try {
                                                                        setCustomValidity('');
                                                                    } catch (e) {
                                                                    }">
                                                                                <div class="invalid-feedback"><?= $this->session->flashdata('error-validation')['link_student']; ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer" style="background-color: #edf0f2">
                                                                    <div class="col-md-6">
                                                                        <button type="submit" class="btn btn-success" style="width: 100%">ثبت</button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button type="button" style="width: 100%" class="btn btn-info" data-dismiss="modal">انصراف</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- / modal for demo -->
                                            <?php
                                            endif;
                                        endif;
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($item->detail_online !== null):
                                            $detail_online = json_decode($item->detail_online);
                                            if($detail_online->link_teacher !== 'null'):?>
                                                <a href="" data-toggle="modal" data-target="#edit-online_<?= $item->course_id; ?>" class="text-danger"><i class="fa fa-pen"></i></a>
                                                <div class="w3-modal fade" id="edit-online_<?= $item->course_id; ?>" style="background-color: rgba(0,0,0,0.8)" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content text-center">
                                                            <div class="modal-header" style="background-color: #edf0f2">
                                                                <h4 class="col-12 modal-title text-center">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                    <span>ویرایش مشخصات کلاس آنلاین</span>
                                                                </h4>
                                                            </div>
                                                            <!--					<form class="form-horizontal" action="--><?//= base_url('completing-course-registration'); ?><!--" method="post">-->
                                                            <form class="form-horizontal" action="<?= base_url('edit-link-online'); ?>" method="post">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                    <input type="hidden" name="course_id" value="<?= $item->course_id ?>">
                                                                    <div class="was-validated">
                                                                        <div class="form-row">
                                                                            <div class="col-md-12 mb-3">
                                                                                <input type="text" name="user" value="<?= $detail_online->user ?>" class="form-control" placeholder="نام کاربری استاد" required oninvalid="setCustomValidity('لطفا نام کاربری استاد را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                                                                <div class="invalid-feedback"><?= $this->session->flashdata('error-validation')['user']; ?></div>
                                                                            </div>
                                                                            <div class="col-md-12 mb-3">
                                                                                <input type="text" name="pass" value="<?= $detail_online->pass ?>" class="form-control" placeholder="رمز عبور استاد" required oninvalid="setCustomValidity('لطفا رمز عبور استاد را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                                                                <div class="invalid-feedback"><?= $this->session->flashdata('error-validation')['pass']; ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="was-validated">
                                                                        <div class="form-row">
                                                                            <div class="col-md-12 mb-3">
                                                                                <input type="text" name="link_teacher" value="<?= $detail_online->link_teacher ?>" class="form-control" placeholder="لینک استاد" required oninvalid="setCustomValidity('لطفا لینک استاد را وارد کنید')" onchange="try {
                                                            setCustomValidity('');
                                                        } catch (e) {
                                                        }">
                                                                                <div class="invalid-feedback"><?= $this->session->flashdata('error-validation')['link_teacher']; ?></div>
                                                                            </div>
                                                                            <div class="col-md-12 mb-3">
                                                                                <input type="text" name="link_student" value="<?= $detail_online->link_student ?>" class="form-control" placeholder="لینک دانشجو" required oninvalid="setCustomValidity('لطفا لینک دانشجو را وارد کنید')" onchange="try {
                                                                        setCustomValidity('');
                                                                    } catch (e) {
                                                                    }">
                                                                                <div class="invalid-feedback"><?= $this->session->flashdata('error-validation')['link_student']; ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer" style="background-color: #edf0f2">
                                                                    <div class="col-md-6">
                                                                        <button type="submit" class="btn btn-success" style="width: 100%">ثبت تغییرات</button>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <button type="button" style="width: 100%" class="btn btn-info" data-dismiss="modal">انصراف</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- / modal for demo -->
                                            <?php
                                            endif;
                                        endif;
                                        ?>
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
