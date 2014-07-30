<?php $this->load->view('my_account/includes/view_edit_profile_header'); ?>

<?php
echo validation_errors('<div class="alert alert-danger">' ,'</div>'); 
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>

<form class="form-horizontal" role="form" action="<?php echo base_url();?>my_account/change_pass" method="POST">

    <div class="row form-row">
        <label for="old_password" class="col-sm-2 control-label">旧密码</label>
        <div class="col-sm-5">
          <input type="password" value="" name="old_password" class="form-control input-xs">
        </div>
    </div>
    
    <div class="row form-row">
        <label for="new_password" class="col-sm-2 control-label">新密码</label>
        <div class="col-sm-5">
          <input type="password" value="" name="new_password" class="form-control input-xs">
        </div>
    </div>
    <div class="row form-row">
        <label for="new_password_conf" class="col-sm-2 control-label">再次输入新密码</label>
        <div class="col-sm-5">
          <input type="password" value="" name="new_password_conf" class="form-control input-xs">
        </div>
    </div>
    
    <div class="col-sm-offset-5">
        <input type="submit" name="update" value="更新" class="btn btn-default"/>
    </div>
</form>
