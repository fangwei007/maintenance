<?php $this->load->view('my_account/includes/view_edit_profile_header'); ?>

<?php
echo validation_errors('<div class="alert alert-danger">' ,'</div>'); 
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>

<form class="form-horizontal" role="form" action="<?php echo base_url();?>my_account/edit_my_profile" method="POST">
    <div class="row form-row">
        <label for="email" class="col-sm-1 control-label">邮箱</label>
        <div class="col-sm-3">
          <input value="<?= !empty($Email) ? $Email : ''; ?>" name="email" disabled class="form-control input-xs">
        </div>
        <label for="input-nickname" class="col-sm-1 control-label">显示名字</label>
        <div class="col-sm-3">
          <input type="text"value="<?= !empty($Nickname) ? $Nickname : ''; ?>" name="nickname" id="input-nickname" class="form-control input-xs">
        </div>
        <div class="col-sm-1">
            <img id="nickname-tips" src="<?= base_url()?>assets/images/site/question_mark.png" />
        </div>
    </div>
    <div class="row form-row">
        <label for="input-name" class="col-sm-1 control-label">真实姓名</label>
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
        
        <div class="col-sm-3">
          <input placeholder="城市" type="text"value="<?= !empty($City) ? $City : ''; ?>" name="city" class="form-control input-xs">
        </div>
    </div>
    
    <div class="row form-row">
            <label for="website" class="col-sm-1 control-label"><?= lang('website'); ?></label>
            <div class="col-sm-8">
                <input type="text" class="form-control input-xs" value="<?php if(isset($Website)){echo $Website;} ?>" name="website" id="website"/>
            </div>
            <div class="col-sm-1">
                <img id="web-tips" src="<?= base_url()?>assets/images/site/question_mark.png" />
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

<script language="javascript">
//set the help info   
    $('#nickname-tips').popover({
        trigger: 'hover ',
        placement: 'bottom',
        content:'显示的名字里只能含有中文，数字和英文大小写字母，不能包含有特殊字符包括：空格~!@#$%^&*等'
    });
    
    $('#web-tips').popover({
        trigger: 'hover ',
        placement: 'top',
        content:'http://或https://开头的网址'
    });
</script>