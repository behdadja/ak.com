
<style>
    /* for modal quide register / bug fix - no overlay */
    .modal-backdrop {
        display: none;
    }

    /* for Rotate icons */
    .fa-spin-hover:hover {
        -webkit-animation: spin 1s;
        -moz-animation: spin 1s;
        -o-animation: spin 1s;
        animation: spin 1s;
    }
    @-moz-keyframes spin {
        from { -moz-transform: rotate(0deg); }
        to { -moz-transform: rotate(360deg); }
    }
    @-webkit-keyframes spin {
        from { -webkit-transform: rotate(0deg); }
        to { -webkit-transform: rotate(360deg); }
    }
    @keyframes spin {
        from {transform:rotate(0deg);}
        to {transform:rotate(360deg);}
    }

    .zoom:hover {
        -ms-transform: scale(1.3); /* IE 9 */
        -webkit-transform: scale(1.3); /* Safari 3-8 */
        transform: scale(1.3);
    }
    </style>

    <!-- هدر -->
    <div class="mdk-box mdk-box--bg-gradient-primary bg-dark js-mdk-box position-relative overflow-hidden" data-effects="parallax-background blend-background">
        <div class="mdk-box__bg">
            <div class="mdk-box__bg-front" style="background-image: url(<?php echo base_url(); ?>assets/images/1280_work-station-straight-on-view.jpg);"></div>
        </div>
        <div class="mdk-box__content">
            <div class="container page__container py-64pt py-md-112pt">
                <div class="row align-items-center text-center text-md-left">
                    <span class="card-body fullbleed">
                        <span class="row">
                            <span class="col-lg-10 col-sm-2">
                                <span class="text-white d-block" style="margin-right: 20px;font-size: 70px">آموزکده</span>
                                    <span class="h2 text-white-70" style="margin-right: 10px;">سامانه مدیریت آموزشگاه</span>
                            </span>
                            <span class="col-lg-2 col-sm-10">
                                <span class="text-right flex">
                                    <img src="<?php echo base_url('images/admin_logo.png'); ?>" width="190" alt="amoozkadeh" class="rounded">
                                </span>
                            </span>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- / پایان-->

    <!-- آموزکده چیست؟ -->
    <div class="bg-white border-bottom-2 py-16pt py-sm-24pt py-md-32pt ">
        <div class="container page__container">
            <div class="row align-items-center">
                <div class="card">
                    <div class="card-header d-flex align-items-center" style="background-color: #E6E6FA">
                            <div class="h2 mb-0 mr-3 text-accent">آموزکده</div><div class="h2 mb-0 ml-1">چیست؟</div>
                        </div>
                        <div class="card-body" style="background-color: #F5F5F5">
                            <div class="chart"  style="height: auto;margin-bottom: -120px">
                                <div class="flex" style="line-height: normal">
                                    <p class="text-black-70 mb-0 mr-4 ml-4 mt-n1" style="text-align: justify">سامانه مدیریت آموزشگاه آموزکده یک سامانه مدیریتی آنلاین است که با امکانات کاربردی، دقیق و در عین حال بسیار ساده به مدیران کلیه‌ی آموزشگاه ها اعم از آموزشگاه های فنی و حرفه ای، هنری، زبان، کامپیوتر، موسیقی و ... در امور مدیریتی قدرت و انعطاف می بخشد چرا که شما در هر لحظه و در هر مکانی که اراده کنید به تمامی امور آموزشگاه خود دسترسی دارید و در صورت نیاز می توانید تغییرات و اصلاحات مد نظر را اعمال نمایید و کلیه امور آموزشگاه خود را همیشه در قالب یک سیستم یکپارچه به همراه داشته باشید.</p>
                                    <p class="text-black-70 mb-0 mr-4 ml-4 mt-n1">از برترین امتیازات این سامانه می توان به موارد زیر اشاره کرد:</p>
                                </div>
                            </div>
                            <canvas id="topicIqChart" class="chart-canvas"></canvas>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / پایان -->


        <!-- امتیازات سامانه -->
        <div class="container page__container" style="margin:50px auto 50px auto">
            <div class="pb-0 mb-0 ml-16pt">
                <h4>1- نمایش اطلاعات کلی آموزشگاه در یک صفحه</h4><hr style="border-color: #007bff">
            </div>
            <div class="row">
                <div class="col-md-6" style="margin-bottom: 15px">
                    <p class="text-black-70 mb-0 mr-4 ml-4 mt-n1" style="text-align: justify">
                        همان طور که در تصویر می بینید در این صفحه، شما تمام اطلاعات مهم آموزشگاه خود را در یک نگاه مشاهده می کنید. تعداد کارآموزان، تعداد دوره های فعال، تعداد آزمون ها، لیست بدهکاران، چک های دریافتی و ...
                    </p><br>
                    <p class="text-black-70 mb-0 mr-4 ml-4 mt-n1" style="text-align: justify">
                        اطلاعات مذکور به شما کمک می کند که به وضعیت آموزشگاه خود اشراف کامل داشته و کلیه امور مالی و آموزشی خود را زیر نظر داشته باشید. این صفحه نمایی کلی از اطلاعات آموزشگاه را نمایش می هد. برای دسترسی به جزئیات اموزشی و مالی آموزشگاه منوها و زیرمنوهایی در نظر گرفته شده که در ادامه توضیح داده خواهد شد.
                    </p>
                </div>
                <div class="col-md-6">
                    <img alt="پروفایل" src="<?php echo base_url('images/manage.jpg'); ?>" style="cursor:pointer" onclick="onClick(this)" class="w3-hover-opacity">
                </div>
            </div>
        </div>

        <div class="bg-white border-bottom-2 py-16pt py-sm-24pt py-md-32pt" style="margin:50px auto 50px auto">
            <div class="bg-white container page__container">
                <div class="pb-0 mb-0 ml-16pt">
                    <h4>2- بخش آموزش</h4><hr style="border-color: #007bff">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <img alt="آموزش" src="<?php echo base_url('images/courses.jpg'); ?>" style="cursor:pointer" onclick="onClick(this)" class="w3-hover-opacity">
                    </div>
                    <div class="col-md-6" style="margin-top: 15px">
                        <p class="text-black-70 mb-0 mr-4 ml-4 mt-n1" style="text-align: justify">
                            مهم ترین کار در یک آموزشگاه، مدیریت برگزاری دوره ها، کلاس ها، آزمون ها و به طور کلی برنامه ریزی آموزشی است. سامانه آموزکده با امکانات کامل خود برای شما امکان مدیریتی دقیق و منظم را با استفاده از قسمت های مختلف فراهم کرده است.
                            <br>
                            <span>1. درس ها</span><br>
                            <span>2. کلاس ها</span><br>
                            <span>3.آزمون ها </span><br>
                            <span>4.دوره ها </span><br>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container page__container" style="margin:50px auto 50px auto">
            <div class="pb-0 mb-0 ml-16pt">
                <h4>3- بخش کاربران</h4><hr style="border-color: #007bff">
            </div>
            <div class="row">
                <div class="col-md-6" style="margin-bottom: 15px">
                    <p class="text-black-70 mb-0 mr-4 ml-4 mt-n1" style="text-align: justify">
                        همان طور که در محیط فیزیکی هر آموزشگاه سه گروه از افراد حضور دارند، در سامانه اموزکده نیز کاربران به سه گروه کلی تقسیم بندی شده اند:
                        <br>
                        <span>1. کارآموزان</span><br>
                        <span>2. اساتید</span><br>
                        <span>3. کارمندان</span><br>
                        در تمامی قسمت های فوق شما به راحتی می توانید اشخاص جدیدی را به هر گروه اضافه ویا از گروه حذف کنید. در قسمت مدیریت هر گروه، تمامی افراد عضو گروه انتخابی، نمایش داده می شوند که برای هر شخص امکان مشاهده تمام جزئیات آموزشی و مالی وی امکان پذیر است. امکانات موجود در این قسمت به مدیر آموزشگاه اجازه می دهد به طور کامل و با ریزترین جزئیات از تمام مشخصات فردی، آموزشی و مالی اشخاص مطلع باشد.
                    </p>
                </div>
                <div class="col-md-6">
                    <img alt="کاربران" src="<?php echo base_url('images/users.jpg'); ?>" style="cursor:pointer" onclick="onClick(this)" class="w3-hover-opacity">
                </div>
            </div>
        </div>

        <div class="bg-white border-bottom-2 py-16pt py-sm-24pt py-md-32pt" style="margin:50px auto 50px auto">
            <div class="bg-white container page__container">
                <div class="pb-0 mb-0 ml-16pt">
                    <h4>4- بخش مالی و حسابداری</h4><hr style="border-color: #007bff">
                </div>
                <div class="row">
                    <div class="col-md-6" style="margin-top: 15px">
                        <img alt="مالی و حسابداری" src="<?php echo base_url('images/financian.jpg'); ?>" style="cursor:pointer" onclick="onClick(this)" class="w3-hover-opacity">
                    </div>
                    <div class="col-md-6" style="margin-top: 10px">
                        <p class="text-black-70 mb-0 mr-4 ml-4 mt-n1" style="text-align: justify">
                            یکی از اساسی ترین و حساس ترین بخش های هر مجموعه، واحد مالی و حسابداری است. سامانه مدیریتی آموزکده با در نظر گرفتن امور مختلف مالی به شما اجازه می دهد به تمامی مسائل مالی و حسابداری آموزشگاه خود اشراف داشته و برای کلیه دریافتی ها، پرداختی ها و چک ها برنامه ریزی کنید. در این قسمت وضعیت مالی کارآموزان، استادیاران، مدیران و حتی وضعیت چک ها را به صورت مجزا مشاهده می نمایید. اینکه شهریه دوره ها و آزمون هایی که هر کارآموز در آن شرکت کرده چقدر است، چه مبلغی از شهریه را پرداخت کرده، پرداختی وی به کدام یک از حالت های نقدی، واریزی و یا چکی بوده و به طور کلی وضعیت مالی آن کارآموز چگونه است. 
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container page__container" style="margin:50px auto 50px auto">
            <div class="pb-0 mb-0 ml-16pt">
                <h4>5- تیکت ها</h4><hr style="border-color: #007bff">
            </div>
            <div class="row" style="margin-bottom: 15px">
                <p class="text-black-70 mb-0 mr-4 ml-4 mt-n1" style="text-align: justify;padding-bottom: 25px">
                    یکی از امکانات کاربردی سامانه مدیریتی آموزکده امکان ارسال تیکت و پیامک به جهت ارتباط بین کلیه کاربران است. این ویژگی به شما امکان ارسال تیکت و پیامک را هم به صورت تکی و هم به صورت گروهی می دهد. شما می توانید از این قسمت برای اطلاع رسانی های مختلف استفاده کنید. به عنوان مثال: اطلاع رسانی برگزاری دوره های جدید، اطلاع رسانی برگزاری آزمون ها، تغییر تاریخ برگزاری کلاس ها یا آزمون ها، سررسید پرداخت چک بدهکاری کارآموزان و ...    
                </p><br>
                <div class="row" style="margin-bottom: 15px;background-color: #465a6e;color: white;border-radius: 50px 0">
                    <p style="text-align: justify;padding: 35px;line-height: 20pt">
                        موارد فوق تنها بخشی از امکانات این سامانه مدیریتی است. تیم ما در حال برنامه ریزی و اجرای فازهای جدید و قدرتمندی در جهت گسترده تر کردن حوزه های فعالیتی این سامانه است.منتظر به روزرسانی ها و افزایش امکانات این سامانه باشید...
                        <br><br>
                        جهت مشاوره و آگاهی از سایر ویژگی های کاربردی و مفید سامانه مدیریت آموزشگاه آموزکده به قسمت راه های ارتباطی مراجعه کنید.
                    </p>
                </div>
            </div>
        </div>

        <div class="page-section bg-gradient-purple border-top-2">
            <div class="container-fluid page__container">
                <div class="row col-lg-12">

                    <div class="col-lg-3 col-sm-12 text-center zoom" style="padding: 20px">
                        <i class="w3-xxlarge mdi fa fa-book-reader fa-spin-hover"></i>
                        <a href="<?= base_url('app/catalog.pdf'); ?>">
                            <span class="d-md-block" style="color: white;font-size: 18px">مطالعه کاتالوگ</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-sm-12 text-center zoom" style="padding: 20px">
                        <i class="w3-xxlarge fa fa-question-circle fa-spin-hover"></i>
                        <a href="" data-toggle="modal" data-target="#form">
                            <span class="d-md-block" style="color: white;font-size: 18px">مشاهده نسخه آزمایشی</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-sm-12 text-center zoom" style="padding: 20px">
                        <i class="w3-xxlarge fa fa-user-circle fa-spin-hover"></i>
                        <a href="<?= base_url('reg_academy'); ?>">
                            <span class="d-md-block" style="color: white;font-size: 18px">ثبت نام</span>
                        </a>
                    </div>
                    <div class="col-lg-3 col-sm-12 text-center zoom" style="padding: 20px">
                        <i class="w3-xxlarge fa fa-mobile-alt fa-spin-hover"></i>
                        <a href="http://yun.ir/qpt">
                            <span class="d-md-block" style="color: white;font-size: 18px">دانلود اپلیکیشن اندروید</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <!-- / پایان -->


        <!-- modal pictures -->
        <div id="modal01" class="w3-modal" onclick="this.style.display = 'none'">
            <div class="w3-modal-content w3-animate-zoom">
                <div class="modal-header" style="height: 40px">
                    <span class="w3-button w3-hover-red w3-display-topright">&times;</span>
                </div>
                <img id="img01" style="width:100%">
            </div>
        </div>


        <!-- for modal pictures -->
        <script>
            function onClick(element) {
                document.getElementById("img01").src = element.src;
                document.getElementById("modal01").style.display = "block";
            }
        </script>
