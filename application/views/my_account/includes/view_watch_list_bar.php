<div class="margin-bot"><span class="setting-title"><?= lang('my_watchlist') ?></span></div>
<?php $cur_page = $this->uri->segment(2);?>
<div class="account-menu">
    <ul class="nav nav-pills">
        <li class="<?= ($cur_page === "my_watch_list_posts") ? 'active':''?>"><a href="<?= site_url('my_account/my_watch_list_posts')?>"><?= lang('my_wl_posts')?></a></li>       
        <li class="<?= ($cur_page === "my_watch_list_positions") ? 'active':''?>"><a href="<?= site_url('my_account/my_watch_list_positions')?>"><?= lang('my_wl_positions')?></a></li>
    </ul>
</div>