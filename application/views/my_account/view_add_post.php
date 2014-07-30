<div class="margin-bot"><span class="setting-title"><?= lang('add_post') ?></span></div>
<?php $this->load->view('my_account/includes/view_inbox_bar'); ?>
<?php
echo validation_errors('<div class="alert alert-danger">', '</div>');
echo ($this->session->flashdata('msg')) ? ('<div class="alert alert-success">' . $this->session->flashdata('msg') . '</div>') : '';
echo (isset($error)) ? ('<div class="alert alert-danger">' . $error . '</div>') : '';
?>

<form class="form-horizontal" role="form" action="<?= base_url(); ?>my_account/add_post" method="POST"  enctype="multipart/form-data">

    <div class="form-row row">
        <label for="title" class="col-sm-1 control-label"><?= lang('title') ?></label>
        <div class="col-sm-8">
            <input class="form-control input-xs" type="text" value="<?php echo set_value('title'); ?>" name="title" />
        </div>
    </div>

    <div class="row form-row">
        <label for="type" class="col-sm-1 control-label"><?= lang('type') ?></label>
        <div class="col-sm-3">
            <select name="type" id="type_post" class="form-control input-sm">
                <option value="article"  <?php echo set_select('type', 'article', TRUE); ?>><?= lang('article_type') ?></option>
                <option value="video"  <?php echo set_select('type', 'video'); ?>><?= lang('video_type') ?></option>
                <option value="event"  <?php echo set_select('type', 'event'); ?>><?= lang('event_type') ?></option>
            </select>
        </div>

        <label for="category" class="col-sm-1 control-label"><?= lang('category') ?></label>
        <div class="col-sm-3">
            <select name="category" class="form-control input-sm">
<!--                <option value="study"  <?php echo set_select('category', 'study', TRUE); ?>><?= lang('study_cate') ?></option>
                <option value="career"  <?php echo set_select('category', 'career'); ?>><?= lang('career_cate') ?></option>-->
                <option value="start_up"  <?php echo set_select('category', 'start_up', TRUE); ?>><?= lang('startup_cate') ?></option>
            </select>
        </div>
    </div>

    <div id="post_summary" class="row form-row">
        <label for="summary" class="col-sm-1 control-label"><?= lang('summary') ?></label>
        <div class="col-sm-8">
            <textarea rows="5" name="summary" maxlength="200" class="form-control"><?= set_value('summary'); ?></textarea>
        </div>
        <div class="col-sm-1">
            <img id="summary-tips" src="<?= base_url() ?>assets/images/site/question_mark.png" />
        </div>
    </div>

    <div id="video_link" class="row form-row">
        <label for="video_link" class="col-sm-1 control-label"><?= lang('video_link') ?></label>
        <div class="col-sm-8">
            <textarea rows="5" name="video_link" class="form-control"><?= set_value('video_link'); ?></textarea>
        </div>
        <div class="col-sm-1">
            <img id="video-tips" src="<?= base_url() ?>assets/images/site/question_mark.png" />
        </div>
    </div>

    <div class="row form-row">
        <label for="content" class="col-sm-1 control-label"><?= lang('content') ?></label>
        <div class="col-sm-cus-8">
            <textarea rows="10" name="content" class="form-control"><?php echo set_value('content'); ?></textarea>
        </div>
    </div>

    <script> CKEDITOR.replace('content');</script>

    <div id="featured_image" class="row form-row">
        <label for="featured_image" class="col-sm-1 control-label"><?= lang('set_featured_image') ?></label>
        <div class="col-sm-8">
            <input type="file" name="featured_image" class="form-control"/>
        </div>
        <div class="col-sm-1">
            <img id="image-tips" src="<?= base_url() ?>assets/images/site/question_mark.png" />
        </div>
    </div>
    <div class="col-sm-offset-5">
        <input type="submit" name="publish" value="<?= lang('submit') ?>" class="btn btn-default"/>
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


    $('#summary-tips').popover({
        trigger: 'hover ',
        placement: 'top',
        content: '短描述用来显示在发布的列表界面用以总览全文,不超过200字'

    });

    $('#image-tips').popover({
        trigger: 'hover ',
        placement: 'top',
        content: '图片的大小不超过1MB，宽度不得小于300像素，高度不得小于225像素，目前支持png, jpg,jpeg, gif格式'

    });

    $('#video-tips').popover({
        trigger: 'hover ',
        placement: 'top',
        content: '视频来源各视频网站发布的分享链接，如<embed>开头的html链接或<iframe>开头的通用链接'

    });

</script>