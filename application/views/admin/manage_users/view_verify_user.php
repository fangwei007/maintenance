<div class="margin-bot"><span class="setting-title"><?= lang('verify_user') ?></span></div>

<?php
echo validation_errors('<div class="alert alert-danger">', '</div>');
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>
<?php if (isset($Email)) { //make sure user existed?>
    <form class="form-horizontal" role="form" action="<?php echo base_url(); ?>admin/manage_users/verify_user/<?= $VerifyUserID ?>" method="POST">
        <input value="<?= $VerifyUserID; ?>" name="user_id" type="hidden">
        <div class="row form-row">
            <label for="website" class="col-sm-1 control-label"><?= lang('website') ?></label>
            <div class="col-sm-3">
                <label class="form-control input-xs"><?= !empty($Website) ? $Website : ''; ?></label>
            </div>
            <label for="nickname" class="col-sm-1 control-label"><?= lang('display_name') ?></label>
            <div class="col-sm-3">
                <label class="form-control input-xs"><?= !empty($Nickname) ? $Nickname : ''; ?></label>
            </div>
        </div>

        <div class="row form-row">

            <label for="status" class="col-sm-1 control-label"><?= lang('status') ?></label>
            <div class="col-sm-3">
                <label class="form-control input-xs"><?php
                    switch ($VerifyStatus) {
                        case 'S':
                            echo lang('verified');
                            break;
                        case 'A':
                            echo lang('processing');
                            break;
                        case 'F':
                            echo lang('fail');
                            break;
                        default:
                            break;
                    }
                    ?></label>
            </div>
        </div>

        <div class="row form-row">
            <label for="note" class="col-sm-1 control-label">申请内容</label>
            <div class="col-sm-8">
                <textarea name="note" id="input-bio" class="form-control" rows="6"><?php echo $Note; ?></textarea>
            </div>
        </div>

        <div class="row form-row">
            <label for="feedback" class="col-sm-1 control-label">审核回馈</label>
            <div class="col-sm-8">
                <textarea name="feedback" id="input-bio" class="form-control" rows="6"><?php if (isset($Feedback)) echo $Feedback; ?></textarea>
            </div>
        </div>

        <div class="col-sm-offset-5">
            <input type="submit" name="verify" value="通过" class="btn btn-default"/>
            <input type="submit" name="reject" value="拒绝" class="btn btn-default"/>
            <a href="<?= base_url() ?>admin/manage_users/show_verify_users">返回</a>
        </div>
    </form>  
    <?php
}else {
    echo lang('no_user');
}
?>
