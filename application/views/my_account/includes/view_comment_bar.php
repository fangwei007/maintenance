<div class="margin-bot"><span class="setting-title"><?= lang('my_comments') ?></span></div>
<div class="account-menu">
    <ul class="nav nav-pills">     
        <li class="<?= active_page('others', $source)?>"><a href="<?= site_url('my_account/my_comments/others')?>"><?= lang('others_comments')?></a></li>
        <li class="<?= active_page('reply', $source)?>"><a href="<?= site_url('my_account/my_comments/reply')?>"><?= lang('reply_comments')?></a></li>
    </ul>
</div>