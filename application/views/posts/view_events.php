<ul class="post-ulist">
    <?php
        if(!empty($posts)){
        foreach($posts as $p): 
    ?>
    <li class="post-list clearfix">
        <a href="<?= base_url() . 'posts/show_post/' . $p['PostID']?>" target="_blank">
        <div class="post-list-headpic">
            <div class="post-list-image"style="background-image:url('<?= base_url() . 'assets/images/posts/' . insert_before_extension($p['Image'], '_medium')?>'); background-repeat:no-repeat;"></div>
        </div>
        </a>
        <div class="post-list-body">
            <div class="title"><a href="<?= base_url() . 'posts/show_post/' . $p['PostID']?>" target="_blank"><?= isset($p['Title']) ? $p['Title'] : ''?></a></div></h3>
            <p class="post-info-block">
                <span class="author"><?= lang('posted_by')?> <a href="<?= base_url() . 'profile/user_profile/' . $p['Nickname']?>"><?= isset($p['Nickname']) ? $p['Nickname'] : ''?></a></span>
                <span><?= isset($p['CreatedOn']) ? readable_time_format($p['CreatedOn'], 'mdhi') : ''?></span>
            </p>
            <div class="preview"><a href="<?= base_url() . 'posts/show_post/' . $p['PostID']?>" target="_blank"><?= isset($p['Summary']) ? $p['Summary'] : ''?></a></div>
            <a href="<?= base_url() . 'posts/show_post/' . $p['PostID']?>" target="_blank"><div class="read-all"><span class="button-title"><?= lang('read_all')?></span></div></a>
        </div>
    </li>
    <?php 
        endforeach;
        echo $pagination;
        }else{
            echo lang('no_post');
        }
    ?>
    
</ul>