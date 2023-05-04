<?php 
$is_user_logged_in = is_user_logged_in();
if(!$is_user_logged_in){
    $wdp_login = get_option('wdp_login_tem') ? get_option('wdp_login_tem') : '';
    if($wdp_login == 1){?>
<div class="login-form1">
    <h2>Login Form 1</h2>
    <form action="<?php echo get_the_permalink();?>" method="post">
        Username: <input type="text" name="username" />
        Password: <input type="password" name="pass" />
        <input type="submit" name="user_login" value="Login" style="margin-top: 10px;" />
    </form>
</div>
<?php } ?>

<?php if($wdp_login == 2){?>
<div class="login-form1" style="border:1px solid black;padding:20px">
    <h2>Login Form 2</h2>
    <form action="<?php echo get_the_permalink();?>" method="post">
        Username: <input type="text" name="username" />
        Password: <input type="password" name="pass" />
        <input type="submit" name="user_login" value="Login" style="margin-top: 10px;" />
    </form>
</div>
<?php } 
}else {
    ?>
<a href="<?php echo wp_logout_url();?>">Logout</a>
<?php
}