<div class="setting-title"><?= lang('manage_posts')?></div>
<?php $cur_page = $this->uri->segment(3);?>
<div style="margin-bottom: 10px;">
    <ul class="nav nav-pills">
        <li class="<?= ($cur_page === "show_published_posts" || empty($cur_page)) ? 'active':''?>"><a href="<?= base_url()?>admin/manage_posts/show_published_posts">已发布的内容</a></li>
        <li class="<?= ($cur_page === "review_videos") ? 'active':''?>"><a href="<?= base_url()?>admin/manage_posts/review_videos">待审核的视频</a></li>
        <li class="<?= ($cur_page === "show_deleted_posts") ? 'active':''?>"><a href="<?= base_url()?>admin/manage_posts/show_deleted_posts">回收站</a></li>
    </ul>
</div>