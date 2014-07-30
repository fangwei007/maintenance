<?php
echo validation_errors('<p class="error">');
echo $this->session->flashdata('msg');
echo $this->session->flashdata('error');
?>

<h2>Edit Article</h2>
<div id="edit_post_form">
    <form action="<?php echo base_url(); ?>admin/manage_posts/edit_post/<?php if (isset($PostID)) echo $PostID; ?>" method="POST" enctype="multipart/form-data">
        <?php if (isset($PostID)): ?>
            <input type="hidden" value="<?php echo $PostID; ?>" name="post_id" />
        <?php endif; ?>
        <label for="title">Title</label>
        <input type="title" value="<?php
        if (isset($Title)) {
            echo $Title;
        }
        ?>" name="title" />

        <label for="type">类型</label>
        <select id="type_post" name="type">
            <option value="article"  <?php if ($Type === 'article') echo ' selected="selected"'; ?>>文章</option>
            <option value="video"  <?php if ($Type === 'video') echo ' selected="selected"'; ?>>视频</option>
            <option value="event"  <?php if ($Type === 'event') echo ' selected="selected"'; ?>>活动</option>
            <option value="position"  <?php if ($Type === 'position') echo ' selected="selected"'; ?>>职位</option>
        </select>

        <label for="category">分类</label>
        <select name="category">
            <option value="study"  <?php if ($Category === 'study') echo ' selected="selected"'; ?>>留学</option>
            <option value="career"  <?php if ($Category === 'career') echo ' selected="selected"'; ?>>求职</option>
            <option value="start_up"  <?php if ($Category === 'start_up') echo ' selected="selected"'; ?>>创业</option>
        </select>

        <div id="video_link" style="display:none;">
            <label for="video_link">Video Links</label>
            <textarea rows="5" name="video_link" maxlength="100"><?= $VideoLink; ?></textarea>
        </div>

        <div id="post_summary" style="display: block;">
            <label for="summary">Summary:</label>
            <textarea rows="5" name="summary" maxlength="100"><?php
                if (isset($Summary)) {
                    echo $Summary;
                }
                ?></textarea>
        </div>

        <label for="content">Content:</label>
        <textarea rows="19" name="content"><?php
            if (isset($Content)) {
                echo $Content;
            }
            ?></textarea>

        <div id="featured_image" style="display: block;">
            <?php if (empty($Image)) { ?>
                <label for="featured_image">设置特色图片</label>
                <input type="file" name="featured_image"/>
            <?php } else { ?>
                <img src="<?php echo base_url(); ?>assets/images/posts/<?php echo insert_before_extension($Image,'_large'); ?>" 
                     alt="<?php echo $Image; ?>"/>
                <a href="<?= base_url(); ?>admin/manage_posts/delete_featured_image/<?= $PostID; ?>">删除此图</a>
            <?php } ?>
        </div>
        
        <label for="level">推送等级</label>
        <select name="level">
            <option value="1"  <?= set_select('type', '1'); ?>>1</option>
            <option value="2"  <?= set_select('type', '2'); ?>>2</option>
            <option value="3"  <?= set_select('type', '3'); ?>>3</option>
            <option value="4"  <?= set_select('type', '4', TRUE); ?>>4</option>
        </select>
        
        <input type="submit" name="publish" value="发布" /> 
        <p><a href="<?php echo site_url('admin/manage_posts') ?>">回到文章管理</a></p>
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

