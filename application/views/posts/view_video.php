<ol class="breadcrumb">
    <li><a href="#"><?= lang($post->Category) . lang('video')?></a></li>
    <li class="active"><?= $post->Title?></li>
</ol>
<div class="article-block">
<div class="article-title"><?= $post->Title?></div>              
<div class="author-date-bar">
    <ul>
        <li><?= readable_time_format($post->CreatedOn, 'ymd')?></li>
<!--        <li>241 Like | 84 Shares</li>-->
    </ul>
    <?php $this->load->view('posts/includes/view_post_toolbar'); ?>
</div> 

<div class="clearfix"><div class="show-video"><?= $post->VideoLink?></div></div>

<!--clarification-->		
<div class="clarification">本视频版权属于<a href="#">比橙网</a>(bridgeous.com)，转载请注明出处，商用请<a href="#">联系比橙</a></div>

<?php $this->load->view('posts/includes/view_post_comments');?>
</div>