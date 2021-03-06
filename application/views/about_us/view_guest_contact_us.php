<div class="margin-bot"><span class="setting-title"><?= "联系我们" ?></span></div>

<?php
echo validation_errors('<div class="alert alert-danger">', '</div>');
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>
<form class="form-horizontal" role="form" action="<?php echo base_url(); ?>about_us/guest_contact_us" method="POST">
    <div class="row form-row">
        <label for="title" class="col-sm-1 control-label">联系类型</label>
        <div class="col-sm-3">
            <select name="title" id="type_post" class="form-control input-sm">
                <option value="suggestion"  <?php echo set_select('title', 'suggestion', TRUE); ?>>提供意见</option>
                <option value="bug"  <?php echo set_select('title', 'bug'); ?>>提交BUG</option>
            </select>
        </div>
    </div>

    <div class="row form-row">
        <label for="email" class="col-sm-1 control-label">您的联系邮箱</label>
        <div class="col-sm-3"><input class="txtForm" name="email" type="email" placeholder=" 邮箱"/></div>

    </div>
    
    <div class="row form-row">
        <label for="name" class="col-sm-1 control-label">您的姓名</label>
        <div class="col-sm-3"><input class="txtForm" type="text" name="name" placeholder=" 姓名"/></div>

    </div>

    <div class="row form-row">
        <label for="content" class="col-sm-1 control-label">描述</label>
        <div class="col-sm-8">
            <textarea name="content" id="input-bio" class="form-control" rows="6"></textarea>
        </div>
    </div>

    <div class="col-sm-offset-5">
        <input type="submit" name="publish" value="提交" class="btn btn-default"/>
    </div>
</form>  
