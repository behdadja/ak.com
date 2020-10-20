
<div class="container-fluid page__container page-section">
    <div class="card mb-32pt p-24pt">
        <div class="card-body">
            <div class="row">
                <div class="table-responsive" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>
                    <div class="search-form search-form--light mb-3 col-md-3">
                        <input type="text" class="form-control search" id="myInput" placeholder="جستجو">
                        <button class="btn" type="button" role="button"><i class="material-icons">search</i></button>
                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">کد سرور</th>
                            <th class="text-center">نام سرور</th>
                            <th class="text-center">تعداد کلاس های آنلاین</th>
                            <th class="text-center">روشن بودن</th>
                            <th class="text-center">خاموش یا روشن کردن</th>
                        </tr>
                        </thead>
                        <tbody id="search">
                        <?php


                        for ($i = 0 ; $i < count($servers) ; $i++){
                            ?>
                            <>
                            <td class="text-center"><?= htmlspecialchars($servers[$i]->server_id , ENT_QUOTES); ?></td>
                            <td class="text-center"><?= htmlspecialchars($servers[$i]->server_name, ENT_QUOTES) ?></td>
                            <td class="text-center" style="color: green"><?= htmlspecialchars($servers[$i]->server_usage, ENT_QUOTES) ?></td>
                            <?php
                            if ($servers[$i]->isON == '1'){?>
                                <td class="text-center"><?= htmlspecialchars('روشن است', ENT_QUOTES) ?></td>
                                <?php
                            } else { ?>
                                <td class="text-center"><?= htmlspecialchars('خاموش است', ENT_QUOTES) ?></td>
                                <?php
                            }
                            ?>

                            <td class="text-center" style="color: blue"> <a href="#" onclick="event.preventDefault();document.getElementById('detail_<?php echo htmlspecialchars($servers[$i]->server_id, ENT_QUOTES); ?>').submit();" data-toggle="tooltip" >0/1</a>
                                <form class="" id='detail_<?php echo htmlspecialchars($servers[$i]->server_id); ?>' style="display:none" action="<?php echo base_url('turn_off_on'); ?>" method="post">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                    <input type="hidden" name="server_id" value="<?php echo htmlspecialchars($servers[$i]->server_id, ENT_QUOTES); ?>">
                                </form></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <a class="btn btn-dark" href="<?= base_url('clear') ?>">clear</a>
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

<?php if($this->session->flashdata('fail')) { ?>
    <script>
        $(document).ready(function(){
            $('#fail').modal('show');
        });
    </script>
    <div id="fail" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">پیام مدیریت</h4>
                </div>
                <div class="modal-body">
                    <h4 class="text-center text-danger"><?= $this->session->flashdata('fail') ?></h4>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- end modal -->
<?php } ?>
