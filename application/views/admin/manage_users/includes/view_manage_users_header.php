<div class="setting-title">管理用户</div>
<?php $cur_page = $this->uri->segment(3);?>
<div style="margin-bottom: 10px;">
    <ul class="nav nav-pills">
        <li class="<?= ($cur_page === "view_users" || empty($cur_page)) ? 'active':''?>"><a href="<?= base_url()?>admin/manage_users/view_users">查看用户</a></li>
        <li class="<?= ($cur_page === "create_user") ? 'active':''?>"><a href="<?= base_url()?>admin/manage_users/create_user">添加用户</a></li>
        <li class="<?= ($cur_page === "verify_user") ? 'active':''?>"><a href="<?= base_url()?>admin/manage_users/show_verify_users">验证用户</a></li>
        <li class="<?= ($cur_page === "deleted_user") ? 'active':''?>"><a href="<?= base_url()?>admin/manage_users/deleted_users">回收站</a></li>
    </ul>
</div>