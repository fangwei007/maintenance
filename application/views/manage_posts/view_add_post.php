<?php
if (isset($message)) {
    echo '<p class="message">' . $message . '</p>';
}
echo validation_errors('<p class="error">');
if (isset($error)) {
    if (is_array($error)) {
        foreach ($error as $e) {
            echo '<p class="error">' . $e . '</p>';
        }
    } else {
        echo '<p class="error">' . $error . '</p>';
    }
}
?>
<div class="add_post">
    <form action="<?=base_url(); ?>admin/manage_posts/add_post" method="POST"  enctype="multipart/form-data">
        <label for="title">Title: </label>
        <input type="text" value="<?=set_value('title'); ?>" name="title" />

        <label for="type">类型</label>
        <select id="type_post" name="type">
            <option value="article"  <?= set_select('type', 'article', TRUE); ?>>文章</option>
            <option value="video"  <?= set_select('type', 'video'); ?>>视频</option>
            <option value="position"  <?= set_select('type', 'position'); ?>>职位</option>
            <option value="event"  <?= set_select('type', 'event'); ?>>活动</option>
        </select>

        <label for="category">分类</label>
        <select name="category">
            <option value="study"  <?= set_select('type', 'study', TRUE); ?>>留学</option>
            <option value="career"  <?= set_select('type', 'career'); ?>>求职</option>
            <option value="start_up"  <?= set_select('type', 'start_up'); ?>>创业</option>
        </select>

        <div id="video_link" style="display:none;">
            <label for="video_link">Video Links</label>
            <textarea rows="5" name="video_link" maxlength="100"><?= set_value('video_link'); ?></textarea>
        </div>

        <div id="post_summary" style="display: block;">
            <label for="summary">Short Summary</label>
            <textarea rows="5" name="summary" maxlength="100"><?= set_value('summary'); ?></textarea>
        </div>

        <label for="content">Content</label>
        <textarea rows="19" name="content"><?= set_value('content'); ?></textarea>
        <script>
            CKEDITOR.replace('content', {
                uiColor: '#0072bc',
                toolbar: [
                    ['Bold', 'Italic', 'SpecialChar', '-', 'RemoveFormat'],
                    ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', '-', 'Link', 'Unlink'],
                    ['Source']
                ]
            });
        </script>

        <div id="featured_image" style="display: block;">
            <label for="featured_image">设置特色图片</label>
            <input type="file" name="featured_image"/>
        </div>

        <label for="level">推送等级</label>
        <select name="level">
            <option value="1"  <?= set_select('type', '1'); ?>>1</option>
            <option value="2"  <?= set_select('type', '2'); ?>>2</option>
            <option value="3"  <?= set_select('type', '3'); ?>>3</option>
            <option value="4"  <?= set_select('type', '4', TRUE); ?>>4</option>
        </select>

        <input type="submit" name="publish" value="发布" />
        <p><a href="<?= site_url('admin/manage_posts') ?>">回到文章管理</a></p>

    </form>

</div>

<script>
    var selected_type = $('#type_post').val();
    if (selected_type === 'video') {
        $('#video_link').css('display', 'block');
        $('#post_summary').css('display', 'none');
        $('#featured_image').css('display', 'block');
    } else if (selected_type === 'position') {
        $('#video_link').css('display', 'none');
        $('#featured_image').css('display', 'none');
        $('#post_summary').css('display', 'none');
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
        } else if (selected_type === 'position') {
            $('#video_link').css('display', 'none');
            $('#featured_image').css('display', 'none');
            $('#post_summary').css('display', 'none');
        } else {
            $('#video_link').css('display', 'none');
            $('#post_summary').css('display', 'block');
            $('#featured_image').css('display', 'block');
        }
    });
</script>