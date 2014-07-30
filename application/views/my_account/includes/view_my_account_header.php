<!-- Left bar container -->
<?php 
$sess_name = ($this->session->userdata('nickname')) ? $this->session->userdata('nickname') : $this->session->userdata('email');
$sess_avatar = ($this->session->userdata('avatar')) ? $this->session->userdata('avatar') : $this->config->item('default_avatar');
?>
<script src="<?=  base_url(); ?>assets/js/ckeditor/ckeditor.js"></script>
<section class="sidebar-left">	
	
    <aside class="sidebar-first-block">
        <!-- Author image  -->
        <a href="<?= base_url(); ?>my_account/change_avatar">
            <div style="margin-bottom:20px; height:170px; background-image:url('<?=  base_url();?>assets/images/users_avatar/<?= insert_before_extension($sess_avatar, '_large')?>'); background-repeat:no-repeat;"></div>
        </a>

        <div class="clearfix">
        <div class="sidebar-article-author"><?= $sess_name;?></div>
        </div>
        <?php if($this->session->userdata('status') === 'N'): ?>
            <a href="<?= base_url(); ?>my_account/activate_account"><div class="button-title-danger">激活账户</div></a><br/>
        <?php endif; ?>
    </aside>
    <aside>
        <ul class="nav nav-pills nav-stacked">
            
            <?php if($this->session->userdata('status') === 'V'): ?>
            <li class="<?= ($type === "post") ? 'active':''?>"><a href="<?= base_url(); ?>my_account/show_published_posts">发布信息</a></li>
            <li class="<?= ($type === "position") ? 'active':''?>"><a href="<?= base_url(); ?>my_account/show_published_positions">发布职位</a></li>
            <?php endif; ?>
            <li class="<?= ($type === "profile") ? 'active':''?>"><a href="<?= base_url(); ?>my_account/edit_my_profile">编辑我的个人资料</a></li>
            <li class="<?= ($type === "follow") ? 'active':''?>"><a href="<?= base_url(); ?>my_account/my_following"><?= lang('follower_follwing')?></a></li>
            <li class="<?= ($type === "stow") ? 'active':''?>"><a href="<?= base_url(); ?>my_account/my_watch_list_posts"><?= lang('my_watchlist')?></a></li>
            <li class="<?= ($type === "comment") ? 'active':''?>"><a href="<?= base_url(); ?>my_account/my_comments"><?= lang('my_comments')?></a></li>
<!--        <a href="<?= base_url(); ?>my_account/"><div class="button-title">我的信箱</div></a>-->
        </ul>
    </aside>

</section>	
<!-- End of left bar container -->

<!--article container-->

<section class="right-content" >
