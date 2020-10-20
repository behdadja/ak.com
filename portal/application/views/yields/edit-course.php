<style>
    * {
        box-sizing: border-box;
    }

    #regForm {
        background-color: #ffffff;
        margin: auto;
        width: 85%;
        min-width: 300px;
    }

    /* Mark input boxes that gets an error on validation: */
    input.invalid {
        background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
        display: none;
    }

    button {
        background-color: #4CAF50;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }

    button:hover {
        opacity: 0.8;
    }

    #prevBtn {
        background-color: #bbbbbb;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.5;
    }

    .step.active {
        opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
        background-color: #4CAF50;
    }

    #radioBtn .notActive {
        color: #3276b1;
        background-color: #fff;
    }
</style>

<div class="col-md-12">
    <div class="white-box">
        <!--.row-->
        <div class="row">
            <div class="panel panel-info" style="background-color: #f7fcfc">
                <?php if (!empty($course_info)): ?>
                <div class="row">
                    <div class="col-md-12 text-center m-t-20">
                        <div class="col-md-10">
                            <div class="panel-heading"> ویرایش دوره
                                : <?php echo htmlspecialchars($course_info[0]->lesson_name, ENT_QUOTES); ?></div>
                            <h3 class="box-title text-danger p-t-10  p-r-20">پر کردن موارد ستاره دار ( * ) الزامی می
                                باشد.</h3>
                        </div>
                        <div class="col-md-2">
                            <!--<span data-toggle='tooltip' data-title='ویرایش تصویر'>-->
                            <a href="" data-toggle="modal" data-target="#modal-pic">
                                <img
                                    src="<?= base_url('assets/course-picture/thumb/' . $course_info[0]->course_pic); ?>"
                                    height="120" alt="user" style="border-radius: 10px;margin-bottom: 5px">
                                <button style="width: 80%" class="btn btn-default">ویرایش عکس</button>
                            </a>
                            <!--</span>-->
                        </div>
                    </div>
                </div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">

                        <!--******************************************* Errors *******************************************-->
                        <div class="row">
                            <?php if ($this->session->flashdata('upload-msg')) : ?>
                                <div
                                    class="alert alert-danger"><?php echo $this->session->flashdata('upload-msg'); ?></div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('start-date')) : ?>
                                <div
                                    class="alert alert-danger"><?php echo $this->session->flashdata('start-date'); ?></div>
                            <?php endif; ?>
                            <!--*******************************************-->
                            <?php
                            if (!empty($this->session->flashdata('var'))) :
                                $all_var = $this->session->flashdata('var');
                                ?>
                                <div class="m-b-20">
                                    <?php foreach ($all_var as $var): ?>
                                        <div class="text-danger p-r-10 p-b-5"
                                             style="border-right: #ff7676 thick solid"><?php echo $var['error']; ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <!--*******************************************-->
                            <?php if (validation_errors()): ?>
                                <div class="m-b-20">
                                    <div class="alert alert-danger">خطاهای زیر را بررسی کنید</div>
                                    <div class="text-danger p-r-10 p-b-5"
                                         style="border-right: #ff7676 thick solid"><?php echo form_error('course_name'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5"
                                         style="border-right: #ff7676 thick solid"><?php echo form_error('employee_id'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5"
                                         style="border-right: #ff7676 thick solid"><?php echo form_error('course_duration'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5"
                                         style="border-right: #ff7676 thick solid"><?php echo form_error('time_meeting'); ?></div>
                                    <div class="text-danger p-r-10 p-b-5"
                                         style="border-right: #ff7676 thick solid"><?php echo form_error('start_date'); ?></div>
                                </div>
                            <?php endif; ?>
                            <!--*******************************************-->

                            <?php
                            $classError = $this->session->flashdata('classError');
                            if (!empty($classError)):
                                ?>
                                <div class="alert alert-danger">
                                    <?= 'تداخل زمانی با کلاس انتخاب شده'; ?>
                                    <a href="" style="color: black;border-radius: 50px" class="btn btn-warning"
                                       data-toggle="modal" data-target="#class"> جزئیات ...</a>
                                </div>
                                <!-- modal -->
                                <div id="class" class="modal fade" role="dialog" tabindex="-1"
                                     aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content text-center">
                                            <div class="modal-header" style="background-color: #edf0f2">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">&times;
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">تداخل زمانی با کلاس انتخاب
                                                    شده </h4>
                                            </div>
                                            <div class="modal-body"><?php
                                                for ($j = 0; $j < sizeof($classError); $j++) {
                                                    echo $classError[$j]['class'] . '<br>';
                                                }
                                                ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" style="width: 100%"
                                                        data-dismiss="modal">بستن
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- / modal -->
                            <?php
                            endif;
                            $teacherError = $this->session->flashdata('thrError');
                            if (!empty($teacherError)):
                                ?>
                                <div class="alert alert-danger">
                                    <?= 'تداخل زمانی با استاد انتخاب شده'; ?>
                                    <a href="" style="color: black;border-radius: 50px" class="btn btn-warning"
                                       data-toggle="modal" data-target="#teacher"> جزئیات ...</a>
                                </div>
                                <!-- modal -->
                                <div id="teacher" class="modal fade" role="dialog" tabindex="-1"
                                     aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content text-center">
                                            <div class="modal-header" style="background-color: #edf0f2">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">&times;
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">تداخل زمانی با استاد انتخاب
                                                    شده </h4>
                                            </div>
                                            <div class="modal-body"><?php
                                                for ($i = 0; $i < sizeof($teacherError); $i++) {
                                                    echo $teacherError[$i]['teacher'] . '<br>';
                                                }
                                                ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" style="width: 100%"
                                                        data-dismiss="modal">بستن
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- / modal -->
                            <?php endif; ?>
                        </div>
                        <!--******************************************* /End Errors *******************************************-->

                        <form action="<?= base_url('training/update-course'); ?>" method="post"
                              enctype="multipart/form-data" name="class_register">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                   value="<?php echo $this->security->get_csrf_hash(); ?>"/>
                            <input type="hidden" name="course_id"
                                   value="<?php echo htmlspecialchars($course_info[0]->course_id, ENT_QUOTES); ?>">
                            <div class="form-body">
                                <div class="text-center">
                                    <h3 style="text-align: right">روز و ساعت برگزاری</h3>
                                    <hr>
                                    <div class="col-md-12">
                                        <div class="form-group col-md-1" style="margin: 0;padding: 0">
                                            <label class="control-label">شنبه</label>
                                            <input type="checkbox" id='sat_check' name='sat_check' <?php
                                            if ($course_info[0]->sat_status === '1') {
                                                echo 'checked';
                                            }
                                            ?> class="js-switch form-control" data-color="#6164c1" data-size="small"/>
                                            <div class="input-append">
                                                <input type="text" readonly
                                                       maxlength="5" <?php if ($course_info[0]->sat_status != '1') {
                                                    echo 'disabled';
                                                } ?> id='sat_clock'
                                                       class="form-control add-on <?php if ($course_info[0]->sat_status === '1') {
                                                           echo 'bg-white';
                                                       } ?>" name="sat_clock"
                                                       value="<?php if ($course_info[0]->sat_status === '1') {
                                                           echo $course_info[0]->sat_clock;
                                                       } ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="control-label">یکشنبه</label>
                                            <input type="checkbox" id='sun_check' name='sun_check' <?php
                                            if ($course_info[0]->sun_status === '1') {
                                                echo 'checked';
                                            }
                                            ?> class="js-switch form-control" data-color="#6164c1" data-size="small"/>
                                            <div class="input-append">
                                                <input type="text" readonly
                                                       maxlength="5" <?php if ($course_info[0]->sun_status != '1') {
                                                    echo 'disabled';
                                                } ?> id='sun_clock'
                                                       class="form-control add-on <?php if ($course_info[0]->sun_status === '1') {
                                                           echo 'bg-white';
                                                       } ?>" name="sun_clock"
                                                       value="<?php if ($course_info[0]->sun_status === '1') {
                                                           echo $course_info[0]->sun_clock;
                                                       } ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="control-label">دوشنبه</label>
                                            <input type="checkbox" id='mon_check' name='mon_check' <?php
                                            if ($course_info[0]->mon_status === '1') {
                                                echo 'checked';
                                            }
                                            ?> class="js-switch form-control" data-color="#6164c1" data-size="small"/>
                                            <div class="input-append">
                                                <input type="text" readonly
                                                       maxlength="5" <?php if ($course_info[0]->mon_status != '1') {
                                                    echo 'disabled';
                                                } ?> id='mon_clock'
                                                       class="form-control add-on <?php if ($course_info[0]->mon_status === '1') {
                                                           echo 'bg-white';
                                                       } ?>" name="mon_clock"
                                                       value="<?php if ($course_info[0]->mon_status === '1') {
                                                           echo $course_info[0]->mon_clock;
                                                       } ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="control-label">سه شنبه</label>
                                            <input type="checkbox" id='tue_check' name='tue_check' <?php
                                            if ($course_info[0]->tue_status === '1') {
                                                echo 'checked';
                                            }
                                            ?> class="js-switch form-control" data-color="#6164c1" data-size="small"/>
                                            <div class="input-append">
                                                <input type="text" readonly
                                                       maxlength="5" <?php if ($course_info[0]->tue_status != '1') {
                                                    echo 'disabled';
                                                } ?> id='tue_clock'
                                                       class="form-control add-on <?php if ($course_info[0]->tue_status === '1') {
                                                           echo 'bg-white';
                                                       } ?>" name="tue_clock"
                                                       value="<?php if ($course_info[0]->tue_status === '1') {
                                                           echo $course_info[0]->tue_clock;
                                                       } ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="control-label">چهار شنبه</label>
                                            <input type="checkbox" id='wed_check' name='wed_check' <?php
                                            if ($course_info[0]->wed_status === '1') {
                                                echo 'checked';
                                            }
                                            ?> class="js-switch form-control" data-color="#6164c1" data-size="small"/>
                                            <div class="input-append">
                                                <input type="text" readonly
                                                       maxlength="5" <?php if ($course_info[0]->wed_status != '1') {
                                                    echo 'disabled';
                                                } ?> id='wed_clock'
                                                       class="form-control add-on <?php if ($course_info[0]->wed_status === '1') {
                                                           echo 'bg-white';
                                                       } ?>" name="wed_clock"
                                                       value="<?php if ($course_info[0]->wed_status === '1') {
                                                           echo $course_info[0]->wed_clock;
                                                       } ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="control-label">پنجشنبه</label>
                                            <input type="checkbox" id='thu_check' name='thu_check' <?php
                                            if ($course_info[0]->thu_status === '1') {
                                                echo 'checked';
                                            }
                                            ?> class="js-switch form-control" data-color="#6164c1" data-size="small"/>
                                            <div class="input-append">
                                                <input type="text" readonly
                                                       maxlength="5" <?php if ($course_info[0]->thu_status != '1') {
                                                    echo 'disabled';
                                                } ?> id='thu_clock'
                                                       class="form-control add-on <?php if ($course_info[0]->thu_status === '1') {
                                                           echo 'bg-white';
                                                       } ?>" name="thu_clock"
                                                       value="<?php if ($course_info[0]->thu_status === '1') {
                                                           echo $course_info[0]->thu_clock;
                                                       } ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-1" style="margin: 0;padding: 0">
                                            <label class="control-label">جمعه</label>
                                            <input type="checkbox" id='thu_check' name='fri_check' <?php
                                            if ($course_info[0]->fri_status === '1') {
                                                echo 'checked';
                                            }
                                            ?> class="js-switch form-control" data-color="#6164c1" data-size="small"/>
                                            <div class="input-append">
                                                <input type="text" readonly
                                                       maxlength="5" <?php if ($course_info[0]->fri_status != '1') {
                                                    echo 'disabled';
                                                } ?> id='fri_clock'
                                                       class="form-control add-on <?php if ($course_info[0]->fri_status === '1') {
                                                           echo 'bg-white';
                                                       } ?>" name="fri_clock"
                                                       value="<?php if ($course_info[0]->fri_status === '1') {
                                                           echo $course_info[0]->fri_clock;
                                                       } ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="box-title">اطلاعات دوره</h3>
                                <hr>
                                <div class="row" style="margin-bottom: 20px">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="course_name" class="control-label">نام درس</label>
                                            <?php if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0'){ ?>
                                                <?php if (!empty($lessons)){ ?>
                                                    <?php foreach ($lessons as $lesson){
                                                        if ($lesson->lesson_id === $course_info[0]->lesson_id) { ?>
                                                            <input type="text" class="form-control"
                                                                   value="<?= htmlspecialchars($lesson->lesson_name, ENT_QUOTES) ?>" disabled>
                                                            <input type="hidden" name="course_name" value="<?= htmlspecialchars($course_info[0]->lesson_id, ENT_QUOTES); ?>">
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }else{ ?>
                                                <select name="course_name" id="course_name"
                                                        class="form-control" <?php if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0') {
                                                    echo "disabled";
                                                } ?>>
                                                    <?php if (!empty($lessons)){
                                                        foreach ($lessons as $lesson){ ?>
                                                            <option
                                                                value="<?php echo htmlspecialchars($lesson->lesson_id, ENT_QUOTES); ?>" <?php
                                                            if ($lesson->lesson_id === $course_info[0]->lesson_id) {
                                                                echo 'selected';
                                                            }
                                                            ?> ><?php echo htmlspecialchars($lesson->lesson_name, ENT_QUOTES); ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                            </select>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="employee_id" class="control-label">نام استاد</label>
                                            <?php if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0'){ ?>
                                                <?php if (!empty($employers)) { ?>
                                                    <?php foreach ($employers as $employee) {
                                                        if ($employee->national_code === $course_info[0]->course_master) { ?>
                                                        <input type="text" class="form-control"
                                                               value="<?= htmlspecialchars($employee->first_name.' '.$employee->last_name, ENT_QUOTES) ?>" disabled>
                                                            <input type="hidden" name="employee_id" value="<?= htmlspecialchars($employee->employee_id, ENT_QUOTES); ?>">
                                                        <?php
                                                        }
                                                    }
                                                }
                                            }else{ ?>
                                                <select name="employee_id" id="employee_name" class="form-control">
                                                    <?php if (!empty($employers)) { ?>
                                                        <?php foreach ($employers as $employee) { ?>
                                                            <option
                                                                value="<?= htmlspecialchars($employee->employee_id, ENT_QUOTES); ?>" <?php
                                                            if ($employee->national_code === $course_info[0]->course_master) {
                                                                echo 'selected';
                                                            } ?> > <?= htmlspecialchars($employee->first_name, ENT_QUOTES) . ' ' . htmlspecialchars($employee->last_name, ENT_QUOTES); ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">مدت زمان (ساعت)</label>
                                            <input type="number" name="course_duration" id="course_duration"
                                                   class="form-control"
                                                   value="<?= htmlspecialchars($course_info[0]->course_duration, ENT_QUOTES); ?>">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">زمان هر جلسه(دقیقه)</label>
                                            <input type="number" name="time_meeting" id="time_meeting"
                                                   class="form-control"
                                                   value="<?= htmlspecialchars($course_info[0]->time_meeting, ENT_QUOTES); ?>" <?php if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0') {
                                                echo "readonly";
                                            } ?>>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="class_id" class="control-label">نام کلاس</label>
                                            <select name="class_id" id="course_name" class="form-control">
                                                <?php if (!empty($classes)): ?>
                                                    <?php foreach ($classes as $class): ?>
                                                        <option
                                                            value="<?php echo htmlspecialchars($class->class_id, ENT_QUOTES); ?>" <?php
                                                        if ($class->class_id === $course_info[0]->class_id) {
                                                            echo 'selected';
                                                        }
                                                        ?>><?php echo htmlspecialchars($class->class_name, ENT_QUOTES); ?></option>
                                                    <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-3">
                                        <label class="control-label text-info">تاریخ شروع دوره</label>
                                        <?php if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0'): ?>
                                            <input class="form-control" type="text" value="<?= htmlspecialchars($start_date, ENT_QUOTES) ?>" disabled>
                                            <input name="start_date" type="hidden" value="<?= htmlspecialchars($start_date, ENT_QUOTES) ?>">
                                        <?php else: ?>
                                            <input type="text" value="<?= htmlspecialchars($start_date, ENT_QUOTES) ?>"
                                                   name="start_date" id="example-input2-group2"
                                                   class="form-control auto-close-example"
                                                   onkeyup="
                                                        var date = this.value;
                                                        if (date.match(/^\d{4}$/) !== null) {
                                                            this.value = date + '-';
                                                        } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                         this.value = date + '-';
                                                         }" maxlength="10" onkeyup='saveValue(this);'
                                                   oninvalid="setCustomValidity('لطفا تاریخ شروع را وارد کنید')"
                                                   onchange="try {
                                                                    setCustomValidity('');
                                                                } catch (e) {
                                                             }">
                                        <?php endif; ?>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-3">
                                        <label for="capacity" class="control-label">ظرفیت
                                            پذیرش <?php echo $this->session->userdata('studentDName'); ?></label>
                                        <div class="form-group">
                                            <input type="number" id="capacity" name="capacity" class="form-control"
                                                   value="<?php echo htmlspecialchars($course_info[0]->capacity, ENT_QUOTES); ?>"
                                                   required></span>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="happy" class="control-label">نوع برگزاری</label>

                                            <div class="input-group">
                                                <div id="radioBtn" class="btn-group">
                                                    <a class="btn btn-info btn-md <?= ($course_info[0]->type_gender === '1') ? 'active' : 'notActive'; ?>" data-toggle="gender" data-title="1">آقایان</a>
                                                    <a class="btn btn-info btn-md <?= ($course_info[0]->type_gender === '0') ? 'active' : 'notActive'; ?>" data-toggle="gender" data-title="0">مختلط</a>
                                                    <a class="btn btn-info btn-md <?= ($course_info[0]->type_gender === '2') ? 'active' : 'notActive'; ?>" data-toggle="gender" data-title="2">بانوان</a>
                                                </div>
                                                <input type="hidden" name="type_gender" id="gender"
                                                       value="<?= $course_info[0]->type_gender; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-12 form-group">

                                        <div class="form-group col-md-3">
                                            <h3 for="happy" class="control-label">نوع دوره</h3>
                                            <div class="input-group">
                                                <div id="radioBtn" class="btn-group">
                                                    <a id="btn1" class="btn btn-info btn-md <?php
                                                    if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0')
                                                        echo 'disabled ';
                                                    echo ($course_info[0]->type_course === '0') ? 'active' : 'notActive';?>"
                                                       data-toggle="happ" data-title="0">عمومی</a>

                                                    <a id="btn2" class="btn btn-info btn-md <?php
                                                    if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0')
                                                        echo 'disabled ';
                                                    echo ($course_info[0]->type_course === '10') ? 'active' : 'notActive';?>"
                                                       data-toggle="happ" data-title="1">خصوصی</a>
                                                </div>
                                                <input type="hidden" name="type_course" id="happ"
                                                       value="<?php echo $course_info[0]->type_course; ?>">
                                            </div>
                                        </div>


                                        <div class="form-group col-md-3">
                                            <h3 for="type-of-class-holding" class="control-label">نوع برگزاری کلاس</h3>
                                            <div class="input-group">
                                                <div id="radioBtn" class="btn-group">
                                                    <a id="hold-btn1" class="btn btn-info btn-md <?= ($course_info[0]->type_holding === '0') ? 'active' : 'notActive';?>"
                                                       data-toggle="type-of-class-holding" data-title="0">حضوری</a>
                                                    <a id="hold-btn1" class="btn btn-info btn-md <?= ($course_info[0]->type_holding === '1') ? 'active' : 'notActive';?>"
                                                       data-toggle="type-of-class-holding" data-title="1">آنلاین</a>
                                                </div>
                                                <input type="hidden" name="type_holding" id="type-of-class-holding"
                                                       value="<?php echo $course_info[0]->type_holding; ?>">
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="form-group col-md-3">
                                            <h3 class="control-label">نوع
                                                دستمزد <?php echo $this->session->userdata('teacherDName'); ?></h3>
                                            <div class="input-group">
                                                <div id="radioBtn" class="btn-group">
                                                    <a id="ba1" class="btn btn-info btn-md <?php
                                                    if ($course_info[0]->type_pay === '0'): echo 'active';
                                                    else: echo 'notActive';
                                                    endif;
                                                    if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0') {
                                                        echo ' disabled';
                                                    }
                                                    ?>" data-toggle="fun" data-title="0">درصدی</a>

                                                    <a id="ba2" class="btn btn-info btn-md <?php
                                                    if ($course_info[0]->type_pay === '1'): echo 'active';
                                                    else: echo 'notActive';
                                                    endif;
                                                    if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0') {
                                                        echo ' disabled';
                                                    }
                                                    ?>" data-toggle="fun" data-title="1">ساعتی</a>

                                                    <a id="ba3" class="btn btn-info btn-md <?php
                                                    if ($course_info[0]->type_pay === '2'): echo 'active';
                                                    else: echo 'notActive';
                                                    endif;
                                                    if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0') {
                                                        echo ' disabled';
                                                    }
                                                    ?>" data-toggle="fun" data-title="2">ماهیانه</a>
                                                </div>
                                                <?php if ($course_info[0]->count_std <= '0' && sizeof($attendance) <= '0'): ?>
                                                    <input type="hidden" name="type_pay" id="fun"
                                                           value="<?php echo $course_info[0]->type_pay; ?>">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id='am'
                                                 class="form-group" <?php if ($course_info[0]->type_pay == '2') {
                                                echo 'style="display:none"';
                                            } ?>>
                                                <h3 for="value_pay">درصد / مبلغ هر ساعت:</h3>
                                                <div class="radio-list">
                                                    <input value="<?php echo $course_info[0]->value_pay; ?>"
                                                           id="value_pay" name="value_pay" class="form-control"
                                                        <?php if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0') {
                                                            echo 'readonly';
                                                        } ?> >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->

                                    <!--عمومی -->
                                    <div id="div2" class="col-md-12" <?php if ($course_info[0]->type_course == '1') {
                                        echo 'style="display: none"';
                                    } ?> >
                                        <div class="form-group">
                                            <h3 class="control-label" for="course_tuition">شهریه دوره </h3>
                                            <input type="number" name="course_tuition" class="form-control"
                                                <?php if ($course_info[0]->type_course === '0'):
                                                    echo 'value="' . $course_info[0]->course_tuition . '"';
                                                elseif ($course_info[0]->type_course === '1'):
                                                    echo 'placeholder="9000"';
                                                endif;
                                                if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0'):
                                                    echo ' readonly';
                                                endif;
                                                ?> />
                                        </div>
                                    </div>
                                    <!--/span-->

                                    <!--خصوصی -->
                                    <div id="div1" class="col-md-12"
                                         style="margin-bottom: 25px;<?php if ($course_info[0]->type_course == '0') {
                                             echo 'display: none';
                                         } ?>">
                                        <h3 for="type_pay">نوع
                                            شهریه <?php echo $this->session->userdata('studentDName'); ?></h3>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <label class="control-label">ساعتی</label>
                                                        <input type="radio" id='s1' name='type_tuition' value="0"
                                                               class="control-label" data-color="#6164c1"
                                                               data-size="small" <?php
                                                        if ($course_info[0]->type_tuition === '0' && $course_info[0]->type_course === '0') {
                                                            echo 'checked';
                                                        }
                                                        if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0') {
                                                            echo 'readonly';
                                                        } ?> />
                                                    </span>
                                                <input type="number" id='t1' name="value_tuition_clock"
                                                       class="form-control"
                                                    <?php if ($course_info[0]->type_tuition === '1') {
                                                        echo 'value="' . $course_info[0]->course_tuition . '">';
                                                    } else {
                                                        echo 'readonly ' . 'placeholder="12000"';
                                                    }
                                                    if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0') {
                                                        echo 'readonly';
                                                    } ?> >

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <label class="control-label">دوره ای</label>
                                                        <input type="radio" id='s2' name='type_tuition' value="1"
                                                               class="control-label" data-color="#6164c1"
                                                               data-size="small" <?php
                                                        if ($course_info[0]->type_tuition === '1' && $course_info[0]->type_course === '0') {
                                                            echo 'checked';
                                                        }
                                                        if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0') {
                                                            echo 'readonly';
                                                        } ?> />
                                                    </span>
                                                <input type="number" id='t2' name="value_tuition_course"
                                                       class="form-control"
                                                    <?php if ($course_info[0]->type_tuition === '1') {
                                                        echo 'value="' . $course_info[0]->course_tuition . '">';
                                                    } else {
                                                        echo 'readonly ' . 'placeholder="560000"';
                                                    }
                                                    if ($course_info[0]->count_std > '0' && sizeof($attendance) > '0') {
                                                        echo 'readonly';
                                                    } ?> >
                                            </div>
                                        </div>
                                    </div>
                                    <!--  End if finished course -->

                                    <div class="row text-center">
                                        <div class="col-md-12">
                                            <h3 class="control-label text-info">توضیحات: </h3>
                                            <textarea type="text" id="description" name="description"
                                                      class="form-control" style="height: 150px"
                                                      required=""><?php echo $course_info[0]->course_description; ?></textarea>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class="row col-md-12 m-t-20">
                                        <label class="control-label">نمایش این دوره در صفحه اصلی سامانه آموزکده (پس از
                                            دریافت تاییدیه)</label>
                                        <input type="checkbox"
                                               name='display_request' <?php if ($course_info[0]->display_status_in_system == '1' || $course_info[0]->display_status_in_system == '2') {
                                            echo 'checked';
                                        } ?> class="js-switch form-control" data-color="#6164c1" data-size="small"
                                               autocomplete="off"/>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-actions">
                                            <button type="submit" style="float:left;margin-top: 20px"
                                                    class="btn btn-success"><i class="fa fa-check"></i> ثبت تغییرات
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!--./row-->
    </div>
