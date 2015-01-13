<?php if($is_sent == FALSE): ?>
<!-- Form-->
<div class="row-fluid">
    <form action="" method="post" class="form-horizontal" autocomplete="off" >
        <legend>Yêu cầu gửi lại mail kích hoạt</legend>
        <div class="control-group">
            <label class="control-label">Email <span class="f_req">*</span></label>
            <div class="controls">
                <input type="email" id="UserEmail" placeholder="Email" name="UserEmail" value="<?php echo set_value("UserEmail", ''); ?>" />
                <?php echo form_error('UserEmail'); ?>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Gửi lại mail kích hoạt</button>            
        </div>
    </form>
</div>
<!-- End form -->
<?php else: ?>
<div class="row-fluid">
    <span class="pull-center" >Mail kích hoạt đã được gửi đến <strong><?php echo $email; ?></strong>. </span>
</div>
<?php endif; ?>
