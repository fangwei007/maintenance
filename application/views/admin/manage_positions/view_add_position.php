<div class="margin-bot"><span class="setting-title"><?= lang('add_position')?></span></div>

<?php
echo validation_errors('<div class="alert alert-danger">' ,'</div>'); 
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo (isset($error)) ? ('<div class="alert alert-danger">' . $error . '</div>') : '';
?>

<form class="form-horizontal" role="form" action="<?php echo base_url();?>admin/manage_positions/add_position" method="POST"  enctype="multipart/form-data">
    
    <div class="form-row row">
        <label for="title" class="col-sm-1 control-label"><?= lang('title')?></label>
        <div class="col-sm-8">
        <input class="form-control input-xs" type="text" value="<?php echo set_value('title'); ?>" name="title" />
        </div>
    </div>

<!--    <div class="row form-row">
        <label for="field" class="col-sm-1 control-label"><?= lang('field')?></label>
        <div class="col-sm-3">
            <select name="field" id="type_post" class="form-control input-sm">
                <option value="IT"  <?php echo set_select('field', 'IT', TRUE); ?>><?= lang('IT_field')?></option>
                <option value="finance"  <?php echo set_select('field', 'finance'); ?>><?= lang('finance_field')?></option>
                <option value="marketing"  <?php echo set_select('field', 'marketing'); ?>><?= lang('marketing_field')?></option>
                <option value="other"  <?php echo set_select('field', 'other'); ?>><?= lang('other_field')?></option>
            </select>
        </div>
    </div>

    <div id="expired_in" class="row form-row">
        <label for="expired_on" class="col-sm-1 control-label"><?= lang('expired_on')?></label>
        <div class="col-sm-8">
            <input class="form-control input-xs" type="text" value="<?= set_value('expired_on'); ?>" name="expired_on" />
        </div>
    </div>-->

    <div class="row form-row">
        <label for="description" class="col-sm-1 control-label"><?= lang('description')?></label>
        <div class="col-sm-cus-8">
            <textarea rows="10" name="description" class="form-control"><?php echo set_value('description'); ?></textarea>
        </div>
    </div>

     <script> CKEDITOR.replace( 'description');</script>
    <div class="col-sm-offset-5">
        <input type="submit" name="publish" value="<?= lang('submit')?>" class="btn btn-default"/>
    </div>
</form>
