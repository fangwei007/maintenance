<div class="margin-bot"><span class="setting-title"><?= lang('edit_post') ?></span></div>

<?php
echo validation_errors('<div class="alert alert-danger">', '</div>');
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo ($this->session->flashdata('error')) ? ('<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>') : '';
?>

<form class="form-horizontal" role="form" action="<?php echo base_url(); ?>admin/manage_posts/edit_post/<?php if (isset($PostID)) echo $PostID; ?>" method="POST" enctype="multipart/form-data">
    <?php if (isset($PostID)): ?>
        <input type="hidden" value="<?php echo $PostID; ?>" name="post_id" />
    <?php endif; ?>

    <div class="form-row row">    
        <label for="title" class="col-sm-1 control-label"><?= lang('title') ?></label>
        <div class="col-sm-8">
            <input class="form-control input-xs" type="text" value="<?php if (isset($Title)) {
        echo $Title;
    } ?>" name="title" id="title"/>
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
        
        <label for="status" class="col-sm-1 control-label">状态</label>
        <div class="col-sm-3">
            <select name="status" class="form-control input-sm">
                <option value="A" <?php if ($Status === 'A') echo ' selected="selected"'; ?>>已发布</option>
                <option value="R" <?php if ($Status === 'R') echo ' selected="selected"'; ?>>待审核</option>
                <option value="D" <?php if ($Status === 'D') echo ' selected="selected"'; ?>><?= lang('deleted')?></option>
            </select>
        </div>
    </div>
        
    <div class="row form-row">
        <label for="type" class="col-sm-1 control-label"><?= lang('type') ?></label>
        <div class="col-sm-3">
            <select name="type" id="type_post" class="form-control input-sm">
                <option value="article"  <?php if ($Type === 'article') echo ' selected="selected"'; ?>><?= lang('article_type') ?></option>
                <option value="video"  <?php if ($Type === 'video') echo ' selected="selected"'; ?>><?= lang('video_type') ?></option>
                <option value="event"  <?php if ($Type === 'event') echo ' selected="selected"'; ?>><?= lang('event_type') ?></option>
            </select>
        </div>

        <label for="category" class="col-sm-1 control-label"><?= lang('category') ?></label>
        <div class="col-sm-3">
            <select name="category" class="form-control input-sm">
<!--                <option value="study"  <?php if ($Category === 'study') echo ' selected="selected"'; ?>><?= lang('study_cate') ?></option>
                <option value="career"  <?php if ($Category === 'career') echo ' selected="selected"'; ?>><?= lang('career_cate') ?></option>-->
                <option value="start_up"  <?php if ($Category === 'start_up') echo ' selected="selected"'; ?>><?= lang('startup_cate') ?></option>
            </select>
        </div>
    </div>

    <div id="post_summary" class="row form-row">
        <label for="summary" class="col-sm-1 control-label"><?= lang('summary') ?></label>
        <div class="col-sm-8">
            <textarea rows="5" name="summary" maxlength="200" class="form-control"><?php if (isset($Summary)) {
        echo $Summary;
    } ?></textarea>
        </div>
    </div>

    <div id="video_link" >
        <div class="row form-row">
            <label for="video_link" class="col-sm-1 control-label"><?= lang('video_link') ?></label>
            <div class="col-sm-8">
                <textarea rows="5" name="video_link" class="form-control"><?= $VideoLink; ?></textarea>
            </div>
        </div>
        <div class="row form-row">
            <label for="video_preview" class="col-sm-1 control-label"><?= lang('manage_posts_view_edit_post_video_preview') ?></label>
            <div class="col-sm-8">
                <?= $VideoLink ?>
            </div>
        </div>    
    </div>

    <div class="row form-row">
        <label for="content" class="col-sm-1 control-label"><?= lang('content') ?></label>
        <div class="col-sm-cus-8">
            <textarea rows="10" name="content" class="form-control"><?php if (isset($Content)) {
        echo $Content;
    } ?></textarea>
        </div>
    </div>

    <script> CKEDITOR.replace('content');</script>  

    <div id="featured_image" class="row form-row">
    <?php if (empty($Image)) { ?>
                <label for="featured_image" class="col-sm-1 control-label"><?= lang('set_featured_image') ?></label>
                <div class="col-sm-8">
                    <input type="file" name="featured_image" class="form-control"/>
                </div>
    <?php } else { ?>
                <div class="col-sm-6 col-md-4 col-sm-offset-4">
                    <div class="thumbnail">
                        <img src="<?php echo base_url(); ?>assets/images/posts/<?= insert_before_extension($Image, '_medium'); ?>" 
                             alt="post image"/>
                        <div class="caption">
                            <a href="<?= base_url(); ?>admin/manage_posts/delete_featured_image/<?= $PostID; ?>"><?= lang('delete_image') ?></a>
                        </div>
                    </div>
                </div>
    <?php } ?>
    </div>


    <div class="col-sm-offset-5">
        <input type="submit" name="publish" value="<?= lang('update') ?>" class="btn btn-default"/>
    </div>
</form>



<script>
    var selected_type = $('#type_post').val();
    if (selected_type === 'video') {
        $('#video_link').css('display', 'block');
        $('#post_summary').css('display', 'none');
        $('#featured_image').css('display', 'block');
    } else {
        $('#video_link').css('display', 'none');
        $('#post_summary').css('display', 'block');
        $('#featured_image').css('display', 'block');
    }
    //in view_start page, let users type their countries when they select Other in country field
    $('#type_post').change(function() {
        var selected_type = $(this).val();
        if (selected_type === 'video') {
            $('#video_link').css('display', 'block');
            $('#post_summary').css('display', 'none');
            $('#featured_image').css('display', 'block');
        } else {
            $('#video_link').css('display', 'none');
            $('#post_summary').css('display', 'block');
            $('#featured_image').css('display', 'block');
        }
    });
</script>