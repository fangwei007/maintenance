<div class="margin-bot"><span class="setting-title"><?= lang($role) . lang('sign_up_title'); ?></span></div>

<?php 
echo validation_errors('<div class="alert alert-danger">','</div>'); 
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>

<div class="center-form"> 
    <form class="form-horizontal" role="form" action="<?php echo base_url();?>register/register_official_user/<?= $role?>" method="POST">
        
        <input type="hidden" value="<?= $role ?>" name="role"/>
        
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label"><?= lang('email')?></label>
            <div class="col-sm-6">
                <input type="email" class="form-control input-xs" value="<?php echo set_value('email'); ?>" name="email" id="email" autocomplete="off"/>
            </div>
        </div>
        
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label"><?= lang('password'); ?></label>
            <div class="col-sm-6">
                <input type="password" class="form-control input-xs" name="password" id="password"/>
            </div>
	</div>
        
        <div class="form-group">
            <label for="passconf" class="col-sm-2 control-label"><?= lang('passconf') ?></label>
            <div class="col-sm-6">
                <input type="password" class="form-control input-xs" name="passconf" id="passconf" />
            </div>
        </div>
            
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label"><?= lang($role) . lang('name'); ?></label>
            <div class="col-sm-6">
                <input type="text" class="form-control input-xs" value="<?php echo set_value('name'); ?>" name="name" id="name"/>
            </div>
	</div>
        
        <div class="form-group">
            <label for="nickname" class="col-sm-2 control-label"><?= lang('nickname'); ?></label>
            <div class="col-sm-6">
                <input type="text" class="form-control input-xs" value="<?php echo set_value('nickname'); ?>" name="nickname" id="nickname"/>
            </div>
	</div>
            
        <div class="form-group">
            <label for="website" class="col-sm-2 control-label"><?= lang($role) . lang('website'); ?></label>
            <div class="col-sm-6">
                <input type="text" class="form-control input-xs" value="<?php echo set_value('website'); ?>" name="website" id="website"/>
            </div>
	</div>

        <div class="col-sm-offset-5"><input class="btn btn-default" type="submit" name="submit" value="<?= lang('register')?>" /></div>
    </form>
    
</div>