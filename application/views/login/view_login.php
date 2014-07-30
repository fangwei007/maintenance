<div class=pageTitle><?= $this->lang->line('Login');?></div>
<div class=pageAnnouncement>
	<?= $this->lang->line('signupQuestion');?> <a class=link href="<?php echo site_url('register') ?>"><?= $this->lang->line('signupForFree');?></a>
</div>

<?php echo validation_errors('<p class="error">'); 
if(isset($error)) {
        echo '<p class="error">' . $error . '</p>';
}
?>

    <form action="<?php echo site_url('login/login_user') ?>" method="POST">
		<div class=formTitle><label for="email">Email:</label></div>
        <div class="formLine"><input class="txtForm" type="email" value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>" name="email" id="email"/></div>
        
        
        <div class=formTitle><label for="password">Password:</label></div>
        <div class="formLine">
			<input class="txtForm" type="password" value="" name="password" id="password"/>
			<span class=hint><a class=link href="<?php echo site_url('login/reset_password') ?>">Forgot password</a></span>
		</div>
        
		<div class=formLineText>
			<label><input name="remember_me" type="checkbox" value="true" style="margin-right:5px;"/>Save email</label>
		</div>
		
        <div class=formButtonLine>
                <input type="submit" name="login" value="submit" class="formButtonSubmit"/>
				
		</div>
        
    </form>
    
		
	

