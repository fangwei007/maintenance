<!--<ol class="breadcrumb">
    <li><a href="#"><?= lang($position->Category) . lang($position->Type)?></a></li>
    <li class="active"><?= $position->Title?></li>
</ol>-->
<div class="article-block">
<div class="article-title"><?= $position->Title?></div>
<?php $this->load->view('positions/includes/view_position_stow_button'); ?>
<div class="author-date-bar">
    <ul>
        <li><?= readable_time_format($position->CreatedOn, 'ymd')?></li>
<!--        <li>241 Like | 84 Shares</li>-->
    </ul>
</div>
<div class="clearfix"><article class="article-content"><?= $position->Description?></article></div>

<!--clarification-->		
<div class="clarification">本职位发布版权属于<a href="#">比橙网</a>(bridgeous.com)，转载请注明出处，商用请<a href="#">联系比橙</a></div>
<?php $this->load->view('positions/includes/view_position_comments');?>
</div>