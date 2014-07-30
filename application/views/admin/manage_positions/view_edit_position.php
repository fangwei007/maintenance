<div class="margin-bot"><span class="setting-title"><?= lang('edit_position') ?></span></div>

<?php
echo validation_errors('<div class="alert alert-danger">', '</div>');
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>

<form class="form-horizontal" role="form" action="<?php echo base_url(); ?>admin/manage_positions/edit_position/<?php if (isset($PositionID)) echo $PositionID; ?>" method="POST" enctype="multipart/form-data">
    <?php if (isset($PositionID)): ?>
        <input type="hidden" value="<?php echo $PositionID; ?>" name="position_id" />
    <?php endif; ?>

    <div class="form-row row">    
        <label for="title" class="col-sm-1 control-label"><?= lang('title') ?></label>
        <div class="col-sm-8">
            <input class="form-control input-xs" type="text" value="<?php
            if (isset($Title)) {
                echo $Title;
            }
            ?>" name="title" id="title"/>
        </div>
    </div>

    <div class="row form-row">
        <label for="country" class="col-sm-1 control-label"><?= lang('country') ?></label>
        <div class="col-sm-3">
            <select name="country" id="type_post" class="form-control input-sm">
                <option value="us"  <?php if ($Country === 'us') echo ' selected="selected"'; ?>><?= lang('us') ?></option>
                <option value="cn"  <?php if ($Country === 'cn') echo ' selected="selected"'; ?>><?= lang('cn') ?></option>
            </select>
        </div>

        <label for="field" class="col-sm-1 control-label"><?= lang('field') ?></label>
        <div class="col-sm-3">
            <select name="field" id="type_post" class="form-control input-sm">
                <option value="IT"  <?php if ($Field === 'IT') echo ' selected="selected"'; ?>><?= lang('IT') ?></option>
                <option value="finance"  <?php if ($Field === 'finance') echo ' selected="selected"'; ?>><?= lang('finance') ?></option>
                <option value="marketing"  <?php if ($Field === 'marketing') echo ' selected="selected"'; ?>><?= lang('marketing') ?></option>
                <option value="design"  <?php if ($Field === 'design') echo ' selected="selected"'; ?>><?= lang('design') ?></option>
                <option value="HR"  <?php if ($Field === 'HR') echo ' selected="selected"'; ?>><?= lang('HR') ?></option>
                <option value="other"  <?php if ($Field === 'other') echo ' selected="selected"'; ?>><?= lang('other') ?></option>
            </select>
        </div>
    </div>
    <div class="row form-row">
        <label for="job_type" class="col-sm-1 control-label"><?= lang('job_type') ?></label>
        <div class="col-sm-3">
            <select name="job_type" id="type_post" class="form-control input-sm">
                <option value="fulltime"  <?php if ($JobType === 'fulltime') echo ' selected="selected"'; ?>><?= lang('fulltime') ?></option>
                <option value="parttime"  <?php if ($JobType === 'parttime') echo ' selected="selected"'; ?>><?= lang('parttime') ?></option>
                <option value="internship"  <?php if ($JobType === 'internship') echo ' selected="selected"'; ?>><?= lang('internship') ?></option>
                <option value="contract"  <?php if ($JobType === 'contract') echo ' selected="selected"'; ?>><?= lang('contract') ?></option>
                <option value="other"  <?php if ($JobType === 'other') echo ' selected="selected"'; ?>><?= lang('other') ?></option>
            </select>
        </div>
    </div>

    <div class="form-row row">
        <label for="level" class="col-sm-1 control-label">推送等级</label>
        <div class="col-sm-3">
            <select name="level" class="form-control input-sm">
                <option value="1" <?php if ($Level === '1') echo ' selected="selected"'; ?>>仅自己可见</option>
                <option value="2" <?php if ($Level === '2') echo ' selected="selected"'; ?>>二级页面</option>
                <option value="4" <?php if ($Level === '4') echo ' selected="selected"'; ?>>推送主页</option>
            </select>
        </div>
    </div>

    <!--    <div class="row form-row">
            <label for="field" class="col-sm-1 control-label"><?= lang('field') ?></label>
            <div class="col-sm-3">
                <select name="field" id="type_post" class="form-control input-sm">
                    <option value="IT"  <?php echo set_select('field', 'IT', TRUE); ?>><?= lang('IT_field') ?></option>
                    <option value="finance"  <?php echo set_select('field', 'finance'); ?>><?= lang('finance_field') ?></option>
                    <option value="marketing"  <?php echo set_select('field', 'marketing'); ?>><?= lang('marketing_field') ?></option>
                    <option value="other"  <?php echo set_select('field', 'other'); ?>><?= lang('other_field') ?></option>
                </select>
            </div>
        </div>
            
       <div id="expired_in" class="row form-row">
            <label for="expired_on" class="col-sm-1 control-label"><?= lang('expired_on') ?></label>
            <div class="col-sm-8">
                <input class="form-control input-xs" type="text" value="<?= set_value('expired_on'); ?>" name="expired_on" />
            </div>
        </div>-->

    <div class="row form-row">
        <label for="description" class="col-sm-1 control-label"><?= lang('description') ?></label>
        <div class="col-sm-cus-8">
            <textarea rows="10" name="description" class="form-control"><?= isset($Description) ? $Description : '' ?></textarea>
        </div>
    </div>

    <script> CKEDITOR.replace('description');</script>
    <div class="col-sm-offset-5">
        <input type="submit" name="publish" value="<?= lang('submit') ?>" class="btn btn-default"/>
    </div>
</form>
