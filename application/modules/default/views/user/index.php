<div class="row-fluid">
    <div class="span12 pull-center">
        User - Index <br/>
        <?php if($flash_message) echo $flash_message."<br/>"; ?>
        <?php if($isLogin) : ?>
        Chào <?php echo $userInfo['UserName']; ?>, <br>
        Bạn đã đăng nhập (<a href="<?php echo $logout_url; ?>">Đăng xuất</a>)
        <?php else: ?>
        <a href="<?php echo $register_url; ?>" >Đăng ký</a>
        <?php endif; ?>
    </div>
</div> <!-- /container -->