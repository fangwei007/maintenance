<?php $cur_page = $this->uri->segment(2);?>
<div class="account-menu">
    <ul class="nav nav-pills">
        <?php if($type === "post"):?>
        <li class="<?= ($cur_page === "show_published_posts") ? 'active':''?>"><a href="<?= site_url('my_account/show_published_posts')?>"><?= lang('published_post')?></a></li>       
        <li class="<?= ($cur_page === "add_post") ? 'active':''?>"><a href="<?= site_url('my_account/add_post')?>"><?= lang('add_post')?></a></li>
        <li class="<?= ($cur_page === "show_deleted_posts") ? 'active':''?>"><a href="<?= site_url('my_account/show_deleted_posts')?>"><?= lang('deleted_post')?></a></li>
        <?php endif;?>

        <?php if($type === "position"):?>
        <li class="<?= ($cur_page === "show_published_positions") ? 'active':''?>"><a href="<?= site_url('my_account/show_published_positions') ?>"><?= lang('published_position') ?></a></li>
        <li class="<?= ($cur_page === "add_position") ? 'active':''?>"><a href="<?= site_url('my_account/add_position')?>"><?= lang('add_position')?></a></li>
        <li class="<?= ($cur_page === "show_deleted_positions") ? 'active':''?>"><a href="<?= site_url('my_account/show_deleted_positions') ?>"><?= lang('deleted_position') ?></a></li>
        <?php endif;?>
    </ul>
</div>