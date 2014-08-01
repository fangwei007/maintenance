<section class="sidebar-left">	
    <?php if(!empty($author_info)){ ?>
    <aside class="sidebar-first-block">
        <!-- Author image  -->
        <a href="<?= base_url() . "profile/user_profile/" . $author_info->Nickname?>">
            <div style="margin-bottom:20px; height:170px; background-image:url('<?=  base_url();?>assets/images/users_avatar/<?= insert_before_extension($author_info->Avatar, '_large')?>'); background-repeat:no-repeat;"></div>
        </a>

        <div class="clearfix">
        <div class="sidebar-article-author">作者：<?= $author_info->Nickname?></div>
            <div class="sidebar-follow-author">
                <?php if($this->session->userdata('user_id') !== $author_info->UserID){ ?>
                    <?php if($this->session->userdata('logged_in')){ ?>
                        <?php if(empty($author_info->Follow)){ ?>
                            <span class="button-title-danger" onclick="follow('<?= $author_info->UserID?>', this, 0);"><?= lang('follow')?></span>
                        <?php }else{ ?>
                            <span class="button-title" onclick="follow('<?= $author_info->UserID?>', this, 1);"><?= lang('unfollow')?></span>
                        <?php } ?>
                    <?php }else{ ?>
                            <span class="button-title-danger log-in"><?= lang('follow')?></span>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

<!--        <a href="#"><div class="button-title">Send Message</div></a><br/>
        <a href="#"><div class="button-title">Connect on Linkedin</div></a>-->
    </aside>	
    <!-- / sidebar-article-author-block -->
    <?php } ?>
    <aside class="sidebar-left-block">
        <a href="<?= base_url()?>posts/show_posts/start_up/article"><span class="title-cn">更多文章</span>|<span class="title-en">Read More</span></a>
            <ul>
                 <?php 
                  if (!empty($sidebar_articles)) {
                      foreach($sidebar_articles as $a){
                ?>
                <li><a href="<?= base_url() . "posts/show_post/" . $a['PostID']?>"><?= $a['Title']?></a></li>
                <?php
                      }
                  }else{
                      echo lang("no_post");
                  }
                 ?>
            </ul>	
    </aside>
    <aside class="sidebar-left-block">
        <a href="<?= base_url()?>posts/show_posts/start_up/event"><span class="title-cn">更多活动</span>|<span class="title-en">Read More</span></a>
            <ul>
                 <?php 
                  if (!empty($sidebar_events)) {
                      foreach($sidebar_events as $e){
                ?>
                <li><a href="<?= base_url() . "posts/show_post/" . $e['PostID']?>"><?= $e['Title']?></a></li>
                <?php
                      }
                  }else{
                      echo lang("no_post");
                  }
                 ?>
            </ul>
    </aside>
    
    <aside class="sidebar-left-block">
        <a href="<?= base_url()?>positions/show_positions"><span class="title-cn">更多职位</span>|<span class="title-en">Read More</span></a>
            <ul>
                 <?php 
                  if (!empty($sidebar_positions)) {
                      foreach($sidebar_positions as $s){
                ?>
                <li><a href="<?= base_url() . "positions/show_position/" . $s['PositionID']?>"><?= $s['Title']?></a></li>
                <?php
                      }
                  }else{
                      echo lang("no_post");
                  }
                 ?>
            </ul>
    </aside>
</section>	
<!-- End of left bar container -->

<!--article container-->

<section class="right-content" >