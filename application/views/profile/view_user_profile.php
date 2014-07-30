<?php $this->load->view('profile/includes/view_profile_header');?>

<ol class="breadcrumb">
    <li><a href="#"><?= lang($user_profile->Role) . lang('official_account')?></a></li>
    <li class="active"><?= $user_profile->Nickname?></li>
</ol>

<?php if(!empty($posts)){ ?>
    <?php foreach($posts as $p): ?>
    <div class="article-preview-block">
        <div class="clearfix">
            <div class="article-title pull-left"><a href="<?= base_url() . 'posts/show_post/'
                             . $p['PostID'] ?>"><?= $p['Title']?></a>
            </div>
            <div class="pull-right"><?= lang($p['Category']) . lang($p['Type'])?></div>
        </div>
        <div class="author-date-bar">
            <ul>
            <li><?= readable_time_format($p['CreatedOn'],'ymd')?></li>
<!--                <li>241 Like | 84 Shares</li>-->
            </ul>
        </div>
        <?php
         switch ($p['Type']) {
            case 'video':
        ?>
                <img alt="video_image" src="<?= base_url() . 'assets/images/posts/' . insert_before_extension($p['Image'], '_medium')?>" />
        <?php
                break;
            case 'position':
                break;
             default:
        ?>
                 <div class="content-preview"><?= $p["Summary"]?></div>
        <?php
                 break;
         }
        ?>

    </div>
    <?php
     endforeach;
    ?>

<?php echo $pagination; ?>
<?php }else{
    echo lang('no_post');
} ?>
