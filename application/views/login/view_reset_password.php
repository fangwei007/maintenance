<div class="setting-title"><?= lang('change_password'); ?></div>
<?php
    echo validation_errors('<div class="alert alert-danger">','</div>');
    if(isset($error)) {
        echo '<div class="alert alert-danger">' . $error . '</div>';
    }
?>

<div class="center-form"> 
    <form class="form-horizontal" role="form" action="<?php echo base_url();?>login/reset_password" method="POST">
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label"><?= lang('email')?></label>
            <div class="col-sm-6">
                <input class="form-control input-xs" type="email" value="<?php echo set_value('email'); ?>" name="email" />
            </div>
        </div>
        <div class="col-sm-offset-5"><input class="btn btn-default" type="submit" name="submit" value="<?= lang('submit');?>" /></div>
    </form>

</div>
