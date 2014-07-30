<ol class="breadcrumb">
    <li><a href="#"><?= lang($post->Category) . lang($post->Type)?></a></li>
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
<a href="<?= base_url() . 'assets/images/posts/' . $post->Image?>"><img src="<?= base_url() . 'assets/images/posts/' . insert_before_extension($post->Image, '_large')?>" alt="featured image"></a>   

<div class="clearfix"><article class="article-content"><?= $post->Content?></article></div>

<!--clarification-->		
<div class="clarification">本文章版权属于<a href="#">比橙网</a>(bridgeous.com)，转载请注明出处，商用请<a href="#">联系比橙</a></div>

<?php $this->load->view('posts/includes/view_post_comments');?>
</div>