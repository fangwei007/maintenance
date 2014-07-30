<?php $cur_page = $this->uri->segment(2);?>
<div class="account-menu">
    <ul class="nav nav-pills">
        <li class="<?= ($cur_page === "my_following") ? 'active':''?>"><a href="<?= site_url('my_account/my_following')?>"><?= lang('my_following')?></a></li>       
        <li class="<?= ($cur_page === "my_followers") ? 'active':''?>"><a href="<?= site_url('my_account/my_followers')?>"><?= lang('my_followers')?></a></li>
    </ul>
</div>