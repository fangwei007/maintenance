<div class="setting-title">个人资料设置</div>
<?php $cur_page = $this->uri->segment(2);?>
<div style="margin-bottom: 10px;">
    <ul class="nav nav-pills">
        <li class="<?= ($cur_page === "edit_my_profile") ? 'active':''?>"><a href="<?= base_url()?>my_account/edit_my_profile">基本资料</a></li>
        <li class="<?= ($cur_page === "change_avatar") ? 'active':''?>"><a href="<?= base_url()?>my_account/change_avatar">修改头像</a></li>
        <li class="<?= ($cur_page === "change_pass") ? 'active':''?>"><a href="<?= base_url()?>my_account/change_pass">修改密码</a></li>
    </ul>
</div>