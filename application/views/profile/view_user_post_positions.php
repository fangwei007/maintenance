<?php $this->load->view('profile/includes/view_profile_header');?>

<ol class="breadcrumb">
    <li><a href="#"><?= lang($user_profile->Role) . lang('official_account')?></a></li>
    <li class="active"><?= $user_profile->Nickname?></li>
</ol>

<?php if(!empty($positions)){ ?>
    <?php foreach($positions as $p): ?>
    <div class="article-preview-block">
        <div class="clearfix">
            <div class="article-title pull-left"><a href="<?= base_url() . 'positions/show_position/'
                             . $p['PositionID'] ?>"><?= $p['Title']?></a>
            </div>
            <div class="pull-right"><?= lang($p['Field'])?></div>
        </div>
        <div class="author-date-bar">
            <ul>
            <li><?= readable_time_format($p['CreatedOn'],'ymd')?></li>
<!--                <li>241 Like | 84 Shares</li>-->
            </ul>
        </div>

    </div>
    <?php
     endforeach;
    ?>

<?php echo $pagination; ?>
<?php }else{
    echo lang('no_post');
} ?>
