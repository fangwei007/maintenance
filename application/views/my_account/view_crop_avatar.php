<?php $this->load->view('my_account/includes/view_edit_profile_header'); ?>

<?php
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>
	
<img id="crop-avatar" src="<?= base_url(); ?>/assets/images/users_avatar/<?= ($file_name) ? $file_name : ''; ?>" />

<!-- select part of image div--> 
<form class="form-horizontal form-row" role="form" id="crop_avatar_form" action="<?= base_url(); ?>my_account/crop_avatar" method="POST">
    <input type="hidden" value="<?= ($file_name) ? $file_name : ''; ?>" name="crop_avatar_name"/>
    <input type="hidden" id="avatar_x" name="avatar_x"/>
    <input type="hidden" id="avatar_y" name="avatar_y"/>
    <input type="hidden" id="avatar_w" name="avatar_w" />
    <input type="hidden" id="avatar_h" name="avatar_h" />
    <div class="col-sm-offset-5">
        <input type="submit" name="crop" value="确认选区" class="btn btn-default">
    </div>
</form>

<script src="<?=  base_url(); ?>assets/js/jquery.Jcrop.min.js"></script>

<script language="javascript">
//crop the image
$('#crop-avatar').Jcrop({
    onSelect: showCoords,
    onChange: showCoords,
    bgColor:     'black',
    bgOpacity:   .4,
    setSelect:   [ 100, 100, 50, 50 ],
    aspectRatio: 1,
    minSize:    [170,170]
});
      
function showCoords(c){
  $('#avatar_x').val(c.x);
  $('#avatar_y').val(c.y);
  $('#avatar_w').val(c.w);
  $('#avatar_h').val(c.h);
};
</script>