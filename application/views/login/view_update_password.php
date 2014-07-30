<h2>Update your password</h2>
<div id="update_password_form">
    <form action="<?php echo base_url();?>login/update_password" method="POST">
        <label for="email">Email: </label>
        <?php if(isset($email_hash, $email_code)):?>
        <input type="hidden" value="<?php echo $email_hash; ?>" name="email_hash" />
        <input type="hidden" value="<?php echo $email_code; ?>" name="email_code" />
        <?php endif; ?>
        <input type="email" value="<?php echo (isset($email) ? $email : ''); ?>" name="email" />
        
        <label for="password">New Password: </label>
        <input type="password" value="" name="password" />
        
        <label for="password_conf">New Password Again: </label>
        <input type="password" value="" name="password_conf" />
        
        <input type="submit" name="update" value="Update my password" />
    </form>
    <?php echo validation_errors('<p class="error">'); 
    if(isset($error)) {
            echo '<p class="error">' . $error . '</p>';
    }
    ?>
</div>