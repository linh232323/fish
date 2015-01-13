<?php if($message == '') : ?>
<!-- Form-->
<div class="row-fluid">
    <form action="" method="post" class="form-horizontal" autocomplete="off" >
        <legend>Tạo mật khẩu mới</legend>
        <div class="control-group">
            <label class="control-label">Mật khẩu mới <span class="f_req">*</span></label>
            <div class="controls">
                <input type="password" id="UserPasswd" placeholder="Mật khẩu" name="UserPasswd" value="<?php echo set_value("UserPasswd"); ?>" />
                <?php echo form_error('UserPasswd'); ?>                
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Xác nhận mật khẩu <span class="f_req">*</span></label>
            <div class="controls">
                <input type="password" id="UserPasswd2" placeholder="Nhập lại mật khẩu" name="UserPasswd2" value="<?php echo set_value("UserPasswd2"); ?>" />
                <?php echo form_error('UserPasswd2'); ?>                
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Cập nhật</button>            
        </div>
    </form>
</div>
<!-- End form -->
<?php else: ?>
<div class="row-fluid">
    <span class="pull-center" ><?php echo $message; ?></span>
    <?php if($is_reset): ?>
    <br>
    <span class="pull-center" ><a href="<?php echo $login_url; ?>">Đăng nhập</a></span>
    <?php endif ?>
</div>
<?php endif; ?>
