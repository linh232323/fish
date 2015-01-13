<div class="row-fluid">
    <div class="span2 pull-center">
        <div class="login-form">
            <?php if($flash_message) echo $flash_message."<br/>"; ?>
            <form action="" method="post" id="login_form">
                <h3>Đăng nhập</h3>   
                <?php if(isset($error)): ?>
                <div class="alert alert-error">
                    <?php echo $error; ?>
                </div>
                <?php endif ?>
                
                    <div class="formRow">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-user"></i></span>
                            <input type="text" id="UserEmail" name="UserEmail" placeholder="Email" value="<?php echo set_value('UserEmail',''); ?>"  />
                        </div>
                        <?php echo form_error('UserEmail'); ?>
                    </div>
                    <div class="formRow">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-lock"></i></span>
                            <input type="password" id="password" name="UserPasswd" placeholder="Mật khẩu" value="" autocomplete="off"/>
                        </div>
                        <?php echo form_error('UserPasswd'); ?>
                    </div>
                    <div class="formRow clearfix">
                        <label class="checkbox"><input type="checkbox" name="RememberMe" value="yes" <?php if($is_remember) echo 'checked'; ?> /> Nhớ mật khẩu</label>
                    </div>
                
                <div class="clearfix">
                    <button class="btn btn-inverse " type="submit" name="submit" value="Sign In">Đăng nhập</button>                    
                </div>  
                <hr>
                    
                <div class="formRow clearfix">
                    <span><a href="<?php echo $register_url; ?>">Đăng ký</a></span>       
                </div>  
                <div class="formRow clearfix ">
                    <span><a href="<?php echo $forgot_url; ?>">Quên mật khẩu?</a></span>      
                </div>  
            </form>
        </div>
    </div>
</div> <!-- /container -->