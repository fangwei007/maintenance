<?php if(!empty($videos_list)){ ?>
    <?php foreach($videos_list as $v):?>
      <div class="video-cell">
<!--          <a href="<?= base_url()?>posts/show_post/<?= $v['PostID']?>"><div class="post_video_image"style="background-image:url('<?= base_url() . 'assets/images/posts/' . insert_before_extension($v['Image'], '_medium')?>'); background-repeat:no-repeat;"></div></a>-->
          <a href="<?= base_url()?>posts/show_post/<?= $v['PostID']?>"><img src="<?= base_url() . 'assets/images/posts/' . insert_before_extension($v['Image'], '_medium')?>" /></a>
          <div class="video-title">
              <a href="<?= base_url()?>posts/show_post/<?= $v['PostID']?>"><h2><?= truncate_string($v['Title'], '19');?></h2></a>
          </div>
<!--                    <div class="video-mark"><a href="#"><span>Like</span></a>|<a href="#">Mark</a></div>-->
      </div><!-- / video-cell -->
    <?php endforeach; ?>
<?php }else{
    echo "暂无内容";
} ?>