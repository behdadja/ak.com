<div class="row">
    <div class="col-md-3">
        <a href="<?php echo base_url('database/delete_all_courses');?>" class="btn btn-danger">delete courses</a>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">کد دوره</th>
                    <th class="text-center">کد آموزشگاه</th>
                    <th class="text-center">وضعیت دوره</th>
                    <th class="text-center">ابزار</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td class="text-center"><?php echo $course->course_id; ?></td>
                        <td class="text-center"><?php echo $course->academy_id; ?></td>
                        <td class="text-center"><?php echo $course->course_status; ?></td>
                        <td class="text-center">
                            <a href="<?php echo base_url('database/edit_course/'.$course->course_id);?>" class="glyphicon glyphicon-pencil m-r-5"></a>|
                            <a href="<?php echo base_url('database/delete_course/'.$course->course_id);?>" class="glyphicon glyphicon-remove text-danger"></a>
                        </td>
                       </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
    <div class="col-md-3">
        <a href="<?php echo base_url('database/delete_all_students');?>" class="btn btn-danger">delete students</a>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">کد آموزشگاه</th>
                    <th class="text-center">کد ملی</th>
                    <th class="text-center">ابزار</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($students as $student): ?>
                    <tr>
                        <td class="text-center"><?php echo $student->academy_id; ?></td>
                        <td class="text-center"><?php echo $student->national_code; ?></td>
                        <td class="text-center">
                            <a href="<?php echo base_url('database/edit_student/'.$student->student_id);?>" class="glyphicon glyphicon-pencil m-r-5"></a>|
                            <a href="<?php echo base_url('database/delete_student/'.$student->student_id);?>" class="glyphicon glyphicon-remove text-danger"></a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
    <div class="col-md-3">
        <a href="<?php echo base_url('database/delete_all_employers');?>" class="btn btn-danger">delete employers</a>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">کد آموزشگاه</th>
                    <th class="text-center">کد ملی</th>
                    <th class="text-center">ابزار</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($employers as $employer): ?>
                    <tr>
                        <td class="text-center"><?php echo $employer->academy_id; ?></td>
                        <td class="text-center"><?php echo $employer->national_code; ?></td>
                        <td class="text-center">
                            <a href="<?php echo base_url('database/edit_employer/'.$employer->employee_id);?>" class="glyphicon glyphicon-pencil m-r-5"></a>|
                            <a href="<?php echo base_url('database/delete_employer/'.$employer->employee_id);?>" class="glyphicon glyphicon-remove text-danger"></a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
    <div class="col-md-3">
        <a href="<?php echo base_url('database/delete_all_courses_students');?>" class="btn btn-danger">delete courses students</a>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">کد دوره</th>
                    <th class="text-center">کد آموزشگاه</th>
                    <th class="text-center">کد ملی</th>
                    <th class="text-center">ابزار</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses_students as $cs): ?>
                    <tr>
                        <td class="text-center"><?php echo $cs->course_id; ?></td>
                        <td class="text-center"><?php echo $cs->academy_id; ?></td>
                        <td class="text-center"><?php echo $cs->student_nc; ?></td>
                        <td class="text-center">
                            <a href="<?php echo base_url('database/edit_course_student/'.$cs->course_student_id);?>" class="glyphicon glyphicon-pencil m-r-5"></a>|
                            <a href="<?php echo base_url('database/delete_course_student/'.$cs->course_student_id);?>" class="glyphicon glyphicon-remove text-danger"></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

