<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Demo FilterSelect</title>
        <style type="text/css">
            html {
                font-size: 100%;
            }
            .wrap--outer {
                width: 58rem;
                margin: 0 auto;
            }
            .wrap--inner {
                display: -webkit-flex;
                display: -moz-flex;
                display: -ms-flex;
                display: -o-flex;
                display: flex;
                flex-flow: wrap row;
                justify-content: space-between;
            }
            .wrap {
                width: 16rem;
            }
            .wrap select {
                width: 100%;
            }
        </style>
    </head>
    <body>

        <div class="wrap--outer">


            <h1>Filter Select</h1>

            <div class="wrap--inner">

                <div class="wrap">
                    <select size='30' class='list filterSelect' data-target='select-family' id='select-city'>
                        <?php
                        $c1 = '0';
                        $c2 = '0';
                        $c3 = '0';
                        $c4 = '0';
                        foreach ($data as $value):
                            $var = $value->cluster;
                            ?>
                            <option value='<?= $value->cluster ?>' data-reference='<?= $value->cluster ?>'>
                                <?php
                                if ($value->cluster === '1') {
                                    $c1++;
                                    echo'خدمات';
                                } elseif ($value->cluster === '2') {
                                    $c2++;
                                    echo'صنعت';
                                } elseif ($value->cluster === '3') {
                                    $c3++;
                                    echo'فرهنگ و هنر';
                                } elseif ($value->cluster === '4') {
                                    $c4++;
                                    echo'کشاورزی';
                                }
                                ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="wrap">
                    <select size='30' class='list filterSelect' data-target='select-name' id='select-family' data-allowempty>
                        <option value="-1" disabled="">---</option>
                        <?php foreach ($data as $value): ?>
                            <option value='<?= $value->group_id; ?>'  data-reference='<?= $value->group_id; ?>' data-belongsto='<?= $value->group_id; ?>'><?= $value->group_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="wrap">
                    <select size='30' class='list' id='select-name'>
                        <option value="-1">---</option>
                        <?php foreach ($data as $value): ?>
                        <option value='<?= $value->standard_id; ?>' data-belongsto='<?= $value->group_id; ?>'><?= $value->standard_name; ?></option>
                         <?php endforeach; ?>
                    </select>
                </div>

            </div>

        </div>


        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

        <script src="<?= base_url(); ?>filterselect.js"></script>

        <script type="text/javascript">
            $('.filterSelect').filterSelect({
                allowEmpty: true
            });
        </script>

    </body>
</html>