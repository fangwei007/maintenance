<div class="margin-bot"><span class="setting-title">激活账户</span></div>
<?php 
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : ''; 
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
?>

<div class="center-form">
    <form class="form-horizontal" role="form" action="<?= site_url('my_account/activate_account') ?>" method="POST">
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label"><?= lang('email');?></label>
            <div class="col-sm-6">
                <input class="form-control input-xs" value="<?= $this->session->userdata('email') ?>" disabled />
            </div>
        </div>
        <input type="hidden" value="<?= $this->session->userdata('email') ?>" name="email" />
        <?php if(isset($_COOKIE['resend_email'])) {?>
        <div class="alert alert-warning">您可以在1分钟后再次发送邮件</div>
        <?php }else { ?>
        <div class="col-sm-offset-5"><input class="btn btn-default" type="submit" name="submit" value="<?= lang('send_vali_email');?>" /></div>
        <?php } ?>
    </form>
</div><!-- end #login_form -->
