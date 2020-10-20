<div class="row">
    <h4 class="alert alert-success"> نتیجه نهایی آزمون آنلاین درس <?= $examInfo[0]->lesson_name; ?></h4>
    <div class="col-lg-3 col-sm-3 col-xs-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">تعداد کل سوالات</h3>
            <ul class="list-inline two-part">
                <li>
                    <div id="sparklinedash"><canvas width="67" height="30" style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas></div>
                </li>
                <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success"><?= $finalResult[0]->count_of_questions; ?></span></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-3 col-sm-3 col-xs-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">تعداد سوالات پاسخ داده شده</h3>
            <ul class="list-inline two-part">
                <li>
                    <div id="sparklinedash2"><canvas width="67" height="30" style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas></div>
                </li>
                <li class="text-right"><i class="ti-arrow-up text-purple"></i> <span class="counter text-purple"><?= $finalResult[0]->count_of_correct_ans + $finalResult[0]->count_of_wrong_ans; ?></span></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-3 col-sm-3 col-xs-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">تعداد سوالات صحیح</h3>
            <ul class="list-inline two-part">
                <li>
                    <div id="sparklinedash3"><canvas width="67" height="30" style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas></div>
                </li>
                <li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-info"><?= $finalResult[0]->count_of_correct_ans; ?></span><i class="mdi mdi-arrow-right-bold-circle-outline"></i><span class="counter text-info"><?= $finalResult[0]->correct_percent; ?>%</span></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-3 col-sm-3 col-xs-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">تعداد سوالات اشتباه</h3>
            <ul class="list-inline two-part">
                <li>
                    <div id="sparklinedash4"><canvas width="67" height="30" style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas></div>
                </li>
                <li class="text-right"><i class="ti-arrow-down text-danger"></i> <span class="text-danger"><?= $finalResult[0]->count_of_wrong_ans; ?></span> <i class="mdi mdi-arrow-right-bold-circle-outline"></i><span class="text-danger"><?= $finalResult[0]->wrong_percent; ?>%</span></li>
            </ul>
        </div>
    </div>
</div>
