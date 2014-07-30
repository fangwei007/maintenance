<div class="margin-bot"><span class="setting-title"><?= lang('add_user')?></span></div>

<?php
echo validation_errors('<div class="alert alert-danger">' ,'</div>'); 
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo (isset($error)) ? ('<div class="alert alert-danger">' . $error . '</div>') : '';
?>
<div class="center-form"> 
    <form class="form-horizontal" role="form" action="<?php echo site_url('admin/manage_users/create_user') ?>" method="POST">
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
            <label for="name" class="col-sm-2 control-label"><?= lang('name'); ?></label>
            <div class="col-sm-6">
                <input type="text" class="form-control input-xs" name="name" id="name"/>
            </div>
	</div>
        
        <div class="form-group">
            <label for="nickname" class="col-sm-2 control-label"><?= lang('display_name'); ?></label>
            <div class="col-sm-6">
                <input type="text" class="form-control input-xs" name="nickname" id="nickname"/>
            </div>
	</div>
        
        <div class="form-group">
            <label for="website" class="col-sm-2 control-label"><?= lang('website'); ?></label>
            <div class="col-sm-6">
                <input type="text" class="form-control input-xs" name="website" id="website"/>
            </div>
	</div>

        <div class="row form-row">
            <label for="role" class="col-sm-1 control-label"><?= lang('role')?></label>
            <div class="col-sm-3">
                <select name="role" id="role" class="form-control input-sm">
                    <option value="admin"  <?php echo set_select('role', 'admin', TRUE); ?>><?= lang('admin')?></option>
                    <option value="editor"  <?php echo set_select('role', 'editor'); ?>><?= lang('editor')?></option>
                    <option value="client"  <?php echo set_select('role', 'client'); ?>><?= lang('user')?></option>
                    <option value="school"  <?php echo set_select('role', 'school'); ?>><?= lang('school')?></option>
                    <option value="industry"  <?php echo set_select('role', 'industry'); ?>><?= lang('industry')?></option>
                </select>
            </div>

            <label for="status" class="col-sm-1 control-label"><?= lang('status')?></label>
            <div class="col-sm-3">
                <select name="status" class="form-control input-sm">
                    <option value="V"  <?php echo set_select('status', 'V', TRUE); ?>><?= lang('verified')?></option>
                    <option value="A"  <?php echo set_select('status', 'A'); ?>><?= lang('unverified')?></option>
                </select>
            </div>
        </div>
        
        <div class="col-sm-offset-5"><input class="btn btn-default" type="submit" name="create" value="<?= lang('create')?>" /></div>
    </form>
    
</div>
