<?php $this->load->view('my_account/includes/view_edit_profile_header'); ?>

<?php
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>

<div id="user_avatar_container">
    <img src="<?= base_url(); ?>/assets/images/users_avatar/<?= insert_before_extension($avatar, '_large'); ?>" class="myProfileAvatar"/>
    <img id="avatar-tips" src="<?= base_url()?>assets/images/site/question_mark.png" />
    <!-- Upload avatar div--> 
    <form id="upload_avatar_form" action="<?= base_url(); ?>my_account/change_avatar" method="POST" enctype="multipart/form-data">
    <p><input id="avatar_input" type="file" name="my_avatar" value="选择图片"/></p>
    </form>
    <p id="uploading" style="display:none;">上传中...</p>
</div>
<script language="javascript">
//submit the form when user select the avatar to upload without click a button
    $('#avatar_input').change(function(){
        $('#uploading').fadeIn();
        $('#upload_avatar_form').submit();
    });
//set the help info   
    $('#avatar-tips').popover({
        trigger: 'hover ',
        placement: 'top',
        content:'图片的大小上限为1MB，宽高都不得小于170像素，目前支持png, jpg,jpeg, gif格式'
        
    });
</script>