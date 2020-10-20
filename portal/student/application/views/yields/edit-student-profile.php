<?php if(validation_errors()): ?>
    <div class="alert alert-danger"><?= validation_errors()?></div>
<?php endif ;?>
<?php if($this->session->flashdata('success-update')): ?>
    <div class="alert alert-success"><?=$this->session->flashdata('success-update');?></div>
<?php endif ;?>
<div class="form-horizontal form-material" action="<?= base_url(); ?>student/update-student-profile" method="post">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
<div class="col-md-3"></div><div class="col-md-6" style="background-color: #EDF1F5;padding: 2%;border-radius: 2%">
    <div class="form-group">
        <label class="col-md-6">نام </label>
        <div class="col-md-6">
            <input type="text" disabled placeholder="<?= $user_info[0]->first_name  ?>" class="form-control form-control-line"> </div>
    </div>
    <div class="form-group">
        <label class="col-md-6">نام خانوادگی </label>
        <div class="col-md-6">
            <input type="text" disabled placeholder="<?=  $user_info[0]->last_name ?>" class="form-control form-control-line"> </div>
    </div>
    <div class="form-group">
        <label class="col-md-6"> نام انگلیسی</label>
        <div class="col-md-6">
            <input type="text" name="first_name_en" value="<?= $user_info[0]->first_name_en ?>" class="form-control form-control-line"> </div>
    </div>
    <div class="form-group">
        <label class="col-md-6"> نام خانوادگی انگلیسی</label>
        <div class="col-md-6">
            <input type="text" name="last_name_en" value="<?=  $user_info[0]->last_name_en ?>" class="form-control form-control-line"> </div>
    </div>
    <div class="form-group">
        <label class="col-md-6">تاریخ تولد</label>
        <div class="col-md-6">
            <input type="text" readonly value="<?= $birthday ?>" name="birthday" min="1300-01-01" min="1395-12-12" id="example-input2-group2" class="form-control auto-close-example" onkeyup="
                                var date = this.value;
                                if (date.match(/^\d{4}$/) !== null) {
                                    this.value = date + '-';
                                } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                    this.value = date + '-';
                                }" maxlength="10" required onkeyup='saveValue(this);' oninvalid="setCustomValidity('لطفا تاریخ تولد را وارد کنید')" onchange="try {
                                            setCustomValidity('');
                                        } catch (e) {
                                        }">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-6">آدرس</label>
        <div class="col-md-6">
            <input type="text" name="street" value="<?= $user_info[0]->street ?>" class="form-control form-control-line"> </div>
    </div>

    <div class="form-group">
        <label class="col-md-6">شماره موبایل</label>
        <div class="col-md-6">
            <input type="text" placeholder="" value="<?= $user_info[0]->phone_num ?>" name="phone_num" class="form-control form-control-line">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-success">تغییر اطلاعات</button>
        </div>
    </div>
</div>
</form>
