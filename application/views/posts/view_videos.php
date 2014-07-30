<ul class="video-ulist">
    <?php
        if(!empty($posts)){
        foreach($posts as $p): 
    ?>
    <li class="video-list">
        <a href="<?= base_url() . 'posts/show_post/' . $p['PostID']?>" target="_blank">
        <div class="video-list-headpic">
            <div class="video-list-image" style="background-image:url('<?= base_url() . 'assets/images/posts/' . insert_before_extension($p['Image'], '_small')?>'); background-repeat:no-repeat;"></div>
        </div>
        </a>
        <div class="video-list-body">
            <div class="title"><a href="<?= base_url() . 'posts/show_post/' . $p['PostID']?>" target="_blank"><?= isset($p['Title']) ? truncate_string($p['Title'], '23') : ''?></a></div>
            <span class="author"><?= lang('posted_by')?> <a href="<?= base_url() . 'profile/user_profile/' . $p['Nickname']?>"><?= isset($p['Nickname']) ? $p['Nickname'] : ''?></a></span>
            <div class="date"><?= isset($p['CreatedOn']) ? readable_time_format($p['CreatedOn'], 'mdhi') : ''?></div>
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