</div>

<div id="modal-pic" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">ویرایش تصویر دوره</h4>
            </div>
            <form class="form-horizontal" action="<?= base_url('course-update-pic'); ?>" enctype="multipart/form-data"
                  method="post">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                           value="<?php echo $this->security->get_csrf_hash(); ?>"/>
                    <input type="hidden" name="course_id" class="form-control"
                           value="<?php echo $course_info[0]->course_id ?>">
                    <div class="form-group">
                        <label class="text-danger" for="input-file-now"> ارسال تصویر با پسوندهای jpg ، jpeg و png امکان
                            پذیر است.</label>
                        <input type="file" id="input-file-now" name="pic_name" class="dropify" required
                               oninvalid="setCustomValidity('لطفا یک فایل انتخاب کنید')" onchange="try {
                                    setCustomValidity('');
                                } catch (e) {
                                }">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success" style="width: 100%">ثبت</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" style="width: 100%" class="btn btn-info" data-dismiss="modal">انصراف
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- edit start date -->
<!--<div id="edit-date" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">-->
<!--    <div class="modal-dialog modal-sm">-->
<!--        <div class="modal-content text-center">-->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
<!--                <h4 class="modal-title" id="myModalLabel">ویرایش تاریخ شروع دوره</h4>-->
<!--            </div>-->
<!--            <form class="form-horizontal" action="--><? //= base_url('edit-start-date'); ?><!--" method="post">-->
<!--                <div class="modal-body" style="padding:10px 40px 10px 40px">-->
<!--                    <input type="hidden" name="--><?php //echo $this->security->get_csrf_token_name(); ?><!--" value="--><?php //echo $this->security->get_csrf_hash(); ?><!--" />-->
<!--                    <input type="hidden" name="course_id" class="form-control" value="--><?php //echo $course_info[0]->course_id ?><!--">-->
<!--                    <div class="form-group">-->
<!--                        <label class="control-label text-info m-b-20">تاریخ شروع دوره :</label>-->
<!--                        <input type="text" name='start_date' class="auto-close-example form-control" onkeyup="-->
<!--                                var date = this.value;-->
<!--                                if (date.match(/^\d{4}$/) !== null) {-->
<!--                                    this.value = date + '-';-->
<!--                                } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {-->
<!--                                    this.value = date + '-';-->
<!--                                }" maxlength="10"required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تاریخ را وارد کنید')" onchange="try {-->
<!--                                            setCustomValidity('');-->
<!--                                        } catch (e) {-->
<!--                                        }">/>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="modal-footer">-->
<!--                    <div class="col-md-6">-->
<!--                        <button type="submit" class="btn btn-success" style="width: 100%">ثبت</button>-->
<!--                    </div>-->
<!--                    <div class="col-md-6">-->
<!--                        <button type="button" style="width: 100%" class="btn btn-info" data-dismiss="modal">انصراف</button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<script>
    $(document).ready(function () {

        // $('#div1').hide();
        // $('#div2').hide();
        // $('#am').hide();

        $('#btn1').click(function () {
            $('#div1').hide();
            $('#div2').show();
        });
        $('#btn2').click(function () {
            $('#div2').hide();
            $('#div1').show();
        });
        $('#ba3').click(function () {
            $('#am').hide();
        });
        $('#ba2').click(function () {
            $('#am').show();
            <?php if ($course_info[0]->type_pay === '0') {?>
            $('#value_pay').val('');
            <?php }else if ($course_info[0]->type_pay === '1') { ?>
            $('#value_pay').val('<?= $course_info[0]->value_pay; ?>');
            <?php } ?>
        });
        $('#ba1').click(function () {
            $('#am').show();
            <?php if ($course_info[0]->type_pay === '1') {?>
            $('#value_pay').val('');
            <?php } else if ($course_info[0]->type_pay === '0') { ?>
            $('#value_pay').val('<?= $course_info[0]->value_pay; ?>');
            <?php } ?>
        });
    });
</script>


