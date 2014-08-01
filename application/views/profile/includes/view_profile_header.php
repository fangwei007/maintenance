<!-- Left bar container -->
<section class="sidebar-left">	
    <?php if(!empty($user_profile)){ ?>
    <aside class="sidebar-first-block">
        <!-- Author image  -->
        <a href="#">
            <div style="margin-bottom:10px; height:170px; background-image:url('<?=  base_url();?>assets/images/users_avatar/<?= insert_before_extension($user_profile->Avatar, '_large')?>'); background-repeat:no-repeat;"></div>
        </a>

        <div class="clearfix">
        <div class="pull-left"><b><?= $user_profile->Nickname;?></b></div>
        </div>
        <div class="author-bio">
            <b><?= lang('biography') . ':';?></b>
            <span class="teaser"><?= mb_substr($user_profile->Biography, 0, 140) ?></span><?php if (mb_strlen($user_profile->Biography) > 140): ?><span class="apo">...</span><span class="complete"><?= mb_substr($user_profile->Biography, 141) ?></span>
            <span class="read-all"><?= lang('read_all');?></span>
            <?php endif; ?>
        </div>
        
        <?php if($this->session->userdata('user_id') !== $user_profile->UserID){ ?>
            <?php if($this->session->userdata('logged_in')){ ?>
                <?php if(empty($user_profile->Follow)){ ?>
                    <div class="button-title-danger" onclick="follow('<?= $user_profile->UserID?>', this, 0);"><?= lang('follow')?></div><br/>
                <?php }else{ ?>
                    <div class="button-title" onclick="follow('<?= $user_profile->UserID?>', this, 1);"><?= lang('unfollow')?></div><br/>
                <?php } ?>
            <?php }else{ ?>
                    <div class="button-title-danger log-in"><?= lang('follow')?></div><br/>
            <?php } ?>
        <?php } ?>
        
<!--        <a href="<?= base_url(); ?>my_account/add_post"><div class="button-title">发送邮件</div></a><br/>-->
        <a href="<?= base_url()?>profile/user_profile/<?=$user_profile->Nickname;?>"><div class="button-title">发布的文章</div></a><br/>
        <a href="<?= base_url()?>profile/user_post_positions/<?=$user_profile->Nickname;?>"><div class="button-title">发布的职位</div></a><br/>
    </aside>	
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

    
<script type="text/javascript">
    var x = 0;
    $(".read-all").click(function(){
        if(x === 0){
           $(this).text("<?= lang('read_less')?>").siblings(".complete").fadeIn('slow');
           $('.apo').hide();
           x = 1;
        }else{
            $(this).text("<?= lang('read_all')?>").siblings(".complete").fadeOut('slow');
            $('.apo').show();
            x = 0;
        }
         
    });
</script>