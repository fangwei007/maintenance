<?php if(!empty($events_list)){ ?>
    <?php foreach($events_list as $e):?>
    <div class="event-cell">
        <a href="<?= base_url()?>posts/show_post/<?= $e['PostID']?>">
            <div class="event-image">
                <img src="<?= base_url() . 'assets/images/posts/' . insert_before_extension($e['Image'], '_medium')?>" />
            </div>
        </a>
        <div class="event-title">
            <a href="<?= base_url()?>posts/show_post/<?= $e['PostID']?>"><h2><?= truncate_string($e['Title'], '19');?></h2></a>
        </div>
<!--                    <div class="video-mark"><a href="#"><span>Like</span></a>|<a href="#">Mark</a></div>-->
    </div><!-- / event-cell -->
    <?php endforeach; ?>
<?php }else{
    echo "暂无内容";
} ?>