<div class="margin-bot"><span class="setting-title"><?= lang('edit_user')?></span></div>

<?php
echo validation_errors('<div class="alert alert-danger">' ,'</div>'); 
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>
<?php if(isset($Email)){ //make sure user existed?>
<p><a href="<?php echo site_url('admin/manage_users/reset_password/'.$UserID) ?>" onclick="return confirm('是否确认重置此用户密码?');" ><?= lang('reset_pwd')?></a></p>
    <form class="form-horizontal" role="form" action="<?php echo base_url();?>admin/manage_users/edit_user/<?= $UserID?>" method="POST">
        <input value="<?= $UserID; ?>" name="user_id" type="hidden">
        <div class="row form-row">
            <label for="email" class="col-sm-1 control-label"><?=lang('email')?></label>
            <div class="col-sm-3">
              <input value="<?= !empty($Email) ? $Email : ''; ?>" name="email" class="form-control input-xs">
            </div>
            <label for="input-nickname" class="col-sm-1 control-label"><?=lang('display_name')?></label>
            <div class="col-sm-3">
              <input type="text" value="<?= !empty($Nickname) ? $Nickname : ''; ?>" name="nickname" id="input-nickname" class="form-control input-xs">
            </div>
        </div>
        
        <div class="row form-row">
            <label for="role" class="col-sm-1 control-label"><?= lang('role')?></label>
            <div class="col-sm-3">
                <select name="role" id="role" class="form-control input-sm">
                    <option value="admin"  <?= ($Role === 'admin') ? 'selected="selected"' : ''; ?>><?= lang('admin')?></option>
                    <option value="editor"  <?= ($Role === 'editor') ? 'selected="selected"' : ''; ?>><?= lang('editor')?></option>
                    <option value="client"  <?= ($Role === 'client') ? 'selected="selected"' : ''; ?>><?= lang('user')?></option>
                    <option value="school"  <?= ($Role === 'school') ? 'selected="selected"' : ''; ?>><?= lang('school')?></option>
                    <option value="industry"  <?= ($Role === 'industry') ? 'selected="selected"' : '' ?>><?= lang('industry')?></option>
                </select>
            </div>

            <label for="status" class="col-sm-1 control-label"><?= lang('status')?></label>
            <div class="col-sm-3">
                <select name="status" class="form-control input-sm">
                    <option value="V"  <?= ($Status === 'V') ? 'selected="selected"' : ''; ?>><?= lang('verified')?></option>
                    <option value="A"  <?= ($Status === 'A') ? 'selected="selected"' : ''; ?>><?= lang('unverified')?></option>
                    <option value="N"  <?= ($Status === 'N') ? 'selected="selected"' : ''; ?>><?= lang('inactive')?></option>
                    <option value="B"  <?= ($Status === 'B') ? 'selected="selected"' : ''; ?>><?= lang('blocked')?></option>
                    <option value="D"  <?= ($Status === 'D') ? 'selected="selected"' : ''; ?>><?= lang('deleted')?></option>
                </select>
            </div>
        </div>
        
        <div class="row form-row">
            <label for="input-name" class="col-sm-1 control-label"><?=lang('name')?></label>
            <div class="col-sm-3">
              <input type="text"value="<?= !empty($Name) ? $Name : ''; ?>" name="name" id="input-name" class="form-control input-xs">
            </div>
            <label for="input-phone" class="col-sm-1 control-label">联系电话</label>
            <div class="col-sm-3">
              <input type="text"value="<?= !empty($Phone) ? $Phone : ''; ?>" name="phone" id="input-phone" class="form-control input-xs">
            </div>
        </div>

        <div class="row form-row">
            <label for="select-country" class="col-sm-1 control-label">所在地</label>
            <div class="col-sm-2">
                <select class="form-control input-sm" onchange="print_state('select-state',this.selectedIndex,'');" id="select-country" name ="country"></select>
            </div>
            <script language="javascript">print_country("select-country","<?php if(isset($Country)){echo $Country;} ?>");</script>
            <div class="col-sm-2">
              <select class="form-control input-sm" name ="state" id ="select-state"></select>
              <?php if(!empty($State)): ?>
                <script language="javascript">
                    print_state('select-state','<?php if($Country === 'US'){ // output country index number
                                                echo 1;}elseif($Country === 'CN'){
                                                echo 2;} ?>', '<?= $State; ?>');
                </script>
                <?php endif; ?>
            </div>

            <div class="col-sm-2">
              <input placeholder="城市" type="text"value="<?= !empty($City) ? $City : ''; ?>" name="city" class="form-control input-xs">
            </div>
        </div>

        <div class="row form-row">
            <label for="input-bio" class="col-sm-1 control-label">简介</label>
            <div class="col-sm-8">
                <textarea name="bio" id="input-bio" class="form-control" rows="6"><?php if(isset($Biography)){echo $Biography;} ?></textarea>
            </div>
        </div>

        <div class="col-sm-offset-5">
            <input type="submit" name="update" value="更新" class="btn btn-default"/>
        </div>
    </form>
<?php }else{
    echo lang('no_user');
} ?>
