<?php if($is_sent == FALSE): ?>
<!-- Form-->
<div class="row-fluid">
    <form action="" method="post" class="form-horizontal" autocomplete="off" >
        <legend>Tìm lại mật khẩu</legend>
        <div class="control-group">
            <label class="control-label">Email <span class="f_req">*</span></label>
            <div class="controls">
                <input type="email" id="UserEmail" placeholder="Email" name="UserEmail" value="<?php echo set_value("UserEmail", ''); ?>" />
                <?php echo form_error('UserEmail'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Mã bảo vệ</label>
            <div class="controls">
                <?php echo $captchaImage; ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>

            <div class="controls">
                <input type="text" id="captchaText" placeholder="Nhập mã bảo vệ" name="CaptchaText" value="" />
                <?php echo form_error('CaptchaText'); ?>                
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>            
        </div>
    </form>
</div>
<!-- End form -->
<?php else: ?>
<div class="row-fluid">
    <span class="pull-center" >Yêu cầu tìm lại mật khẩu đã gửi đến <strong><?php echo $email; ?></strong>. </span>
</div>
<?php endif; ?>
