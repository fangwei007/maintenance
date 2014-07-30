<div class="setting-title"><?= lang('manage_positions')?></div>
<?php $cur_page = $this->uri->segment(3);?>
<div style="margin-bottom: 10px;">
    <ul class="nav nav-pills">
        <li class="<?= ($cur_page === "show_published_positions" || empty($cur_page)) ? 'active':''?>"><a href="<?= base_url()?>admin/manage_positions/show_published_positions">已发布的职位</a></li>
        <li class="<?= ($cur_page === "show_deleted_positions") ? 'active':''?>"><a href="<?= base_url()?>admin/manage_positions/show_deleted_positions">回收站</a></li>
    </ul>
</div>