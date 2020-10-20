<div class="tab-pane active" id="messages">
    <div class="steamline">
        <?php if(!empty($tickets_from_student)){ ?>
            <?php foreach($tickets_from_student as $key => $ticket){ ?>
            <div class="sl-item">
                <div class="sl-left"> <img src="<?= base_url(); ?>assets/profile-picture/<?= $ticket->pic_name; ?>" alt="user" class="img-circle"> </div>
                <div class="sl-right">
                    <div class="m-l-40"> <a href="javascript:;" class="text-info"><?= $ticket->first_name.' '.$ticket->last_name; ?></a> <span class="sl-date">5 دقیقه قبل</span>
                        <div class="m-t-20 row">
                            <div class="col-md-2 col-xs-12"></div>
                            <div class="col-md-9 col-xs-12">
                                <p><?= $ticket->smt_body; ?></p> <button class="btn btn-success" alt="default" data-toggle="modal" data-target="#myModal_<?= $ticket->smt_id; ?>">پاسخ دادن</button></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sample modal content -->
            <div id="myModal_<?= $ticket->smt_id; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="myModalLabel">پاسخ دادن به تیکت شماره <?= $ticket->smt_id; ?></h4> </div>
                        <div class="modal-body">
                            <h4>متن مورد نظر خود را بنویسید : </h4>
                            <form class="form-group" action="/tickets/reply-to-student-ticket" method="post">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                <input type="hidden" name="id" value="<?= $ticket->smt_id; ?>">
                                <div class="form-group">
                                    <label class=""></label>
                                    <textarea name="answer_body" class="form-control" rows="5"></textarea>
                                </div>
                                <button class="btn btn-success" type="submit" >ارسال پاسخ</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">بستن</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <hr>
            <?php } ?>
        <?php } ?>
    </div>
</div>
