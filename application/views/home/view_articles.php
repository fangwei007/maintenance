<?php if(!empty($blogs_list)){ ?>
    <?php foreach($blogs_list as $b):?>
      <article class="articles-cell pull-left">
          <a href="<?= base_url()?>posts/show_post/<?= $b['PostID']?>">
              <div class="post-image">
                  <img class="article-image" src="<?= base_url() . 'assets/images/posts/' . insert_before_extension($b['Image'], '_medium')?>" alt="post image" />
                  <?php if($b['Type'] === 'video'): ?>
                  <img class="video-button" src="<?= base_url() . 'assets/images/site/vedio_button.png'?>" alt="video play button" />
                  <?php endif; ?>
              </div>
          </a>
          <div class="articles-title">
              <a href="<?= base_url()?>posts/show_post/<?= $b['PostID']?>"><h2><?= truncate_string($b['Title'],19)?></h2></a>
          </div>
          <div class="articles-buttom">
              <div class="articles-author"><?= lang('posted_by')?> <a href="<?= base_url() . 'profile/user_profile/' . $b['AuthorName']?>"><?= $b['AuthorName']?></a></div>
<!--                            <div class="articles-mark"><a href="#">Like</a> | <a href="#"><span>Mark</span></a></div>-->
          </div><!-- / articles-buttom --> 
      </article><!-- / articles-cell -->
    <?php endforeach; ?>
<?php } ?>

